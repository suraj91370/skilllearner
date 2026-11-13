<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BackupService
{
    /**
     * Storage directory for database backups.
     */
    public static function getBackupDirectory(): string
    {
        $dir = storage_path('app/backups');
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true, true);
        }

        return $dir;
    }

    /**
     * List all database backup files with size and creation time.
     */
    public static function listBackups(): array
    {
        $dir = static::getBackupDirectory();
        $files = File::files($dir);

        $backups = [];
        foreach ($files as $file) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['sql', 'sqlite'])) {
                $bytes = $file->getSize();
                $backups[] = [
                    'filename' => $file->getFilename(),
                    'size' => static::formatBytes($bytes),
                    'size_bytes' => $bytes,
                    'created_at' => Carbon::createFromTimestamp($file->getMTime())->format('d M Y, h:i A'),
                    'timestamp' => $file->getMTime(),
                    'path' => $file->getRealPath(),
                ];
            }
        }

        // Sort latest backups first
        usort($backups, fn ($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        return $backups;
    }

    /**
     * Create a full SQL dump of the connected database.
     */
    public static function createBackup(): array
    {
        $dir = static::getBackupDirectory();
        $defaultConn = config('database.default', 'mysql');
        $databaseName = config("database.connections.{$defaultConn}.database", 'careerfixx_db');
        $timestamp = date('Y_m_d_His');
        $filename = "skilllearner_backup_{$timestamp}.sql";
        $filePath = "{$dir}/{$filename}";

        $header = "-- ==========================================================\n";
        $header .= "-- SkillLearner Platform Automated Database Backup\n";
        $header .= '-- Date & Time: '.date('Y-m-d H:i:s')."\n";
        $header .= "-- Connection: {$defaultConn}\n";
        $header .= "-- Database: {$databaseName}\n";
        $header .= '-- Server: '.(php_uname('n') ?: 'localhost')."\n";
        $header .= "-- ==========================================================\n\n";
        $header .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        File::put($filePath, $header);

        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            $sqlitePath = config('database.connections.sqlite.database');
            if (File::exists($sqlitePath)) {
                $copyFile = "skilllearner_backup_{$timestamp}.sqlite";
                $copyPath = "{$dir}/{$copyFile}";
                File::copy($sqlitePath, $copyPath);
                $bytes = filesize($copyPath);

                return [
                    'filename' => $copyFile,
                    'size' => static::formatBytes($bytes),
                    'size_bytes' => $bytes,
                    'created_at' => date('d M Y, h:i A'),
                    'path' => $copyPath,
                ];
            }
        }

        $pdo = DB::connection()->getPdo();

        // MySQL / MariaDB dump
        $tablesStatement = $pdo->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
        $tables = $tablesStatement->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            // Table header & drop statement
            $tableSql = "\n-- ----------------------------------------------------------\n";
            $tableSql .= "-- Table structure for `{$table}`\n";
            $tableSql .= "-- ----------------------------------------------------------\n";
            $tableSql .= "DROP TABLE IF EXISTS `{$table}`;\n";

            $createTableStmt = $pdo->query("SHOW CREATE TABLE `{$table}`");
            $createTableRow = $createTableStmt->fetch(\PDO::FETCH_NUM);
            $tableSql .= ($createTableRow[1] ?? '').";\n\n";

            File::append($filePath, $tableSql);

            // Fetch table data in chunks
            $rowsStmt = $pdo->query("SELECT * FROM `{$table}`");
            $rows = $rowsStmt->fetchAll(\PDO::FETCH_ASSOC);

            if (! empty($rows)) {
                $valueRows = [];

                foreach ($rows as $row) {
                    $values = array_map(function ($val) use ($pdo) {
                        if ($val === null) {
                            return 'NULL';
                        }

                        return $pdo->quote($val);
                    }, array_values($row));

                    $valueRows[] = '('.implode(', ', $values).')';
                }

                // Chunk into batches of 100 values to avoid excessive line lengths
                $chunks = array_chunk($valueRows, 100);
                foreach ($chunks as $chunk) {
                    $chunkSql = "INSERT INTO `{$table}` VALUES \n".implode(",\n", $chunk).";\n";
                    File::append($filePath, $chunkSql);
                }
                File::append($filePath, "\n");
            }
        }

        File::append($filePath, "\nSET FOREIGN_KEY_CHECKS=1;\n-- SkillLearner Backup Completed Successfully.\n");

        $bytes = filesize($filePath);

        Log::info("💾 [BACKUP-SERVICE] Database backup generated: {$filename} (".static::formatBytes($bytes).')');

        return [
            'filename' => $filename,
            'size' => static::formatBytes($bytes),
            'size_bytes' => $bytes,
            'created_at' => date('d M Y, h:i A'),
            'path' => $filePath,
        ];
    }

    /**
     * Delete an existing backup file safely.
     */
    public static function deleteBackup(string $filename): bool
    {
        $clean = basename($filename);
        $path = static::getBackupDirectory().'/'.$clean;
        if (File::exists($path)) {
            return File::delete($path);
        }

        return false;
    }

    /**
     * Get real absolute path for a backup file if valid.
     */
    public static function getBackupFullPath(string $filename): ?string
    {
        $clean = basename($filename);
        $path = static::getBackupDirectory().'/'.$clean;

        return File::exists($path) ? $path : null;
    }

    /**
     * Human-readable byte formatting.
     */
    public static function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2).' GB';
        }
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        }

        return $bytes.' Bytes';
    }
}

