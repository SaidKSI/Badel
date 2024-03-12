<style>
    th {
        font-size: 12px;
        white-space: nowrap;
        border: 1px solid gray
    }

    td {
        font-size: 12px;
        white-space: nowrap;
    }
</style>
<div class="container">
    <div class="row pb-4">
        <div class="col-md-3">
            <input wire:model.debounce.300ms="search" type="text" name="search" class="form-control" placeholder="Transaction ID">
        </div>
        <!-- ... Other filter inputs ... -->
        <div class="d-flex m-2 mr-5">
            <div class="col-md-2">
                <button wire:click="applyFilter" class="btn btn-primary">Apply Filters</button>
            </div>
            <div class="col-md-2">
                <button wire:click="resetFilters" class="btn btn-secondary">Reset Filters</button>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Bedel ID</th>
                <th>Balance</th>
                <th>Sender Phone</th>
                <th>Phone Receiver</th>
                <th>Receiver Bank</th>
                <th>Transaction time</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->user->first_name . " " . $transaction->user->last_name }}</td>
                <td>{{ $transaction->transaction_id }}</td>
                @php
                $balance = $transaction->amount - $transaction->amount_after_tax
                @endphp
                <td class="{{$balance >= 0 ? 'text-success' : 'text-danger'}}">
                    {{$balance}}
                    <i class="bi bi-info-circle text-primary" style="font-size: 0.8rem;" data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="Amount: {{ $transaction->amount }}, Amount after tax: {{ $transaction->amount_after_tax }}">
                    </i>
                </td>
                <td>{{ $transaction->receiver_phone }}</td>
                <td>{{ $transaction->send_full_name }}</td>
                <td>{{ $transaction->Plateform_reciever->Sb_name }}</td>
                <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                <td>Action</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex gap-3">{!! $transactions->links() !!}<div class="col-sm-1">
            <select wire:model="perPage" class="form-control">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
    </div>


</div>