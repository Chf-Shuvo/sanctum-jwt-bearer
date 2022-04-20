<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            return User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function login(Request $request)
    {
        try {
            if (Auth::attempt($request->only("email", "password"))) {
                $user = auth()->user();
                $token = $user->createToken("token")->plainTextToken;
                return response(
                    [
                        "token" => $token,
                        "user" => $user,
                    ],
                    Response::HTTP_ACCEPTED
                );
            } else {
                return response(
                    [
                        "message" => "Invalid Credentials, Access Denied!",
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function logout()
    {
        try {
            auth()
                ->user()
                ->tokens()
                ->delete();
            return response(
                [
                    "response" => "success",
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
