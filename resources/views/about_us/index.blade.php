@extends('layouts.app')
@section('title', 'About Us')
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
                        <li class="breadcrumb-item active" aria-current="page">About us</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card form-card">

                    <div class="card-body px-4">
                        <form method="POST" action="{{ route('aboutUs.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="1" name="serial_no">
                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="bx bx-globe"></i>
                                    About Us
                                </h5>
                            </div>

                            <div class="form-section">
                                <div class="row g-2 mb-2">
                                    <div class="col-md-12">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern"
                                                for="title">{{ __('Title') }}</label> <strong class="text-danger">*</strong>
                                            <input type="text" name="title" class="form-control" id="title"
                                                placeholder="Enter your title"
                                                value="{{ old('title', $data->title ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-group-modern">
                                            <label
                                                class="form-label form-label-modern" for="contents">{{ __('Content') }}</label>
                                            <i class="bx bx-phone-call input-icon"></i>
                                            <textarea name="contents" id="contents" rows="5" class="form-control">{{ old('content', $data->content ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row g-3">
                                            @php
                                                $collageImages = is_array($data->images ?? null) ? array_values($data->images) : [];
                                                if ($collageImages === [] && !empty($data->image)) {
                                                    $collageImages = [$data->image];
                                                }
                                            @endphp
                                            @for($i = 0; $i < 4; $i++)
                                            <div class="col-md-6 col-lg-3">
                                                <div class="input-group-modern">
                                                    <label class="form-label form-label-modern" for="images_{{ $i }}">
                                                        {{ __('Collage Image') }} {{ $i + 1 }}
                                                    </label>
                                                    <input type="file" name="images[{{ $i }}]" class="form-control" id="images_{{ $i }}" accept="image/*">
                                                    <small class="text-muted text-danger">
                                                        {{ __('Recommended size: 630 x 400px, Max file size: 2MB') }}
                                                    </small>
                                                    @if(!empty($collageImages[$i]))
                                                    <div class="image-preview mt-2">
                                                        <img src="{{ asset($collageImages[$i]) }}" height="80" alt="Collage image {{ $i + 1 }}" class="rounded">
                                                        <small class="text-muted d-block mt-1">Current image</small>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-3 mt-4">
                                    <button type="button"
                                        class="btn btn-outline-secondary btn-secondary text-white px-4">
                                        <i class="bx bx-x me-1"></i>Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bx bx-check me-1"></i>
                                        {{ $data->id ? __('Update') : __('Save') }}
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection