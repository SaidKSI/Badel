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
    <h5 class="card-title">FEES</h5>
    {{-- <livewire:on-hold> --}}

      <div class="table-responsive">
        <table class="table datatable table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Min</th>
              <th>Max</th>
              <th>Fee</th>
              <th>Updated At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($fees as $fee)
            <tr>
              <td>{{ $fee->id }}</td>
              <td>{{ $fee->min}}</td>
              <td>{{ $fee->max }}</td>
              <td>{{ $fee->fee }}</td>
              <td>{{ $fee->updated_at->format('Y-m-d H:i') }}</td>
              <td>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                  data-bs-target="#editModal{{ $fee->id }}">
                  <i class="bi bi-pen-fill"></i>
                </button>
                <div class="modal fade" id="editModal{{ $fee->id }}" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="{{ route('fees_update', ['id' => $fee->id]) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="modal-header">
                          <h5 class="modal-title">Edit Fee</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="row mb-3">
                            <label for="inputMin" class="col-sm-2 col-form-label">MIN</label>
                            <div class="col-sm-10">
                              <input type="number" name="min" class="form-control" value="{{ $fee->min }}">
                            </div>
                          </div>
                          <div class="row mb-3">
                            <label for="inputMax" class="col-sm-2 col-form-label">MAX</label>
                            <div class="col-sm-10">
                              <input type="number" name="max" class="form-control" value="{{ $fee->max }}">
                            </div>
                          </div>
                          <div class="row mb-3">
                            <label for="inputFee" class="col-sm-2 col-form-label">FEE</label>
                            <div class="col-sm-10">
                              <input type="number" name="fee" class="form-control" value="{{ $fee->fee }}">
                            </div>
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
          </tbody>
        </table>
      </div>
  </div>
</div>
@endsection