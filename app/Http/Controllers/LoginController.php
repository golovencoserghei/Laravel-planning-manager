<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Log in in application.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function loginView(Request $request)
    {
       return view('auth/login');
    }

    public function login(Request $request)
    {
        $email = $request->post('email'); 
        $password = $request->post('password');

        if (!Auth::attempt(['email'=>$email, 'password'=>$password])) {
            toastr()->warning('! повторите попытку');
            return back()->withInput();
        }

        $user = User::where('email', $email)->firstOrFail();
        Auth::login($user);
        return redirect('/');
    }

    public function logout () 
    {
        Auth::logout();

        return redirect('login');
    }
}
