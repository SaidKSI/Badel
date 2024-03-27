<?php

namespace App\Livewire;

use App\Models\PhoneNumber;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PhoneTable extends Component
{
    use WithPagination;

    public $status;

    #[Url(as: 's')]
    public $search = '';
    public $bedel_id;

    public function updatePhoneStatus($phone_id, $status)
    {
        sleep(1);
        // Update transaction status
        $phone = PhoneNumber::findOrFail($phone_id);
        $phone->status = $status;

        // Switch based on status
        switch ($status) {
            case 'Terminated':
                session()->flash('status', [
                    'message' => 'Phone terminated',
                    'icon' => 'bi bi-check-circle',
                    'status' => 'success'
                ]);
                break;
                $this->dispatch('closeEditModal');

            case 'Canceled':
                session()->flash('status', [
                    'message' => 'Phone Canceled',
                    'icon' => 'bi bi-exclamation-octagon',
                    'status' => 'danger'
                ]);
                break;

            case 'Accepted':
                session()->flash('status', [
                    'message' => 'Phone Accepted',
                    'icon' => 'bi bi-check-circle',
                    'status' => 'success'
                ]);
                $this->dispatch('closeTerminateModal');
                break;
        }

        $phone->save();

        // Emit an event to close the modal using JavaScript
    }

    public function render()
    {
        $phones = PhoneNumber::with([
            'user:id,first_name,last_name'
        ])
            ->where('status', $this->status)
            ->when($this->search, function ($query) {
                $query->where('phone_number', 'like', '%' . $this->search . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        return view('livewire.phone-table', ['phones' => $phones]);
    }
}