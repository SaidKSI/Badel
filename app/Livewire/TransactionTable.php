<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionTable extends Component
{
    use WithPagination;

    public $status;
    public $search = '';
    public $bedel_id; // Added property to hold the bedel_id value

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateTransactionStatus($transaction_id, $status)
    {
        // Update transaction status
        $transaction = Transaction::findOrFail($transaction_id);
        $transaction->status = $status;

        // Check if additional fields need to be updated
        if ($status === 'Terminated') {
            $transaction->bedel_id = $this->bedel_id; // Set the bedel_id value
        }

        $transaction->save();

        // Emit an event to close the modal using JavaScript
        $this->dispatch('closeModal');
    }

    public function applySearch()
    {
        // This method is called when the Enter key is pressed
        $this->resetPage();
        // The Livewire component will automatically filter the transactions based on the $search value
    }

    public function render()
    {
        $transactions = Transaction::with([
            'user:id,first_name,last_name',
            'sendBank:id,Sb_name',
            'receiverBank:id,Sb_name'
        ])
            ->where('status', $this->status)
            ->whereNull('deleted_at')
            ->when($this->search, function ($query) {
                $query->where('transaction_id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        $transactionsCount = Transaction::where('status', $this->status)
            ->whereNull('deleted_at')
            ->count();
        return view('livewire.transaction-table', ['transactions' => $transactions, 'transactionsCount' => $transactionsCount]);
    }
}