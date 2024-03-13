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
        <h5 class="card-title">Transaction History |{{$dateDifference}}</h5>
        {{-- <livewire:on-hold> --}}
            <form action="">
                <div class="row pb-4">
                    <div class="col-md-3">
                        <div class="col-sm-10">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ old('start_date', $start_date) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-sm-10">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ old('end_date', $end_date) }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="col-sm-10">
                            <label for="status">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option selected value="">Status</option>
                                <option value="terminated" {{ old('status')=='terminated' ? 'selected' : '' }}>
                                    Terminated</option>
                                <option value="canceled" {{ old('status')=='canceled' ? 'selected' : '' }}>Canceled
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-primary">Search</button>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Bedel ID</th>
                            <th>Balance</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Sender Phone</th>
                            <th>Phone Receiver</th>
                            <th>Sender Bank</th>
                            <th>Receiver Bank</th>
                            <th>Transaction time</th>
                            <th>Status</th>
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
                            <td>{{ $transaction->send_full_name }}</td>
                            <td>{{ $transaction->receiver_full_name }}</td>
                            <td>{{ $transaction->send_phone }}</td>
                            <td>{{ $transaction->receiver_phone }}</td>
                            <td>{{ $transaction->sendBank->Sb_name }}</td>
                            <td>{{ $transaction->receiverBank->Sb_name }}</td>
                            <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @if($transaction->status == 'Terminated')
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>
                                    Terminated</span> <small>at {{ $transaction->updated_at->format('Y-m-d H:i')}}
                                </small>
                                @elseif($transaction->status == 'Canceled')
                                <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>
                                    Cancelled</span> <small>at {{ $transaction->updated_at->format('Y-m-d H:i')}}
                                </small>
                                @endif
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