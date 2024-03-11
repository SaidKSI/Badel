@props(['commande'])

<li class="notification-item">
	<i class="bi bi-exclamation-circle text-warning"></i>
	<a href="/commande/{{ $commande->id }}">
	<div>
		<h4>{{ $commande->user->name }}</h4>
		<p>{{ $commande->created_at->diffForHumans() }}</p>
	</div>
</a>
</li>



<li>
	<hr class="dropdown-divider">
</li>
