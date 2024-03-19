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
    <h5 class="card-title">Pending Phone </h5>

    <div class="table-responsive">
      <table class="table datatable table-striped">
        <thead>
          <tr>
            <th>User</th>
            <th>Phone Number</th>
            <th>Created_at</th>
            <th>Action</th>
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
              <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>
                Cancelled</span><small>at {{ $phone->updated_at->format('Y-m-d H:i')}}
              </small>
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


@endsection