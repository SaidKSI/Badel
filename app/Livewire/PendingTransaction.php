<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class PendingTransaction extends Component
{
    public function render()
    {
        // Fetch transactions with status 'OnHold'
        $transactions = Transaction::where('status', 'OnHold')->get();

        // Pass the transactions to the Livewire view
        return view('livewire.pending-transaction', ['transactions' => $transactions]);
    }
}
