<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index(UserLoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return response()->json([
                'Error' => 'Credenciales incorrectas'
            ], 401);
        }

        $user = User::query()->where('email', $request->only('email'))->first();

        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            $token = $user->createToken(Str::random())->plainTextToken;

            return response()->json([
                'access_token' => $token
            ]);
        }

        return response()->json([
            'Error' => 'No tienes permisos para la api'
        ], 403);
    }
}
