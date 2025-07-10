<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Backup;
use Illuminate\Support\Facades\Storage;
use Spatie\DbDumper\Databases\MySql;
use App\Jobs\BackupJob;
use App\Helpers\QueueHelper;

class BackupController extends Controller
{

    public function index()
    {
        $backups = Backup::all(); // Ambil daftar backup dari database

        $data = [
            'judul' => "Pemeliharaan Sistem",
            'backups' => $backups,
        ];

        return view('admin.pemeliharaan.pemeliharaan', $data);
    }

    public function createBackup()
    {
        BackupJob::dispatch(); // Antri ke queue

        // Jalankan worker hanya di production
        if (app()->environment('production')) {
            QueueHelper::runQueueWorkerInBackground(); // Boleh tetap pakai ini
        }

        // Kembalikan respon langsung tanpa menunggu worker selesai
        return response()->json([
            'success' => true,
            'message' => 'Backup sedang diproses. Anda bisa melanjutkan aktivitas lain.'
        ]);
    }




    public function downloadBackup($filename)
    {
        $file = Backup::where('filename', $filename)->firstOrFail();
        return response()->download(storage_path('app/' . $file->path));
    }

    public function backupDatabase()
    {
        // Path file backup yang akan dibuat
        $filePath = storage_path('app/backup_' . now()->format('Y_m_d_H_i_s') . '.sql');

        // Buat backup database
        MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->dumpToFile($filePath);

        // Kembalikan file backup sebagai respons download
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function deleteBackup($filename)
    {
        $backup = Backup::where('filename', $filename)->firstOrFail();

        // Hapus file dari storage lokal
        Storage::disk('local')->delete($backup->path);

        // Hapus data backup dari database
        $backup->delete();

        return response()->json([
            'success' => true,
            'message' => 'Backup berhasil dihapus!'
        ]);
    }
}
