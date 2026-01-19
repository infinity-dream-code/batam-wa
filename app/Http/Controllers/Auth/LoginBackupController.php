<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Validation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Validator;

class LoginBackupController extends Controller
{

    use Authenticatable;

    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('Admin.index');
        }
        return view("login");
    }

    public function authenticate(Request $request)
    {
        $canLogin = true;
        $loginWith = "Username";
        $input = $request->all();

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $rules = [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $canLogin = false;
            $message_errors = (new Validation)->modify($validator, $rules);

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Required Form',
                'validation_errors' => $message_errors,
            ], 200);
        }

        if ($canLogin) {
            if (Auth::attempt(array($fieldType => $input['username'], 'password' => $input['password']))) {
                // return redirect()->route('home');
                return response()->json([
                    'status' => true,
                    'alert' => 'success',
                    'message' => 'Sukses login',
                    'redirect_to' => route('Admin.index'),
                    'validation_errors' => []
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'alert' => 'danger',
                    'message' => $loginWith . ' dan password tidak cocok',
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => $loginWith . ' tidak terdaftar pada sistem admin!',
            ], 200);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required'],
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('dashboard');
    }
}
