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
      font-size: 12px;
      white-space: nowrap;
    }
  </style>
  <div class="card-body">
    <h5 class="card-title">Phone History |{{$dateDifference}} Days</h5>
    {{-- <livewire:on-hold> --}}
      <form action="" class="m-2">
        <div class="row pb-4">
          <div class="col mt-4">
            <div class="col-sm-10">
              <input type="text" name="phone_number" title="Enter search keyword" placeholder="Search by Phone Number"
                value="{{ old('phone_number',request('phone_number'))}}" class="form-control">
            </div>
          </div>
          <div class="col">
            <div class="col-sm-10">
              <label for="start_date">Start Date</label>
              <input type="date" class="form-control" id="start_date" name="start_date"
                value="{{ old('start_date',request('start_date')) }}">
            </div>
          </div>
          <div class="col">
            <div class="col-sm-10">
              <label for="end_date">End Date</label>
              <input type="date" class="form-control" id="end_date" name="end_date"
                value="{{ old('end_date',request('end_date'))}}">
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
        </div>
        <div class="d-flex gap-3">
          <button class="btn btn-primary">Search</button>
          <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
        </div>

      </form>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Username</th>
              <th>Phone Number</th>
              <th>Created at</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @if (count($phones) > 0)
            @foreach ($phones as $phone)
            <tr>
              <td><a href="{{route('user',['id'=>$phone->user_id])}}">{{ $phone->user->first_name . " " .
                  $phone->user->last_name }}</a></td>
              <td>{{ $phone->phone_number }}</td>
              <td>{{ $phone->created_at->format('Y-m-d H:i') }}</td>
              <td>
                @if($phone->status == 'Terminated')
                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>
                  Terminated</span> <small>at {{ $phone->updated_at->format('Y-m-d H:i')}}
                </small>
                @elseif($phone->status == 'Canceled')
                <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>
                  Cancelled</span> <small>at {{ $phone->updated_at->format('Y-m-d H:i')}}
                </small>
                @endif
              </td>

            </tr>
            @endforeach
            @else
            <tr>
              <td colspan="8" class="text-center">No phones found.</td>
            </tr>
            @endif
          </tbody>
          <tfoot>
            <tr>
              <td colspan="11" style="white-space: normal;">{{
                $phones->appends(request()->query())->links() }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
  </div>
</div>

<script>
  function showTooltip(element) {
        var tooltip = new bootstrap.Tooltip(element);
        tooltip.show();
    }
</script>

@endsection