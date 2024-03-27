@props(['message', 'status', 'icon'])

<div class="alert alert-{{ $status }} alert-dismissible fade show position-fixed top-0 end-0" role="alert" style="margin-top: 90px" >
  <i class="{{ $icon }} me-1"></i>
  {{ $message }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<script>
  setTimeout(function() {
        var alertDiv = document.querySelector('.alert');
        alertDiv.classList.remove('show');
        alertDiv.classList.add('hide');
    }, 3000);
</script>