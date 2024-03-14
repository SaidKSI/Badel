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
        <h5 class="card-title">On Hold Transaction</h5>
        {{-- <livewire:on-hold> --}}

            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Date of birth</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <a href="{{route('user',['id'=>$user->id])}}">{{ $user->id }}</a>
                            </td>
                            <td>{{ $user->first_name . " " . $user->last_name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->date_of_birth }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
</div>
@endsection