<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashbored') }}" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">Badel Portal</span>
        </a>
    </div><!-- End Logo -->
    @php
    $transactionItems = [
    (object) [
    'text' => 'Pending',
    'url' => '/transactions/pending',
    ],
    (object) [
    'text' => 'OnHold',
    'url' => '/transactions/onhold',
    ],
    (object) [
    'text' => 'Terminated',
    'url' => '/transactions/terminated',
    ],
    (object) [
    'text' => 'Cancel',
    'url' => '/transactions/Canceled',
    ],
    ];

    $phoneItems = [
    (object) [
    'text' => 'Pending',
    'url' => '/phones/pending',
    ],
    (object) [
    'text' => 'OnHold',
    'url' => '/phones/onhold',
    ],
    (object) [
    'text' => 'Terminated',
    'url' => '/phones/terminated',
    ],
    (object) [
    'text' => 'Canceled',
    'url' => '/phones/canceled',
    ],
    ];

    $menuItems = [
    [
    'title' => 'Transaction',
    'icon' => 'bi bi-arrow-left-right',
    'items' => $transactionItems,
    ],
    [
    'title' => 'Phone',
    'icon' => 'bi bi-phone',
    'items' => $phoneItems,
    ],
    ];
    @endphp

    @foreach ($menuItems as $menu)
    <li class="nav-item dropdown pe-3" style="list-style: none;">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="{{ $menu['icon'] }}" class="rounded-circle"></i>
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ $menu['title'] }}</span>
        </a><!-- End Profile Image Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            @foreach ($menu['items'] as $item)
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="/admin{{ $item->url }}"
                    title="{{ $item->text }}">
                    <span>{{ $item->text }}</span>
                </a>
            </li>
            @endforeach
            <li>
                <hr class="dropdown-divider">
            </li>
        </ul>
    </li>
    @endforeach

    <li class="nav-item dropdown pe-3" style="list-style: none;">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="bi  bi-clock-history" class="rounded-circle"></i>
            <span class="d-none d-md-block dropdown-toggle ps-2">History</span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="/admin/history/transactions">
                    <span>Transaction</span>
                </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="/admin/history/phones">
                    <span>Phone Number</span>
                </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
        </ul>
    </li>

    <li class="nav-item dropdown pe-3" style="list-style: none;">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="bi  bi-grid" class="rounded-circle"></i>
            <span class="d-none d-md-block dropdown-toggle ps-2">Other Pages</span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="/admin/banks">
                    <span>Banks</span>
                </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="/admin/fees">
                    <span>Fees</span>
                </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="/admin/users">
                    <span>Users</span>
                </a>
            </li>

        </ul>
    </li>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            @livewire('notifications')


            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person bi-lg" alt="Profile" class="rounded-circle" style="font-size: 20px"></i>
                    <span class="d-none d-md-block dropdown-toggle ps-2"> @auth {{ auth()->user()->username }}
                        @endauth</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
                <!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->