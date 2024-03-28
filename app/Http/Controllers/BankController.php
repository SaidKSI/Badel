<?php

namespace App\Http\Controllers;

use App\Models\Sbank;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Sbank::paginate(25);

        return view('bank.index', ['banks' => $banks]);
    }
    public function show(Request $request, $id)
    {
        $bank = Sbank::findOrFail($id);

        $transactionCount = Transaction::where('send_sb_id', $bank->id)
            ->orWhere('receiver_sb_id', $bank->id)
            ->whereNull('deleted_at')
            ->count();

        $totalAmount = Transaction::where('send_sb_id', $id)
            ->where('status', 'Terminated')
            ->whereNull('deleted_at')
            ->sum('amount');

        $totalAmountAfterTax = Transaction::where('send_sb_id', $id)
            ->where('status', 'Terminated')
            ->whereNull('deleted_at')
            ->sum('amount_after_tax');

        $transactions = Transaction::with([
            'user:id,first_name,last_name',
            'sendBank:id,Sb_name',
            'receiverBank:id,Sb_name'
        ])
            ->where(function ($query) use ($bank) {
                $query->where('send_sb_id', $bank->id)
                    ->orWhere('receiver_sb_id', $bank->id);
            })
            ->whereNull('deleted_at');

        if ($request->transaction_id) {
            $transactions->where('transaction_id', $request->transaction_id);
        }

        $transactions = $transactions->orderBy('updated_at', 'desc')->paginate(25);
        $balance = $totalAmount - $totalAmountAfterTax ;
        return view('bank.show', compact('bank', 'totalAmount', 'totalAmountAfterTax', 'transactionCount', 'transactions','balance'));
    }



    public function banks_update(Request $request, $id)
    {
        // dd($request, $id);
        $validator = Validator::make($request->all(), [
            'send_account' => 'required',
            'can_send' => 'required',
            'can_receive' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bank = Sbank::findOrFail($id);
        $bank->send_account = $request->send_account;
        $bank->can_send = $request->can_send;
        $bank->can_receive = $request->can_receive;
        $bank->save();

        return redirect()->back()->with('success', 'Bank updated successfully.');
    }
}