<?php

namespace App\Livewire;

use App\Models\Sbank;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class OnHold extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 10;

    public function render()
    {
        $banks = Sbank::get();
        $transactions = Transaction::search($this->search)
            ->simplePaginate($this->perPage);

        return view('livewire.on-hold', compact('transactions', 'banks'));
    }

    public function applyFilter()
    {
        // This method is triggered when the Search button is clicked
        $this->resetPage(); // Reset pagination when applying filters
    }

    public function resetFilters()
    {
        // Reset all filters and search
        $this->search = '';
        $this->perPage = 10;

        // Trigger the render method to refresh the Livewire component
        $this->render();
    }
}
