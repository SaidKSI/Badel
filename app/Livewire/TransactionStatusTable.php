<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class TransactionStatusTable extends Component
{

    public $status;
    public $transactions;

    protected $listeners = ['newTransactionAdded' => 'loadTransactions'];

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
            ->get(); // Change the number as per your requirement
    }

    public function updateTransactionStatus($transaction_id, $status)
    {
        // Update transaction status
        $transaction = Transaction::findOrFail($transaction_id);
        $transaction->status = $status;
        $transaction->save();

        // Fire an event to notify other components about the new transaction
        $this->emit('newTransactionAdded');

        // Reload transactions
        $this->loadTransactions();
    }

    public function render()
    {
        return view('livewire.transaction-status-table');
    }
}