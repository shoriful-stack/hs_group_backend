@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Edit Blog') }}</li>
                </ol>
            </div>
        </div>

        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-md-12 mb-2">
                                    <label for="title">{{ __('Title') }}</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           placeholder="Enter your blog post title"
                                           value="{{ old('title', $blog->title) }}">
                                </div>

                                <div class="form-group col-md-12 mb-2">
                                    <label for="tag_id">{{ __('Tags') }}</label>
                                    <select name="tag_id[]" id="tag_id" class="form-select search_tags" multiple>
                                        @foreach($blog->tags as $tag)
                                            <option value="{{ $tag->id }}" selected>{{ @$tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-12 mb-2">
                                    <label for="editor">{{ __('Content') }}</label>
                                    <textarea name="contents" id="editor" class="form-control" rows="6">{{ old('contents', $blog->content) }}</textarea>
                                </div>

                                <div class="form-group col-md-6 mb-2">
                                    <label for="image">{{ __('Image') }}</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    @if($blog->image)
                                        <div class="mt-2">
                                            <img src="{{ asset($blog->image) }}" alt="Current Image" height="60">
                                        </div>
                                    @endif
                                    <small class="text-muted text-danger">
                                        {{ __('Recommended size: 900 x 643px, Max file size: 200KB') }}
                                    </small>
                                </div>

                                <div class="form-group col-md-6 mb-2">
                                    <label for="serial_no">{{ __('Serial No') }}</label>
                                    <input type="number" name="serial_no" id="serial_no" class="form-control"
                                           placeholder="1" value="{{ old('serial_no', $blog->serial_no) }}">
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
                                           class="form-control"
                                           value="{{ old('published_at', $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('Y-m-d\TH:i') : '') }}"
>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="language_id">{{ __('Language') }}</label>
                                    <select name="language_id" id="language_id" class="form-select search_language">
                                        @if($blog->language)
                                            <option value="{{ $blog->language->id }}" selected>{{ $blog->language->name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="category_id">{{ __('Category') }}</label>
                                    <select name="category_id" id="category_id" class="form-select search_category">
                                        @if($blog->category)
                                            <option value="{{ $blog->category->id }}" selected>{{ $blog->category->name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="status">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-select select2">
                                        @foreach (\App\Enums\BlogStatus::options() as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('status', $blog->status->value) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="seo_title">{{ __('Meta Title') }}</label>
                                    <input type="text" class="form-control" name="seo_title" id="seo_title"
                                           placeholder="Meta Title" value="{{ old('seo_title', $blog->seo_title) }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label for="seo_keywords">{{ __('Meta Keywords') }}</label>
                                    <input type="text" name="seo_keywords" id="seo_keywords" data-role="tagsinput"
                                           class="form-control" placeholder="Keywords"
                                           value="{{ old('seo_keywords', $blog->seo_keywords) }}">
                                </div>

                                <div class="form-group">
                                    <label for="seo_description">{{ __('Meta Description') }}</label>
                                    <textarea name="seo_description" id="seo_description" class="form-control">{{ old('seo_description', $blog->seo_description) }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer mt-1">
                <button type="submit" class="btn btn-success waves-effect waves-light text-white">{{ __('Update') }}</button>
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
                placeholder: "Select One",
                allowClear: true,
            });

            $('.search_language').select2({
                theme: 'classic',
                placeholder: "Select Language",
                ajax: {
                    url: "{{ route('language.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({ q: params.term, status: 1 }),
                    processResults: data => ({
                        results: $.map(data, item => ({ text: item.name, id: item.id }))
                    })
                }
            });

            $('.search_category').select2({
                theme: 'classic',
                placeholder: "Select Category",
                ajax: {
                    url: "{{ route('blogCategory.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({ q: params.term }),
                    processResults: data => ({
                        results: $.map(data, item => ({ text: item.name, id: item.id }))
                    })
                }
            });

            $('.search_tags').select2({
                theme: 'classic',
                tags: true,
                placeholder: "Select Tags",
                ajax: {
                    url: "{{ route('tags.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({ q: params.term }),
                    processResults: data => ({
                        results: $.map(data, item => ({ text: item.name, id: item.id }))
                    })
                }
            });
        });
    </script>
@endpush