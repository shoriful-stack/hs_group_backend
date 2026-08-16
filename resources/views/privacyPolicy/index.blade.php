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
                        <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card form-card">
                    <div class="card-body px-4">
                        <form method="POST" action="{{ route('privacyPolicies.store') }}">
                            @csrf

                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="bx bx-globe"></i>
                                    Language & Basic Info
                                </h5>
                                <div class="row g-4 mb-2">
                                    <div class="col-md-6">
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
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Title') }}</label>
                                            <i class="bx bx-text input-icon"></i>
                                            <input type="text" name="title" class="form-control"
                                                   placeholder="Enter Privacy Policy Title"
                                                   value="{{ old('title', $data->title ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section d-none">
                                <h5 class="form-section-title">
                                    <i class="bx bx-list-ol"></i>
                                    Ordering
                                </h5>
                                <div class="row g-2 mb-2">
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Serial No') }}</label>
                                            <i class="bx bx-hash input-icon"></i>
                                            <input type="number" name="serial_no" class="form-control"
                                                   value="{{ old('serial_no', $data->serial_no ?? 1) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="bx bx-file"></i>
                                    Privacy Policy Content
                                </h5>
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Content') }}</label>
                                            <i class="bx bx-detail input-icon" style="top: 1rem;"></i>
                                            <textarea name="contents" id="content" class="form-control" rows="6"
                                                      placeholder="Write your privacy policy here...">{{ old('content', $data->content ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @can('Edit Privacy Policy')
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

@push('scripts')
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            ckfinder: {
                uploadUrl: "{{ route('ckEditorUpload') . '?_token=' . csrf_token() }}"
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
