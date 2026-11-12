<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CashfreeService
{
    /**
     * Get the active Cashfree API base URL based on config/env.
     */
    public static function getBaseUrl(): string
    {
        $env = config('cashfree.env', 'sandbox');
        $endpoints = config('cashfree.endpoints', [
            'sandbox' => 'https://sandbox.cashfree.com/pg',
            'production' => 'https://api.cashfree.com/pg',
        ]);

        return $endpoints[$env] ?? 'https://sandbox.cashfree.com/pg';
    }

    /**
     * Get default HTTP headers required for Cashfree API v2023-08-01.
     */
    public static function getHeaders(): array
    {
        return [
            'x-client-id' => (string) config('cashfree.app_id', env('CASHFREE_APP_ID', '')),
            'x-client-secret' => (string) config('cashfree.secret_key', env('CASHFREE_SECRET_KEY', '')),
            'x-api-version' => (string) config('cashfree.api_version', '2023-08-01'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Check if Cashfree API credentials are configured.
     */
    public static function isConfigured(): bool
    {
        $appId = config('cashfree.app_id', env('CASHFREE_APP_ID', ''));
        $secret = config('cashfree.secret_key', env('CASHFREE_SECRET_KEY', ''));

        return ! empty($appId) && ! empty($secret);
    }

    /**
     * Create a Cashfree Payment Gateway order and receive a payment_session_id.
     *
     * @param  array{
     *     order_id: string,
     *     order_amount: float,
     *     order_currency?: string,
     *     customer_id: string,
     *     customer_name: string,
     *     customer_email: string,
     *     customer_phone: string,
     *     return_url?: string,
     *     notify_url?: string,
     *     order_note?: string
     * }  $params
     * @return array{
     *     success: bool,
     *     payment_session_id?: string,
     *     order_id?: string,
     *     order_status?: string,
     *     error?: string,
     *     raw?: array
     * }
     */
    public static function createOrder(array $params): array
    {
        if (! static::isConfigured()) {
            return [
                'success' => false,
                'error' => 'Cashfree API credentials are not set in .env (CASHFREE_APP_ID & CASHFREE_SECRET_KEY required).',
            ];
        }

        // Clean phone number: remove non-digits, take last 10 digits
        $cleanPhone = preg_replace('/\D/', '', (string) ($params['customer_phone'] ?? '9999999999'));
        if (strlen($cleanPhone) > 10) {
            $cleanPhone = substr($cleanPhone, -10);
        }
        if (strlen($cleanPhone) < 10) {
            $cleanPhone = '9999999999';
        }

        // Clean customer id (alphanumeric + underscore/hyphen, max 50)
        $cleanCustomerId = preg_replace('/[^a-zA-Z0-9_\-]/', '_', (string) ($params['customer_id'] ?? 'cust_guest'));
        if (strlen($cleanCustomerId) > 45) {
            $cleanCustomerId = substr($cleanCustomerId, 0, 45);
        }

        $baseUrl = static::getBaseUrl();
        $headers = static::getHeaders();

        $returnUrl = $params['return_url'] ?? url('/payment/cashfree/callback?order_id={order_id}');
        $notifyUrl = $params['notify_url'] ?? url('/payment/cashfree/webhook');

        $payload = [
            'order_id' => $params['order_id'],
            'order_amount' => round((float) $params['order_amount'], 2),
            'order_currency' => $params['order_currency'] ?? 'INR',
            'customer_details' => [
                'customer_id' => $cleanCustomerId,
                'customer_name' => mb_substr(trim((string) ($params['customer_name'] ?? 'Student')), 0, 95),
                'customer_email' => trim((string) ($params['customer_email'] ?? 'student@skilllearner.org')),
                'customer_phone' => $cleanPhone,
            ],
            'order_meta' => [
                'return_url' => $returnUrl,
                'notify_url' => $notifyUrl,
            ],
            'order_note' => $params['order_note'] ?? 'SkillLearner Course Package Enrollment',
        ];

        try {
            $response = Http::withHeaders($headers)
                ->timeout(20)
                ->post("{$baseUrl}/orders", $payload);

            $data = $response->json();

            if ($response->successful() && ! empty($data['payment_session_id'])) {
                return [
                    'success' => true,
                    'payment_session_id' => $data['payment_session_id'],
                    'order_id' => $data['order_id'] ?? $params['order_id'],
                    'order_status' => $data['order_status'] ?? 'ACTIVE',
                    'raw' => $data,
                ];
            }

            $errorMessage = $data['message'] ?? 'Failed to create order on Cashfree.';
            Log::error('Cashfree Order Creation Failed', [
                'status' => $response->status(),
                'response' => $data,
                'payload' => $payload,
            ]);

            return [
                'success' => false,
                'error' => $errorMessage,
                'raw' => $data,
            ];
        } catch (\Throwable $e) {
            Log::error('Cashfree Order Exception: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return [
                'success' => false,
                'error' => 'Connection to Cashfree failed: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Fetch order details directly from Cashfree to verify payment status.
     *
     * @return array{
     *     success: bool,
     *     order_status?: string,
     *     order_amount?: float,
     *     order_currency?: string,
     *     raw?: array,
     *     error?: string
     * }
     */
    public static function getOrder(string $orderId): array
    {
        if (! static::isConfigured()) {
            return [
                'success' => false,
                'error' => 'Cashfree API credentials are not set.',
            ];
        }

        $baseUrl = static::getBaseUrl();
        $headers = static::getHeaders();

        try {
            $response = Http::withHeaders($headers)
                ->timeout(15)
                ->get("{$baseUrl}/orders/{$orderId}");

            $data = $response->json();

            if ($response->successful()) {
                return [
                    'success' => true,
                    'order_status' => strtoupper((string) ($data['order_status'] ?? '')),
                    'order_amount' => (float) ($data['order_amount'] ?? 0),
                    'order_currency' => $data['order_currency'] ?? 'INR',
                    'raw' => $data,
                ];
            }

            return [
                'success' => false,
                'error' => $data['message'] ?? 'Order lookup failed on Cashfree.',
                'raw' => $data,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error' => 'Failed to connect to Cashfree: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Verify Cashfree webhook signature using HMAC-SHA256.
     *
     * Cashfree sends headers:
     * - x-webhook-signature
     * - x-webhook-timestamp
     */
    public static function verifyWebhookSignature(string $rawBody, string $signature, string $timestamp): bool
    {
        $secretKey = (string) config('cashfree.secret_key', env('CASHFREE_SECRET_KEY', ''));
        if (empty($secretKey)) {
            return false;
        }

        $expectedData = $timestamp.$rawBody;
        $computedSignature = base64_encode(hash_hmac('sha256', $expectedData, $secretKey, true));

        return hash_equals($computedSignature, $signature);
    }
}
