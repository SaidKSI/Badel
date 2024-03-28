@extends('app.layout')

@section('content')
<section class="section profile">
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
    <div class="row">
        <div class="col-xl-3">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <img src="{{ asset($bank->profile_picture) }}" alt="Bank Image" style="width: 60px; height: auto;">
                    <div class="ps-3 text-center">
                        <h6 class="text-success  pt-1 fw-bold">
                            {{ $totalAmount }}
                            <small style="font-size: 6px">MRU</small>
                        </h6>
                        <h6 class="text-danger  pt-2 ps-1">
                            {{ $totalAmountAfterTax }}
                            <small style="font-size: 6px">MRU</small>
                        </h6>
                        @php
                        $balance = $totalAmount -$totalAmountAfterTax
                        @endphp
                        <h6>
                            Balance :
                            <span class="{{ $balance < 0 ? 'text-danger' : ($balance > 0 ? 'text-success' : '') }}">
                                {{ $balance }} <small style="font-size: 6px">MRU</small>
                            </span>
                        </h6>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="row">

        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab"
                            data-bs-target="#profile-overview">{{$transactionCount}} Transactions</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">
                            Charts</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Recent
                            Activity</button>
                    </li>

                </ul>
                <div class="tab-content pt-2">

                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <form action="" id="searchForm">
                            <div class="p-2" style="width: 25%">
                                <input type="text" name="transaction_id" id="transaction_id"
                                    title="Enter search keyword" placeholder="Search by Transaction ID..."
                                    value="{{ old('transaction_id',request('transaction_id'))}}" class="form-control">
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
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
                                    @if ($transactions && count($transactions) > 0)
                                    @foreach ($transactions as $transaction)
                                    <tr>
                                        <td><a
                                                href="{{ route('transaction', ['transaction_id' => $transaction->transaction_id]) }}">{{
                                                $transaction->transaction_id }}</a></td>
                                        @php
                                        $balance = $transaction->amount - $transaction->amount_after_tax
                                        @endphp
                                        <td class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $balance }}
                                            <i class="bi bi-info-circle text-primary" style="font-size: 0.8rem;"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                                title="Amount: {{ $transaction->amount }}  || Amount after tax: {{ $transaction->amount_after_tax }}"
                                                onmouseenter="showTooltip(this)"></i>
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
                                                Terminated</span> <small>at {{
                                                $transaction->updated_at->format('Y-m-d
                                                H:i')}}
                                            </small>
                                            @elseif($transaction->status == 'Canceled')
                                            <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>
                                                Cancelled</span> <small>at {{
                                                $transaction->updated_at->format('Y-m-d
                                                H:i')}}
                                            </small>
                                            @elseif($transaction->status == 'OnHold')
                                            <span class="badge bg-warning text-dark"><i
                                                    class="bi bi-exclamation-triangle me-1"></i> OnHold</span>
                                            <small>at {{
                                                $transaction->updated_at->format('Y-m-d
                                                H:i')}}
                                            </small>
                                            @elseif($transaction->status == 'Pending')
                                            <span class="badge bg-dark"><i class="bi bi-clock-history me-1"></i>
                                                Pending</span>
                                            <small>from {{
                                                $transaction->updated_at->format('Y-m-d
                                                H:i')}}
                                            </small>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="10" class="text-center">No transactions found for {{
                                            $bank->Sb_name
                                            }}.</td>
                                    </tr>
                                    @endif

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="11">{{$transactions->links()}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>

                    <div class="tab-pane fade profile-edit" id="profile-edit">

                        <h5 class="card-title">Transaction Reports<span> {{$bank->Sb_name}} bank</span></h5>

                        <!-- Line Chart -->
                        <div id="reportsChart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#reportsChart"), {
                                        series: [{
                                            name: 'Amount',
                                            data: {!! json_encode($transactions->pluck('amount')->toArray()) !!}
                                        }, {
                                            name: 'Amount After Tax',
                                            data: {!! json_encode($transactions->pluck('amount_after_tax')->toArray()) !!}
                                        }, {
                                            name: 'Balance',
                                            data: {!! json_encode($transactions->pluck('balance')->toArray()) !!}
                                        }],
                                        chart: {
                                            height: 350,
                                            type: 'area',
                                            toolbar: {
                                                show: false
                                            },
                                        },
                                        markers: {
                                            size: 4
                                        },
                                        colors: ['#4154f1', '#d62222', '#2eca7a'],
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                shadeIntensity: 1,
                                                opacityFrom: 0.3,
                                                opacityTo: 0.4,
                                                stops: [0, 90, 100]
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            curve: 'smooth',
                                            width: 2
                                        },
                                        xaxis: {
                                            type: 'datetime',
                                            categories: {!! json_encode($transactions->pluck('created_at')->toArray()) !!}
                                        },
                                        tooltip: {
                                            x: {
                                                format: 'dd/MM/yy HH:mm'
                                            },
                                        }
                                    }).render();
                                });
                        </script>



                    </div>
                    <div class="tab-pane fade" id="profile-settings">
                        <div class="p-2" style="width: 25%">
                            <input type="text" name="transaction_id" title="Enter search keyword"
                                placeholder="Search by Transaction ID..."
                                value="{{ old('transaction_id',request('transaction_id'))}}" class="form-control">
                        </div>
                        <div class="table-responsive">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>IN or OUT</th>
                                        <th>Bedel ID</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($transactions && count($transactions) > 0)
                                    @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>
                                            @if ($transaction->send_sb_id == $bank->id)
                                            <i class="bi bi-arrow-left-square-fill"></i> <span class="text-danger"
                                                style="font-size: 12px">OUT</span>
                                            @elseif ($transaction->receiver_sb_id == $bank->id)
                                            <i class="bi bi-arrow-right-square-fill"></i> <span class="text-success"
                                                style="font-size: 15px">IN</span>
                                            @else
                                            Unknown
                                            @endif
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('transaction', ['transaction_id' => $transaction->transaction_id]) }}">
                                                {{ $transaction->transaction_id }}
                                            </a>
                                        </td>
                                        @php
                                        $balance = $transaction->amount - $transaction->amount_after_tax;
                                        @endphp
                                        <td class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $balance }}
                                            <i class="bi bi-info-circle text-primary" style="font-size: 0.8rem;"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                                id="{{ $transaction->id }} "
                                                title="Amount: {{ $transaction->amount }}  || Amount after tax: {{ $transaction->amount_after_tax }}"
                                                onmouseenter="showTooltip(this)"></i>
                                        </td>
                                        <td>
                                            @if ($transaction->status == 'Terminated')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Terminated
                                            </span>
                                            <small>at {{ $transaction->updated_at->format('Y-m-d H:i') }}</small>
                                            @elseif ($transaction->status == 'Canceled')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                                Cancelled
                                            </span>
                                            <small>at {{ $transaction->updated_at->format('Y-m-d H:i') }}</small>
                                            @elseif ($transaction->status == 'OnHold')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                OnHold
                                            </span>
                                            <small>at {{ $transaction->updated_at->format('Y-m-d H:i') }}</small>
                                            @elseif ($transaction->status == 'Pending')
                                            <span class="badge bg-dark">
                                                <i class="bi bi-folder me-1"></i>
                                                Pending
                                            </span>
                                            <small>at {{ $transaction->updated_at->format('Y-m-d H:i') }}</small>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="10" class="text-center">No transactions found for {{ $bank->Sb_name
                                            }}.</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="11">{{$transactions->links()}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>


                </div>

            </div>
        </div>
    </div>

    </div>
</section>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById('searchForm');
        var input = document.getElementById('transaction_id');

        input.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent default form submission
                form.submit(); // Submit the form
            }
        });
    });
</script>