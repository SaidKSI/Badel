<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sbank;
use Illuminate\Http\Request;

class Sbankcontroller extends Controller
{

    public function SbankList(){
        $sbanks = Sbank::all();
        return  response()->json($sbanks, 200);
    }
}
