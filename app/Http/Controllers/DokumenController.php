<?php

namespace App\Http\Controllers;

use App\Helpers\HTTPHelper;
use App\Helpers\MainHelper;
use App\Helpers\MSGHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $kode = MainHelper::kode();
        $categories = MainHelper::categories();
        $main_menu = MainHelper::main_menu();

        return view('welcome', compact(array('kode', 'categories', 'main_menu')));
    }

    public static function check(Request $request)
    {
        $file = MainHelper::decrypt($request->file);
        $DokumenDirectory = MSGHelper::DokumenDirectory;
        $filename = urldecode($file);
        $filePath = $DokumenDirectory . '/' . $filename;
        // if file is not found
        if (!Storage::exists($filePath)) return HTTPHelper::notFound('file is not found');
        $data = Storage::path($filePath);
        return HTTPHelper::success([$data], 'File Ada');
    }
}
