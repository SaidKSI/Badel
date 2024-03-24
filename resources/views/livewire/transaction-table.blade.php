<div wire:poll.30s>
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

  <h5 class="card-title"> {{$status}} Transaction</h5>
  <div class="m-2" style="width: 20%">
    <input type="text" wire:model.debounce.50ms="search" name="query" title="Enter search keyword"
      placeholder="Search by Transaction ID..." wire:keydown.enter="applySearch" class="form-control">
  </div>
  <div class="table-responsive">
    <table class="table table-striped" id="{{$status}}_transaction" wire:poll.30s>
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
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @if (count($transactions) > 0)
        @foreach ($transactions as $transaction)
        <tr>
          <td><a href="{{route('user',['id'=>$transaction->user_id])}}">{{ $transaction->user->first_name . "
              " .
              $transaction->user->last_name }}</a></td>
          <td><a href="{{ route('transaction', ['transaction_id' => $transaction->transaction_id]) }}">{{
              $transaction->transaction_id }}</a></td>
          </td>
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
          @switch($status)
          @case('Pending')
          <td class="d-flex">

            <button wire:click="updateTransactionStatus({{ $transaction->id }}, 'Terminated')"
              class="btn btn-sm btn-success me-2" title="Terminated">
              <i class="bi bi-check-circle"></i>
            </button>
            <button wire:click="updateTransactionStatus({{ $transaction->id }}, 'OnHold')"
              class="btn btn-sm btn-warning me-2" title="OnHold">
              <i class="bi bi-clock-fill"></i>
            </button>

            <button wire:click="updateTransactionStatus({{ $transaction->id }}, 'Canceled')"
              class="btn btn-sm btn-danger" title="Canceled">
              <i class="bi bi-exclamation-octagon"></i>
            </button>

          </td>
          @break
          @case('Terminated')
          <td>
            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>
              Terminated</span> <small>at {{ $transaction->updated_at->format('Y-m-d H:i')}}
            </small>
          </td>
          @break
          @case('OnHold')
          <td class="d-flex">
            <button wire:click="updateTransactionStatus({{ $transaction->id }}, 'Terminated')"
              class="btn btn-success me-2">
              <i class="bi bi-check-circle"></i>
            </button>
            <button wire:click="updateTransactionStatus({{ $transaction->id }}, 'Canceled')" class="btn btn-danger">
              <i class="bi bi-exclamation-octagon"></i>
            </button>
          </td>
          @break
          @case('Canceled')
          <td>
            <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>
              Cancelled</span> <small>at {{ $transaction->updated_at->format('Y-m-d H:i')}}
            </small>
          </td>
          @break
          @default

          @endswitch

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
          <td colspan="11">
            <x-pagination :items="$transactions" />
          </td>
        </tr>
      </tfoot>
    </table>
    <div>
    </div>
  </div>
</div>