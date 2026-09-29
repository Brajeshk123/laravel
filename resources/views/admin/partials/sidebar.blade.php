<div class="sidebar">

    <div class="logo mb-4">
        CMS Admin
    </div>

    @can('view dashboard')
        <a href="{{ route('admin.dashboard') }}"
            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>
    @endcan

    <div class="sidebar-heading mt-3">
        <i class="bi bi-shield-lock"></i>
        Administration
    </div>

    @can('view users')
        <a href="{{ route('admin.users.index') }}"
            class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i>
            Users
        </a>
    @endcan

    @can('view roles')
        <a href="{{ route('admin.roles.index') }}"
            class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i>
            Roles
        </a>
    @endcan

    @can('view permissions')
        <a href="{{ route('admin.permissions.index') }}"
            class="{{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i>
            Permissions
        </a>
    @endcan

    <div class="sidebar-heading mt-3">
        <i class="bi bi-folder"></i>
        Content
    </div>

    @can('view contents')
        <a href="{{ route('admin.contents.index') }}"
            class="{{ request()->routeIs('admin.contents.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i>
            Contents
        </a>
    @endcan

    @can('view categories')
        <a href="{{ route('admin.categories.index') }}"
            class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i>
            Categories
        </a>
    @endcan

    @can('view tags')
        <a href="{{ route('admin.tags.index') }}"
            class="{{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i>
            Tags
        </a>
    @endcan
    @can('view media')
        <a href="{{ route('admin.media.index') }}"
            class="{{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i>
            Media
        </a>
    @endcan

    <div class="sidebar-heading mt-3">
        <i class="bi bi-globe"></i>
        Website
    </div>
    
    @can('view menus')
        <a href="{{ route('admin.menus.index') }}"
            class="{{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i>
            Menus
        </a>
    @endcan

    @can('manage settings')
        <a href="{{ route('admin.settings.index') }}"
            class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i>
            Settings
        </a>
    @endcan

</div>
