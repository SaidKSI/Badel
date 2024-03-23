@extends('dashbored')

@section('inner_content')
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
<h5 class="card-title">Dashbored </h5>
<div class="card-body">
    <div class="card">
        <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">
                        Statistic</button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">
                        Transaction</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#phone_number">
                        Phone</button>
                </li>

            </ul>
            <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    <div class="row">
                        @foreach($banks as $bank)
                        <div class="col-xxl-4 col-md-3">
                            <div class="card info-card sales-card ">
                                <div class="card-body">
                                    <h5 class="card-title"> <a href="{{route('bank',['id'=>$bank->id])}}"> {{
                                            $bank->Sb_name }} </a>
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            {{-- <i class="bi bi-cart" style="font-size: 40px"></i> --}}
                                            <img src="{{ asset($bank->profile_picture) }}" alt="Bank Image"
                                                style="width: 30px; height: auto;">
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="text-success  pt-1 fw-bold">
                                                {{ $bankTotals[$bank->Sb_name]['totalAmount'] }}
                                                <small style="font-size: 6px">MRU</small>
                                            </h6>
                                            <h6 class="text-danger  pt-2 ps-1">
                                                {{ $bankTotals[$bank->Sb_name]['totalAmountAfterTax'] }}
                                                <small style="font-size: 6px">MRU</small>
                                            </h6>
                                            @php
                                            $balance = $bankTotals[$bank->Sb_name]['totalAmount'] -
                                            $bankTotals[$bank->Sb_name]['totalAmountAfterTax']
                                            @endphp
                                            <h6>
                                                Balance :
                                                <span
                                                    class="{{ $balance < 0 ? 'text-danger' : ($balance > 0 ? 'text-success' : '') }}">
                                                    {{ $balance }}
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body pb-0">
                                    <h5 class="card-title">Transaction Status</h5>

                                    <div id="transactionChart" style="min-height: 400px;" class="echart"></div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                        echarts.init(document.querySelector("#transactionChart")).setOption({
                                            tooltip: {
                                                trigger: 'item',
                                                formatter: '{a} <br/>{b}: {c} ({d}%)'
                                            },
                                            legend: {
                                                top: '5%',
                                                left: 'center'
                                            },
                                            series: [{
                                                name: 'Transaction Status',
                                                type: 'pie',
                                                radius: ['40%', '70%'],
                                                avoidLabelOverlap: false,
                                                label: {
                                                    show: false,
                                                    position: 'center'
                                                },
                                                emphasis: {
                                                    label: {
                                                        show: true,
                                                        fontSize: '18',
                                                        fontWeight: 'bold'
                                                    }
                                                },
                                                labelLine: {
                                                    show: false
                                                },
                                                data: [
                                                    { value: {{ $holdTransactionCount }}, name: 'Hold' },
                                                    { value: {{ $cancelledTransactionCount }}, name: 'Cancelled' },
                                                    { value: {{ $pendingTransactionCount }}, name: 'Pending' },
                                                    { value: {{ $terminatedTransactionCount }}, name: 'Terminated' }
                                                ]
                                            }]
                                        });
                                    });
                                    </script>

                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body pb-0">
                                    <h5 class="card-title">Phones Status</h5>

                                    <div id="PhoneChart" style="min-height: 400px;" class="echart"></div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                        echarts.init(document.querySelector("#PhoneChart")).setOption({
                                            tooltip: {
                                                trigger: 'item',
                                                formatter: '{a} <br/>{b}: {c} ({d}%)'
                                            },
                                            legend: {
                                                top: '5%',
                                                left: 'center'
                                            },
                                            series: [{
                                                name: 'Phone Status',
                                                type: 'pie',
                                                radius: ['40%', '70%'],
                                                avoidLabelOverlap: false,
                                                label: {
                                                    show: false,
                                                    position: 'center'
                                                },
                                                emphasis: {
                                                    label: {
                                                        show: true,
                                                        fontSize: '18',
                                                        fontWeight: 'bold'
                                                    }
                                                },
                                                labelLine: {
                                                    show: false
                                                },
                                                data: [
                                                    { value: {{ $holdPhoneCount }}, name: 'Hold' },
                                                    { value: {{ $cancelledPhoneCount }}, name: 'Cancelled' },
                                                    { value: {{ $pendingPhoneCount }}, name: 'Pending' },
                                                    { value: {{ $terminatedPhoneCount }}, name: 'Terminated' }
                                                ]
                                            }]
                                        });
                                    });
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                    @livewire('transaction-status-table', ['status' => 'Pending'])
                    @livewire('transaction-status-table', ['status' => 'OnHold'])
                    @livewire('transaction-status-table', ['status' => 'Terminated'])
                    @livewire('transaction-status-table', ['status' => 'Canceled'])
                </div>
                <div class="tab-pane fade phone pt-3" id="phone_number">
                </div>
            </div>

        </div>
    </div>
</div>




@endsection