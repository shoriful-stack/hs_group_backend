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
                        <li class="breadcrumb-item active" aria-current="page">General Setting</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card form-card">
                    <div class="card-body px-4">
                        <form method="POST" action="{{ route('generalSettings.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="bx bx-globe"></i>
                                    Title
                                </h5>
                                <div class="row g-4 mb-2">
                                    {{--                                     <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Language') }}</label>
                                            <i class="bx bx-world input-icon"></i>
                                            <select name="language_id" id="language_id" class="form-control">
                                                @foreach ($languages as $key => $value )
                                                    <option value="{{ $key }}"
                                                        {{ old('language_id', $data->language_id ?? '') == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Title') }}</label>
                                            <i class="bx bx-text input-icon"></i>
                                            <input type="text" name="title" id="title" class="form-control"
                                                   value="{{ old('title', $data->title ?? '') }}"
                                                   placeholder="Enter site title">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section mb-3">
                                <h5 class="form-section-title">
                                    <i class="bx bx-image"></i>
                                    Logos & Favicon
                                </h5>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Favicon') }}</label>
                                            <i class="bx bx-photo-album input-icon"></i>
                                            <input type="file" name="favicon" class="form-control" accept="image/*">
                                            @if(!empty($data->favicon))
                                                <div class="image-preview mt-2">
                                                    <img src="{{ asset($data->favicon) }}" height="50" alt="Favicon" class="rounded">
                                                    <small class="text-muted d-block mt-1">Current favicon</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Logo Header') }}</label>
                                            <i class="bx bx-photo-album input-icon"></i>
                                            <input type="file" name="logo_header" class="form-control" accept="image/*">
                                            @if(!empty($data->logo_header))
                                                <div class="image-preview mt-2">
                                                    <img src="{{ asset($data->logo_header) }}" height="50" alt="Logo Header" class="rounded">
                                                    <small class="text-muted d-block mt-1">Current header logo</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Logo Footer') }}</label>
                                            <i class="bx bx-photo-album input-icon"></i>
                                            <input type="file" name="logo_footer" class="form-control" accept="image/*">
                                            @if(!empty($data->logo_footer))
                                                <div class="image-preview mt-2">
                                                    <img src="{{ asset($data->logo_footer) }}" height="50" alt="Logo Footer" class="rounded">
                                                    <small class="text-muted d-block mt-1">Current footer logo</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Footer Description') }}</label>
                                            <i class="bx bx-detail input-icon" style="top:1rem;"></i>
                                            <textarea name="description" id="description" class="form-control" rows="3"
                                                      placeholder="Enter site description">{{ old('description', $data->description ?? '') }}</textarea>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="bx bx-detail"></i>
                                    Meta Information
                                </h5>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Keywords') }}</label>
                                            <i class="bx bx-detail input-icon" style="top:1rem;"></i>
                                            <textarea name="keywords" id="keywords" class="form-control" rows="3"
                                                      placeholder="Enter SEO keywords">{{ old('keywords', $data->keywords ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Cookies') }}</label>
                                            <i class="bx bx-cookie input-icon" style="top:1rem;"></i>
                                            <textarea name="cookies_name" id="cookies" class="form-control" rows="3"
                                                      placeholder="Enter cookies text">{{ old('cookies_name', $data->cookies ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @can('Edit General Settings')
                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-secondary text-white px-4">
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
