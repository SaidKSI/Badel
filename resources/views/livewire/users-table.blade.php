<div class="container">
    <div class="row pb-4">
        <div class="col-md-4">
            <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Search users...">
        </div>
        <div class="col-md-2">
            <select wire:model="orderBy" class="form-control">
                <option value="id">ID</option>
                <option value="name">Name</option>
                <option value="email">Email</option>
                <option value="created_at">Sign Up Date</option>
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model="orderAsc" class="form-control">
                <option value="1">Ascending</option>
                <option value="0">Descending</option>
            </select>
        </div>

        <div class="col-md-1">
            <button wire:click="applyFilter" class="btn btn-primary">Search</button>
        </div>
        <div class="col-md-1">
            <button wire:click="resetFilters" class="btn btn-secondary">Reset</button>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name . " " . $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex gap-3">{!! $users->links() !!}<div class="col-md-1">
            <select wire:model="perPage" class="form-control">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
    </div>
</div>