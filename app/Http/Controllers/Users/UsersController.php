<?php

namespace App\Http\Controllers\Users;

use App\Helpers\HTTPHelper;
use App\Helpers\MainHelper;
use App\Helpers\MSGHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Collective\Html\FormFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public $rules = [
        'username' => 'required',
        'role' => 'required',
        'name' => 'required',
        'email' => 'required|unique:users,email',
        'password' => 'required|min:8|max:12',
    ];
    public $rules_updated = [
        'username' => 'required',
        'role' => 'required',
        'name' => 'required',
        'email' => 'required',
    ];

    public function index()
    {
        return view('backend.users.index');
    }

    public function getUsers(Request $request)
    {
        $data = User::all();
        return DataTables::of($data)
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
                    '<i id="getEditData" data-id="' . MainHelper::encrypt($data->id) . '" class="fa fa-pencil text-info btn btn-primary btn-sm m-r-10" data-toggle="tooltip" title="Edit"></i>
                    <i data-id="' . MainHelper::encrypt($data->id) . '" data-toggle="modal" data-target="#DeleteUsersModel" id="getDeleteId" class="fa fa-trash text-info btn btn-danger btn-sm m-r-10" data-toggle="tooltip" title="Delete"></i>';
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

        $username = $validator['username'];
        $role = $validator['role'];
        $name = $validator['name'];
        $email = $validator['email'];
        $password = $validator['password'];

        $created = [
            'username' => $username,
            'role' => $role,
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
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
            ->log('Created New Users');

        $create = User::create($created);

        $id = User::where('username', $username)->where('role', $role)->where('name', $name)->where('email', $email)->first()->assignRole($role);

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
        $data = User::find($id);

        $name = MainHelper::roles();
        $getName = DB::table('roles')->where('name', $data->role)->first();
        $selectedName = $getName->name;

        // $status_code = MainHelper::status_code();
        // $selectedstatus_code = Complaint::where('complaint_status_code', $data->complaint_status_code)->first();
        // $selectedComplaint_status_code = $selectedstatus_code->complaint_status_code;

        $html = '<div class="form-group">
                    <label for="Username">Username:</label>
                    <input type="text" class="form-control" name="username" id="editUsername" value="' . $data->username . '">
                </div>
                <div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="name" id="editName" value="' . $data->name . '">
                </div>
                
                <div class="form-group">
                    <label for="role">Role:</label>
                    <input type="hidden" id="n_role" value="' . $data->role . '">
                    ' . FormFacade::select("role", $name, $selectedName, ["class" => "form-control", "id" => "editRole"]) . '
                </div>

                <div class="form-group">
                    <label for="Email">Email:</label>
                    <input type="email" class="form-control" name="email" id="editEmail" value="' . $data->email . '">
                </div>';

        return response()->json(['html' => $html]);
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
        $source = User::where('email', $request->email)->get();
        $source_email = collect($source, true)->implode('email');

        $validator = $this->validate($request, $this->rules_updated);

        $username = $validator['username'];
        $role = $validator['role'];
        $name = $validator['name'];
        $email = $validator['email'];

        $updated1 = [
            'username' => $username,
            'role' => $role,
            'name' => $name,
        ];

        $updated = [
            'username' => $username,
            'role' => $role,
            'name' => $name,
            'email' => $email,
        ];

        $user = Auth::user()->id;
        $anEloquentModel = new User();

        if ($email == $source_email) {
            activity()
                ->performedOn($anEloquentModel)
                ->causedBy($user)
                ->withProperties([
                    'attributes' => $updated1
                ])
                ->log('Updated Users ( Same Email )');
            $update = User::find($id)->update($updated1);
        } else {
            activity()
                ->performedOn($anEloquentModel)
                ->causedBy($user)
                ->withProperties([
                    'attributes' => $updated
                ])
                ->log('Updated Users ( Different Email )');
            $update = User::find($id)->update($updated);
        }
        $roles = User::find($id)->syncRoles($role);
        // $user->syncRoles(['writer', 'admin']);

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
        $anEloquentModel = new User();
        $data = User::find($id);
        activity()
            ->performedOn($anEloquentModel)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $data
            ])
            ->log('Deleted Users');
        User::find($id)->delete($id);
        return HTTPHelper::success([], MSGHelper::MSG_DELETE_SUCCESS);
    }
}
