<?php

namespace App\Http\Controllers;

use App\Helpers\HTTPHelper;
use App\Helpers\MSGHelper;
use App\Models\User;
use App\Models\UsersLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        DB::beginTransaction();
        try {

            $username = $request->input('username');
            $password = $request->input('password');
            $role = str_replace(' ', '', $request->input('role'));

            // check role request
            if (!$role) return HTTPHelper::failed(MSGHelper::MSG_ROLE_REQUIRED, 422);

            // check password
            $user = User::where('username', $username)
                ->where('role', 'like', $role)
                ->first();

            // check user password
            if (!$user || !Hash::check($password, $user->password)) return HTTPHelper::failed(MSGHelper::MSG_LOGIN_FAILED, 422);

            $hasRole = $user->hasRole($role);

            if ($hasRole == false) {
                $user->assignRole($role);
            }

            // check if user doesn't have role
            if (!$user->hasRole($role)) return HTTPHelper::failed(MSGHelper::MSG_ROLE_REQUIRED, 422);

            $credentials = [
                'username' => $username,
                'role' => $role,
                'password' => $password
            ];

            if (Auth::attempt(['username' => $username, 'password' => $password, 'role' => $role])) {
                // response message
                Auth::user();

                $log = UsersLog::create([
                    'username' => $username,
                    'login_date' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                    'login_ip' => request()->ip(),
                    'login_browser' => request()->userAgent(),
                    'result_login' => 'Sukses Auth Login',
                    'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                ]);

                DB::commit();
                return HTTPHelper::success([], MSGHelper::MSG_LOGIN_SUCCESS);
            } else {
                return HTTPHelper::failed(MSGHelper::MSG_LOGIN_FAILED, 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return HTTPHelper::success([], MSGHelper::MSG_LOGOUT_SUCCESS);
        return redirect()->route('login');
    }
}
