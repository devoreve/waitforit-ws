<?php

namespace App\Http\Controllers;

use App\ResetPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    use ResetPasswords;

    protected $broker = 'users';

    public function getResetForm($token, Request $request)
    {
        $email = $request->get('email');
        return view('auth.password.reset', compact('token', 'email'));
    }
}