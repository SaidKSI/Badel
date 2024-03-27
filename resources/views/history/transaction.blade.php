@extends('app.layout')

@section('content')
<div class="card">
    <style>
        th {
            font-size: 12px;
            white-space: nowrap;
            border: 1px solid gray;
        }

        td {
            white-space: nowrap;
            font-size: 12px;
        }
    </style>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Transaction</h5>

            <!-- Default Tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                        type="button" role="tab" aria-controls="home" aria-selected="true">Table</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Graph</button>
                </li>
            </ul>
            <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card-body">
                        <h5 class="card-title">Transaction History <span> {{$dateDifference}} Days</span></h5>

                        <form action="" class="m-2">
                            <div class="row pb-4">
                                <div class="col">
                                    <div class="col-sm-10">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ old('start_date', $start_date) }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="col-sm-10">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ old('end_date', $end_date) }}">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="col-sm-10">
                                        <label for="status">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="">Status</option>
                                            <option value="terminated" {{ request('status')=='terminated' ? 'selected'
                                                : '' }}>
                                                Terminated
                                            </option>
                                            <option value="canceled" {{ request('status')=='canceled' ? 'selected' : ''
                                                }}>
                                                Canceled
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="col-sm-10">
                                        <label for="sendBank">Send Bank</label>
                                        <select class="form-select" id="sendBank" name="send_sb_id">
                                            <option value="" {{ request('send_sb_id')=="" ? 'selected' : '' }}>Send Bank
                                            </option>
                                            @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ request('send_sb_id')==$bank->id ?
                                                'selected' : '' }}>
                                                {{ $bank->Sb_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="col-sm-10">
                                        <label for="receiver">Receiver Bank</label>
                                        <select class="form-select" id="receiver" name="receiver_sb_id">
                                            <option value="" {{ request('receiver_sb_id')=="" ? 'selected' : '' }}>
                                                Receiver Bank</option>
                                            @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ request('receiver_sb_id')==$bank->id ?
                                                'selected' : '' }}>
                                                {{ $bank->Sb_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex  gap-3">
                                <div class="">
                                    <button class="btn btn-primary">Search</button>
                                </div>
                                <div class="">
                                    <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped">
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
                                        <td><a href="{{route('user',['id'=>$transaction->user_id])}}">{{
                                                $transaction->user->first_name . " " .
                                                $transaction->user->last_name }}</a></td>
                                        <td><a
                                                href="{{ route('transaction', ['transaction_id' => $transaction->transaction_id]) }}">{{
                                                $transaction->transaction_id }}</a></td>
                                        @php
                                        $balance = $transaction->amount - $transaction->amount_after_tax
                                        @endphp
                                        <td class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $balance }}
                                            <i id="{{$transaction->transaction_id}}"
                                                class="bi bi-info-circle text-primary" style="font-size: 0.8rem;"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                                title="Amount: {{ $transaction->amount }}  || Amount after tax: {{ $transaction->amount_after_tax }}"
                                                onmouseenter="showTooltip(this)"></i>
                                        </td>
                                        <td>{{ $transaction->send_full_name }}</td>
                                        <td>{{ $transaction->receiver_full_name }}</td>
                                        <td>{{ $transaction->send_phone }}</td>
                                        <td>{{ $transaction->receiver_phone }}</td>
                                        <td><a href="{{route('bank',['id'=>$transaction->send_sb_id])}}">{{
                                                $transaction->sendBank->Sb_name }} </a> </td>
                                        <td><a href="{{route('bank',['id'=>$transaction->receiver_sb_id])}}">{{
                                                $transaction->receiverBank->Sb_name }}</a> </td>
                                        <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            @if($transaction->status == 'Terminated')
                                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>
                                                Terminated</span> <small>at {{ $transaction->updated_at->format('Y-m-d
                                                H:i')}}
                                            </small>
                                            @elseif($transaction->status == 'Canceled')
                                            <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>
                                                Cancelled</span> <small>at {{ $transaction->updated_at->format('Y-m-d
                                                H:i')}}
                                            </small>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="11" class="text-center">No transactions found.</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="11" style="white-space: normal;">{{$transactions->links()}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reports <span>|{{$dateDifference}} Days</span></h5>
                            <div id="reportsChart"></div>


                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#reportsChart"), {
                                        series: [
                                            {
                                                name: 'Transaction Amount',
                                                data: [
                                                    @foreach($transactions as $transaction)
                                                        {{ $transaction->amount }},
                                                    @endforeach
                                                ],
                                            },
                                            {
                                                name: 'Amount After Tax',
                                                data: [
                                                    @foreach($transactions as $transaction)
                                                        {{ $transaction->amount_after_tax }},
                                                    @endforeach
                                                ]
                                            },
                                            {
                                                name: 'Balance',
                                                data: [
                                                    @foreach($transactions as $transaction)
                                                        {{ $transaction->amount - $transaction->amount_after_tax }},
                                                    @endforeach
                                                ]
                                            }
                                        ],
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
                                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
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
                                            categories: [
                                                @foreach($transactions as $transaction)
                                                    '{{ $transaction->created_at }}',
                                                @endforeach
                                            ]
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

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>


@endsection