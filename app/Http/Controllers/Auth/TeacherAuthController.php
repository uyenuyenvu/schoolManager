<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TeacherAuthController extends Controller
{
    use AuthenticatesUsers;


    protected $redirectTo = 'teachers/';

    protected function guard()
    {
        return Auth::guard('teacher');
    }

    public function showLoginForm()
    {
        return view('backend.auth.teacher.login');
    }




    public function login(Request $request)
    {

        $this->validateLogin($request);


        $teacher = Teacher::where('email', $request->email)->first();

        if($teacher==null)
        {
            Session::put('login_error', 'Tài khoản không tồn tại');
            return back();
        }

        if($teacher->is_active != 1)
        {
            Session::put('login_error', 'Tài khoản đang bị khóa');
            return back();
        }



        if (auth()->guard('teacher')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'deleted_at' => null])) {
            return redirect($this->redirectTo);
        }
    }



    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        return redirect('/');
    }
}
