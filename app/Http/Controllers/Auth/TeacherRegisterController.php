<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Teacher;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherRegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/teachers';

    public function showRegistrationForm()
    {
        $companies = Company::select('id','name','is_active')->where('is_active',1)->get();
        return view('backend.auth.teacher.register')->with([
            'companies'=>$companies
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $teacher = Teacher::create($input);

        $this->guard('teacher')->login($teacher);

        if ($response = $this->registered($request, $teacher)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectTo);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
