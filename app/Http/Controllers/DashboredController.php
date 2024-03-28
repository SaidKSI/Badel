<?php

namespace App\Http\Controllers;

use App\Models\Fees;
use App\Models\PhoneNumber;
use App\Models\Sbank;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboredController extends Controller
{

    public function index()
    {
        return view('home');
    }
    public function users()
    {
        $users = User::get();
        return view('user.index', ['users' => $users]);
    }
    public function fees()
    {
        $fees = Fees::get();
        return view('fees', ['fees' => $fees]);
    }
    public function fees_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'min' => 'required|numeric',
            'max' => 'required|numeric',
            'fee' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fee = Fees::findOrFail($id);
        $fee->min = $request->min;
        $fee->max = $request->max;
        $fee->fee = $request->fee;
        $fee->save();

        return redirect()->back()->with('success', 'Fee updated successfully.');
    }

    public function transaction_history(Request $request)
    {
        $dateDifference = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date));
        $status = $request->input('status');
        $sendBankId = $request->input('send_sb_id');
        $receiverBankId = $request->input('receiver_sb_id');
        $transactionId = $request->input('transaction_id');

        $query = Transaction::with([
            'user:id,first_name,last_name',
            'sendBank:id,Sb_name',
            'receiverBank:id,Sb_name'
        ])->whereNull('deleted_at');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($status && in_array($status, ['terminated', 'canceled'])) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['terminated', 'canceled']);
        }

        if ($sendBankId) {
            $query->where('send_sb_id', $sendBankId);
        }

        if ($receiverBankId) {
            $query->where('receiver_sb_id', $receiverBankId);
        }

        if ($transactionId) {
            $query->where('transaction_id', $transactionId);
        }

        $transactions = $query->orderBy('updated_at', 'desc')->paginate(25);
        $banks = Sbank::get();

        return view('history.transaction', [
            'transactions' => $transactions,
            'dateDifference' => $dateDifference,
            'banks' => $banks
        ]);
    }



    public function phone_history(Request $request)
    {
        $dateDifference = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date));

        $status = $request->input('status');

        $query = PhoneNumber::with(['user:id,first_name,last_name']);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->phone_number) {
            $query->where('phone_number', $request->phone_number);
        }
        if ($status && in_array($status, ['terminated', 'canceled'])) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['terminated', 'canceled']);
        }
        $phones = $query->orderBy('updated_at', 'desc')->paginate(25);

        return view('history.phone', [
            'phones' => $phones,
            'dateDifference' => $dateDifference
        ]);
    }
}