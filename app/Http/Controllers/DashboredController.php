<?php

namespace App\Http\Controllers;

use App\Models\Fees;
use App\Models\PhoneNumber;
use App\Models\Sbank;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

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
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->addDay()->format('Y-m-d'));

        // Calculate the difference in days between the start and end dates
        $dateDifference = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));

        $status = $request->input('status');

        $transactions = Transaction::with([
            'user:id,first_name,last_name',
            'sendBank:id,Sb_name',
            'receiverBank:id,Sb_name'
        ])
            ->whereNull('deleted_at')
            ->whereBetween('created_at', [$startDate, $endDate]);

        // Apply status filter
        if ($status && in_array($status, ['terminated', 'canceled'])) {
            $transactions->where('status', $status);
        } else {
            // Default status filter if no specific status is selected
            $transactions->whereIn('status', ['terminated', 'canceled']);
        }

        $transactionCount = $transactions->count();

        $transactions = $transactions->get();
        $banks = Sbank::get();
        return view('history.transaction', [
            'transactions' => $transactions,
            'transactionCount' => $transactionCount,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'dateDifference' => $dateDifference,
            'banks' => $banks
        ]);
    }

    public function phone_history(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->addDay()->format('Y-m-d'));

        // Calculate the difference in days between the start and end dates
        $dateDifference = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));

        $status = $request->input('status');

        $phones = PhoneNumber::with(['user:id,first_name,last_name'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($status && in_array($status, ['terminated', 'canceled'])) {
            $phones->where('status', $status);
        } else {
            // Default status filter if no specific status is selected
            $phones->whereIn('status', ['terminated', 'canceled']);
        }

        $phones = $phones->orderBy('created_at', 'desc')->get();

        return view('history.phone', [
            'phones' => $phones,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'dateDifference' => $dateDifference
        ]);
    }
}