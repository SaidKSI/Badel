@php
$pollInterval = $status === 'Pending' ? 1200 : 30; // 20 minutes for Pending, 30 seconds for others
@endphp
<div wire:poll.{{ $pollInterval }}s>
  @if (session('status'))
  <x-alert :message="session('status')['message']" :status="session('status')['status']"
    :icon="session('status')['icon']" />
  @endif

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

  <h5 class="card-title"> {{$status}} Transaction </h5>
  <div class="m-2" style="width: 20%">
    <input type="text" wire:model.debounce.50ms="search" name="query" title="Enter search keyword"
      placeholder="Search by Transaction ID..." wire:keydown.enter="applySearch" class="form-control">
  </div>
  <div class="table-responsive">
    <table class="table table-striped" id="{{$status}}_transaction">
      <thead>
        <tr>
          @switch($status)
          @case('Pending')
          <th>User Name</th>
          <th>Bedel ID</th>
          <th>Sender Phone</th>
          <th>Amount</th>
          <th>Sender Bank</th>
          <th>Receiver Bank</th>
          <th>Transaction time</th>
          <th>Actions</th>
          @break
          @case('Accepted')
          <th>User Name</th>
          <th>Bedel ID</th>
          <th>Amount after tax</th>
          <th>Amount</th>
          <th>Sender Phone</th>
          <th>Phone Receiver</th>
          <th>Receiver Bank</th>
          <th>Transaction time</th>
          <th>Action</th>
          @break
          @case('OnHold')
          <th>User Name</th>
          <th>Bedel ID</th>
          <th>Balance</th>
          {{-- <th>Amount after tax</th>
          <th>Amount</th> --}}
          <th>Sender Phone</th>
          <th>Phone Receiver</th>
          <th>Receiver Bank</th>
          <th>Transaction time</th>
          <th>Action</th>
          @break
          @case('Terminated')
          <th>User Name</th>
          <th>Bedel ID</th>
          <th>Amount</th>
          <th>Sender Phone</th>
          <th>Receiver Bank</th>
          <th>Transaction time</th>
          {{-- <th>Terminated</th> --}}
          <th>Transaction ID</th>
          <th>Status</th>
          @break
          @case('Canceled')
          <th>User Name</th>
          <th>Bedel ID</th>
          <th>Amount</th>
          <th>Sender Phone</th>
          <th>Receiver Bank</th>
          <th>Transaction time</th>
          {{-- <th>Transaction ID</th> --}}
          <th>Status</th>
          @break
          @default
          @endswitch
        </tr>
      </thead>
      <tbody>
        @if (count($transactions) > 0)
        @foreach ($transactions as $transaction)
        <tr>
          @switch($status)
          @case('Pending')
          <td><a href="{{route('user',['id'=>$transaction->user_id])}}">{{ $transaction->user->first_name . "
              " .
              $transaction->user->last_name }}</a></td>
          <td><a href="{{ route('transaction', ['transaction_id' => $transaction->transaction_id]) }}">{{
              $transaction->transaction_id }}</a></td>
          <td>{{ $transaction->send_phone }}</td>
          <td>{{ $transaction->amount }}</td>
          <td><a href="{{route('bank',['id'=>$transaction->send_sb_id])}}">{{
              $transaction->sendBank->Sb_name }} </a> </td>
          <td><a href="{{route('bank',['id'=>$transaction->receiver_sb_id])}}">{{
              $transaction->receiverBank->Sb_name }}</a> </td>
          <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
          <td class="d-flex">
            <button data-bs-toggle="modal" data-bs-target="#terminate-{{ $transaction->id }}"
              class="btn btn-sm btn-success me-2" title="Accepted">
              <i class="bi bi-check-circle"></i>
            </button>
            <button wire:click="updateTransactionStatus({{ $transaction->id }}, 'OnHold')"
              class="btn btn-sm btn-warning me-2" title="OnHold">
              <i class="bi bi-clock-fill"></i>
            </button>
            <button wire:confirm="Are you sure you want to delete this Transaction?"
              wire:click="updateTransactionStatus({{ $transaction->id }}, 'Canceled')" class="btn btn-sm btn-danger"
              title="Canceled">
              <i class="bi bi-exclamation-octagon"></i>
            </button>
            <div class="modal fade" id="terminate-{{ $transaction->id }}" tabindex="-1"
              aria-labelledby="terminateModalLabel-{{ $transaction->id }}" aria-hidden="true">
              <div wire:ignore.self class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="terminateModalLabel-{{ $transaction->id }}">Validation Process</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form wire:submit.prevent="updateTransactionStatus({{ $transaction->id }}, 'Accepted')"
                    id="updateForm{{ $transaction->id }}">
                    <div class="modal-body">
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control"
                            value="{{ $transaction->user->first_name . " " .
                          $transaction->user->last_name }}" readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Sender Phone</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control"
                            value="{{$transaction->send_phone}}" readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Receiver Bank</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control"
                            value="{{$transaction->receiverBank->Sb_name}}" readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Badel ID</label>
                        <div class="col-sm-8">
                          @php
                          $maskedId = str_repeat('x', max(0, strlen($transaction->transaction_id) - 4)) .
                          substr($transaction->transaction_id, -4);
                          @endphp
                          <input type="text" class="form-control" value="{{ $maskedId }}" readonly>
                        </div>
                      </div>
                      <input type="text" id="originalTransactionId" value="{{ $transaction->transaction_id }}" hidden>
                      <input type="text" id="originalAmount" value="{{ $transaction->amount }}" hidden>

                      <div class="row mb-3">
                        <label for="reBadelId" class="col-sm-3 col-form-label">Re_Badel ID </label>
                        <div class="col-sm-8">
                          <input id="reBadelId" type="text" name="reBadelId" class="form-control">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="reAmount" class="col-sm-3 col-form-label">Re_Amount </label>
                        <div class="col-sm-8">
                          <input id="reAmount" type="text" name="reAmount" class="form-control">
                        </div>
                      </div>

                      <div class="modal-footer justify-content-center">
                        <button type="submit" id="validateBtn" class="btn btn-primary" disabled>Validate</button>
                        <div id="error_message"
                          class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                          role="alert">Conditions not met. Please enter correct Re_Badel ID and Re_Amount.
                        </div>
                      </div>

                      <script>
                        $(document).ready(function() {
                                  $('#reBadelId, #reAmount').on('input', function() {
                                      var originalTransactionId = $('#originalTransactionId').val();
                                      var originalAmount = $('#originalAmount').val();
                                      var reBadelId = $('#reBadelId').val();
                                      var reAmount = $('#reAmount').val();
                                      
                                      // console.log("Original Transaction ID:", originalTransactionId);
                                      // console.log("Original Amount:", originalAmount);
                                      // console.log("Re_Badel ID:", reBadelId);
                                      // console.log("Re_Amount:", reAmount);

                                      if (reBadelId == originalTransactionId && reAmount == originalAmount) {
                                          // console.log("Conditions met. Enabling Validate button.");
                                          $('#validateBtn').prop('disabled', false);
                                          $('#error_message').hide();
                                      } else {
                                          // console.log("Conditions not met. Disabling Validate button.");
                                          $('#validateBtn').prop('disabled', true);
                                      }
                                  });
                              });
                              
                      </script>
                  </form>

                </div>
              </div>
            </div>
          </td>
          <script>
            window.addEventListener('closeTerminateModal', event => {
     $("#terminate-{{ $transaction->id }}").modal('hide');                
      })
          </script>
          @break
          @case('Accepted')
          <td><a href="{{route('user',['id'=>$transaction->user_id])}}">{{ $transaction->user->first_name . "
              " .
              $transaction->user->last_name }}</a></td>
          <td><a href="{{ route('transaction', ['transaction_id' => $transaction->transaction_id]) }}">{{
              $transaction->transaction_id }}</a></td>
          <td>{{ $transaction->amount_after_tax }}</td>
          <td>{{ $transaction->amount }}</td>
          <td>{{ $transaction->send_phone }}</td>
          <td>{{ $transaction->receiver_phone }}</td>
          <td><a href="{{route('bank',['id'=>$transaction->receiver_sb_id])}}">{{
              $transaction->receiverBank->Sb_name }}</a> </td>
          <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
          <td class="d-flex">
            <button wire:click="updateTransactionStatus({{ $transaction->id }}, 'Pending')"
              class="btn btn-sm btn-warning me-2" title="Restore">
              <i class="bi bi-arrow-clockwise"></i>
            </button>
            <button class="btn btn-sm btn-success" title="Terminated" data-bs-toggle="modal"
              data-bs-target="#editModal{{ $transaction->id }}">
              <i class="bi bi-check-circle"></i>

            </button>
            <!-- Modal -->
            <div class="modal fade" id="editModal{{ $transaction->id }}" tabindex="-1"
              aria-labelledby="editModalLabel{{ $transaction->id }}" aria-hidden="true">

              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $transaction->id }}">Terminate Transaction </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form wire:submit.prevent="updateTransactionStatus({{ $transaction->id }}, 'Terminated')"
                    id="updateForm{{ $transaction->id }}" P>
                    <div class="modal-body">
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control"
                            value="{{ $transaction->user->first_name . " " .
                          $transaction->user->last_name }}" readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Bedel ID</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control"
                            value="{{$transaction->transaction_id}}" readonly>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Sender Phone</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control"
                            value="{{$transaction->send_phone}}" readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Receiver Phone</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control"
                            value="{{$transaction->receiver_phone}}" readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Receiver Name</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control"
                            value="{{$transaction->receiver_full_name}}" readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Receiver Bank</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control"
                            value="{{$transaction->receiverBank->Sb_name}}" readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Amount</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control" value="{{$transaction->amount}}"
                            readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Amount after Tax</label>
                        <div class="col-sm-8">
                          <input type="text" name="send_account" class="form-control"
                            value="{{$transaction->amount_after_tax}}" readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputMin" class="col-sm-3 col-form-label">Transaction ID</label>
                        <div class="col-sm-8">
                          <input type="text" wire:model="bedel_id" class="form-control" >
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save
                          changes</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            <script>
              window.addEventListener('closeEditModal', event => {
       $("#editModal{{ $transaction->id }}").modal('hide');                
        })
            </script>
          </td>
          @break
          @case('OnHold')
          <td><a href="{{route('user',['id'=>$transaction->user_id])}}">{{ $transaction->user->first_name . "
              " .
              $transaction->user->last_name }}</a></td>
          <td><a href="{{ route('transaction', ['transaction_id' => $transaction->transaction_id]) }}">{{
              $transaction->transaction_id }}</a></td>
          @php
          $balance = $transaction->amount - $transaction->amount_after_tax
          @endphp
          <td class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
            {{ $balance }}

            <i class="bi bi-info-circle text-primary" id="{{ $transaction->id }} " style="font-size: 0.8rem;"
              data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
              title="Amount: {{ $transaction->amount }}  || Amount after tax: {{ $transaction->amount_after_tax }}"
              onmouseenter="showTooltip(this)"></i>
          </td>
          <td>{{ $transaction->send_phone }}</td>
          <td>{{ $transaction->receiver_phone }}</td>
          <td><a href="{{route('bank',['id'=>$transaction->receiver_sb_id])}}">{{
              $transaction->receiverBank->Sb_name }}</a> </td>
          <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
          <td class="d-flex">
            <button wire:click="updateTransactionStatus({{ $transaction->id }}, 'Terminated')"
              class="btn btn-sm btn-success me-2">
              <i class="bi bi-check-circle"></i>
            </button>
            <button wire:confirm="Are you sure you want to delete this Transaction?"
              wire:click="updateTransactionStatus({{ $transaction->id }}, 'Canceled')" class="btn btn-sm btn-danger"
              title="Canceled">
              <i class="bi bi-exclamation-octagon"></i>
            </button>
          </td>
          @break
          @case('Terminated')
          <td><a href="{{route('user',['id'=>$transaction->user_id])}}">{{ $transaction->user->first_name . "
              " .
              $transaction->user->last_name }}</a></td>
          <td><a href="{{ route('transaction', ['transaction_id' => $transaction->transaction_id]) }}">{{
              $transaction->transaction_id }}</a></td>
          <td>{{ $transaction->amount }}</td>
          <td>{{ $transaction->send_phone }}</td>
          <td><a href="{{route('bank',['id'=>$transaction->receiver_sb_id])}}">{{
              $transaction->receiverBank->Sb_name }}</a> </td>
          <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
          {{-- <td>{{ $transaction->updated_at->format('Y-m-d H:i') }}</td> --}}
          <td>{{ $transaction->bedel_id }}</td>
          <td> <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>
              Terminated</span> <small>at {{ $transaction->updated_at->format('Y-m-d H:i')}}
            </small></td>

          @break
          @case('Canceled')
          <td><a href="{{route('user',['id'=>$transaction->user_id])}}">{{ $transaction->user->first_name . "
              " .
              $transaction->user->last_name }}</a></td>
          <td><a href="{{ route('transaction', ['transaction_id' => $transaction->transaction_id]) }}">{{
              $transaction->transaction_id }}</a></td>
          <td>{{ $transaction->amount }}</td>
          <td>{{ $transaction->send_phone }}</td>
          <td><a href="{{route('bank',['id'=>$transaction->receiver_sb_id])}}">{{
              $transaction->receiverBank->Sb_name }}</a> </td>
          <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
          {{-- <td>
            Transaction ID
          </td> --}}
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
            {{$transactions->links()}}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>

</div>

<script>
  document.querySelectorAll('.btn').forEach(function(button) {
      button.addEventListener('click', function() {
          navigator.vibrate([50]); // Vibrate for 50 milliseconds
          this.style.transform = 'scale(1.2)'; // Make the button slightly smaller
      });
  });
</script>