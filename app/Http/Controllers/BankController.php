<?php

namespace App\Http\Controllers;

use App\Models\Sbank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Sbank::get();

        return view('bank', ['banks' => $banks]);
    }
}
