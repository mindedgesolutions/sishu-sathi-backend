<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $userId;

    public function __construct(Request $request)
    {
        if ($request->mobile) {
            $user = User::where('mobile', $request->mobile)->first();
            $this->userId = $user?->id;
        }
    }

    // -----------------------------------------

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = User::create([
                'name' => trim($request->name),
                'mobile' => trim($request->mobile),
            ]);

            UserDetails::create(['user_id' => $data->id]);

            $token = $data->createToken(config('app.tokenName'))->accessToken;

            DB::commit();

            return response()->json([
                'data' => UserResource::make($data),
                'token' => $token
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Registration :' . $th->getMessage());
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // -----------------------------------------

    public function triggerOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^(\+?\d{1,3}[- ]?)?\d{10}$/', 'exists:users,mobile']
        ], [
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex' => 'Invalid mobile number format.',
            'mobile.exists' => 'Mobile number does not exist.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $otp = rand(100000, 999999);

        if (UserOtp::where('user_id', $this->userId)->exists()) {
            UserOtp::where('user_id', $this->userId)->delete();
        }

        UserOtp::create([
            'user_id' => $this->userId,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5)
        ])->save();

        return response()->json(['data' => $otp], Response::HTTP_OK);
    }

    // -----------------------------------------

    public function otpLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6'
        ], [
            'otp.required' => 'OTP is required.',
            'otp.digits' => 'OTP must be 6 digits.'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $dbOtp = UserOtp::where('user_id', $this->userId)
            ->where('otp', $request->otp);

        if (!$dbOtp->exists()) {
            return response()->json(['errors' => 'Invalid OTP'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($dbOtp->first()->expires_at < now()) {
            return response()->json(['errors' => 'OTP has expired'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::find($this->userId);
        $token = $user->createToken(config('app.tokenName'))->accessToken;
        $dbOtp->delete();

        return response()->json([
            'data' => UserResource::make($user),
            'token' => $token
        ], Response::HTTP_OK);
    }

    // -----------------------------------------

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
