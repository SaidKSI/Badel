<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sbank;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionStatusTable extends Component
{
    public $status;
    public $transactions;
    // public $banks;

    public function mount($status)
    {
        $this->status = $status;
        $this->loadTransactions();
    }

    public function loadTransactions()
    {
        // Load transactions based on the current status
        $this->transactions = Transaction::with([
            'user:id,first_name,last_name',
            'sendBank:id,Sb_name',
            'receiverBank:id,Sb_name'
        ])
            ->where('status', $this->status)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get banks
        // $this->banks = Sbank::get();
    }

    public function updateTransactionStatus($transaction_id, $status)
    {
        // Update transaction status
        $transaction = Transaction::findOrFail($transaction_id);
        $transaction->status = $status;
        $transaction->save();

        // Reload transactions
        $this->loadTransactions();
    }

    public function render()
    {
        return view('livewire.transaction-status-table');
    }
}