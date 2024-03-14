@extends('dashbored')

@section('inner_content')
<div class="card-body">
    <h5 class="card-title">Dashbored</h5>

    <div class="row">
        @foreach($banks as $bank)
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">{{ $bank->Sb_name }}</h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
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
                                <span class="{{ $balance < 0 ? 'text-danger' : ($balance > 0 ? 'text-success' : '') }}">
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

</div>
@endsection