<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Repository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard('api')->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => Lang::get('default.unauthorized')], 401);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function logout()
    {
        $this->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        $user = User::find(auth('api')->user()->id);

        if ($user->status !== Status::ACTIVE) {
            return response()->json(['error' => Lang::get('default.inactive_account')], 401);
        }

        UserRepository::updateFirstLogin();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard('api')->factory()->getTTL() * 500,
            'id'         => $user->id,
            'type'       => $user->type,
            'type_name'  => $user->type_name,
            'first_login'  => $user->first_login,
        ]);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
