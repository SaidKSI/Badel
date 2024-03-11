<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboredController extends Controller
{
    public function users()
    {
        $users = User::get();
        return view('user.index', ['users' => $users]);
    }
}
