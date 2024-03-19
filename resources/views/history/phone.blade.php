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
    <h5 class="card-title">Phone History |{{$dateDifference}} Days</h5>
    {{-- <livewire:on-hold> --}}
      <form action="">
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
                <option value="" {{ request('status')=='' ? 'selected' : '' }}>Status</option>
                <option value="terminated" {{ request('status')=='terminated' ? 'selected' : '' }}>
                  Terminated
                </option>
                <option value="canceled" {{ request('status')=='canceled' ? 'selected' : '' }}>
                  Canceled
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
      </form>

      <div class="table-responsive">
        <table class="table datatable table-striped">
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