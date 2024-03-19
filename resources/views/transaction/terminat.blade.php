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
    <h5 class="card-title">Terminated Transaction <span>| {{$transactionCount}} in {{$date_difference}}
        Days</span></h5>

    <form action="">
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
      <table class="table datatable table-striped">
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
            <td><a href="{{route('user',['id'=>$transaction->user_id])}}">{{ $transaction->user->first_name . " " .
                $transaction->user->last_name }}</a></td>
            <td><a href="{{ route('transaction', ['transaction_id' => $transaction->transaction_id]) }}">{{
                $transaction->transaction_id }}</a></td>
            @php
            $balance = $transaction->amount - $transaction->amount_after_tax
            @endphp
            <td class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
              {{ $balance }}
              <i class="bi bi-info-circle text-primary" style="font-size: 0.8rem;" data-bs-toggle="tooltip"
                data-bs-placement="top" data-bs-html="true"
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
              <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>
                Terminated</span> <small>at {{ $transaction->updated_at->format('Y-m-d H:i')}}
              </small>
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



@endsection