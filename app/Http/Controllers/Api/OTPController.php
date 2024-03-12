<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;

class OTPController extends Controller
{
    function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'regex:/^\+[0-9]+$/'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorsAsString = implode("\n", $errors->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        $checkUser = User::where('phone', $request->phone)->exists();

        if($checkUser) {
            return response()->json([
                'status' => false,
                'message' => 'user_existed',
                'data' => []
            ], 200);
        }

        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $verificationSID = getenv("TWILIO_VERIFICATION_SID");


        try {
            $twilio = new Client($sid, $token);

            $verification_check = $twilio->verify->v2->services($verificationSID)
                ->verifications
                ->create($request->phone, 'whatsapp');

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => array()
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => array()
            ]);
        }
    }

    function sendForgotOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'regex:/^\+[0-9]+$/'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorsAsString = implode("\n", $errors->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        $checkUser = User::where('phone', $request->phone)->exists();

        if(!$checkUser) {
            return response()->json([
                'status' => false,
                'message' => 'user_not_existed',
                'data' => []
            ], 200);
        }

        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $verificationSID = getenv("TWILIO_VERIFICATION_SID");


        try {
            $twilio = new Client($sid, $token);

            $verification_check = $twilio->verify->v2->services($verificationSID)
                ->verifications
                ->create($request->phone, 'whatsapp');

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => array()
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => array()
            ]);
        }
    }

    function verifyForgotOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'regex:/^\+[0-9]+$/'],
            'code' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorsAsString = implode("\n", $errors->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        $checkUser = User::where('phone', $request->phone)->exists();

        if(!$checkUser) {
            return response()->json([
                'status' => false,
                'message' => 'user_not_existed',
                'data' => []
            ], 200);
        }

        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $verificationSID = getenv("TWILIO_VERIFICATION_SID");
        $twilio = new Client($sid, $token);

        $verification_check = $twilio->verify->v2->services($verificationSID)
            ->verificationChecks
            ->create([
                    "to" => $request->phone,
                    "code" => $request->code,
                    "channel" => 'whatsapp'
                ]
            );

        if(!$verification_check->valid) {
            return response()->json([
                'status' => false,
                'message' => 'invalid_code',
                'data' => []
            ], 200);
        }
        else {
            $user = User::where('phone', $request->phone)->first();


            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => [
                    "uuid" => $user->uuid
                ]
            ], 200);
        }
    }
}
