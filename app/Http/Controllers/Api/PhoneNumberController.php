<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'hello';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'phone_number' => 'required|unique:users',
            'user_id' => 'required|exists:users,id',
            // Add any other validation rules you need
        ]);

        // Create a new PhoneNumber with 'OnHold' status
        $phoneNumber = PhoneNumber::create([
            'phone_number' => $request->input('phone_number'),
            'user_id' => $request->input('user_id'),
            'status' => 'OnHold',
        ]);

        // You can customize the response format as needed
        return response()->json([
            'message' => 'PhoneNumber created successfully',
            'data' => $phoneNumber,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PhoneNumber $phoneNumber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhoneNumber $phoneNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhoneNumber $phoneNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhoneNumber $phoneNumber)
    {
        //
    }
}
