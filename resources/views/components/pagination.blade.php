@props(['items'])
<nav aria-label="Page navigation example">
  <ul class="pagination">
      <!-- Previous Page Link -->
      @if ($items->onFirstPage())
      <li class="page-item disabled">
          <span class="page-link">Previous</span>
      </li>
      @else
      <li class="page-item">
          <button class="page-link" wire:click="previousPage" wire:loading.attr="disabled"
              rel="prev">
              Previous
          </button>
      </li>
      @endif

      <!-- Pagination Elements -->
      @foreach ($items->links()->elements as $element)
      @if (is_array($element))
      @foreach ($element as $page => $url)
      @if ($page == $items->currentPage())
      <li class="page-item active" aria-current="page">
          <span class="page-link">{{ $page }}</span>
      </li>
      @else
      <li class="page-item">
          <button class="page-link" wire:click="gotoPage({{ $page }})"
              wire:loading.attr="disabled">{{ $page }}</button>
      </li>
      @endif
      @endforeach
      @endif
      @endforeach

      <!-- Next Page Link -->
      @if ($items->hasMorePages())
      <li class="page-item">
          <button class="page-link" wire:click="nextPage" wire:loading.attr="disabled"
              rel="next">Next</button>
      </li>
      @else
      <li class="page-item disabled">
          <span class="page-link">Next</span>
      </li>
      @endif
  </ul>
</nav>