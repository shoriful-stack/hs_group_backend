<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="dropdown">
        <i class="bi bi-caret-down"></i>
    </button>
    <ul class="dropdown-menu">
    @can('Edit Blogs')
        <li>
            <a class="dropdown-item" href="{{ route('blogs.edit', $row->id) }}">Edit</a>
        </li>
        @endcan
        <!-- 
        @can('Delete Blogs')
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal"  onclick="loadModal('{{ route('blogs.destroy', $row->id) }}')">Delete</a>
        </li>
        @endcan
        -->
    </ul>
</div>
