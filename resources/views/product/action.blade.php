<div class="dropdown">
    <button class="btn btn-primary btn-sm" data-bs-toggle="dropdown">Action
        <i class="bi bi-caret-down"></i>
    </button>
    <ul class="dropdown-menu">
        @can('Edit Products')
        <li>
            <a class="dropdown-item" href="{{ route('products.edit', $row->id) }}">Edit</a>
        </li>
        @endcan
    </ul>
</div>