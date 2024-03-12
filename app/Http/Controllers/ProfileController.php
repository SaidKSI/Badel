<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function changeFirstName(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errorsAsString = implode("\n", $validator->errors()->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        $user->first_name = $request->first_name;

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array()
        ]);
    }

    public function changeLastName(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errorsAsString = implode("\n", $validator->errors()->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        $user->last_name = $request->last_name;

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array()
        ]);
    }

    public function changeDateOfBirth(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'date_of_birth' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            $errorsAsString = implode("\n", $validator->errors()->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        $user->date_of_birth = $request->date_of_birth;

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array()
        ]);
    }

    public function changePhone(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'regex:/^\+[0-9]+$/', 'unique:users,phone'],
            'country_code' => ['required', 'string', 'regex:/^[0-9]+$/'],
            'uuid' => 'required|string'
        ]);

        if ($validator->fails()) {
            $errorsAsString = implode("\n", $validator->errors()->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        $user->phone = $request->phone;
        $user->country_code = $request->country_code;
        $user->uuid = $request->uuid;

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array()
        ]);
    }

    public function changeEmail(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email|string|max:255',
        ]);

        if ($validator->fails()) {
            $errorsAsString = implode("\n", $validator->errors()->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        $user->email = $request->email;

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array()
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:4|confirmed',
        ]);

        if ($validator->fails()) {
            $errorsAsString = implode("\n", $validator->errors()->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        $user->password =  Hash::make($request->password);

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array()
        ]);
    }
}
