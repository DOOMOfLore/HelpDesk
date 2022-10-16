<?php

namespace App\Helpers;

use App\Models\Categories\Categories;
use App\Models\MainMenu\MainMenu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MainHelper
{
    public static function encrypt($string)
    {
        $encrypted = Crypt::encryptString($string);
        return $encrypted;
    }

    public static function decrypt($string)
    {
        $encrypted = Crypt::decryptString($string);
        return $encrypted;
    }

    public static function convertValueToLowerCase($request)
    {
        return strtolower($request);
    }
    public static function convertValueToUpperCase($request)
    {
        return strtoupper($request);
    }

    public static function uploadPictureProcess($file, $directory, $filename = null)
    {
        if (!$filename || strtolower($filename) == 'null') abort(401, 'Nama file tidak boleh kosong');
        return Storage::putFileAs($directory, $file, $filename);
    }

    public static function PathFile()
    {
        $path = MSGHelper::DokumenDirectory;

        if (!File::isDirectory($path)) {
            $basepath =  File::makeDirectory($path, 0777, true, true);
        }
        $basepath = $path;

        return $basepath;
    }


    public static function uploadPictures(Request $request, $filename)
    {
        $DokumenDirectory = MSGHelper::DokumenDirectory;

        $filename = urldecode($filename);
        try {
            if (empty($request->file('file'))) return HTTPHelper::failed('Unggah file tidak berhasil');

            if (!$filename) return HTTPHelper::failed('Nama file tidak boleh kosong');

            $PathFile = MainHelper::PathFile();

            $filePath = MainHelper::uploadPictureProcess(
                $request->file,
                $DokumenDirectory,
                $filename
            );

            return HTTPHelper::success([], 'Unggah File Berhasil');
        } catch (\Exception $e) {
            return HTTPHelper::failed($e->getMessage());
        }
    }

    public static function kode()
    {
        $kode = DB::table('complaint')->max('complaint_id');
        $date = Carbon::now()->setTimezone('Asia/Jakarta')->format('Ymd');
        $addNol = '';
        $kode = str_replace("PGJ", "", $kode);
        $kode = (int) $kode + 1;
        $incrementKode = $kode;

        if (strlen($kode) == 1) {
            $addNol = "0000";
        } elseif (strlen($kode) == 2) {
            $addNol = "000";
        } elseif (strlen($kode == 3)) {
            $addNol = "00";
        } elseif (strlen($kode == 4)) {
            $addNol = "0";
        }

        $kodeBaru = "COMP-" . $date . $addNol . $incrementKode;
        return $kodeBaru;
    }

    public static function categories()
    {
        $value = Categories::select('categories')
            ->where('is_active', 1)
            ->pluck('categories', 'categories');
        // ->pluck('categories');

        return $value;
    }

    public static function main_menu()
    {
        $value = MainMenu::select('main_menu')
            ->where('is_active', 1)
            ->pluck('main_menu', 'main_menu');
        // ->pluck('main_menu');

        return $value;
    }

    public static function status_code()
    {
        $value = [
            'release' => 'release',
            'waiting approval' => 'waiting approval',
            'on process' => 'on process',
            'unapproved' => 'unapproved'
        ];
        return $value;
    }
}
