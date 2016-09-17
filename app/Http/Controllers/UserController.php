<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 17/09/16
 * Time: 15:59
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

    public function auth(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:3|max:255',
            'password' => 'required'
        ]);

        $token = Auth::attempt($request->only(['username', 'password']));

        if($token === false)
        {
            return response()->json(['error' => 'Invalid user']);
        }

        return $token;
    }

}