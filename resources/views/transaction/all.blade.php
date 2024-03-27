@extends('dashbored')

@section('content')
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
    <h5 class="card-title">Transaction <span>| {{$transactionCount}} in {{$dateDifference}}
        Days</span></h5>
    <form action="">
      <div class="row pb-4">
        <div class="col">
          <div class="col-sm-10">
            <label for="start_date">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date"
              value="{{ old('start_date', $startDate) }}">
          </div>
        </div>
        <div class="col">
          <div class="col-sm-10">
            <label for="end_date">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date"
              value="{{ old('end_date', $endDate) }}">
          </div>
        </div>

        <div class="col">
          <div class="col-sm-10">
            <label for="status">Status</label>
            <select class="form-select" id="status" name="status">
              <option value="">Status</option>
              <option value="terminated" {{ request('status')=='terminated' ? 'selected' : '' }}>
                Terminated
              </option>
              <option value="canceled" {{ request('status')=='canceled' ? 'selected' : '' }}>
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

    <div id="transactiontables">
      <x-transaction-table-status :transactions="$transactions" status="Pending" />
      <x-transaction-table-status :transactions="$transactions" status="OnHold" />
      <x-transaction-table-status :transactions="$transactions" status="Terminated" />
      <x-transaction-table-status :transactions="$transactions" status="Canceled" />
    </div>

  </div>
</div>
<script>
  //   $(document).ready(function() {
//     let transactions; // Define a variable to store transactions

//     // Function to fetch transactions
//     function fetchTransactions() {
//         $.ajax({
//             url: '/admin/all_transactions/fetch', // Route to fetch transactions
//             method: 'GET',
//             success: function(response) {
//                 // select the body using ajax and empty it and append the response to the body
                


//             },
//             error: function(xhr, status, error) {
//                 console.error(error);
//                 console.error(status);
//                 console.error(xhr);
//             }
//         });
//     }

//     // Call fetchTransactions initially
//     fetchTransactions();

//     // Call fetchTransactions every 30 seconds
//     setInterval(fetchTransactions, 30000); // 30000 milliseconds = 30 seconds
// });


</script>
@endsection