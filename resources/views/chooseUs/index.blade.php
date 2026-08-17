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
                        <li class="breadcrumb-item active" aria-current="page">Choose Us</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card form-card">
                    <div class="card-body px-4">
                        <form method="POST" action="{{ route('chooseUs.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="bx bx-globe"></i>
                                    Language & Title
                                </h5>
                                <div class="row g-4 mb-2">

                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Title') }}</label>
                                            <i class="bx bx-text input-icon"></i>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Enter Section Title"
                                                value="{{ old('title', $data->title ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                            <textarea name="content" id="content" class="form-control" rows="4"
                                                placeholder="Write about this section...">{{ old('content', $data->content ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="form-section-title m-0">
                                        <i class="bx bx-list-plus"></i> {{ __('Features') }}
                                    </h5>
                                    <button type="button" class="btn btn-sm btn-primary" id="addFeatureRow">
                                        <i class="bx bx-plus"></i> {{ __('Add New') }}
                                    </button>
                                </div>

                                <div id="featuresWrapper">
                                    @php
                                    $rawFeatures = old('features', $data->features ?? []);
                                    if (is_string($rawFeatures)) {
                                        $decoded = json_decode($rawFeatures, true);
                                        if (is_string($decoded)) {
                                            $decoded = json_decode($decoded, true);
                                        }
                                        $features = is_array($decoded) ? $decoded : [];
                                    } else {
                                        $features = is_array($rawFeatures) ? $rawFeatures : [];
                                    }
                                    @endphp

                                    @if(!empty($features) && is_array($features))
                                    @foreach($features as $index => $feature)
                                    <div class="card mb-2 p-3 feature-item">
                                        <div class="mb-2">
                                            <label>{{ __('Icon') }}</label>
                                            <input type="text"
                                                name="features[{{ $index }}][icon]"
                                                class="form-control form-control-sm"
                                                value="{{ $feature['icon'] ?? '' }}"
                                                placeholder="Icon (e.g. fa-solid fa-truck)">
                                        </div>

                                        <div class="mb-2">
                                            <label>{{ __('Title') }}</label>
                                            <input type="text"
                                                name="features[{{ $index }}][title]"
                                                class="form-control form-control-sm"
                                                value="{{ $feature['title'] ?? '' }}"
                                                placeholder="{{ __('Enter title') }}">
                                        </div>

                                        <div class="mb-2">
                                            <label>{{ __('Short Description') }}</label>
                                            <textarea name="features[{{ $index }}][short_description]"
                                                class="form-control form-control-sm feature-note"
                                                placeholder="{{ __('Enter short description') }}">{{ $feature['short_description'] ?? '' }}</textarea>
                                        </div>

                                        <div class="mb-2">
                                            <label>{{ __('Image') }}</label>
                                            <input type="file"
                                                name="features[{{ $index }}][image]"
                                                class="form-control form-control-sm"
                                                accept="image/*">
                                            @if(!empty($feature['image']))
                                            <input type="hidden" name="features[{{ $index }}][existing_image]" value="{{ $feature['image'] }}">
                                            <div class="mt-2">
                                                <img src="{{ asset($feature['image']) }}" alt="" height="72" class="rounded">
                                                <small class="text-muted d-block">{{ __('Current image') }}</small>
                                            </div>
                                            @endif
                                        </div>

                                        <button type="button" class="btn btn-danger btn-sm w-100 remove-feature">
                                            <i class="bx bx-trash"></i> Remove
                                        </button>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>


                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="bx bx-image"></i>
                                    Image
                                </h5>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label class="form-label form-label-modern">{{ __('Image') }}</label>
                                            <i class="bx bx-photo-album input-icon"></i>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                            <small class="text-muted text-danger">
                                            {{ __('Recommended size: 480 x 430px, Max file size: 200KB') }}
                                            </small>

                                            @if(!empty($data->image))
                                            <div class="image-preview mt-2">
                                                <img src="{{ asset( $data->image) }}"
                                                    height="100" alt="Choose Us Image" class="rounded">
                                                <small class="text-muted d-block mt-1">Current image</small>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @can('Edit Choose Us')
                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <a href="{{ route('chooseUs.index') }}" class="btn btn-outline-secondary btn-secondary text-white px-4">
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

    function initFeatureEditors() {
        document.querySelectorAll('textarea.feature-note').forEach(textarea => {
            if (!textarea.classList.contains('ck-initialized')) {
                ClassicEditor
                    .create(textarea, {
                        ckfinder: {
                            uploadUrl: "{{ route('ckEditorUpload') . '?_token=' . csrf_token() }}"
                        }
                    })
                    .then(editor => {
                        textarea.classList.add('ck-initialized');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        });
    }
    initFeatureEditors();

    $(document).ready(function() {
        let featureIndex = {{
                isset($features) ? count($features) : 0
            }};

        $('#addFeatureRow').on('click', function() {
            let featureHtml = `
        <div class="card mb-2 p-3 feature-item">
            <div class="mb-2">
                <label>Icon</label>
                <input type="text" name="features[${featureIndex}][icon]" class="form-control form-control-sm"
                       placeholder="Icon (e.g. fa-solid fa-truck)">
            </div>
            <div class="mb-2">
                <label>Title</label>
                <input type="text" name="features[${featureIndex}][title]" class="form-control form-control-sm"
                       placeholder="Enter title">
            </div>
            <div class="mb-2">
                <label>Short Description</label>
                <textarea name="features[${featureIndex}][short_description]" class="form-control form-control-sm feature-note"
                          placeholder="Enter short description"></textarea>
            </div>
            <div class="mb-2">
                <label>Image</label>
                <input type="file" name="features[${featureIndex}][image]" class="form-control form-control-sm" accept="image/*">
            </div>
            <button type="button" class="btn btn-danger btn-sm w-100 remove-feature">
                <i class="bx bx-trash"></i> Remove
            </button>
        </div>
    `;
            $('#featuresWrapper').append(featureHtml);
            featureIndex++;
            initFeatureEditors();
        });

        $(document).on('click', '.remove-feature', function() {
            $(this).closest('.feature-item').remove();
        });
    });
</script>
@endpush