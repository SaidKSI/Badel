<?php

namespace App\Http\Controllers;

use App\Models\Sbank;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request, $status)
    {
        $view = '';

        switch ($status) {
            case 'pending':
                $view = 'transaction.pending';
                break;

            case 'terminated':
                $view = 'transaction.terminat';
                break;

            case 'Canceled':
                $view = 'transaction.cancel';
                break;

            case 'onhold':
                $view = 'transaction.onhold';
                break;

            default:
                // You can handle other cases or set a default view here
                break;
        }

        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->addDay()->format('Y-m-d'));


        // Calculate the difference in days between the start and end dates
        $dateDifference = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));

        $transactions = Transaction::with([
            'user:id,first_name,last_name',
            'sendBank:id,Sb_name',
            'receiverBank:id,Sb_name'
        ])
            ->where('status', $status)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
        $transactionCount = $transactions->count();
        $banks = Sbank::get();
        return view($view, [
            'transactions' => $transactions,
            'status' => $status,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'date_difference' => $dateDifference,
            'transactionCount' => $transactionCount,
            'banks' => $banks
        ]);
    }


    public function updateStatus($id, $status)
    {
        // Find the transaction
        $transaction = Transaction::findOrFail($id);

        if (!$transaction) {
            return redirect()->route('transactions')->with(['error' => 'Transaction not found'], 404);
        }

        // Update the transaction status
        $transaction->status = $status;
        $transaction->save();
        return back()->with(['message' => 'Transaction updated successfully', 'data' => $transaction]);

        // return redirect()->route('transactions', ['status' => $status])->with(['message' => 'Transaction updated successfully', 'data' => $transaction]);
    }

    public function show($transaction_id)
    {
        $banks = Sbank::get();
        $transaction = Transaction::with([
            'user:id,first_name,last_name',
            'sendBank:id,Sb_name',
            'receiverBank:id,Sb_name'
        ])->where("transaction_id", $transaction_id)->firstOrFail();
        // dd($transaction);
        return view('transaction.show', ['transaction' => $transaction, 'banks' => $banks]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'send_sb_id' => 'required',
            'amount' => 'required',
            'amount_after_tax' => 'required',
            'transaction_id' => 'required',
            'send_phone' => 'required',
            'status' => 'required',
            'receiver_sb_id' => 'required',
            'receiver_phone' => 'required',
        ]);

        // Find the transaction
        $transaction = Transaction::findOrFail($id);

        // Update the transaction with the form data
        $transaction->update([
            'send_sb_id' => $request->send_sb_id,
            'amount' => $request->amount,
            'amount_after_tax' => $request->amount_after_tax,
            'transaction_id' => $request->transaction_id,
            'send_phone' => $request->send_phone,
            'status' => $request->status,
            'receiver_sb_id' => $request->receiver_sb_id,
            'receiver_phone' => $request->receiver_phone,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Transaction updated successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
