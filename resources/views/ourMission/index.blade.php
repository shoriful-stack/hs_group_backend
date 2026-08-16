@extends('layouts.app')

@section('content')
<div class="modern-contact-form">
    <div class="container-fluid px-4">
        <div class="breadcrumb-modern d-none d-sm-flex align-items-center">
            <div class="d-flex align-items-center">
                <i class="bx bx-home-alt me-2 text-muted"></i>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Our Mission</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card form-card">
                    <div class="card-body px-4">
                        <form method="POST" action="{{ route('ourMissions.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-section mb-2">
                                <h5 class="form-section-title">
                                    <i class="bx bx-file"></i>
                                    Content
                                </h5>
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Content') }}</label>
                                            <i class="bx bx-detail input-icon" style="top: 1rem;"></i>
                                            <textarea name="contents" class="form-control" rows="4"
                                                placeholder="Write about this mission...">{{ old('content', $data->content ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @can('Edit Our Mission')
                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <a href="{{ route('ourMissions.index') }}" class="btn btn-outline-secondary btn-secondary text-white px-4">
                                    <i class="bx bx-x me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-check me-1"></i>
                                    {{ $data->id ? __('Update') : __('Save') }}
                                </button>
                            </div>
                            @endcan
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection