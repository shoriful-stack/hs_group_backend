<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="dropdown">
        <i class="bi bi-caret-down"></i>
    </button>
    <ul class="dropdown-menu">
        @can('Edit Roles')
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal"
                onclick="loadModal('{{ route('roles.edit', $row->id) }}')">Edit</a>
        </li>
        @endcan
        @can('Permissions Roles')
        <li>
            <a class="dropdown-item" href="{{ route('roles.permission.index', $row->id) }}">Role Permission</a>
        </li>
        @endcan
        <!-- 
        @can('Delete Roles')
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal"
                onclick="loadModal('{{ route('roles.destroy', $row->id) }}')">Delete</a>
        </li>
        @endcan
        -->
    </ul>
</div>
