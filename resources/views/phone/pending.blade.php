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
    <h5 class="card-title">Pending Phone</h5>

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
            <td class="d-flex">

              <button type="button" class="btn btn-success me-2"
                onclick="updatePhoneStatus({{ $phone->id }}, 'Terminated', this.closest('tr'))">
                <i class="bi bi-check-circle"></i>
              </button>
              <button type="button" class="btn btn-warning me-2"
                onclick="updatePhoneStatus({{ $phone->id }}, 'OnHold', this.closest('tr'))">
                <i class="bx bxs-hand"></i>
              </button>

              <button type="button" class="btn btn-danger"
                onclick="updatePhoneStatus({{ $phone->id }}, 'Canceled', this.closest('tr'))">
                <i class="bi bi-exclamation-octagon"></i>
              </button>


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
  function updatePhoneStatus(phoneId, status, row) {
    if (confirm(`Are you sure you want to ${status.toLowerCase()} this phone?`)) {
      $.ajax({
        url: `/admin/phones/update/${phoneId}/${status}`,
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          _method: 'PATCH',
          status: status
        },
        success: function (response) {
          // Remove the row from the table
          $(row).remove();
          console.log(response.message);
        },
        error: function (xhr, status, error) {
          console.error(error);
        }
      });
    }
  }
</script>

@endsection