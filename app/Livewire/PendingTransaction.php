<?php

namespace App\Livewire;

use App\Models\Sbank;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class PendingTransaction extends Component
{
    use WithPagination;

    public $filterTransactionId;
    public $filterStatus;
    public $filterReceiverBankId;
    public $filterSenderBankId;
    public $perPage = 10;

    
    public function render()
    {
        $banks = Sbank::get();
        $transactions = Transaction::query()
            ->when($this->filterTransactionId, function ($query) {
                $query->where('transaction_id', 'like', '%' . $this->filterTransactionId . '%');
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterReceiverBankId, function ($query) {
                $query->where('receiver_sb_id', $this->filterReceiverBankId);
            })
            ->when($this->filterSenderBankId, function ($query) {
                $query->where('send_sb_id', $this->filterSenderBankId);
            })
            ->simplePaginate($this->perPage);

        return view('livewire.pending-transaction', ['transactions' => $transactions,'banks'=>$banks ]);
    }

    public function applyFilters()
    {
        $this->resetPage(); // Reset pagination when applying filters
    }

    public function resetFilters()
    {
        $this->reset(['filterTransactionId', 'filterStatus', 'filterReceiverBankId', 'filterSenderBankId']);
        $this->resetPage(); // Reset pagination when resetting filters
    }
}
