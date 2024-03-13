<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class TransactionDateFilter extends Component
{
    public $startDate, $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.transaction-date-filter', [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }
}
