@extends('dashbored')

@section('inner_content')
<div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Users</h5>
      <livewire:users-table>
        <!-- Table with stripped rows -->
        {{-- <table class="table datatable">
          <thead>
            <tr>
              <th scope="col">id</th>
              <th scope="col">Full Name</th>
              <th scope="col">Email</th>
              <th scope="col">Phone Number</th>
              <th scope="col">Date of Birth</th>

            </tr>
          </thead>
          <tbody>
            @if (count($users) > 0)
            @foreach ($users as $user)
            <tr>
              <th scope=" row"><a href="/user/{{ $user->id }}">{{ $loop->iteration }}</a></th>
              <td>{{ $user->first_name." ". $user->last_name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->phone }}</td>
              <td style="width: 200px;">{{ $user->date_of_birth }}</td>

            </tr>
            @endforeach
            @else
            <td colspan="8" class="text-center">No users found.</td>
            @endif
          </tbody>
        </table> --}}
        <!-- End Table with stripped rows -->

    </div>
  </div>
</div>
@endsection