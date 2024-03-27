<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionTable extends Component
{
    use WithPagination;

    public $status;

    #[Url(as: 's')]
    public $search = '';
    
    public $bedel_id;




    
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateTransactionStatus($transaction_id, $status)
    {
        sleep(1);
        // Update transaction status
        $transaction = Transaction::findOrFail($transaction_id);
        $transaction->status = $status;

        // Switch based on status
        switch ($status) {
            case 'Terminated':
                $transaction->bedel_id = $this->bedel_id; // Set the bedel_id value
                session()->flash('status', [
                    'message' => 'Transaction terminated',
                    'icon' => 'bi bi-check-circle',
                    'status' => 'success'
                ]);
                $this->dispatch('closeEditModal');
                break;

            case 'Canceled':
                session()->flash('status', [
                    'message' => 'Transaction Canceled',
                    'icon' => 'bi bi-exclamation-octagon',
                    'status' => 'danger'
                ]);
                break;

            case 'Accepted':
                session()->flash('status', [
                    'message' => 'Transaction Accepted',
                    'icon' => 'bi bi-check-circle',
                    'status' => 'success'
                ]);
                $this->dispatch('closeTerminateModal');
                break;
        }

        $transaction->save();

        // Emit an event to close the modal using JavaScript
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

        return view('livewire.transaction-table', ['transactions' => $transactions]);
    }
}