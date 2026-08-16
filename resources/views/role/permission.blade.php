@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Role') }}</li>
                </ol>
            </div>
        </div>

        <div class="main-body">
            <div class="row">
                <div class="col-md-12">
                    <p>You can assign permission for <strong>{{ $role->name }}</strong> role</p>
                    <form action="{{ route('roles.permission.save', $role->id) }}" method="post">
                        @csrf
                        <div class="table-responsive">
                            <table class="table spark-table-wrapper">
                                <thead>
                                    <tr>
                                        <th><label><input type="checkbox" id="all" class="k-checkbox check-all">
                                                Module</label>
                                        <th>
                                        <th>Route
                                        <th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $module => $permission)
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type="checkbox" @if ($role->hasAnyPermission(collect($permission)->pluck('name')->toArray())) checked @endif
                                                        onClick='menuchecked({{ $permission[0]->module_id }})'
                                                        id="menu_id{{ $permission[0]->module_id }}"
                                                        class="k-checkbox checkBox">
                                                    {{ $module }}
                                                </label>
                                            <td>
                                            <td>
                                                @php
                                                    $key = 0;
                                                @endphp
                                                @foreach ($permission as $permissionName)
                                                    @php
                                                        $key++;
                                                    @endphp
                                                    <label>
                                                        <input type="checkbox"
                                                            class="k-checkbox checkBox menu_id_{{ $permission[0]->module_id }}"
                                                            name="permissions[]" value="{{ $permissionName->name }}"
                                                            @if ($role->hasPermissionTo($permissionName->name)) checked @endif>
                                                        {{ $permissionName->name }}
                                                    </label>

                                                    @if ($key % 6 == 0)
                                                        </br>
                                                    @endif
                                                @endforeach
                                            <td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2 mb-2">
                            <button type="submit" class="btn btn-primary">Save</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script>
            $(".check-all").click(function() {
                if ($(this).is(':checked')) {
                    $('.checkBox').prop('checked', 'checked');
                } else {
                    $('.checkBox').prop('checked', false);
                }
            });

            function menuchecked(id) {
                if ($('#menu_id' + id).is(':checked')) {
                    $('.menu_id_' + id).prop('checked', 'checked');
                } else {
                    $('.menu_id_' + id).prop('checked', false);

                }
            }
        </script>
    @endpush
