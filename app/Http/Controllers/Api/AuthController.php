<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    use ResponseTrait;

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
             'phone' => $request->phone,
        ]);
        $user->sendEmailVerificationNotification();
        return $this->respondSuccess([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return $this->respondUnprocessableEntity('Incorrect username or password');
        }
        $tokenResult = auth()->user()->createToken('Personal Access Token');
        return $this->respondSuccess([
            'id' => auth()->user()->id,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'access_token' => $tokenResult->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $user = auth()->user()->tokens();
        $user->delete();
        return $this->respondSuccess([
            'user' => 'Logout success'
        ]);
    }


}
