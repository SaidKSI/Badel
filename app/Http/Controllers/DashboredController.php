<?php

namespace App\Http\Controllers;

use App\Models\Fees;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboredController extends Controller
{
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
}
