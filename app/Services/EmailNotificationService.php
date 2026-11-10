<?php

namespace App\Services;

use App\Mail\AccountCreatedMail;
use App\Mail\ActiveReferralMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\PassiveReferralMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EmailNotificationService
{
    /**
     * Send Passive Referral (Level-2) email notification to affiliate.
     */
    public static function sendPassiveReferral(
        User $user,
        float $amount,
        ?string $buyerName = null,
        ?string $packageName = null
    ): bool {
        if (empty($user->email)) {
            Log::warning("Skipped sending Passive Referral email: User #{$user->id} has no email.");

            return false;
        }

        try {
            Mail::to($user->email, $user->name)->send(
                new PassiveReferralMail(
                    userName: $user->name,
                    amount: $amount,
                    buyerName: $buyerName,
                    packageName: $packageName
                )
            );

            Log::info("Passive referral email sent to {$user->email} for amount {$amount} INR.");

            return true;
        } catch (Throwable $e) {
            Log::error("Failed to send Passive Referral email to {$user->email}: ".$e->getMessage());

            return false;
        }
    }

    /**
     * Send Direct Active Referral (Level-1) email notification to affiliate.
     */
    public static function sendActiveReferral(
        User $user,
        float $amount,
        ?string $buyerName = null,
        ?string $packageName = null
    ): bool {
        if (empty($user->email)) {
            Log::warning("Skipped sending Active Referral email: User #{$user->id} has no email.");

            return false;
        }

        try {
            Mail::to($user->email, $user->name)->send(
                new ActiveReferralMail(
                    userName: $user->name,
                    amount: $amount,
                    buyerName: $buyerName,
                    packageName: $packageName
                )
            );

            Log::info("Active referral email sent to {$user->email} for amount {$amount} INR.");

            return true;
        } catch (Throwable $e) {
            Log::error("Failed to send Active Referral email to {$user->email}: ".$e->getMessage());

            return false;
        }
    }

    /**
     * Send Welcome / Account Created email notification to new user.
     */
    public static function sendAccountCreated(User $user, ?string $packageName = null): bool
    {
        if (empty($user->email)) {
            Log::warning("Skipped sending Account Created email: User #{$user->id} has no email.");

            return false;
        }

        try {
            Mail::to($user->email, $user->name)->send(
                new AccountCreatedMail(
                    userName: $user->name,
                    email: $user->email,
                    affiliateId: $user->affiliate_id,
                    packageName: $packageName ?? $user->active_package
                )
            );

            Log::info("Account created welcome email sent to {$user->email}.");

            return true;
        } catch (Throwable $e) {
            Log::error("Failed to send Account Created email to {$user->email}: ".$e->getMessage());

            return false;
        }
    }

    /**
     * Send Password Reset email notification.
     */
    public static function sendForgotPassword(User $user, string $resetUrl): bool
    {
        if (empty($user->email)) {
            Log::warning("Skipped sending Password Reset email: User #{$user->id} has no email.");

            return false;
        }

        try {
            Mail::to($user->email, $user->name)->send(
                new ForgotPasswordMail(
                    userName: $user->name,
                    resetUrl: $resetUrl
                )
            );

            Log::info("Password reset email sent to {$user->email}.");

            return true;
        } catch (Throwable $e) {
            Log::error("Failed to send Password Reset email to {$user->email}: ".$e->getMessage());

            return false;
        }
    }
}

