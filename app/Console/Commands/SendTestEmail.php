<?php

namespace App\Console\Commands;

use App\Mail\AccountCreatedMail;
use App\Mail\ActiveReferralMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\PassiveReferralMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test 
                            {to? : Recipient email address (e.g. your_email@gmail.com)} 
                            {--type=passive : Email type (passive, active, welcome, forgot)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test Skilllearner branded email via Hostinger SMTP or configured mailer';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $to = $this->argument('to') ?: $this->ask('Enter the recipient email address to send test email to:');
        if (! filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $this->error("Invalid email address: '{$to}'");

            return Command::FAILURE;
        }

        $type = strtolower((string) $this->option('type'));

        $this->info('====================================================');
        $this->info('        SKILLLEARNER EMAIL TESTING TOOL             ');
        $this->info('====================================================');
        $this->line('Mailer Driver : '.Config::get('mail.default'));
        $this->line('SMTP Host     : '.Config::get('mail.mailers.smtp.host'));
        $this->line('SMTP Port     : '.Config::get('mail.mailers.smtp.port'));
        $this->line('SMTP Scheme   : '.(Config::get('mail.mailers.smtp.scheme') ?: 'auto (smtps for 465)'));
        $this->line('SMTP Username : '.Config::get('mail.mailers.smtp.username'));
        $this->line('From Address  : '.Config::get('mail.from.address').' ('.Config::get('mail.from.name').')');
        $this->line('Sending To    : '.$to);
        $this->line('Template Type : '.$type);
        $this->info('----------------------------------------------------');

        $mailable = match ($type) {
            'active' => new ActiveReferralMail(
                userName: 'Test User',
                amount: 420.00,
                buyerName: 'Demo Buyer',
                packageName: 'Basic Package'
            ),
            'welcome', 'account', 'created' => new AccountCreatedMail(
                userName: 'Test User',
                email: $to,
                affiliateId: 'SKL-7890',
                packageName: 'Advance Package'
            ),
            'forgot', 'reset' => new ForgotPasswordMail(
                userName: 'Test User',
                resetUrl: url('/reset-password/test-token?email='.urlencode($to))
            ),
            default => new PassiveReferralMail(
                userName: 'Test User',
                amount: 20.00,
                buyerName: 'Demo Buyer',
                packageName: 'Advance Package'
            ),
        };

        $this->line('Dispatching email... please wait...');

        try {
            Mail::to($to)->send($mailable);
            $this->newLine();
            $this->info(" SUCCESS! Test {$type} email has been successfully dispatched to: {$to}");
            $this->line('Please check your Inbox (and Spam/Junk folder if sending to an external mailbox).');
            $this->info('====================================================');

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->newLine();
            $this->error(' ERROR: Could not send email via SMTP.');
            $this->line('Exception: '.$e->getMessage());
            $this->newLine();
            $this->comment('Hostinger SMTP Troubleshooting:');
            $this->line('1. Check if MAIL_PASSWORD in .env matches your actual Hostinger email password.');
            $this->line('2. In .env, ensure:');
            $this->line('   MAIL_MAILER=smtp');
            $this->line('   MAIL_HOST=smtp.hostinger.com');
            $this->line('   MAIL_PORT=465');
            $this->line('   MAIL_USERNAME=info@skilllearner.org');
            $this->line('   MAIL_ENCRYPTION=ssl');
            $this->line('3. If testing locally without internet or before setting password, set:');
            $this->line('   MAIL_MAILER=log  (view email output in storage/logs/laravel.log)');
            $this->info('====================================================');

            return Command::FAILURE;
        }
    }
}
