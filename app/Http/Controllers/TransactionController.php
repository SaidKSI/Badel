<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index($status)
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

        $transactions = Transaction::with(['user', 'sendBank', 'receiverBank'])
            ->where('status', $status)
            ->whereNull('deleted_at')
            ->get();


        return view($view, ['transactions' => $transactions, 'status' => $status]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

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
