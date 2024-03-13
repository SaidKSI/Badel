@extends('dashbored')

@section('inner_content')
<div>
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
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Banks</h5>

      <!-- Table with stripped rows -->
      <table class="table datatable">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">IMG</th>
            <th scope="col">Bank Name</th>
            <th scope="col">Send Account</th>
            <th scope="col">can send</th>
            <th scope="col">can receive</th>

          </tr>
        </thead>
        <tbody>
          @if (count($banks) > 0)
          @foreach ($banks as $bank)
          <tr>
            <th scope="row"><a href="/bank/{{ $bank->id }}">{{ $loop->iteration }}</a></th>
            <td>{{ $bank->Sb_name }}</td>
            <td>{{ $bank->send_account }}</td>
            <td>
              @if ($bank->can_send)
              <span class="text-success">&#11044;</span> {{-- Green dot --}}
              @else
              <span class="text-danger">&#11044;</span> {{-- Red dot --}}
              @endif
            </td>
            <td> @if ($bank->can_receive)
              <span class="text-success">&#11044;</span> {{-- Green dot --}}
              @else
              <span class="text-danger">&#11044;</span> {{-- Red dot --}}
              @endif
            </td>
          </tr>
          @endforeach
          @else
          <tr>
            <td colspan="8" class="text-center">No Banks found.</td>
          </tr>
          @endif
        </tbody>
      </table>
      <!-- End Table with stripped rows -->

    </div>
  </div>
</div>


@endsection