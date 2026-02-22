<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    /**
     * Display list of backups.
     */
    public function index()
    {
        $backupPath = storage_path('app/backups');
        
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $files = File::files($backupPath);
        
        $backups = collect($files)
            ->filter(function ($file) {
                return $file->getExtension() === 'sql' || $file->getExtension() === 'zip';
            })
            ->map(function ($file) {
                return [
                    'name' => $file->getFilename(),
                    'size' => $this->formatSize($file->getSize()),
                    'date' => date('Y-m-d H:i:s', $file->getMTime()),
                ];
            })
            ->sortByDesc('date')
            ->values();

        return view('admin.backup.index', compact('backups'));
    }

    /**
     * Create a new backup.
     */
    public function create()
    {
        try {
            $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);

            // Get database configuration
            $host = env('DB_HOST');
            $port = env('DB_PORT');
            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');

            // Create backup command
            $command = sprintf(
                'mysqldump -h %s -P %s -u %s %s > %s',
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($username),
                escapeshellarg($database),
                escapeshellarg($path)
            );

            if (!empty($password)) {
                $command = sprintf(
                    'mysqldump -h %s -P %s -u %s -p%s %s > %s',
                    escapeshellarg($host),
                    escapeshellarg($port),
                    escapeshellarg($username),
                    escapeshellarg($password),
                    escapeshellarg($database),
                    escapeshellarg($path)
                );
            }

            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                throw new \Exception('Backup creation failed.');
            }

            return redirect()->route('admin.backup')
                ->with('success', 'Backup created successfully.');

        } catch (\Exception $e) {
            return redirect()->route('admin.backup')
                ->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    /**
     * Download a backup file.
     */
    public function download($file)
    {
        $path = storage_path('app/backups/' . $file);

        if (!File::exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }

    /**
     * Delete a backup file.
     */
    public function destroy($file)
    {
        $path = storage_path('app/backups/' . $file);

        if (File::exists($path)) {
            File::delete($path);
            return redirect()->route('admin.backup')
                ->with('success', 'Backup deleted successfully.');
        }

        return redirect()->route('admin.backup')
            ->with('error', 'Backup file not found.');
    }

    /**
     * Format file size.
     */
    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}