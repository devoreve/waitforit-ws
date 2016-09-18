<?php

namespace App\Http\Controllers;

use App\ResetPasswords;

class PasswordController extends Controller
{
    use ResetPasswords;

    protected $broker = 'users';
}