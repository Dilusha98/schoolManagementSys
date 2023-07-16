<?php

namespace App\Http\Controllers;

use App\Models\UserManagment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function index(Request $request)
    {
        $userName = $request->userName;
        $passWord = $request->passWord;

        $user = UserManagment::where(function ($query) use ($userName) {
            $query->where('UserUserName', $userName)
                ->orWhere('userEmail', $userName);
        })->first();

        if ($user && Hash::check($passWord, $user->userPassword)) {
            if ($user->role == 1) {
                $request->session()->put('name', 'admin');
                $request->session()->put('user', $user);
                return 1;
            } else {
                $request->session()->put('name', 'teacher');
                $request->session()->put('user', $user);
                return 2;
            }
            
        } else {
            return response()->json([
                'error' => 'Incorrect username or password !',
            ]);
        }

    }
}
