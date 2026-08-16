@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="page-title-breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Edit Page') }}</li>
                </ol>
            </div>
        </div>

        <form action="{{ route('pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-md-12 mb-2">
                                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title"
                                           class="form-control" value="{{ $page->title }}" required>
                                </div>

                                <div class="form-group col-md-12 mb-2">
                                    <label for="content">{{ __('Content') }}</label>
                                    <textarea name="content" id="content" class="form-control" rows="5">{{ $page->content }}</textarea>
                                </div>

                                <div class="form-group col-md-6 mb-2">
                                    <label for="main_image">{{ __('Main Image') }}</label>
                                    <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*">
                                    <small class="text-muted text-danger">
                                    {{ __('Recommended size: 506 x 432px, Max file size: 200KB') }}
                                    </small>
                                    @if($page->main_image)
                                        <img src="{{ asset($page->main_image) }}" alt="{{ $page->title }}" height="40" class="mt-1">
                                    @endif
                                </div>

                                <div class="form-group col-md-6 mb-2">
                                    <label for="sub_image">{{ __('Sub Image') }}</label>
                                    <input type="file" name="sub_image" id="sub_image" class="form-control" accept="image/*">
                                    <small class="text-muted text-danger">
                                    {{ __('Recommended size: 308 x 218px, Max file size: 200KB') }}
                                    </small>
                                    @if($page->sub_image)
                                        <img src="{{ asset($page->sub_image) }}" alt="{{ $page->title }}" height="40" class="mt-1">
                                    @endif
                                </div>

                                <div class="form-group col-md-4 mb-2">
                                    <label for="serial_no">{{ __('Serial No') }}</label>
                                    <input type="number" name="serial_no" id="serial_no"
                                           class="form-control" value="{{ $page->serial_no }}">
                                </div>

                                <div class="form-group col-md-4 mb-2">
                                    <label for="status">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-control">
                                        @foreach(\App\Enums\PageStatus::cases() as $status)
                                            <option value="{{ $status->value }}"
                                            {{ old('status', $page->status->value ?? 1) == $status->value ? 'selected' : '' }}>
                                           {{ $status->label() }}
                                           </option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="form-group col-md-4 mb-2">
                                    <label for="published_at">{{ __('Published At') }}</label>
                                    <input type="datetime-local" name="published_at" id="published_at"
                                           class="form-control" value="{{ \Carbon\Carbon::parse($page->published_at)->format('Y-m-d\TH:i') }}">
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
                                    <label for="language_id">{{ __('Language') }} <span class="text-danger">*</span></label>
                                    <select name="language_id" id="language_id" class="form-control search_language" required>
                                        @if($page->language)
                                            <option value="{{ $page->language->id }}" selected>{{ $page->language->name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="seo_title">{{ __('Meta Title') }}</label>
                                    <input type="text" name="seo_title" id="seo_title"
                                           class="form-control" value="{{ $page->seo_title }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label for="seo_keywords">{{ __('Meta Keywords') }}</label>
                                    <textarea name="seo_keywords" id="seo_keywords"
                                              class="form-control">{{ $page->seo_keywords }}</textarea>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="seo_description">{{ __('Meta Description') }}</label>
                                    <textarea name="seo_description" id="seo_description"
                                              class="form-control">{{ $page->seo_description }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer mt-1">
                <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Update') }}</button>
            </div>
        </form>
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

        $(document).ready(function() {
            $('.search_language').select2({
                theme: 'classic',
                minimumInputLength: 0,
                placeholder: "Select Language",
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
                                return { text: item.name, id: item.id }
                            })
                        }
                    },
                    cache: true
                }
            });
        });
    </script>
@endpush
