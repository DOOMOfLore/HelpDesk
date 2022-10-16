<?php

namespace App\Http\Controllers\Complaint;

use App\Helpers\HTTPHelper;
use App\Helpers\MainHelper;
use App\Helpers\MSGHelper;
use App\Http\Controllers\Controller;
use App\Models\Categories\Categories;
use App\Models\Complaint\Complaint;
use App\Models\MainMenu\MainMenu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class WaitingApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
    protected $rules_update = [
        'complaint_name' => 'required',
        'code_request' => 'required',
        'mps_user' => 'required',
        'main_menu' => 'required',
        'categories' => 'required',
        'other_categories' => '',
        'description' => 'required',
        'request' => 'required',
        'reason' => 'required',
        'status_code' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kode = MainHelper::kode();
        $categories = MainHelper::categories();
        $main_menu = MainHelper::main_menu();

        return view('backend.complaint.waitingapproval.index', compact(array('kode', 'categories', 'main_menu')));
    }

    public function getWaitingApproval(Request $request)
    {
        $start = Complaint::select('*')->where(['is_active' => '1']);

        if (!empty($start)) {
            $data = Complaint::select('*')->where(['complaint_status_code' => 'waiting approval'])->where(['is_active' => '1']);
        } else {
            $data = Complaint::all();
        }

        return DataTables::of($data)
            ->addColumn('description', function ($data) {
                $description = substr($data->description, 0, 100);
                return $description;
            })
            ->addColumn('created_at', function ($data) {
                $created_at = Carbon::parse($data->created_at)->setTimezone('Asia/Jakarta')->format("Y-m-d H:i:s");
                return $created_at;
            })
            ->addColumn('updated_at', function ($data) {
                $updated_at = Carbon::parse($data->updated_at)->setTimezone('Asia/Jakarta')->format("Y-m-d H:i:s");
                return $updated_at;
            })
            ->addColumn('Actions', function ($data) {
                return
                    '<i class="fa fa-pencil text-info btn btn-primary btn-sm m-r-10" data-toggle="tooltip" data-placement="top" title="Edit" id="getEdit" data-id="' . MainHelper::encrypt($data->complaint_id) . '" onchange="validate(this)"></i>' .
                    '<i data-id="' . MainHelper::encrypt($data->complaint_id) . '" data-toggle="modal" data-target="#DeleteUsersModel" id="getDeleteId" class="fa fa-trash text-info btn btn-danger btn-sm m-r-10" data-toggle="tooltip" title="Delete"></i>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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


        $user = Auth::user()->id;
        $anEloquentModel = new User();
        activity()
            ->performedOn($anEloquentModel)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $created
            ])
            ->log('Created New Complaint');

        $create = Complaint::create($created);

        if (!$create) return HTTPHelper::failed(MSGHelper::MSG_CREATE_FAILED, 422);

        return HTTPHelper::success([], MSGHelper::MSG_CREATE_SUCCESS);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = MainHelper::decrypt($id);
        $data = Complaint::find($id);

        $encrypt_id = MainHelper::encrypt($id);

        $main_menu = MainMenu::pluck('main_menu', 'main_menu');
        // dd($main_menu);
        $selectedMainMenu = MainMenu::where('main_menu', $data->main_menu)->first();
        $selectedIDMainMenu = $selectedMainMenu->main_menu;

        $categories = Categories::pluck('categories', 'categories');
        $selectedCategories = Categories::where('categories', $data->categories)->first();
        $selectedIDCategories = $selectedCategories->categories;

        $status_code = MainHelper::status_code();
        $selectedstatus_code = Complaint::where('complaint_status_code', $data->complaint_status_code)->first();
        $selectedComplaint_status_code = $selectedstatus_code->complaint_status_code;

        return view('backend.complaint.waitingapproval.edit', compact(array('data', 'encrypt_id', 'main_menu', 'selectedIDMainMenu', 'categories', 'selectedIDCategories', 'status_code', 'selectedComplaint_status_code')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $id = MainHelper::decrypt($id);
        $validator = $this->validate($request, $this->rules_update);
        $data =  Complaint::find($id);

        $status_code = MainHelper::convertValueToLowerCase($validator['status_code']);

        if ($status_code == 'release') {

            $release = [
                'complaint_status' => 'release',
                'complaint_status_code' => 'release',
            ];

            $update = Complaint::find($id)->update($release);
        }

        if ($status_code == 'waiting approval') {
            $waiting_approval = [
                'complaint_status' => 'on progress',
                'complaint_status_code' => 'waiting approval',
            ];

            $update = Complaint::find($id)->update($waiting_approval);
        }

        if ($status_code == 'on process') {
            $onprocess = [
                'complaint_status' => 'on progress',
                'complaint_status_code' => 'on process',
            ];

            $update = Complaint::find($id)->update($onprocess);
        }

        if ($status_code == 'unapproved') {
            $unapproved = [
                'complaint_status' => 'unapproved',
                'complaint_status_code' => 'unapproved',
            ];

            $update = Complaint::find($id)->update($unapproved);
        }

        $complaint_name = $validator['complaint_name'];
        $code_request = $validator['code_request'];
        $mps_user = $validator['mps_user'];
        $main_menu = $validator['main_menu'];
        $categories = $validator['categories'];
        $other_categories = $validator['other_categories'];
        $description = $validator['description'];
        $request2 = $validator['request'];
        $reason = $validator['reason'];
        $complaint_source_division = 'default';
        $complaint_classification = 'default';
        $complaint_sub_classification = 'default';
        $complaint_pic = 'default';
        $complaint_treatment = 'default';
        $complaint_user_input = 'default';
        $filename = $request->filename;

        $updated = [
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
            'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ];

        $user = Auth::user()->id;
        $anEloquentModel = new User();

        activity()
            ->performedOn($anEloquentModel)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $updated
            ])
            ->log('Updated Complaint');

        $update = Complaint::find($id)->update($updated);

        if (!$update) return HTTPHelper::failed(MSGHelper::MSG_UPDATE_FAILED, 422);
        return HTTPHelper::success([], MSGHelper::MSG_UPDATE_SUCCESS);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
