@php
$pollInterval = $status === 'Pending' ? 1200 : 30; // 20 minutes for Pending, 30 seconds for others
@endphp
<div wire:poll.{{ $pollInterval }}s>
  @if (session('status'))
  <x-alert :message="session('status')['message']" :status="session('status')['status']"
    :icon="session('status')['icon']" />
  @endif

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

  <h5 class="card-title"> {{$status}} phone </h5>
  <div class="m-2" style="width: 20%">
    <input type="text" wire:model.debounce.50ms="search" name="query" title="Enter search keyword"
      placeholder="Search by phone ID..." wire:keydown.enter="applySearch" class="form-control">
  </div>
  <div class="table-responsive">
    <table class="table table-striped" id="{{ $status }}_phone">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Phone Number</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (count($phones) > 0)
                @foreach ($phones as $phone)
                    <tr>
                        <td><a href="{{ route('user', ['id' => $phone->user_id]) }}">{{ $phone->user->first_name . " " . $phone->user->last_name }}</a></td>
                        <td>{{ $phone->phone_number }}</td>
                        <td>{{ $phone->created_at->format('Y-m-d H:i') }}</td>
                        <td class="d-flex">
                            @switch($status)
                                @case('Pending')
                                    <button data-bs-toggle="modal" data-bs-target="#terminate-{{ $phone->id }}"
                                            class="btn btn-sm btn-success me-2"
                                            wire:click="updatePhoneStatus({{ $phone->id }}, 'Terminated')"
                                            title="Accepted" wire:confirm="Are you sure you want to Terminate this phone?">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button wire:click="updatePhoneStatus({{ $phone->id }}, 'OnHold')"
                                            class="btn btn-sm btn-warning me-2" title="OnHold">
                                        <i class="bi bi-clock-fill"></i>
                                    </button>
                                    <button wire:confirm="Are you sure you want to delete this phone?"
                                            wire:click="updatePhoneStatus({{ $phone->id }}, 'Canceled')" class="btn btn-sm btn-danger"
                                            title="Canceled">
                                        <i class="bi bi-exclamation-octagon"></i>
                                    </button>
                                    @break
                                @case('OnHold')
                                    <button data-bs-toggle="modal" data-bs-target="#terminate-{{ $phone->id }}"
                                            class="btn btn-sm btn-success me-2"
                                            wire:click="updatePhoneStatus({{ $phone->id }}, 'Terminated')" title="Accepted"
                                            wire:confirm="Are you sure you want to Terminate this phone?">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button wire:confirm="Are you sure you want to delete this phone?"
                                            wire:click="updatePhoneStatus({{ $phone->id }}, 'Canceled')" class="btn btn-sm btn-danger"
                                            title="Canceled">
                                        <i class="bi bi-exclamation-octagon"></i>
                                    </button>
                                    @break
                                @case('Terminated')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Terminated</span> <small>at {{ $phone->updated_at->format('Y-m-d H:i') }}</small>
                                    @break
                                @case('Canceled')
                                    <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Canceled</span> <small>at {{ $phone->updated_at->format('Y-m-d H:i') }}</small>
                                    @break
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">No phones found.</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    {{ $phones->links() }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>


</div>

<script>
  document.querySelectorAll('.btn').forEach(function(button) {
      button.addEventListener('click', function() {
          navigator.vibrate([50]); // Vibrate for 50 milliseconds
          this.style.transform = 'scale(1.2)'; // Make the button slightly smaller
      });
  });
</script>