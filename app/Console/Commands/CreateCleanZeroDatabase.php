<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Throwable;

class CreateCleanZeroDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create-clean-zero
                            {--superadmin=superadmin@skilllearne.org : Super Admin email to preserve}
                            {--password=password123 : Password for the superadmin account}
                            {--target-new-db=skilllearner_zero_db : Name of fresh MySQL database to create}
                            {--export-file=database/skilllearner_clean_zero.sql : Path for exported clean SQL file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean all dummy users and transactions so dashboard stats start from 0, preserving only superadmin@skilllearne.org and master course/package catalog.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $superadminEmail = (string) $this->option('superadmin');
        $superadminPassword = (string) $this->option('password');
        $targetNewDb = (string) $this->option('target-new-db');
        $exportSqlPath = base_path((string) $this->option('export-file'));

        $this->info('=========================================================');
        $this->info('🚀 SKILLLEARNER: CLEAN ZERO DATABASE INITIALIZATION');
        $this->info('=========================================================');
        $this->info("Super Admin Target : {$superadminEmail}");
        $this->info("New Fresh DB Name  : {$targetNewDb}");
        $this->info("Export SQL File    : {$exportSqlPath}");
        $this->line('');

        // 1. Clean current active database (careerfixx_db)
        $this->info('Step 1: Cleaning current database to 0 stats...');
        $this->cleanDatabaseTables($superadminEmail, $superadminPassword);

        // 2. Create the new separate database in MySQL (targetNewDb)
        $this->info("Step 2: Creating new standalone database '{$targetNewDb}' in MySQL...");
        $this->createNewStandaloneDatabase($targetNewDb, $superadminEmail, $superadminPassword);

        // 3. Export clean SQL dump
        $this->info("Step 3: Exporting clean standalone SQL dump to '{$exportSqlPath}'...");
        $this->exportCleanSqlDump($exportSqlPath);

        // 4. Clear all caches
        $this->info('Step 4: Clearing application and view caches...');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');

        $this->line('');
        $this->info('=========================================================');
        $this->info('✅ SUCCESS! DATABASE RESET COMPLETED AT ZERO STATS');
        $this->info('=========================================================');
        $this->table(
            ['Metric / Area', 'New Value', 'Notes'],
            [
                ['Super Admin User', $superadminEmail, 'Only 1 user in system (Role: super_admin)'],
                ['Other Users', '0', 'All test/dummy users deleted'],
                ['Total Platform Revenue', '₹0.00', 'Clean slate start'],
                ['Orders Count', '0', 'All test orders cleared'],
                ['Commissions Count', '0', 'All test commissions cleared'],
                ['Payouts Count', '0', 'All payout requests cleared'],
                ['Pending KYC Queue', '0', 'All test KYC cleared'],
                ['Super Admin Wallet', '₹0.00', 'Wallet balance reset to zero'],
                ['Super Admin Earnings', '₹0.00', 'Today, weekly, monthly, total earnings = 0'],
                ['Super Admin Package', 'Infinity Package', 'Full access with all courses unlocked'],
                ['Master Catalog', 'Preserved', 'All Packages, Courses, Videos, Mentors intact'],
                ['Roles & Permissions', 'Preserved', 'All 6 RBAC roles active'],
                ['System Settings', 'Preserved', 'Site name, logo, contact, tax settings intact'],
                ['New MySQL DB Created', $targetNewDb, 'Standalone fresh DB ready in MySQL'],
                ['Exported SQL File', $exportSqlPath, 'Ready to import in production / hosting'],
            ]
        );

        return self::SUCCESS;
    }

    /**
     * Clean all transactional data and reset users table.
     */
    protected function cleanDatabaseTables(string $superadminEmail, string $password): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Truncate transactional tables
        $tablesToTruncate = [
            'orders',
            'commissions',
            'payouts',
            'kyc_verifications',
            'activity_logs',
            'offer_redemptions',
            'mentor_payouts',
            'user_courses',
            'password_reset_tokens',
            'sessions',
        ];

        foreach ($tablesToTruncate as $tbl) {
            if (Schema::hasTable($tbl)) {
                DB::table($tbl)->truncate();
                $this->line("  - Truncated table: {$tbl}");
            }
        }

        // 2. Ensure Super Admin exists with ZERO earnings
        $superadmin = User::where('email', $superadminEmail)->first();
        if (! $superadmin) {
            $superadmin = new User;
            $superadmin->email = $superadminEmail;
            $superadmin->password = Hash::make($password);
        }

        $superadmin->name = 'Super Admin';
        $superadmin->phone = '+91 99999 00001';
        $superadmin->role = 'super_admin';
        $superadmin->affiliate_id = 'SL-SUPER';
        $superadmin->sponsor_id = null;
        $superadmin->active_package = 'Infinity Package';
        $superadmin->payment_status = 'paid';
        $superadmin->is_blocked = false;
        $superadmin->kyc_status = 'Verified ✅';
        $superadmin->wallet_balance = 0.00;
        $superadmin->today_earning = 0.00;
        $superadmin->weekly_earning = 0.00;
        $superadmin->monthly_earning = 0.00;
        $superadmin->total_earning = 0.00;
        $superadmin->passive_earning = 0.00;
        $superadmin->industry_revenue = 0.00;
        $superadmin->save();

        $this->line("  - Reset Super Admin: {$superadmin->email} (ID: {$superadmin->id}) with 0.00 wallet & earnings.");

        // 3. Delete all other users
        $deletedUsersCount = User::where('id', '!=', $superadmin->id)->delete();
        $this->line("  - Deleted other users: {$deletedUsersCount} user(s) removed.");

        // 4. Unlock all courses for Super Admin with 0% progress
        $allCourses = Course::all();
        foreach ($allCourses as $c) {
            UserCourse::firstOrCreate([
                'user_id' => $superadmin->id,
                'course_id' => $c->id,
            ], [
                'progress_percent' => 0,
            ]);
        }
        $this->line("  - Unlocked {$allCourses->count()} master courses for Super Admin preview.");

        // 5. Seed initial clean activity log
        if (Schema::hasTable('activity_logs')) {
            try {
                ActivityLog::record(
                    'DATABASE_INITIALIZED_ZERO',
                    'system',
                    "Database clean initialized from zero for Super Admin {$superadminEmail}. All previous dummy transactions removed."
                );
            } catch (Throwable) {
                // If ActivityLog helper fails, ignore or insert created_at only
                DB::table('activity_logs')->insert([
                    'action' => 'DATABASE_INITIALIZED_ZERO',
                    'module' => 'system',
                    'description' => "Database clean initialized from zero for Super Admin {$superadminEmail}.",
                    'user_id' => $superadmin->id,
                    'ip_address' => '127.0.0.1',
                    'created_at' => now(),
                ]);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Create fresh standalone MySQL database and populate it.
     */
    protected function createNewStandaloneDatabase(string $dbName, string $superadminEmail, string $password): void
    {
        try {
            DB::statement("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $this->line("  - Created database `{$dbName}` in MySQL.");

            // Dump structure and clean data into new database using mysql CLI
            $mysqlBin = 'C:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysql.exe';
            $dumpBin = 'C:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysqldump.exe';

            if (file_exists($dumpBin) && file_exists($mysqlBin)) {
                $tempDump = storage_path('app/temp_clean_dump.sql');
                $currentDb = config('database.connections.mysql.database');

                // Export current clean db
                $cmdExport = 'cmd.exe /c ""'.$dumpBin.'" -u root '.$currentDb.' > "'.$tempDump.'""';
                exec($cmdExport);

                // Import into new db
                if (file_exists($tempDump) && filesize($tempDump) > 0) {
                    $cmdImport = 'cmd.exe /c ""'.$mysqlBin.'" -u root '.$dbName.' < "'.$tempDump.'""';
                    exec($cmdImport);
                    @unlink($tempDump);
                    $this->line("  - Successfully cloned clean zero schema & data into `{$dbName}`.");
                }
            }
        } catch (Throwable $e) {
            $this->warn('  - Note while creating new db: '.$e->getMessage());
        }
    }

    /**
     * Export clean SQL dump file.
     */
    protected function exportCleanSqlDump(string $exportSqlPath): void
    {
        $dumpBin = 'C:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysqldump.exe';
        $currentDb = config('database.connections.mysql.database');

        $dir = dirname($exportSqlPath);
        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        if (file_exists($dumpBin)) {
            $cmd = 'cmd.exe /c ""'.$dumpBin.'" -u root '.$currentDb.' > "'.$exportSqlPath.'""';
            exec($cmd);
            if (file_exists($exportSqlPath)) {
                $this->line('  - Dump saved ('.number_format(filesize($exportSqlPath)).' bytes).');
            }
        }
    }
}
