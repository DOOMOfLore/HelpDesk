<?php

namespace App\Http\Controllers\Status;

use App\Helpers\HTTPHelper;
use App\Helpers\MainHelper;
use App\Helpers\MSGHelper;
use App\Http\Controllers\Controller;
use App\Models\Status\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $rules = [
        'status' => 'required',
        'description' => '',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.status.index');
    }

    public function getStatus(Request $request)
    {
        $start = Status::select('*')->where(['is_active' => '1']);

        if (!empty($start)) {
            $data = Status::select('*')->where(['is_active' => '1']);
        } else {
            $data = Status::all();
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
                    '<i class="fa fa-pencil text-info btn btn-primary btn-sm m-r-10" data-toggle="tooltip" data-placement="top" title="Edit" id="getEdit" data-id="' . MainHelper::encrypt($data->status_id) . '" onchange="validate(this)"></i>' .
                    '<i data-id="' . MainHelper::encrypt($data->status_id) . '" data-toggle="modal" data-target="#DeleteUsersModel" id="getDeleteId" class="fa fa-trash text-info btn btn-danger btn-sm m-r-10" data-toggle="tooltip" title="Delete"></i>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
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

        $status = $validator['status'];
        $description = $validator['description'];

        $created = [
            'status' => $status,
            'description' => $description,
            'is_active' => '1',
            'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ];


        $user = Auth::user()->id;
        $anEloquentModel = new Status();
        activity()
            ->performedOn($anEloquentModel)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $created
            ])
            ->log('Created New Status');

        $create = Status::create($created);

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
        $data = Status::find($id);

        $encrypt_id = MainHelper::encrypt($id);

        return view('backend.status.edit', compact(array('data', 'encrypt_id')));
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
        $id = MainHelper::decrypt($id);
        $validator = $this->validate($request, $this->rules);

        $data =  Status::find($id);

        $status = $validator['status'];
        $description = $validator['description'];

        $updated = [
            'status' => $status,
            'description' => $description,
            'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ];

        $user = Auth::user()->id;
        $anEloquentModel = new Status();

        activity()
            ->performedOn($anEloquentModel)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $updated
            ])
            ->log('Updated Status');

        $update = Status::find($id)->update($updated);

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
        $id = MainHelper::decrypt($id);
        $user = Auth::user()->id;
        $anEloquentModel = new Status();
        $data = Status::find($id);

        $deleted = [
            'is_active' => '0',
            'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ];

        activity()
            ->performedOn($anEloquentModel)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $data
            ])
            ->log('Deleted Status');

        Status::find($id)->update($deleted);
        return HTTPHelper::success([], MSGHelper::MSG_DELETE_SUCCESS);
    }
}
