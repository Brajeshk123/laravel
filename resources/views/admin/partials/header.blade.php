<div class="topbar d-flex justify-content-between align-items-center">

    <div>

        <h1 class="h4 mb-2">
            @yield('page-title')
        </h1>

        @include('admin.partials.breadcrumb')

    </div>

    <div class="d-flex align-items-center gap-2">

        <span>{{ Auth::user()->name }}</span>

        <form method="POST"
              action="{{ route('admin.logout') }}"
              class="mb-0">

            @csrf

            <button class="btn btn-sm btn-danger">

                Logout

            </button>

        </form>

    </div>

</div>
