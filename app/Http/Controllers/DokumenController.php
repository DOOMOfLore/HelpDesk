<?php

namespace App\Http\Controllers;

use App\Helpers\HTTPHelper;
use App\Helpers\MainHelper;
use App\Helpers\MSGHelper;
use App\Models\Complaint\Complaint;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    protected $rules = [
        'complaint_name' => 'required',
        'code_request' => 'required',
        'mps_user' => 'required',
        'main_menu' => 'required',
        'categories' => 'required',
        'other_categories' => '',
        'description' => 'required',
        'request' => 'required',
        'reason' => 'required',
        'file' => 'required|mimes:pdf,jpg,jpeg,png',
    ];

    public function index()
    {
        $kode = MainHelper::kode();
        $categories = MainHelper::categories();
        $main_menu = MainHelper::main_menu();

        return view('welcome', compact(array('kode', 'categories', 'main_menu')));
    }
    
    public function storecomplaint(Request $request)
    {
        $validator = $this->validate($request, $this->rules);

        $complaint_name = $validator['complaint_name'];
        $code_request = $validator['code_request'];
        $mps_user = $validator['mps_user'];
        $main_menu = $validator['main_menu'];
        $categories = $validator['categories'];
        $other_categories = $validator['other_categories'];
        $description = $validator['description'];
        $request2 = $validator['request'];
        $reason = $validator['reason'];
        $file = $validator['file'];
        $complaint_source_division = 'default';
        $complaint_classification = 'default';
        $complaint_sub_classification = 'default';
        $complaint_pic = 'default';
        $complaint_treatment = 'default';
        $complaint_user_input = 'default';
        $complaint_status = 'release';
        $complaint_status_code = 'release';

        $today = Carbon::now()->setTimezone('Asia/Jakarta')->format("Y-m-d g:i:s A");
        // Array containing search string
        $searchVal = array("-", "/", ":", " ");
        // Array containing replace string from  search string
        $replaceVal = array("", "", "", "");
        // Function to replace string
        $base_filename = str_replace($searchVal, $replaceVal, $today);
        $extension = '.' . $file->extension();
        $filename = MainHelper::convertValueToUpperCase($base_filename . $extension);
        $upload = MainHelper::uploadPictures($request, $filename);

        // dd($file);


        $created = [
            'complaint_name' => $complaint_name,
            'code_request' => $code_request,
            'mps_user' => $mps_user,
            'main_menu' => $main_menu,
            'categories' => $categories,
            'other_categories' => $other_categories,
            'description' => $description,
            'request' => $request2,
            'reason' => $reason,
            'picture' => $filename,
            'complaint_source_division' => $complaint_source_division,
            'complaint_classification' => $complaint_classification,
            'complaint_sub_classification' => $complaint_sub_classification,
            'complaint_pic' => $complaint_pic,
            'complaint_treatment' => $complaint_treatment,
            'complaint_user_input' => $complaint_user_input,
            'complaint_status' => $complaint_status,
            'complaint_status_code' => $complaint_status_code,
            'is_active' => '1',
            'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ];


        activity()
            ->withProperties([
                'attributes' => $created
            ])
            ->log('User Created New Complaint');

        $create = Complaint::create($created);

        if (!$create) return HTTPHelper::failed(MSGHelper::MSG_CREATE_FAILED, 422);

        return HTTPHelper::success([], MSGHelper::MSG_CREATE_SUCCESS);
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
