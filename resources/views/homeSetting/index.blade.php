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
                        <li class="breadcrumb-item active" aria-current="page">Home Settings</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card form-card">
                    <div class="card-body px-4">
                        <form action="{{ route('homeSettings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-check mb-3">
                                <input class="form-check-input toggle-section" type="checkbox" id="section_enable" name="section_enable" value="1" {{ $data->section_enable ? 'checked' : '' }}>
                                <label class="form-check-label" for="section_enable">
                                    Enable Sections
                                </label>
                            </div>

                            <div id="section_rows" class="card p-3 mb-4 {{ $data->section_enable ? '' : 'd-none' }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Section Rows</h6>
                                    <button type="button" class="btn btn-sm btn-primary" id="addRow">+ Add Row</button>
                                </div>
                                <div id="rowsContainer">
                                    @if(!empty($sections) && $sections->count())
                                        @foreach($sections as $index => $section)
                                            <div class="row g-3 align-items-end mb-2 section-row">
                                                <div class="col-md-4">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" class="form-control form-control-sm" name="sections[{{ $index }}][title]" value="{{ $section->title }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Position</label>
                                                    <input type="number" class="form-control form-control-sm" name="sections[{{ $index }}][position]" value="{{ $section->position }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Page</label>
                                                    <select class="form-select form-select-sm select_page" name="sections[{{ $index }}][page]" required>
                                                        @if($section->page_id)
                                                            <option value="{{ $section->page_id }}" selected>{{ $section->page->title ?? 'N/A' }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-2 text-end">
                                                    <button type="button" class="btn btn-sm btn-danger removeRow">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="brand_enable" name="brand_enable" value="1" {{ $data->brand_enable ? 'checked' : '' }}>
                                <label class="form-check-label" for="brand_enable">
                                    Enable Brands
                                </label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="blog_enable" name="blog_enable" value="1" {{ $data->blog_enable ? 'checked' : '' }}>
                                <label class="form-check-label" for="blog_enable">
                                    Enable Blogs
                                </label>
                            </div>

                            <!-- <div class="form-check mb-3">
                                <input class="form-check-input toggle-video" type="checkbox" id="video_enable" name="video_enable" value="1" {{ $data->video_enable ? 'checked' : '' }}>
                                <label class="form-check-label" for="video_enable">
                                    Enable Video Section
                                </label>
                            </div>

                            <div id="video_fields" class="card p-3 mb-4 {{ $data->video_enable ? '' : 'd-none' }}">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Video URL</label>
                                    <input type="url" class="form-control" name="video_url" value="{{ $data->video_url }}" placeholder="Enter video link">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Video Thumbnail</label>
                                    <input type="file" class="form-control" name="video_thumb">
                                    @if($data->video_thumb)
                                        <small class="text-muted">Current: {{ $data->video_thumb }}</small>
                                    @endif
                                </div>
                            </div> -->

                            <!-- <div class="mb-3 col-md-6">
                                <label class="form-label">Since Image</label>
                                <input type="file" class="form-control" name="since_image">
                                @if($data->since_image)
                                    <small class="text-muted">Current: {{ $data->since_image }}</small>
                                @endif
                            </div> -->

                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <a href="{{ route('ourMissions.index') }}" class="btn btn-outline-secondary btn-secondary text-white px-4">
                                    <i class="bx bx-x me-1"></i>Cancel
                                </a>
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

@push('scripts')
<script>
$(document).ready(function () {

    $('#section_enable').on('change', function () {
        $('#section_rows').toggleClass('d-none', !$(this).is(':checked'));
    });

    $('#video_enable').on('change', function () {
        $('#video_fields').toggleClass('d-none', !$(this).is(':checked'));
    });

    $('#addRow').on('click', function () {
        let container = $('#rowsContainer');
        let index = container.children('.section-row').length;

        let row = $(`
            <div class="row g-3 align-items-end mb-2 section-row">
                <div class="col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control form-control-sm" name="sections[${index}][title]" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Position</label>
                    <input type="number" class="form-control form-control-sm" name="sections[${index}][position]" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Page</label>
                    <select class="form-select form-select-sm select_page" name="sections[${index}][page]" required></select>
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-sm btn-danger removeRow">Remove</button>
                </div>
            </div>
        `);

        container.append(row);

        row.find('.select_page').select2({
            theme: 'classic',
            placeholder: 'Select Page',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: "{{ route('page.search') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) { return { q: params.term, page_limit: 10 }; },
                processResults: function(data) {
                    return { results: $.map(data, function(item) { return { id: item.id, text: item.title }; }) };
                },
                cache: true
            }
        });
    });

    $(document).on('click', '.removeRow', function () {
        $(this).closest('.section-row').remove();
    });

    $('.select_page').each(function () {
        $(this).select2({
            theme: 'classic',
            placeholder: 'Select Page',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: "{{ route('page.search') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) { return { q: params.term, page_limit: 10 }; },
                processResults: function(data) {
                    return { results: $.map(data, function(item) { return { id: item.id, text: item.title }; }) };
                },
                cache: true
            }
        });
    });

});
</script>
@endpush
