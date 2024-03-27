<?php

namespace App\Http\Controllers;

use App\Models\PhoneNumber;
use Illuminate\Http\Request;


class PhoneNumberController extends Controller
{
    public function index($status)
    {
        $view = '';
        switch ($status) {
            case 'pending':
                $view = 'phone.pending';
                break;

            case 'terminated':
                $view = 'phone.terminat';
                break;

            case 'canceled':
                $view = 'phone.canceled';
                break;

            case 'onhold':
                $view = 'phone.onhold';
                break;

            default:
                // You can handle other cases or set a default view here
                break;
        }
        // dd($status . "| " . $view);

        return view($view);
    }
    public function updateStatus($id, $status)
    {
        // Find the phone
        $phone = PhoneNumber::findOrFail($id);

        if (!$phone) {
            return response()->json(['error' => 'Phone not found'], 404);
        }

        // Update the phone status
        $phone->status = $status;
        $phone->save();

        return response()->json(['message' => 'Phone updated successfully', 'data' => $phone]);
    }
}