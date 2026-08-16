@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-title-box">
        <div class="page-title-breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Create Product') }}</li>
            </ol>
        </div>
    </div>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
        @csrf
        <input type="hidden" value="1" name="type">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-12 mb-2">
                                <label for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" type="text" id="name"
                                    value="{{ old('name') }}" required />
                            </div>

                            <div class="form-group col-md-6 mb-2">
                                <label for="thumb_image">{{ __('Thumb Image') }} <span class="text-danger">*</span> </label>
                                <input class="form-control" id="thumb_image" name="thumb_image" type="file"
                                    accept="image/*" />
                                <small class="text-muted text-danger">
                                    {{ __('Recommended size: 1000 x 710px, Max file size: 200KB') }}
                                </small>
                            </div>

                            <div class="form-group col-md-6 mb-2">
                                <label for="background_image">{{ __('Background Image') }} </label>
                                <input class="form-control" id="background_image" name="background_image" type="file"
                                    accept="image/*" />
                                <small class="text-muted text-danger">
                                    {{ __('Recommended size: 1920 x 1000px, Max file size: 200KB') }}
                                </small>
                            </div>

                            <div class="form-group mb-2">
                                <label for="details">{{ __('Details') }} </label>
                                <textarea name="details" id="details" class="form-control">{!! old('details') !!}</textarea>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="form-section-title m-0"><i class="bx bx-list-plus"></i> {{ __('Features') }}</h5>
                                    <button type="button" class="btn btn-sm btn-primary" id="addFeatureRow"><i class="bx bx-plus"></i> {{ __('Add New') }}</button>
                                </div>
                                <div id="featuresWrapper"></div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="form-section-title m-0"><i class="bx bx-list-plus"></i> {{ __('Videos') }}</h5>
                                    <button type="button" class="btn btn-sm btn-primary" id="addVideoRow"><i class="bx bx-plus"></i> {{ __('Add New') }}</button>
                                </div>
                                <div id="videosWrapper"></div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="form-section-title m-0"><i class="bx bx-list-plus"></i> {{ __('Documents') }}</h5>
                                    <button type="button" class="btn btn-sm btn-primary" id="addDocumentRow"><i class="bx bx-plus"></i> {{ __('Add New') }}</button>
                                </div>
                                <div id="documentsWrapper"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="form-group mb-2">
                                <label for="language_id">{{ __('Language') }} <span
                                        class="text-danger">*</span></label>
                                <select name="language_id" id="language_id" class="form-control search_language"
                                    required>
                                    <option value="1" selected>English</option>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="category_id">{{ __('Category') }} <span
                                        class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-control search_category"
                                    required>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="brand_id">{{ __('Brand') }} <span class="text-danger">*</span></label>
                                <select name="brand_id" id="brand_id" class="form-control search_brand" required>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="origin_id">{{ __('Origin') }} <span class="text-danger">*</span></label>
                                <select name="origin_id" id="origin_id" class="form-control search_origin" required>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="seo_title">{{ __('Meta Title') }} </label>
                                <input type="text" name="seo_title" class="form-control" id="seo_title"
                                    placeholder="Enter your meta title">
                            </div>

                            <div class="form-group mb-2">
                                <label for="seo_keywords">{{ __('Meta Keyword') }} </label>
                                <textarea name="seo_keywords" id="seo_keywords" rows="4" class="form-control"
                                    placeholder="Enter your meta keyword"></textarea>
                            </div>

                            <div class="form-group mb-2">
                                <label for="seo_description">{{ __('Meta Description') }} </label>
                                <textarea name="seo_description" id="seo_description" rows="4" class="form-control"
                                    placeholder="Enter your meta description"></textarea>
                            </div>

                            <div class="form-group mb-2">
                                <button type="submit"
                                    class="float-end btn btn-info waves-effect waves-light text-white">{{ __('Submit') }}</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    function initEditors() {
        document.querySelectorAll('textarea.editor').forEach(textarea => {
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
                    .catch(error => console.error(error));
            }
        });
    }
    ClassicEditor
        .create(document.querySelector('#details'), {
            ckfinder: {
                uploadUrl: "{{ route('ckEditorUpload') . '?_token=' . csrf_token() }}"
            }
        })
        .catch(error => {
            console.error(error);
        });
    $(document).ready(function() {
        $('.select2').select2({
            theme: "classic",
            minimumInputLength: 0,
            placeholder: "Select One",
            allowClear: true,
        });

        let defaultLanguage = '1'; // English ID
        $('.search_language').select2({
            theme: 'classic',
            minimumInputLength: 0,
            // allowClear: true,
            ajax: {
                url: "{{ route('language.search') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        status: 1,
                        page_limit: 10
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    }

                },
                cache: true
            }
        });
        // Always keep English selected
        $('.search_language').on('select2:unselecting', function(e) {
            if (e.params.args.data.id === defaultLanguage) {
                e.preventDefault(); // stop deselecting English
            }
        });

        // Ensure English is always in selection on load
        $('.search_language').val([defaultLanguage]).trigger('change');

        $('.search_category').select2({
            theme: 'classic',

            minimumInputLength: 0,
            placeholder: "Select Category",
            allowClear: true,
            ajax: {
                url: "{{ route('productCategories.search') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        status: 1,
                        page_limit: 10
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    }

                },
                cache: true
            }
        });

        $('.search_brand').select2({
            theme: 'classic',
            minimumInputLength: 0,
            placeholder: "Select Brand",
            allowClear: true,
            ajax: {
                url: "{{ route('productBrands.search') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        status: 1,
                        page_limit: 10
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    }

                },
                cache: true
            }
        });

        $('.search_origin').select2({
            theme: 'classic',
            minimumInputLength: 0,
            placeholder: "Select Origin",
            allowClear: true,
            ajax: {
                url: "{{ route('productOrigins.search') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        status: 1,
                        page_limit: 10
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    }

                },
                cache: true
            }
        });
    });

    $(document).ready(function() {

        $('#addFeatureRow').on('click', function() {
            let featureCard = `
        <div class="card mb-2 p-3 feature-item">
            <div class="mb-2" style="display:none;">
                <label>{{ __('Title') }}</label>
                <input type="text" name="features_title[]" class="form-control form-control-sm" placeholder="{{ __('Enter title') }}">
            </div>
            <div class="mb-2">
                <label>{{ __('Image') }}</label>
                <input type="file" name="features_image[]" class="form-control form-control-sm" accept="image/*">
            </div>
            <div class="mb-2">
                <label>{{ __('Title') }}</label>
                <textarea name="features_note[]" class="form-control form-control-sm editor" placeholder="{{ __('Enter note') }}"></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm w-100 remove-feature">Remove</button>
        </div>`;
            $('#featuresWrapper').append(featureCard);
            initEditors();
        });

        $('#featuresWrapper').on('click', '.remove-feature', function() {
            $(this).closest('.feature-item').remove();
        });

        $('#addVideoRow').on('click', function() {
            let videoCard = `
        <div class="card mb-2 p-3 video-item">
            <div class="mb-2">
                <label>{{ __('Title') }}</label>
                <input type="text" name="videos_title[]" class="form-control form-control-sm" placeholder="{{ __('Enter title') }}">
            </div>
            <div class="mb-2">
                <label>{{ __('Thumbnail') }}</label>
                <input type="file" name="videos_image[]" class="form-control form-control-sm" accept="image/*">
            </div>
            <div class="mb-2">
                <label>{{ __('URL') }}</label>
                <input type="url" name="videos_video_link[]" class="form-control form-control-sm" placeholder="https://">
            </div>
            <div class="mb-2">
                <label>{{ __('Note') }}</label>
                <textarea name="videos_content[]" class="form-control form-control-sm editor" placeholder="{{ __('Enter note') }}"></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm w-100 remove-video">Remove</button>
        </div>`;
            $('#videosWrapper').append(videoCard);
            initEditors();
        });

        $('#videosWrapper').on('click', '.remove-video', function() {
            $(this).closest('.video-item').remove();
        });

        $('#addDocumentRow').on('click', function() {
            let documentCard = `
        <div class="card mb-2 p-3 document-item">
            <div class="mb-2">
                <label>{{ __('Title') }}</label>
                <input type="text" name="documents_title[]" class="form-control form-control-sm" placeholder="{{ __('Enter title') }}">
            </div>
            <div class="mb-2">
                <label>{{ __('Attachment') }}</label>
                <input type="file" name="documents_attachment[]" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label>{{ __('Link') }}</label>
                <input type="url" name="documents_link[]" class="form-control form-control-sm" placeholder="https://">
            </div>
            <button type="button" class="btn btn-danger btn-sm w-100 remove-document">Remove</button>
        </div>`;
            $('#documentsWrapper').append(documentCard);
        });

        $('#documentsWrapper').on('click', '.remove-document', function() {
            $(this).closest('.document-item').remove();
        });
    });
</script>
@endpush