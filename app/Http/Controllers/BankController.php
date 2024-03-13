<?php

namespace App\Http\Controllers;

use App\Models\Sbank;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Sbank::get();

        return view('bank.index', ['banks' => $banks]);
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
