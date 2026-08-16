@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Product Category') }}</li>
                </ol>
            </div>
        </div>
        <div class="card">
        <div class="card-head p-3">
        <div class="align-items-center d-flex bg-white border-bottom pb-2 mb-3 main-content-card-header">
            <h4 class="main-card-title mb-0 flex-grow-1">{{ __('Product Category') }}</h4>
            <div class="flex-shrink-0">
                <div class="app-search">
                    <div class="input-group">
                        @can('Add Product Categories')
                        <button class="btn btn-sm btn-success" type="button" id="button-addon2" data-bs-toggle="modal"
                            data-bs-target="#modal" onclick="loadModal('{{ route('productCategories.create') }}')"><i
                                class="fa-regular fa-plus"></i> Add New</button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive ">
            {!! $dataTable->table(['class' => 'table table-striped table-bordered'], true) !!}
        </div>
        </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $('#modal').on('hidden.bs.modal', function() {
            window.LaravelDataTables["productCategories-table"];
        });
    </script>
@endpush
