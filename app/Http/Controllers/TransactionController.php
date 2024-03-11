<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($status)
    {
        $view = '';

        switch ($status) {
            case 'hold':
                $view = 'transaction.pending';
                break;

            case 'terminated':
                $view = 'transaction.terminat';
                break;

            case 'cancelled':
                $view = 'transaction.cancel';
                break;

            default:
                // You can handle other cases or set a default view here
                break;
        }

        $transactions = Transaction::where('status', $status)->get();

        return view($view, ['transactions' => $transactions, 'status' => $status]);
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
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
