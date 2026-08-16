@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Create Blog') }}</li>
                </ol>
            </div>
        </div>

        <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-md-12 mb-2">
                                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           placeholder="Enter your blog post title" value="{{ old('title') }}" required>
                                </div>

                                <div class="form-group col-md-12 mb-2">
                                    <label for="tag_id">{{ __('Tags') }}</label>
                                    <select name="tag_id[]" id="tag_id" class="form-select search_tags" multiple></select>
                                </div>                                

                                <div class="form-group col-md-12 mb-2">
                                    <label for="editor">{{ __('Content') }} <span class="text-danger">*</span></label>
                                    <textarea name="contents" id="editor" class="form-control" rows="6">{{ old('contents') }}</textarea>
                                </div>

                                <div class="form-group col-md-6 mb-2">
                                    <label for="image">{{ __('Image') }}</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    <small class="text-muted text-danger">
                                        {{ __('Recommended size: 900 x 643px, Max file size: 200KB') }}
                                    </small>
                                </div>

                                <div class="form-group col-md-6 mb-2">
                                    <label for="serial_no">{{ __('Serial No') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="serial_no" id="serial_no" class="form-control"
                                           placeholder="1" value="{{ old('serial_no', 1) }}" required>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">

                                <div class="form-group">
                                    <label for="published_at">{{ __('Published At') }}</label>
                                    <input type="datetime-local" name="published_at" id="published_at"
                                           class="form-control" value="{{ old('published_at') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label for="language_id">{{ __('Language') }} <span class="text-danger">*</span></label>
                                    <select name="language_id" id="language_id" class="form-select search_language" required></select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="category_id">{{ __('Category') }} <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-select search_category" required></select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="status">{{ __('Status') }} <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select select2" required>
                                        @foreach (\App\Enums\BlogStatus::options() as $key => $label)
                                            <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="seo_title">{{ __('Meta Title') }}</label>
                                    <input type="text" class="form-control" name="seo_title" id="seo_title"
                                    placeholder="Meta Title" value="{{ old('seo_title') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label for="seo_keywords">{{ __('Meta Keywords') }}</label>
                                    <input type="text" name="seo_keywords" id="seo_keywords" data-role="tagsinput"
                                           class="form-control" placeholder="Keywords"
                                           value="{{ old('seo_keywords') }}">
                                </div>

                                <div class="form-group">
                                    <label for="seo_description">{{ __('Meta Description') }}</label>
                                    <textarea name="seo_description" id="seo_description" class="form-control">{{ old('seo_description') }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer mt-1">
                <button type="submit" class="btn btn-success waves-effect waves-light text-white">{{ __('Submit') }}</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: "{{ route('ckEditorUpload') . '?_token=' . csrf_token() }}"
            }
        })
        .catch(error => {
            console.error(error);
        });
        $(document).ready(function () {
            $('.select2').select2({
                theme: "classic",
                minimumInputLength: 0,
                placeholder: "Select One",
                allowClear: true,
            });

            $('.search_language').select2({
                theme: 'classic',
                minimumInputLength: 0,
                placeholder: "Select Language",
                allowClear: true,
                ajax: {
                    url: "{{ route('language.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({ q: params.term, status: 1, page_limit: 10 }),
                    processResults: data => ({
                        results: $.map(data, item => ({ text: item.name, id: item.id }))
                    }),
                    cache: true
                }
            });

            $('.search_category').select2({
                width: '100%',
                theme: 'classic',
                minimumInputLength: 0,
                placeholder: "Select Category",
                allowClear: true,
                ajax: {
                    url: "{{ route('blogCategory.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({ q: params.term, page_limit: 10 }),
                    processResults: data => ({
                        results: $.map(data, item => ({ text: item.name, id: item.id }))
                    }),
                    cache: true
                }
            });

            $('.search_tags').select2({
                width: '100%',
                theme: 'classic',
                tags: true,
                minimumInputLength: 0,
                placeholder: "Select Tags",
                allowClear: true,
                ajax: {
                    url: "{{ route('tags.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({ q: params.term, page_limit: 10 }),
                    processResults: data => ({
                        results: $.map(data, item => ({ text: item.name, id: item.id }))
                    }),
                    cache: true
                }
            });

            $('#title').on('keyup', function () {
                const titleVal = $(this).val();
                const $seo = $('#seo_title');

                if (!$seo.data('edited')) {
                    $seo.val(titleVal);
                }
            });
            $('#seo_title').on('input', function () {
                $(this).data('edited', true);
            });
        });
    </script>
@endpush
