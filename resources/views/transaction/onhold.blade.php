@extends('dashbored')

@section('inner_content')
<div class="card">
    <style>
        th {
            font-size: 12px;
            white-space: nowrap;
            border: 1px solid gray;
        }

        td {
            font-size: 12px;
            white-space: nowrap;
        }
    </style>
    <div class="card-body">
        <h5 class="card-title">On Hold Transaction</h5>
        {{-- <livewire:on-hold> --}}

            <div class="table-responsive">
                <table class="table datatable">
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
                        @if (count($transactions) > 0)
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->user->first_name . " " . $transaction->user->last_name }}</td>
                            <td>{{ $transaction->transaction_id }}</td>
                            @php
                            $balance = $transaction->amount - $transaction->amount_after_tax
                            @endphp
                            <td class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $balance }}
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-html="true"
                                    title="Amount: {{ $transaction->amount }}  || Amount after tax: {{ $transaction->amount_after_tax }}"
                                    onclick="showTooltip(this)">
                                    <i class="bi bi-info-circle text-primary" style="font-size: 0.8rem;"></i>
                                </button>
                            </td>
                            <td>{{ $transaction->receiver_phone }}</td>
                            <td>{{ $transaction->send_full_name }}</td>
                            <td>{{ $transaction->receiverBank->Sb_name }}</td>
                            <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="d-flex">
                                    <form action="
                                        {{-- {{ route('transactions.updateStatus', ['id' => $transaction->id, 'status' => 'terminated']) }} --}}
                                        " method="POST"
                                        onsubmit="return confirm('Are you sure you want to terminate this transaction?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success me-2" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Terminate">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>

                                    <form action="
                                        {{-- {{ route('transactions.updateStatus', ['id' => $transaction->id, 'status' => 'cancelled']) }} --}}
                                        " method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this transaction?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger me-2" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Cancel">
                                            <i class="bi bi-exclamation-octagon"></i>
                                        </button>
                                    </form>

                                    <form action="
                                      {{-- {{ route('transactions.updateStatus', ['id' => $transaction->id, 'status' => 'hold']) }} --}}
                                      " method="POST"
                                        onsubmit="return confirm('Are you sure you want to put this transaction on hold?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Hold">
                                            <i class="bx bxs-hand"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" class="text-center">No transactions found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
    </div>
</div>

<script>
    function showTooltip(element) {
        var tooltip = new bootstrap.Tooltip(element);
        tooltip.show();
    }
</script>

@endsection