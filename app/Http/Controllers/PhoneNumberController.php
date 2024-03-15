<?php

namespace App\Http\Controllers;

use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    public function index(Request $request, $status)
    {
        $view = '';

        switch ($status) {
            case 'pending':
                $view = 'phone.pending';
                break;

            case 'terminated':
                $view = 'phone.terminat';
                break;

            case 'Canceled':
                $view = 'phone.cancel';
                break;

            case 'onhold':
                $view = 'phone.onhold';
                break;

            default:
                // You can handle other cases or set a default view here
                break;
        }
        $phones = PhoneNumber::with(['user:id,first_name,last_name'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();

        return view($view, [
            'phones' => $phones,
            'status' => $status
        ]);
    }
    public function updateStatus($id, $status)
    {
        // Find the transaction
        $phone = PhoneNumber::findOrFail($id);

        if (!$phone) {
            return redirect()->route('phones')->with(['error' => 'Phone not found'], 404);
        }

        // Update the phone status
        $phone->status = $status;
        $phone->save();
        return back()->with(['message' => 'Phone updated successfully', 'data' => $phone]);

        // return redirect()->route('phones', ['status' => $status])->with(['message' => 'Phone updated successfully', 'data' => $transaction]);
    }
}
