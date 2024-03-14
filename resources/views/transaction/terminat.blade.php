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
    <h5 class="card-title">Terminated Transaction </h5>

    <livewire:transaction-date-filter>


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
              <td><a href="{{route('user',['id'=>$transaction->user_id])}}">{{ $transaction->user->first_name . " " .
                  $transaction->user->last_name }}</a></td>
              <td>{{ $transaction->transaction_id }}</td>
              @php
              $balance = $transaction->amount - $transaction->amount_after_tax
              @endphp
              <td class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                {{ $balance }}
                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top"
                  data-bs-html="true"
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