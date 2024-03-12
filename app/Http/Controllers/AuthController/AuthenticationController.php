<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\fees;
use App\Models\Sbank;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'phone' => ['required', 'string', 'regex:/^\+[0-9]+$/', 'unique:users,phone'],
            'country_code' => ['required', 'string', 'regex:/^[0-9]+$/'],
            'password' => 'required|string|min:4|confirmed',
            'verification' => 'required|string'
        ]);

        if ($validator->fails()) {
            $errorsAsString = implode("\n", $validator->errors()->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        // Validate the verification code (remove Twilio verification)

        // Create and save the user
        $user = new User();
        $user->fill([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email ?? null,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'country_code' => $request->country_code,
            'password' => Hash::make($request->password),
            'uuid' => Str::uuid(),
        ]);
        $user->save();

        // Generate an authentication token
        $token = $user->createToken('token-name')->plainTextToken;

        // Fetch additional data for the response
        $userData = $user->only(['id', 'first_name', 'last_name', 'email', 'date_of_birth', 'phone', 'country_code']);
        // $userData['notification'] = DB::table('notifications')
        //     ->select('read_at')
        //     ->where('notifiable_id', $user->id)
        //     ->whereNull('read_at')->count();

        $subBank = Sbank::get();
        $fees = Fees::get();
        // $generalSettings = GeneralSetting::first();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'token' => $token,
                'user' => $userData,
                'sub_bank' => $subBank,
                'fees' => $fees,
                // 'general_settings' => $generalSettings,
            ],
        ], 201);
    }


    public function login(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'phone' => ['required', 'string', 'regex:/^\+[0-9]+$/'],
                'password' => 'required'
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validateUser->errors(),
                'data' => array()
            ]);
        }

        if (!Auth::attempt($request->only(['phone', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect password or phone',
            ], 200);
        }

        $user = User::where('phone', $request->phone)
            ->select('id', 'first_name', 'last_name', 'email', 'date_of_birth', 'phone', 'country_code')
            ->first();
        // $user['notification'] = DB::table('notifications')
        //     ->select('read_at')
        //     ->where('notifiable_id', $user->id)
        //     ->whereNull('read_at')->count();
        $token = $user->createToken('token-name')->plainTextToken;

        $subBank = Sbank::get();
        $fees = fees::get();
        // $generalSettings = GeneralSetting::first();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array(
                "token" => $token,
                "user" => $user,
                "sub_bank" => $subBank,
                "fees" => $fees,
                // "general_settings" => $generalSettings,
            )
        ], 201);
    }

    public function logout(Request $request)
    {
        // Logout from web-based authentication (for your app)
        Auth::logout();

        // Revoke the user's personal access token (for API authentication)
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array()
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'phone' => ['required', 'string', 'regex:/^\+[0-9]+$/'],
                'password' => 'required',
                'uuid' => 'required'
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validateUser->errors(),
                'data' => array()
            ]);
        }

        $user = User::where('phone', $request->phone)->where('uuid', $request->uuid)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid data',
                'data' => array()
            ]);
        }

        $user->update([
            'password' => $request->password,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => array()
        ]);
    }

    public function checkTokenExpiration()
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'User is not authenticated',
                'data' => array()
            ]);
        }

        if (Gate::denies('check-token-expiration')) {
            $user = Auth::user();

            $user['notification'] = DB::table('notifications')
                ->select('read_at')
                ->where('notifiable_id', $user->id)
                ->whereNull('read_at')->count();

            $subBank = Sbank::get();
            $fees = fees::get();
            $generalSettings = GeneralSetting::first();
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => array(
                    "user" => $user->only(['id', 'first_name', 'last_name', 'email', 'date_of_birth', 'phone', 'country_code', 'notification']),
                    "sub_bank" => $subBank,
                    "fees" => $fees,
                    "general_settings" => $generalSettings,
                )
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Token has expired',
            'data' => array()
        ]);
    }

    public function register(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'username' => 'required|string',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user = Admin::create([
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'username' => $validatedData['username'],

            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $message;
            // Handle the exception or log the message
            // You can also rethrow the exception if needed: throw $e;
        }
    }
}
