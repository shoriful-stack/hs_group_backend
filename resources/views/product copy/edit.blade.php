@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Edit Product') }}</li>
                </ol>
            </div>
        </div>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            id="myForm">
            @csrf
            @method('PUT')
            <input type="hidden" value="1" name="type">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-md-12 mb-2">
                                    <label for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
                                    <input class="form-control" name="name" type="text" id="name"
                                        value="{{ $product->name }}" required />
                                </div>

                                <div class="form-group col-md-6 mb-2">
                                    <label for="thumb_image">{{ __('Thumb Image') }} </label>
                                    <input class="form-control" id="thumb_image" name="thumb_image" type="file"
                                        accept="image/*" />
                                    <img src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}"
                                        class="img-thumbnail mt-2" />
                                    <small class="text-muted text-danger">
                                        {{ __('Recommended size: 1000 x 710px, Max file size: 200KB') }}
                                    </small>
                                </div>

                                <div class="form-group col-md-6 mb-2">
                                    <label for="background_image">{{ __('Background Image') }} </label>
                                    <input class="form-control" id="background_image" name="background_image" type="file"
                                        accept="image/*" />
                                    <img src="{{ asset($product->background_image) }}" alt="{{ $product->name }}"
                                        class="img-thumbnail mt-2" />
                                    <small class="text-muted text-danger">
                                        {{ __('Recommended size: 1920 x 1000px, Max file size: 200KB') }}
                                    </small>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="details">{{ __('Details') }} </label>
                                    <textarea name="details" id="details" class="form-control">{!! $product->details !!}</textarea>
                                </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="form-section-title m-0"><i class="bx bx-list-plus"></i> {{ __('Features') }}</h5>
                                <button type="button" class="btn btn-sm btn-primary" id="addFeatureRow"><i class="bx bx-plus"></i> {{ __('Add New') }}</button>
                            </div>
                            <div id="featuresWrapper">
                                @if ($product->productFeatures)
                                    @foreach ($product->productFeatures as $feature)
                                        <div class="card mb-2 p-3 feature-item">
                                            <input type="hidden" name="features_id[]" value="{{ $feature->id }}">
                                            <div class="mb-2 d-none">
                                                <label>{{ __('Title') }}</label>
                                                <input type="text" name="features_title[]" class="form-control form-control-sm" value="{{ $feature->title }}" placeholder="{{ __('Enter title') }}">
                                            </div>
                                            <div class="mb-2">
                                                <label>{{ __('Image') }}</label>
                                                <input type="file" name="features_image[]" class="form-control form-control-sm" accept="image/*">
                                                @if($feature->image)
                                                    <a href="{{ asset($feature->image) }}" target="_blank" class="d-inline-block mt-1"><i class="bx bx-image"></i> View</a>
                                                @endif
                                            </div>
                                            <div class="mb-2">
                                                <label>{{ __('Note') }}</label>
                                                <textarea name="features_note[]" class="form-control form-control-sm feature-note" placeholder="{{ __('Enter note') }}">{{ $feature->content }}</textarea>
                                            </div>
                                            <button type="button" class="btn btn-danger btn-sm w-100 remove-feature">Remove</button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="form-section-title m-0"><i class="bx bx-list-plus"></i> {{ __('Videos') }}</h5>
                                <button type="button" class="btn btn-sm btn-primary" id="addVideoRow"><i class="bx bx-plus"></i> {{ __('Add New') }}</button>
                            </div>
                            <div id="videosWrapper">
                                @if ($product->productVideos)
                                    @foreach ($product->productVideos as $video)
                                        <div class="card mb-2 p-3 video-item">
                                            <input type="hidden" name="videos_id[]" value="{{ $video->id }}">
                                            <div class="mb-2">
                                                <label>{{ __('Title') }}</label>
                                                <input type="text" name="videos_title[]" class="form-control form-control-sm" value="{{ $video->title }}" placeholder="{{ __('Enter title') }}">
                                            </div>
                                            <div class="mb-2">
                                                <label>{{ __('Thumbnail') }}</label>
                                                <input type="file" name="videos_image[]" class="form-control form-control-sm" accept="image/*">
                                                @if($video->image)
                                                    <a href="{{ asset($video->image) }}" target="_blank" class="d-inline-block mt-1"><i class="bx bx-image"></i> View</a>
                                                @endif
                                            </div>
                                            <div class="mb-2">
                                                <label>{{ __('URL') }}</label>
                                                <input type="url" name="videos_link[]" class="form-control form-control-sm" value="{{ $video->video_link }}">
                                            </div>
                                            <div class="mb-2">
                                                <label>{{ __('Note') }}</label>
                                                <textarea name="videos_content[]" class="form-control form-control-sm video-note" placeholder="{{ __('Enter note') }}">{{ $video->content }}</textarea>
                                            </div>
                                            <button type="button" class="btn btn-danger btn-sm w-100 remove-video">Remove</button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="form-section-title m-0"><i class="bx bx-list-plus"></i> {{ __('Documents') }}</h5>
                                <button type="button" class="btn btn-sm btn-primary" id="addDocumentRow"><i class="bx bx-plus"></i> {{ __('Add New') }}</button>
                            </div>
                            <div id="documentsWrapper">
                                @if ($product->productDocuments)
                                    @foreach ($product->productDocuments as $document)
                                        <div class="card mb-2 p-3 document-item">
                                            <input type="hidden" name="documents_id[]" value="{{ $document->id }}">
                                            <div class="mb-2">
                                                <label>{{ __('Title') }}</label>
                                                <input type="text" name="documents_title[]" class="form-control form-control-sm" value="{{ $document->title }}" placeholder="{{ __('Enter title') }}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label>{{ __('Attachment') }}</label>
                                                <input type="file" name="documents_attachment[]" class="form-control form-control-sm">
                                                @if($document->attachment)
                                                    <a href="{{ asset($document->attachment) }}" target="_blank" class="d-inline-block mt-1"><i class="bx bx-file"></i> View</a>
                                                @endif
                                            </div>
                                            <div class="mb-2">
                                                <label>{{ __('Link') }}</label>
                                                <input type="url" name="documents_link[]" class="form-control form-control-sm" value="{{ $document->link }}">
                                            </div>
                                            <button type="button" class="btn btn-danger btn-sm w-100 remove-document">Remove</button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
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
                                        @if ($product->language)
                                            <option value="{{ $product->language->id }}" selected>
                                                {{ $product->language->name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="category_id">{{ __('Category') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control search_category"
                                        required>
                                        @if ($product->productCategory)
                                            <option value="{{ $product->productCategory->id }}" selected>
                                                {{ $product->productCategory->name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="brand_id">{{ __('Brand') }} <span class="text-danger">*</span></label>
                                    <select name="brand_id" id="brand_id" class="form-control search_brand" required>
                                        @if ($product->productBrand)
                                            <option value="{{ $product->productBrand->id }}" selected>
                                                {{ $product->productBrand->name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="origin_id">{{ __('Origin') }} <span class="text-danger">*</span></label>
                                    <select name="origin_id" id="origin_id" class="form-control search_origin" required>
                                        @if ($product->productOrigin)
                                            <option value="{{ $product->productOrigin->id }}" selected>
                                                {{ $product->productOrigin->name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="seo_title">{{ __('Meta Title') }} </label>
                                    <input type="text" name="seo_title" class="form-control" id="seo_title"
                                        placeholder="Enter your meta title" value="{{ $product->seo_title }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label for="seo_keywords">{{ __('Meta Keyword') }} </label>
                                    <textarea name="seo_keywords" id="seo_keywords" rows="4" class="form-control"
                                        placeholder="Enter your meta keyword">{!! $product->seo_keywords !!}</textarea>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="seo_description">{{ __('Meta Description') }} </label>
                                    <textarea name="seo_description" id="seo_description" rows="4" class="form-control"
                                        placeholder="Enter your meta description">{!! $product->seo_description !!}</textarea>
                                </div>
                                <div class="form-group mb-2">
                                    <button type="submit"
                                        class="float-end btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
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
    ClassicEditor
        .create(document.querySelector('#details'), {
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
                    .catch(error => { console.error(error); });
            }
        });
    }
    initFeatureEditors();
        function initVideoEditors() {
        document.querySelectorAll('textarea.video-note').forEach(textarea => {
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
                    .catch(error => { console.error(error); });
            }
        });
    }
    initVideoEditors();
        $(document).ready(function() {
            $('.select2').select2({
                theme: "classic",
                minimumInputLength: 0,
                placeholder: "Select One",
                allowClear: true,
            });

            let defaultLanguage = '1';

            $('.search_language').select2({
                theme: 'classic',
                minimumInputLength: 0,
                allowClear: true,
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
        let newRow = `
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
                <textarea name="features_note[]" class="form-control form-control-sm feature-note" placeholder="{{ __('Enter note') }}"></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm w-100 remove-feature">Remove</button>
        </div>`;
        $('#featuresWrapper').append(newRow);
        initFeatureEditors();
    });
    $('#featuresWrapper').on('click', '.remove-feature', function() {
        $(this).closest('.feature-item').remove();
    });

    $('#addVideoRow').on('click', function() {
        let newRow = `
        <div class="card mb-2 p-3 video-item">
            <div class="mb-2">
                <label>{{ __('Title') }}</label>
                <input type="text" name="videos_title[]" class="form-control form-control-sm" placeholder="{{ __('Enter title') }}" required>
            </div>
            <div class="mb-2">
                <label>{{ __('Thumbnail') }}</label>
                <input type="file" name="videos_image[]" class="form-control form-control-sm" accept="image/*">
            </div>
            <div class="mb-2">
                <label>{{ __('URL') }}</label>
                <input type="url" name="videos_link[]" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label>{{ __('Note') }}</label>
                <textarea name="videos_content[]" class="form-control form-control-sm video-note" placeholder="{{ __('Enter note') }}"></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm w-100 remove-video">Remove</button>
        </div>`;
        $('#videosWrapper').append(newRow);
        initVideoEditors();
    });
    $('#videosWrapper').on('click', '.remove-video', function() {
        $(this).closest('.video-item').remove();
    });

    $('#addDocumentRow').on('click', function() {
        let newRow = `
        <div class="card mb-2 p-3 document-item">
            <div class="mb-2">
                <label>{{ __('Title') }}</label>
                <input type="text" name="documents_title[]" class="form-control form-control-sm" placeholder="{{ __('Enter title') }}" required>
            </div>
            <div class="mb-2">
                <label>{{ __('Attachment') }}</label>
                <input type="file" name="documents_attachment[]" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label>{{ __('Link') }}</label>
                <input type="url" name="documents_link[]" class="form-control form-control-sm">
            </div>
            <button type="button" class="btn btn-danger btn-sm w-100 remove-document">Remove</button>
        </div>`;
        $('#documentsWrapper').append(newRow);
    });
    $('#documentsWrapper').on('click', '.remove-document', function() {
        $(this).closest('.document-item').remove();
    });
        });
    </script>
@endpush
