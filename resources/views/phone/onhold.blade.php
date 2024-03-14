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
      <table class="table datatable">
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
              <div class="d-flex">
                <form action="{{ route('phones.updateStatus', ['id' => $phone->id, 'status' => 'Terminated']) }}"
                  method="POST" onsubmit="return confirm('Are you sure you want to terminate this phone?');">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="btn btn-success me-2" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Terminate">
                    <i class="bi bi-check-circle"></i>
                  </button>
                </form>

                <form action="
                    {{ route('phones.updateStatus', ['id' => $phone->id, 'status' => 'Canceled']) }}
                    " method="POST" onsubmit="return confirm('Are you sure you want to cancel this phone?');">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="btn btn-danger me-2" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Cancel">
                    <i class="bi bi-exclamation-octagon"></i>
                  </button>
                </form>

              </div>
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