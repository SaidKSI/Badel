<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usersQuery = User::query();

        if ($request->user_name) {
            $usersQuery->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->user_name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->user_name . '%');
            });
        }

        // Paginate the filtered users
        $users = $usersQuery->orderby('created_at', 'desc')->paginate(25);

        return view('user.index', ['users' => $users]);
    }
    public function show($id)
    {
        $user = User::with(['transaction', 'phone_number'])->findOrFail($id);
        $transactionCount = $user->transaction->count();
        $phoneCount = $user->phone_number->count();

        return view('user.show', compact('user', 'transactionCount', 'phoneCount'));
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
