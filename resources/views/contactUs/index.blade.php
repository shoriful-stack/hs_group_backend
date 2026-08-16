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
                        <li class="breadcrumb-item active" aria-current="page">Contact Management</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card form-card">

                    <div class="card-body px-4">
                        <form method="POST" action="{{ route('contactUs.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="bx bx-globe"></i>
                                    Basic Settings
                                </h5>
                                <div class="row g-4 mb-2">
                                    {{--                                     <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Language') }}</label>
                                            <i class="bx bx-world input-icon"></i>
                                            <select name="language_id" id="language_id" class="form-control" required>
                                                @foreach($languages as $id => $name)
                                                    <option value="{{ $id }}"
                                                        {{ old('language_id', $data->language_id ?? '') == $id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Business Address') }}</label>
                                            <i class="bx bx-map input-icon"></i>
                                            <input type="text" name="address" class="form-control" 
                                                   placeholder="Enter your business address"
                                                   value="{{ old('address', $data->address ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="bx bx-phone-call"></i>
                                    Contact Information
                                </h5>
                                <div class="row g-2 mb-2">
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Primary Phone') }}</label>
                                            <i class="bx bx-phone input-icon"></i>
                                            <input type="text" name="primary_phone" class="form-control"
                                                   placeholder="+1 (555) 123-4567"
                                                   value="{{ old('primary_phone', $data->primary_phone ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Secondary Phone') }}</label>
                                            <i class="bx bx-phone-call input-icon"></i>
                                            <input type="text" name="secondary_phone" class="form-control"
                                                   placeholder="+1 (555) 987-6543"
                                                   value="{{ old('secondary_phone', $data->secondary_phone ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Primary Email') }}</label>
                                            <i class="bx bx-envelope input-icon"></i>
                                            <input type="email" name="primary_email" class="form-control"
                                                   placeholder="contact@yourbusiness.com"
                                                   value="{{ old('primary_email', $data->primary_email ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Secondary Email') }}</label>
                                            <i class="bx bx-envelope-open input-icon"></i>
                                            <input type="email" name="secondary_email" class="form-control"
                                                   placeholder="support@yourbusiness.com"
                                                   value="{{ old('secondary_email', $data->secondary_email ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('WhatsApp Number') }}</label>
                                            <i class="bx bxl-whatsapp input-icon"></i>
                                            <input type="text" name="whatsapp_number" class="form-control"
                                                   placeholder="+1 (555) 123-4567"
                                                   value="{{ old('whatsapp_number', $data->whatsapp_number ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="bx bx-map-pin"></i>
                                    Location & Media
                                </h5>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Latitude') }}</label>
                                            <i class="bx bx-target-lock input-icon"></i>
                                            <input type="text" name="lat" class="form-control"
                                                   placeholder="40.7128"
                                                   value="{{ old('lat', $data->lat ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Longitude') }}</label>
                                            <i class="bx bx-current-location input-icon"></i>
                                            <input type="text" name="lang" class="form-control"
                                                   placeholder="-74.0060"
                                                   value="{{ old('lang', $data->lang ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Business Logo') }}</label>
                                            <i class="bx bx-image input-icon"></i>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                            @if(!empty($data->image))
                                                <div class="image-preview">
                                                    <img src="{{ asset( $data->image) }}" 
                                                         height="100" alt="Current Logo" class="rounded">
                                                    <small class="text-muted d-block mt-1">Current logo</small>
                                                </div>
                                            @endif
                                            <small class="text-muted text-danger">
                                                {{ __('Recommended size: 913 x 180px, Max file size: 200KB') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Google Map Embed Code') }}</label>
                                            <i class="bx bx-map input-icon" style="top: 1rem;"></i>
                                            <textarea name="map" class="form-control" rows="4" 
                                                      placeholder="Paste your Google Maps embed code here..."
                                                      style="padding-left: 2.5rem;">{{ old('map', $data->map ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @can('Edit Contact Settings')
                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <button type="button" class="btn btn-outline-secondary btn-secondary text-white px-4">
                                    <i class="bx bx-x me-1"></i>Cancel
                                </button>
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
