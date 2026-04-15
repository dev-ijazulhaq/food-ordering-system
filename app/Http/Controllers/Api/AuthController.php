<?php

namespace App\Http\Controllers\Api;

use App\Domains\User\Actions\LoginUserAction;
use App\Domains\User\Actions\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registration(RegisterRequest $request, RegisterUserAction $action)
    {
        try {
            $user = $action->execute(
                $request->name,
                $request->email,
                $request->password,
                $request->role,
                $request->phone_number
            );
            return response()->json([
                'user' => new UserResource($user),
                'message' => 'Registration successful, Please verify your email.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }

    public function login(LoginRequest $request, LoginUserAction $action)
    {
        try {
            $result = $action->execute($request->email, $request->password);
            return response()->json([
                'user' => new UserResource($result['user']),
                'token' => $result['token']
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 401);
        }
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function me()
    {
        return new UserResource(auth()->user());
    }
}
