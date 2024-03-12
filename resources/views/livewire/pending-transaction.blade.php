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
            <input wire:model.debounce.300ms="filterTransactionId" type="text" class="form-control"
                placeholder="Transaction ID">
        </div>
        <div class="col-md-3">
            <select wire:model="filterStatus" class="form-control">
                <option value="">Select Transaction Status</option>
                <option value="OnHold">OnHold</option>
                <option value="Terminated">Terminated</option>
                <option value="Canceled">Cancelled</option>
                <!-- Add more receiver bank options as needed -->
            </select>
        </div>
        <div class="col-md-3">
            <select wire:model="filterReceiverBankId" class="form-control">
                <option value="">Select Receiver Bank</option>
                @foreach($banks as $bank)
                <option value="{{ $bank->id }}">{{ $bank->Sb_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select wire:model="filterSenderBankId" class="form-control">
                <option value="">Select Sender Bank</option>
                @foreach($banks as $bank)
                <option value="{{ $bank->id }}">{{ $bank->Sb_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="d-flex m-2 mr-5">
            <div class="col-md-2">
                <button wire:click="applyFilters" class="btn btn-primary">Apply Filters</button>
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
                {{-- <th>Amount after tax</th>
                <th>Amount</th> --}}
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
                {{-- <td class="text-danger">{{ $transaction->amount_after_tax }}</td>
                <td class="text-success">{{ $transaction->amount }}</td> --}}
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
    {!! $transactions->links() !!}
</div>