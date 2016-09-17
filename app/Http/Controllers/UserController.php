<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 17/09/16
 * Time: 15:59
 */

namespace App\Http\Controllers;

use Canis\Lumen\Jwt\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'register']]);
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

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $result = DB::table('users')->insert([
            [
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password'))
            ]
        ]);

        /** @var Token $token */
        $token = Auth::attempt($request->only(['username', 'password']));

        return response()->json(['success' => $result, 'token' => $token->getTokenString()]);
    }

}