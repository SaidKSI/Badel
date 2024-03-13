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
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @if (count($banks) > 0)
          @foreach ($banks as $bank)
          <tr>
            <th scope="row"><a href="/bank/{{ $bank->id }}">{{ $loop->iteration }}</a></th>
            <td>
              <img src="{{ asset($bank->profile_picture) }}" alt="Bank Image" style="width: 50px; height: auto;">
            </td>
            <td>{{ $bank->Sb_name }}</td>
            <td>{{ $bank->send_account }}</td>
            <td>
              @if ($bank->can_send)
              <span class="text-success">&#11044;</span> {{-- Green dot --}}
              @else
              <span class="text-danger">&#11044;</span> {{-- Red dot --}}
              @endif
            </td>
            <td>
              @if ($bank->can_receive)
              <span class="text-success">&#11044;</span> {{-- Green dot --}}
              @else
              <span class="text-danger">&#11044;</span> {{-- Red dot --}}
              @endif
            </td>
            <td>
              <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#editModal{{ $bank->id }}">
                <i class="bi bi-pen-fill"></i>
              </button>
              <!-- Modal -->
              <div class="modal fade" id="editModal{{ $bank->id }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="{{ route('banks_update', ['id' => $bank->id]) }}" method="POST">
                      @method('PATCH')
                      @csrf
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h5 class="modal-title">Edit bank {{ $bank->Sb_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <!-- Modal Body -->
                      <div class="modal-body">
                        <div class="row mb-3">
                          <label for="inputMin" class="col-sm-2 col-form-label">Send Account</label>
                          <div class="col-sm-10">
                            <input type="text" name="send_account" class="form-control"
                              value="{{ $bank->send_account }}">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputMax" class="col-sm-2 col-form-label">Can Send</label>
                          <div class="col-sm-10">
                            <input type="number"  class="form-control" value="{{ $bank->can_send }}"
                              name="can_send" min="0" max="1" step="1" pattern="[0-1]"
                              title="Please enter either 0 or 1">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputMax" class="col-sm-2 col-form-label">Can Receive</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control"
                              value="{{ $bank->can_receive }}" name="can_receive" min="0" max="1" step="1"
                              pattern="[0-1]" title="Please enter either 0 or 1">
                          </div>
                        </div>


                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
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