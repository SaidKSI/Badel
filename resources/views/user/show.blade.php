@extends('dashbored')

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

                    {{-- <img src="{{asset('assets/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle"> --}}
                    <i class="bi bi-person bi-lg" alt="Profile" class="rounded-circle" style="font-size: 60px"></i>
                    <h2>{{ $user->first_name . " " . $user->last_name }}</h2>
                    <div class="m-3">
                        <h3>{{ $user->email ? $user->email : "" }}</h3>
                        <h3>({{ $user->country_code }}){{ $user->phone }}</h3>
                        <h3>{{ $user->date_of_birth}}</h3>
                        <h3>{{ $user->uuid}}</h3>

                    </div>

                </div>
            </div>

        </div>

        <div class="col-xl-9">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">{{$transactionCount}} Transactions</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">{{$phoneCount}}
                                Phone Numbers</button>
                        </li>


                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            {{-- <form action="">
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
                                                <option value="terminated" {{ old('status')=='terminated' ? 'selected'
                                                    : '' }}>
                                                    Terminated</option>
                                                <option value="canceled" {{ old('status')=='canceled' ? 'selected' : ''
                                                    }}>Canceled
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
                            </form> --}}

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
                                        @if ($user->transaction && count($user->transaction) > 0)
                                        @foreach ($user->transaction as $transaction)
                                        <tr>
                                            <td> <a
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
                                            <td><a href="{{route('bank',['id'=>$transaction->send_sb_id])}}">{{
                                                    $transaction->sendBank->Sb_name }} </a> </td>
                                            <td><a href="{{route('bank',['id'=>$transaction->receiver_sb_id])}}">{{
                                                    $transaction->receiverBank->Sb_name }}</a> </td>
                                            <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @if($transaction->status == 'Terminated')
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>
                                                    Terminated</span> <small>at {{
                                                    $transaction->updated_at->format('Y-m-d
                                                    H:i')}}
                                                </small>
                                                @elseif($transaction->status == 'Canceled')
                                                <span class="badge bg-danger"><i
                                                        class="bi bi-exclamation-octagon me-1"></i>
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
                                                <span class="badge bg-dark"><i class="bi bi-folder me-1"></i>
                                                    Pending</span>
                                                <small>at {{
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
                                                $user->first_name . " " . $user->last_name
                                                }}.</td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>

                                            <th>Phone Number</th>
                                            <th>Created at</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($user->phone_number && count($user->phone_number) > 0)
                                        @foreach ($user->phone_number as $phone_number)
                                        <tr>
                                            <td>{{ $phone_number->phone_number }}</td>
                                            <td>{{ $phone_number->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @if($phone_number->status == 'Terminated')
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>
                                                    Terminated</span> <small>at {{
                                                    $phone_number->updated_at->format('Y-m-d
                                                    H:i')}}
                                                </small>
                                                @elseif($phone_number->status == 'Canceled')
                                                <span class="badge bg-danger"><i
                                                        class="bi bi-exclamation-octagon me-1"></i>
                                                    Cancelled</span> <small>at {{
                                                    $phone_number->updated_at->format('Y-m-d
                                                    H:i')}}
                                                </small>
                                                @elseif($phone_number->status == 'OnHold')
                                                <span class="badge bg-warning text-dark"><i
                                                        class="bi bi-exclamation-triangle me-1"></i> OnHold</span>
                                                <small>at {{
                                                    $phone_number->updated_at->format('Y-m-d
                                                    H:i')}}
                                                </small>
                                                @elseif($phone_number->status == 'Pending')
                                                <span class="badge bg-dark"><i class="bi bi-folder me-1"></i>
                                                    Pending</span>
                                                <small>at {{
                                                    $phone_number->updated_at->format('Y-m-d
                                                    H:i')}}
                                                </small>
                                                @endif

                                            </td>

                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="8" class="text-center">No phones found {{
                                                $user->first_name . " " . $user->last_name
                                                }}..</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>



                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
</section>
@endsection