<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class TestUserController extends Controller
{
    public function login($id)
    {
        $user = User::find($id);

        $token = \JWTAuth::fromUser($user);

        return response()->json(compact('token'))->cookie('todoToken', $token, 1000, null, null, false, false);
    }
}
