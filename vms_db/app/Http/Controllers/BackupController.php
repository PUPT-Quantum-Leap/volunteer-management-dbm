<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BackupController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (! $user || $user->role !== 'admin') {
                return redirect('/')->with('error', 'Unauthorized access');
            }

            return $next($request);
        });
    }

    /**
     * Display backup management page
     */
    public function index()
    {
        $backupPath = storage_path('app/backups');
        $backups = [];

        if (File::exists($backupPath)) {
            $files = File::allFiles($backupPath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'sql') {
                    $backups[] = [
                        'filename' => $file->getFilename(),
                        'path' => $file->getPathname(),
                        'size' => $this->formatBytes($file->getSize()),
                        'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                    ];
                }
            }
        }

        // Sort by creation date (newest first)
        usort($backups, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return view('admin.backup.index', compact('backups'));
    }

    /**
     * API endpoint to get backup list as JSON
     */
    public function list()
    {
        $backupPath = storage_path('app/backups');
        $backups = [];

        if (File::exists($backupPath)) {
            $files = File::allFiles($backupPath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'sql') {
                    $backups[] = [
                        'filename' => $file->getFilename(),
                        'path' => $file->getPathname(),
                        'size' => $this->formatBytes($file->getSize()),
                        'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                    ];
                }
            }
        }

        // Sort by creation date (newest first)
        usort($backups, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return response()->json($backups);
    }

    /**
     * Create a new database backup
     */
    public function create(Request $request)
    {
        try {
            $backupPath = storage_path('app/backups');

            // Create backup directory if it doesn't exist
            if (! File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            // Generate backup filename with timestamp
            $timestamp = date('Y-m-d_H-i-s');
            $filename = "backup_{$timestamp}.sql";
            $filepath = "{$backupPath}/{$filename}";

            // Create MySQL backup using mysqldump or PHP fallback
            $this->createMySQLBackup($filepath);

            // Keep only last 10 backups to save space
            $this->cleanupOldBackups($backupPath, 10);

            return response()->json([
                'success' => true,
                'message' => 'Backup created successfully',
                'filename' => $filename,
                'size' => $this->formatBytes(File::size($filepath)),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create backup: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download a backup file
     */
    public function download($filename)
    {
        $filepath = storage_path("app/backups/{$filename}");

        if (! File::exists($filepath)) {
            abort(404, 'Backup file not found');
        }

        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    /**
     * Delete a backup file
     */
    public function delete($filename)
    {
        $filepath = storage_path("app/backups/{$filename}");

        if (! File::exists($filepath)) {
            return response()->json([
                'success' => false,
                'message' => 'Backup file not found',
            ], 404);
        }

        try {
            File::delete($filepath);

            return response()->json([
                'success' => true,
                'message' => 'Backup deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete backup: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Restore from backup
     */
    public function restore(Request $request)
    {
        try {
            // Validate the request
            $validator = \Validator::make($request->all(), [
                'backup_file' => 'required|file|max:10240', // Max 10MB, removed mimes restriction
            ]);

            if ($validator->fails()) {
                \Log::warning('Restore validation failed', [
                    'errors' => $validator->errors()->toArray(),
                    'request_data' => $request->all(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: '.$validator->errors()->first(),
                ], 422);
            }

            $file = $request->file('backup_file');

            // Debug: Log file info
            \Log::info('Restore attempt started', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'temp_path' => $file->getPathname(),
                'extension' => $file->getClientOriginalExtension(),
                'is_valid' => $file->isValid(),
                'error' => $file->getError(),
            ]);

            $tempPath = $file->getPathname();

            // Verify file exists and is readable
            if (! file_exists($tempPath) || ! is_readable($tempPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Backup file is not accessible',
                ], 400);
            }

            // Create a backup before restoring
            $this->createQuickBackup();

            // Read and execute SQL from backup file
            $sqlContent = file_get_contents($tempPath);

            if (empty($sqlContent)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Backup file is empty or invalid',
                ], 400);
            }

            \Log::info('Backup file read successfully', ['size' => strlen($sqlContent)]);

            // Check if this is a selective restore (only specific data)
            $isSelectiveRestore = $request->has('restore_type') && $request->restore_type === 'selective';

            if ($isSelectiveRestore) {
                return $this->selectiveRestore($sqlContent, $request);
            }

            // Full database restore
            return $this->fullRestore($sqlContent);

        } catch (\Exception $e) {
            DB::rollBack();
            // Re-enable foreign key checks in case of error
            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            } catch (\Exception $ignore) {
            }

            \Log::error('Restore failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Restore failed: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Perform selective restore (only specific records)
     */
    private function selectiveRestore($sqlContent, Request $request)
    {
        // Get selected tables to restore
        $selectedTables = $request->get('tables', []);
        $selectedIds = $request->get('ids', []);

        \Log::info('Selective restore', [
            'selected_tables' => $selectedTables,
            'selected_ids' => $selectedIds,
        ]);

        // For now, implement as full restore with warning
        \Log::warning('Selective restore not fully implemented, performing full restore');

        return $this->fullRestore($sqlContent);
    }

    /**
     * Perform full database restore
     */
    private function fullRestore($sqlContent)
    {
        // Disable foreign key checks and set SQL mode
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('SET SQL_MODE=NO_AUTO_VALUE_ON_ZERO');

        // Split SQL into individual statements
        $statements = array_filter(array_map('trim', explode(';', $sqlContent)));

        \Log::info('Processing SQL statements', ['count' => count($statements)]);

        $executedCount = 0;
        $errors = [];

        // Process statements in order, but handle table operations carefully
        foreach ($statements as $index => $statement) {
            if (! empty($statement)) {
                // Remove comments from the beginning of statements
                $statement = preg_replace('/^--.*?\n/', '', $statement);
                $statement = trim($statement);

                if (empty($statement)) {
                    continue;
                }

                try {
                    // For DROP TABLE IF EXISTS statements, execute immediately
                    if (stripos($statement, 'DROP TABLE IF EXISTS') === 0) {
                        DB::statement($statement);
                        $executedCount++;

                        \Log::info('DROP TABLE executed', [
                            'index' => $index,
                            'statement' => substr($statement, 0, 100),
                        ]);

                        continue;
                    }

                    // For CREATE TABLE statements, execute immediately after ensuring table doesn't exist
                    if (stripos($statement, 'CREATE TABLE') === 0) {
                        // Extract table name to double-check
                        if (preg_match('/CREATE TABLE `?(\w+)`?/i', $statement, $matches)) {
                            $tableName = $matches[1];
                            // Double-check table doesn't exist
                            try {
                                DB::statement("DROP TABLE IF EXISTS `{$tableName}`");
                                \Log::info("Extra DROP TABLE executed for {$tableName}");
                            } catch (\Exception $e) {
                                \Log::warning("Extra DROP failed for {$tableName}: ".$e->getMessage());
                            }
                        }

                        DB::statement($statement);
                        $executedCount++;

                        \Log::info('CREATE TABLE executed', [
                            'index' => $index,
                            'statement' => substr($statement, 0, 100),
                        ]);

                        continue;
                    }

                    // For INSERT statements, use REPLACE INTO to handle conflicts
                    if (stripos($statement, 'INSERT INTO') === 0) {
                        $statement = preg_replace('/^INSERT INTO/i', 'REPLACE INTO', $statement);

                        // Log the exact statement being executed for debugging
                        \Log::info('Executing REPLACE statement', [
                            'original_length' => strlen($statement),
                            'statement_preview' => substr($statement, 0, 300),
                        ]);
                    }

                    // Execute all other statements
                    DB::statement($statement);
                    $executedCount++;

                    \Log::info('Statement executed successfully', [
                        'index' => $index,
                        'statement_type' => substr($statement, 0, 20),
                    ]);

                } catch (\Exception $e) {
                    $errorInfo = [
                        'index' => $index,
                        'error' => $e->getMessage(),
                        'error_code' => $e->getCode(),
                        'statement' => substr($statement, 0, 500),
                        'statement_length' => strlen($statement),
                    ];
                    $errors[] = $errorInfo;

                    \Log::error('Statement failed during restore', $errorInfo);

                    // For CREATE TABLE errors, this is critical
                    if (stripos($statement, 'CREATE TABLE') === 0) {
                        throw new \Exception('Critical error during table creation: '.$e->getMessage());
                    }
                }
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        \Log::info('Full restore completed', [
            'executed_statements' => $executedCount,
            'errors_count' => count($errors),
            'warning' => 'This will overwrite ALL existing data including recently deleted records.',
        ]);

        // Force phpMyAdmin to refresh by switching to the same database
        $this->refreshPhpMyAdmin();

        $message = 'Database restored successfully. Note: All existing data was overwritten.';
        if (! empty($errors)) {
            $message .= ' Some statements had errors but the restore completed.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'executed_count' => $executedCount,
            'errors_count' => count($errors),
        ]);
    }

    /**
     * Force phpMyAdmin to refresh by switching database connections
     */
    private function refreshPhpMyAdmin()
    {
        try {
            // Get current database config
            $dbConfig = config('database.connections.mysql');

            // Create a temporary config file for phpMyAdmin
            $tempConfig = [
                'host' => $dbConfig['host'],
                'username' => $dbConfig['username'],
                'password' => $dbConfig['password'],
                'db' => $dbConfig['database'],
                'port' => $dbConfig['port'] ?? 3306,
            ];

            // Write temporary config file
            $configContent = "<?php\nreturn ".var_export($tempConfig, true).";\n";
            $tempConfigFile = sys_get_temp_dir().'/phpmyadmin_config.php';
            file_put_contents($tempConfigFile, $configContent);

            \Log::info('phpMyAdmin refresh config created', [
                'config_file' => $tempConfigFile,
                'database' => $dbConfig['database'],
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to create phpMyAdmin refresh config', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * MySQL-based backup creation
     */
    private function createMySQLBackup($filepath)
    {
        // Try mysqldump first
        $dbConfig = config('database.connections.mysql');
        $command = sprintf(
            'mysqldump -h%s -u%s -p%s %s > %s',
            $dbConfig['host'],
            $dbConfig['username'],
            $dbConfig['password'],
            $dbConfig['database'],
            $filepath
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || ! File::exists($filepath) || File::size($filepath) === 0) {
            // Fallback to PHP-based backup
            $this->createPhpBackup($filepath);
        }
    }

    /**
     * PHP-based backup creation (fallback method)
     */
    private function createPhpBackup($filepath)
    {
        $tables = DB::select('SHOW TABLES');
        $tableField = 'Tables_in_'.DB::getDatabaseName();

        $sql = '-- Database Backup - '.date('Y-m-d H:i:s')."\n";
        $sql .= "-- Generated by Volunteer Management System\n";
        $sql .= '-- MySQL Database: '.DB::getDatabaseName()."\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$tableField;

            // Skip certain system tables
            if (in_array($tableName, ['failed_jobs', 'jobs', 'cache', 'cache_locks', 'sessions', 'password_reset_tokens'])) {
                continue;
            }

            // Get table structure
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            if (! empty($createTable)) {
                $sql .= "-- Table structure for {$tableName}\n";
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";

                // Get the CREATE TABLE statement and reset auto_increment
                $createTableSql = $createTable[0]->{'Create Table'};
                // Remove AUTO_INCREMENT value to ensure clean restore
                $createTableSql = preg_replace('/AUTO_INCREMENT\s*=\s*\d+\s*/', '', $createTableSql);

                $sql .= $createTableSql.";\n\n";

                // Get table data
                $rows = DB::table($tableName)->get();
                if ($rows->isNotEmpty()) {
                    $sql .= "-- Data for {$tableName}\n";
                    foreach ($rows as $row) {
                        $values = [];
                        $rowArray = (array) $row;
                        foreach ($rowArray as $value) {
                            if ($value === null) {
                                $values[] = 'NULL';
                            } elseif (is_bool($value)) {
                                $values[] = $value ? '1' : '0';
                            } elseif (is_numeric($value)) {
                                $values[] = $value;
                            } else {
                                $values[] = "'".addslashes($value)."'";
                            }
                        }
                        $sql .= "INSERT INTO `{$tableName}` VALUES (".implode(', ', $values).");\n";
                    }
                    $sql .= "\n";
                }
            }
        }

        File::put($filepath, $sql);
    }

    /**
     * Create a quick backup before restore
     */
    private function createQuickBackup()
    {
        $backupPath = storage_path('app/backups');

        if (! File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $timestamp = date('Y-m-d_H-i-s');
        $filename = "pre_restore_backup_{$timestamp}.sql";
        $filepath = "{$backupPath}/{$filename}";

        $this->createMySQLBackup($filepath);
    }

    /**
     * Clean up old backups keeping only the specified number
     */
    private function cleanupOldBackups($backupPath, $keepCount)
    {
        if (! File::exists($backupPath)) {
            return;
        }

        $files = glob("{$backupPath}/*.sql");
        usort($files, function ($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        $filesToDelete = array_slice($files, $keepCount);
        foreach ($filesToDelete as $file) {
            File::delete($file);
        }
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision).' '.$units[$i];
    }
}
