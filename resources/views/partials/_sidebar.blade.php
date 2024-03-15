<aside class="sidebar" id="sidebar">

	<ul class="sidebar-nav" id="sidebar-nav">
		<li class="nav-item">
			<a class="nav-link collapsed" href="/admin/dashbored">
				<i class="bi bi-grid"></i>
				<span>Dashboard</span>
			</a>
		</li>
		{{-- <li class="nav-heading">Transaction</li>
		<li class="nav-item">
			<a class="nav-link collapsed" href="/admin/transactions/pending">
				<i class="bi bi-clock-fill"></i>
				<span>Pending Transaction</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" href="/admin/transactions/terminated">
				<i class="bi bi-check2-square"></i>
				<span>Accepted Transaction</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" href="/admin/transactions/onhold">
				<i class="bi bi-clock-fill"></i>
				<span>On Hold Transaction</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" href="/admin/transactions/Canceled">
				<i class="bx bxs-hand"></i>
				<span>Cancelled Transaction</span>
			</a>
		</li> --}}
		<li class="nav-item">
			<a class="nav-link collapsed" data-bs-target="#transaction" data-bs-toggle="collapse" href="#">
				<i class="bi bi-arrow-left-right"></i><span>Transactions</span><i class="bi bi-chevron-down ms-auto"></i>
			</a>
			<ul id="transaction" class="nav-content collapse " data-bs-parent="#sidebar-nav">
				<li>
					<a href="/admin/transactions/pending">
						<i class="bi bi-clock-fill"></i><span>Pending Transaction </span>
					</a>
				</li>
				<li>
					<a href="/admin/transactions/terminated">
						<i class="bi bi-check2-square"></i><span>Accepted Transaction</span>
					</a>
				</li>
				<li>
					<a href="/admin/transactions/onhold">
						<i class="bi bi-clock-fill"></i><span>On Hold Transaction</span>
					</a>
				</li>
				<li>
					<a href="/admin/transactions/Canceled">
						<i class="bx bxs-hand"></i><span>Cancelled Transaction</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" data-bs-target="#phone" data-bs-toggle="collapse" href="#">
				<i class="bi bi-phone"></i><span>Phone Numbers</span><i class="bi bi-chevron-down ms-auto"></i>
			</a>
			<ul id="phone" class="nav-content collapse " data-bs-parent="#sidebar-nav">
				<li>
					<a href="/admin/phones/pending">
						<i class="bi bi-clock-fill"></i><span>Pending Phone</span>
					</a>
				</li>
				<li>
					<a href="/admin/phones/terminated">
						<i class="bi bi-check2-square"></i><span>Accepted Phone</span>
					</a>
				</li>
				<li>
					<a href="/admin/phones/onhold">
						<i class="bi bi-clock-fill"></i><span>On Hold Phone</span>
					</a>
				</li>
				<li>
					<a href="/admin/phones/Canceled">
						<i class="bx bxs-hand"></i><span>Cancelled Phone</span>
					</a>
				</li>
			</ul>
		</li>

		<li class="nav-item">
			<a class="nav-link collapsed" data-bs-target="#other" data-bs-toggle="collapse" href="#">
				<i class="ri-file-paper-2-fill"></i><span>Other Pages</span><i class="bi bi-chevron-down ms-auto"></i>
			</a>
			<ul id="other" class="nav-content collapse " data-bs-parent="#sidebar-nav">
				<li>
					<a class="nav-link collapsed" href="/admin/banks">
						<i class="bi bi-bank"></i>
						<span>Banks</span>
					</a>
				</li>
				<li>
					<a class="nav-link collapsed" href="/admin/fees">
						<i class="bi bi-currency-exchange"></i>
						<span>Fees</span>
					</a>
				</li>
				<li>
					<a class="nav-link collapsed" href="/admin/users">
						<i class="bi bi-people-fill"></i>
						<span>Users</span>
					</a>
				</li>
			</ul>
		</li>



		<li class="nav-item">
			<a class="nav-link collapsed" data-bs-target="#history" data-bs-toggle="collapse" href="#">
				<i class="bx bx-history"></i><span>History</span><i class="bi bi-chevron-down ms-auto"></i>
			</a>
			<ul id="history" class="nav-content collapse " data-bs-parent="#sidebar-nav">
				<li>
					<a href="/admin/transaction/history">
						<i class="bi bi-circle"></i><span>Transaction History</span>
					</a>
				</li>
				<li>
					<a href="/admin/phone/history">
						<i class="bi bi-circle"></i><span>Phone History</span>
					</a>
				</li>
			</ul>
		</li>
		{{-- <li class="nav-item">
			<a class="nav-link collapsed" href="/admin/history">
				<i class="bx bx-history"></i>
				<span>History</span>
			</a>
		</li> --}}
	</ul>

</aside>