<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="dropdown">
        <i class="bi bi-caret-down"></i>
    </button>
    <ul class="dropdown-menu">
        @can('Edit Users')
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal"
                onclick="loadModal('{{ route('users.edit', $row->id) }}')"><i class="bx bx-pen"></i> Edit</a>
        </li>
        @endcan

        <li>
            @php
                $defaultPassword = strstr($row->email, '@', true);
            @endphp
            <form method="POST" action="{{ route('users.reset-password', $row->id) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="dropdown-item" title="{{ $defaultPassword }}" >
                    <i class="bx bx-reset"></i> Reset Password
                </button>
            </form>
        </li>
        <!-- @can('Delete Users')
        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal"
                onclick="loadModal('{{ route('users.destroy', $row->id) }}')"><i class="bx bx-trash"></i> Delete</a>
        </li>
        @endcan -->
    </ul>
</div>
