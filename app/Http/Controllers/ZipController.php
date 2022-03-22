<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use File;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
class ZipController extends Controller
{
    public function zipFile_SVBaiThi(Request $request)
    {
        $zip_file = $request->masinhvien.'.zip';
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $path = storage_path('app/'.$request->duongdan);
       // 
        //dd($path);
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath= $file->getRealPath();
                // extracting filename with substr/strlen
                $relativePath = $request->masinhvien.'/' . substr($filePath, strlen($path) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
    }
    public function zipFile_PhongThi(Request $request)
    {
        $subject = $request->duongdan;
        $search = ['/'];
        $replace   = '_';
        $result = str_replace($search, $replace, $subject);
    
        $zip_file = $result.'.zip';
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $path = storage_path('app/'.$request->duongdan);
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = $request->duongdan.'/' . substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
    }
    public function zipFile_DLNgayThi($ngaythi)
    {
    
        $zip_file = $ngaythi.'.zip';
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $path = storage_path('app/file/baithi/'.$ngaythi);
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = $ngaythi.'/' . substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
    }
    public function zipFile_DLCaThi($ngaythi,$cathi)
    {
    
        $zip_file = $cathi.'.zip';
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $path = storage_path('app/file/baithi/'.$ngaythi.'/'.$cathi);
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = $cathi.'/' . substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
    }
    public function zipFile_DLPhongThi($ngaythi,$cathi,$phongthi)
    {
    
        $zip_file = $phongthi.'.zip';
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $path = storage_path('app/file/baithi/'.$ngaythi.'/'.$cathi.'/'.$phongthi);
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = $phongthi.'/' . substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
    }
}
