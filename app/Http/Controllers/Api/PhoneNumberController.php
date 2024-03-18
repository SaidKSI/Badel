<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Notifications\notifications;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'phone_number' => 'required|unique:phone_numbers',
            'user_id' => 'required|exists:users,id',
            // Add any other validation rules you need
        ]);

        // Check if the phone number is already verified
        if (User::where('phone', $request->phone_number)->exists()) {
            return response()->json(['error' => 'Phone number already exists and is verified'], 400);
        }

        // Check if the user exists
        if (!User::find($request->user_id)) {
            return response()->json(['error' => 'User does not exist'], 400);
        }

        // Create a new PhoneNumber with 'OnHold' status
        $phoneNumber = PhoneNumber::create([
            'phone_number' => $request->input('phone_number'),
            'user_id' => $request->input('user_id'),
            'status' => 'pending',
        ]);

        $admins = Admin::get();
        foreach ($admins as $admin) {
            $admin->notify(new notifications($phoneNumber, 'phone'));
        }
        // Return a success response
        return response()->json([
            'message' => 'PhoneNumber created successfully',
            'data' => $phoneNumber,
        ], 201);
    }
}
