<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\VerifyOtpRequest;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    use ResponseTrait;
    public function resendOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user->hasVerifiedEmail()) {
            return $this->respondUnprocessableEntity('Email already verified');
        }
        VerificationCode::where('user_id', $user->id)->delete();
        $user->sendEmailVerificationNotification();
        return response(["status" => 200, "message" => "OTP sent successfully"]);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = User::find($request->user_id);

        if (!$user->hasVerifiedEmail()) {
            $verificationCode = VerificationCode::where([['user_id', $request->user_id], ['otp', $request->otp]])->first();
            $now = Carbon::now();

            if (!$verificationCode) {
                return $this->respondUnprocessableEntity('Your OTP is not correct');
            } elseif ($verificationCode && $now->isAfter($verificationCode->expire_at)) {
                return $this->respondUnprocessableEntity('Your OTP has been expired');
            }

            $tokenResult = $user->createToken('Personal Access Token');
            $user->markEmailAsVerified();
            return $this->respondSuccess([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'access_token' => $tokenResult->plainTextToken,
            ]);
        } else {
            return $this->respondUnprocessableEntity('Email already verified');
        }
    }

}
