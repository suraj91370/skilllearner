<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CashfreeService
{
    /**
     * Get configured Cashfree App ID (from Setting DB or .env).
     */
    public static function getAppId(): string
    {
        return (string) (class_exists(Setting::class) ? Setting::get('cashfree_app_id', config('cashfree.app_id', env('CASHFREE_APP_ID', ''))) : config('cashfree.app_id', env('CASHFREE_APP_ID', '')));
    }

    /**
     * Get configured Cashfree Secret Key (from Setting DB or .env).
     */
    public static function getSecretKey(): string
    {
        return (string) (class_exists(Setting::class) ? Setting::get('cashfree_secret_key', config('cashfree.secret_key', env('CASHFREE_SECRET_KEY', ''))) : config('cashfree.secret_key', env('CASHFREE_SECRET_KEY', '')));
    }

    /**
     * Get active Cashfree Environment (sandbox or production).
     */
    public static function getEnv(): string
    {
        return (string) (class_exists(Setting::class) ? Setting::get('cashfree_env', config('cashfree.env', env('CASHFREE_ENV', 'sandbox'))) : config('cashfree.env', env('CASHFREE_ENV', 'sandbox')));
    }

    /**
     * Get the active Cashfree API base URL based on config/env.
     */
    public static function getBaseUrl(): string
    {
        $env = static::getEnv();
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
            'x-client-id' => static::getAppId(),
            'x-client-secret' => static::getSecretKey(),
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
        $appId = static::getAppId();
        $secret = static::getSecretKey();

        return ! empty($appId) && ! empty($secret);
    }

    /**
     * Test connection to Cashfree Payment Gateway using provided or saved credentials.
     */
    public static function testConnection(?string $appId = null, ?string $secret = null, ?string $env = null): array
    {
        $appId = $appId ?: static::getAppId();
        $secret = $secret ?: static::getSecretKey();
        $env = $env ?: static::getEnv();

        if (empty($appId) || empty($secret)) {
            return [
                'success' => false,
                'message' => 'Cashfree App ID aur Secret Key dono required hain.',
            ];
        }

        $baseUrl = $env === 'production' ? 'https://api.cashfree.com/pg' : 'https://sandbox.cashfree.com/pg';
        $headers = [
            'x-client-id' => $appId,
            'x-client-secret' => $secret,
            'x-api-version' => '2023-08-01',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        try {
            // Ping orders endpoint with a dummy test ID
            $response = Http::withHeaders($headers)
                ->timeout(10)
                ->get("{$baseUrl}/orders/skl_ping_test");

            // In Cashfree API:
            // 404 means the credentials are valid and authorized (order just wasn't found)
            // 401 / 403 means authentication failed
            if ($response->status() === 404 || $response->successful()) {
                return [
                    'success' => true,
                    'message' => "Cashfree ({$env}) credentials valid hain aur connection successfully establish ho gaya! ✅",
                    'status' => $response->status(),
                ];
            }

            if ($response->status() === 401 || $response->status() === 403) {
                return [
                    'success' => false,
                    'message' => "Authentication Failed (HTTP {$response->status()}): Invalid Cashfree App ID ya Secret Key.",
                    'raw' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => "Gateway response status: {$response->status()}",
                'raw' => $response->json(),
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => "Connection failed: {$e->getMessage()}",
            ];
        }
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

        $orderId = (string) $params['order_id'];
        $amount = round((float) $params['order_amount'], 2);
        $customerName = mb_substr(trim((string) ($params['customer_name'] ?? 'Student')), 0, 95);
        $customerEmail = trim((string) ($params['customer_email'] ?? 'student@skilllearner.org'));
        $orderNote = $params['order_note'] ?? 'SkillLearner Course Package Enrollment';

        // Verify API credentials exist
        if (! static::isConfigured()) {
            Log::error('💳 [CASHFREE-GATEWAY] Cannot initiate order: API credentials missing in database settings.');

            return [
                'success' => false,
                'error' => 'Cashfree API credentials are not configured. Please enter your App ID and Secret Key in Admin > Payment Gateway.',
            ];
        }

        $baseUrl = static::getBaseUrl();
        $headers = static::getHeaders();

        $returnUrl = $params['return_url'] ?? url('/payment/cashfree/callback?order_id={order_id}');
        $notifyUrl = $params['notify_url'] ?? url('/payment/cashfree/webhook');

        // Cashfree API (especially in Production) strictly requires HTTPS return_url & notify_url
        if (str_starts_with($returnUrl, 'http://')) {
            $returnUrl = 'https://'.substr($returnUrl, 7);
        }
        if (str_starts_with($notifyUrl, 'http://')) {
            $notifyUrl = 'https://'.substr($notifyUrl, 7);
        }

        $payload = [
            'order_id' => $orderId,
            'order_amount' => $amount,
            'order_currency' => $params['order_currency'] ?? 'INR',
            'customer_details' => [
                'customer_id' => $cleanCustomerId,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'customer_phone' => $cleanPhone,
            ],
            'order_meta' => [
                'return_url' => $returnUrl,
                'notify_url' => $notifyUrl,
            ],
            'order_note' => $orderNote,
        ];

        try {
            Log::info("💳 [CASHFREE-GATEWAY] 🚀 Calling Cashfree PG API ({$baseUrl}/orders) for Order #{$orderId} (₹{$amount})");

            $response = Http::withHeaders($headers)
                ->timeout(20)
                ->post("{$baseUrl}/orders", $payload);

            $data = $response->json();

            if ($response->successful() && ! empty($data['payment_session_id'])) {
                Log::info("💳 [CASHFREE-GATEWAY] ✅ Live order created on Cashfree! Session ID: {$data['payment_session_id']}");

                return [
                    'success' => true,
                    'payment_session_id' => $data['payment_session_id'],
                    'order_id' => $data['order_id'] ?? $orderId,
                    'order_status' => $data['order_status'] ?? 'ACTIVE',
                    'is_simulated' => false,
                    'raw' => $data,
                ];
            }

            $errorMessage = $data['message'] ?? 'Failed to create order on Cashfree.';
            Log::error('💳 [CASHFREE-GATEWAY] Order Creation Failed', [
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
            Log::error('💳 [CASHFREE-GATEWAY] Exception: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return [
                'success' => false,
                'error' => 'Connection to Cashfree failed: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Fetch order details directly from Cashfree or Simulator to verify payment status.
     *
     * @return array{
     *     success: bool,
     *     order_status?: string,
     *     order_amount?: float,
     *     order_currency?: string,
     *     is_simulated?: bool,
     *     raw?: array,
     *     error?: string
     * }
     */
    public static function getOrder(string $orderId): array
    {
        $baseUrl = static::getBaseUrl();
        $headers = static::getHeaders();

        try {
            Log::info("💳 [CASHFREE-GATEWAY] 🔍 Querying Cashfree API ({$baseUrl}/orders/{$orderId}) for status");

            $response = Http::withHeaders($headers)
                ->timeout(15)
                ->get("{$baseUrl}/orders/{$orderId}");

            $data = $response->json();

            if ($response->successful()) {
                $status = strtoupper((string) ($data['order_status'] ?? ''));
                Log::info("💳 [CASHFREE-GATEWAY] ✅ Live order status for #{$orderId}: {$status}");

                return [
                    'success' => true,
                    'order_status' => $status,
                    'order_amount' => (float) ($data['order_amount'] ?? 0),
                    'order_currency' => $data['order_currency'] ?? 'INR',
                    'is_simulated' => false,
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
