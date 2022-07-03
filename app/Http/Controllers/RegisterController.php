<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Log in in application.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function edit()
    {
       return view('registration/register');
    }

    public function store(Request $request)
    {
        $name = $request->post('name');
        $prename = $request->post('prename');
        $email = $request->post('email'); 
        $password = $request->post('password');
        $passwordHash = Hash::make($password);

        User::create([
            'name' => $name,
            'prename' => $prename,
            'email' => $email,
            'password' => $passwordHash
        ]);
        return redirect('login');
    } 
}
