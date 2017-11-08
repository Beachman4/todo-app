<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserRegistered;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;
use Auth;
use Mail;
use Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $creds = [
            'email' => $email,
            'password' => $password
        ];

        try {
            if (!$token = JWTAuth::attempt($creds)) {
                throw new UnauthorizedHttpException('', "Invalid Credentials");
            }
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('', 'An error occurred');
        }

        $user = $this->user();

        return response()->json(compact('token', 'user'));
    }

    public function register(Request $request)
    {
        $array = $request->only(['email', 'name', 'password']);

        $array['password'] = Hash::make($array['password']);

        $user = User::create($array);

        $token = JWTAuth::fromUser($user);

        Mail::to($user)->send(new UserRegistered($user));

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function authenticate()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            throw new UnauthorizedHttpException('', 'An error occurred');

        } catch (TokenInvalidException $e) {

            throw new BadRequestHttpException('An error occurred');

        } catch (JWTException $e) {

            throw new HttpException('An error occurred');

        }

        // the token is valid and we have found the user via the sub claim
        return $this->user();
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
