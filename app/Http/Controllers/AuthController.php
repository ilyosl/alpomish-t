<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(RegisterUserRequest $request, AuthService $service){
//        dd($request);
        $user = $service->StoreNewUser($request->validated());
        return response($user);
    }

    public function login(LoginUserRequest $request, AuthService $service){
        $credentials = $request->validated();
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if(!($user = $service->isAuth($credentials, $remember))){
            return response([
                'error' => 'Credentials are not correct'
            ], 422);
        }
        $token = $service->GetTokenUser($user);

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }
    public function logout()
    {
        /** @var User $user **/
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }

}
