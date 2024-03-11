<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function render()
    {
        return view('livewire.users-table', [
            'users' => User::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage),
        ]);
    }

    public function applyFilter()
    {
        // This method is triggered when the Search button is clicked
        $this->render();
    }

    public function resetFilters()
    {
        // Reset all filters and search
        $this->search = '';
        $this->orderBy = 'id';
        $this->orderAsc = true;
        $this->perPage = 10;

        // Trigger the render method to refresh the Livewire component
        $this->render();
    }
}
