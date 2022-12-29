<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Congregation;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Log in in application.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function edit(): View|Factory|Application
    {
        $congregations = Congregation::query()->select('id', 'name')->get();

       return view('registration/register', compact('congregations'));
    }

    public function store(Request $request)
    {
        $name = $request->post('name');
        $prename = $request->post('prename');
        $email = $request->post('email');
        $password = $request->post('password');
        $congregationId = $request->post('congregation');
        $passwordHash = Hash::make($password);

        User::create([
            'name' => $name,
            'prename' => $prename,
            'congregation_id' => $congregationId,
            'email' => $email,
            'password' => $passwordHash
        ]);
        return redirect('login');
    }
}
