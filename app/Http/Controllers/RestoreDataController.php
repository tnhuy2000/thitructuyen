<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\BackupDestination\Backup;

class RestoreDataController extends Controller
{

    public function Backup()
    {
        Backup::export();
        Backup::export('database_backup');
    }

    public function Restore(Request $request)

    {

        if (!file_exists(storage_path('upload'))) {

            mkdir(storage_path('upload'));

        }
               
        # Lưu file đã được upload vào thư mục trên server
        
       
        Storage::put('upload', $request->file_sql);

        $sql  = storage_path('app/upload' . '/'.$request->file_sql);

         // Chạy câu lệnh sql và set đồng ý kiểm tra các khoá ngoại trong bảng

        DB::statement("SET foreign_key_checks=1");

// Đọc dữ liệu từ file sql và thực hiện lệnh và sau đó chạy các lệnh sql bằng lệnh unprepared của laravel để có thể chạy được các lệnh sql raw

        

        DB::unprepared(file_get_contents($sql));

        

    }
}
