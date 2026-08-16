<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="dropdown">
        <i class="bi bi-caret-down"></i>
    </button>
    <ul class="dropdown-menu">
        @can('Edit Product Categories')
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal" onclick="loadModal('{{ route('productCategories.edit', $row->id) }}')">Edit</a>
        </li>
        @endcan
        
        @can('Delete Product Categories')
        <form action="{{ route('productCategories.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button class="dropdown-item" type="submit">{{ __('Delete') }}</button>
        </form>
        @endcan
       
    </ul>
</div>
