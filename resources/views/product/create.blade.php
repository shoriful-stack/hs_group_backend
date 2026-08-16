@extends('layouts.app')

@section('content')

@include('service.create-service-ui-styles')
@push('scripts')
<script>
    $(document).ready(function() {
        if (!$('.wrapper').hasClass('toggled')) {
            $('.toggle-icon').trigger('click');
        }
    });
</script>
@endpush
<div class="container-fluid px-2">
    <div class="page-header">
        <div>
            <h2>{{ isset($product) ? 'Edit Product' : 'Create Product' }}</h2>
            <small class="text-muted">Manage product content dynamically</small>
        </div>
        <a href="{{ route('products.index') }}" class="btn-back">
            <i class="bx bx-arrow-back"></i> Back to Products
        </a>
    </div>

    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data" class="py-3">
        @csrf
        @if(isset($product))
        @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card animate-fade-up mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label">Title *</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Industrial Cleaning" value="{{ old('title', $product->title ?? '') }}" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Thumbnail</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="image" class="form-control">
                                </div>
                                @if(isset($product) && $product->image)
                                <div class="mt-2">
                                    <img src="{{ asset($product->image) }}" alt="Current thumbnail" class="img-fluid" style="max-height:100px;">
                                </div>
                                @endif
                                <div class="form-text">1920 × 1000 px recommended</div>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Full Description</label>
                                <textarea name="description" class="form-control editor" rows="4" placeholder="Detailed description of the service…">{{ old('description', $product->description ?? '') }}</textarea>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Short Description</label>
                                <textarea name="subtitle" class="form-control" rows="4" placeholder="Brief tagline or summary…">{{ old('subtitle', $product->subtitle ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- product application --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Key Application Points</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Application Points *</label>
                                <textarea name="application_titles[]" class="form-control" rows="3"
                                placeholder="Comma separated: Application A, Application B, Application C">
                                {{ old('application_titles.0', isset($product) ? $product->applications->pluck('title')->implode(', ') : '') }}
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- product overview --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Key Overview Points</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Overview Points *</label>
                                <textarea name="overview_titles[]" class="form-control" rows="3" placeholder="Comma separated: Overview A, Overview B, Overview C">{{ old('overview_titles.0', isset($product) ? $product->overviews->pluck('title')->implode(', ') : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- product technical specification --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Technical Specification</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <textarea id="technical_specifications" name="technical_specifications" class="form-control" rows="3">{{ old('technical_specifications', isset($product) ? $product->technical_specifications : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- product feature --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Key Features</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Features *</label>
                                <textarea name="feature_titles[]" class="form-control" rows="3" placeholder="Comma separated: Feature A, Feature B, Feature C">{{ old('feature_titles.0', isset($product) ? $product->features->pluck('title')->implode(', ') : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- document --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Product Document</h6>
                        <button type="button" class="btn-add" id="addDocument">
                            <i class="bx bx-plus"></i> Add Document
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="documentsWrapper">
                            @if(old('documents_title'))
                            @foreach(old('documents_title') as $i => $title)
                            <div class="repeater-card animate-slide-in">
                                <div class="row g-3 align-items-start">
                                    <div class="col-md-6">
                                        <label class="form-label">Attachments</label>
                                        <input type="file" name="product_documents[]" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">URL</label>
                                        <input type="text" name="documents_link[]" class="form-control" placeholder="Document URL">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="documents_title[]" class="form-control" value="{{ $title }}" placeholder="Document title">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Description</label>
                                        <textarea name="documents_description[]" class="form-control" rows="2" placeholder="Describe this document...">{{ old('documents_description.'.$i) }}</textarea>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" onclick="removeItem(this)" class="btn-remove btn-remove-lg">
                                            <i class="bx bx-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @elseif(isset($product))
                            @foreach($product->documents as $document)
                            <div class="repeater-card animate-slide-in">
                                <div class="row g-3 align-items-start">
                                    <div class="col-md-6">
                                        <label class="form-label">Attachment</label>
                                        <input type="file" name="product_documents[]" class="form-control">

                                        @if($document->attachment)
                                        <a href="{{ asset($document->attachment) }}" target="_blank">View File</a>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">URL</label>
                                        <input type="text" name="documents_link[]" class="form-control" value="{{ $document->link }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="documents_title[]" class="form-control" value="{{ $document->title }}" placeholder="Document title">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Description</label>
                                        <textarea name="documents_description[]" class="form-control" rows="2" placeholder="Describe this benefit…">{{ $document->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif

                            <div class="empty-state" id="documentsEmpty">
                                <i class="bx bx-star"></i>
                                <span>No documents added yet. Click <strong>Add Document</strong> to start.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- right side --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 24px;">
                    <div class="card animate-fade-up overflow-hidden">
                        <div class="publish-accent"></div>
                        <div class="card-header">
                            <h6 class="mb-0">Publish Settings</h6>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">Category *</label>
                                <select name="category_id" class="form-select custom-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $name => $id)
                                    <option value="{{ $id }}" {{ old('category_id', $product->category_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Images (Multiple)</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="product_images[]" class="form-control" multiple>
                                </div>
                                @if(isset($product) && $product->galleries->isNotEmpty())
                                <div class="mt-2">
                                    @foreach($product->galleries as $gallery)
                                    <img src="{{ asset($gallery->image) }}" alt="Product image" class="img-fluid mb-2" style="max-height:100px;">
                                    @endforeach
                                </div>
                                @endif
                                <div class="form-text">1020 × 400 px recommended</div>
                            </div>

                            <hr class="my-4">

                            <div class="seo-section">
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="seo_title" class="form-control" placeholder="SEO page title…" value="{{ old('seo_title', $product->seo_title ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <textarea name="seo_keywords" class="form-control" rows="2" placeholder="keyword1, keyword2, …">{{ old('seo_keywords', $product->seo_keywords ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="seo_description" class="form-control" rows="3" placeholder="Short page description for search engines…">{{ old('seo_description', $product->seo_description ?? '') }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn-save mt-4">
                                <i class="bx bx-check-circle" style="font-size:1.2rem;"></i>
                                Save Product
                            </button>

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
        .create(document.querySelector('#technical_specifications'), {
            ckfinder: {
                uploadUrl: "{{ route('ckEditorUpload') . '?_token=' . csrf_token() }}"
            }
        })
        .catch(error => {
            console.error(error);
        });

    function removeItem(button) {
        const card = $(button).closest('.repeater-card');
        card.css({
            transform: 'scale(0.95) translateY(-4px)',
            opacity: 0,
            transition: 'all 0.2s ease'
        });
        setTimeout(() => {
            card.remove();
            updateEmptyStates();
        }, 200);
    }

    function updateEmptyStates() {
        ['documents'].forEach(function(key) {
            const wrapper = $('#' + key + 'Wrapper');
            const empty = $('#' + key + 'Empty');
            if (empty.length) {
                const hasCards = wrapper.find('.repeater-card').length > 0;
                empty.toggle(!hasCards);
            }
        });
    }

    function hideEmpty(wrapperId) {
        const empty = $('#' + wrapperId + 'Empty');
        if (empty.length) empty.hide();
    }

    /* documents */
    $('#addDocument').click(function() {
        hideEmpty('documents');
        $('#documentsWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="row g-3 align-items-start">
                <div class="col-md-6">
                    <label class="form-label">Attachment</label>
                    <input type="file" name="product_documents[]" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">URL</label>
                    <input type="text" name="documents_link[]" class="form-control" placeholder="Document URL">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="documents_title[]" class="form-control" placeholder="Document title">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <textarea name="documents_description[]" class="form-control" rows="2" placeholder="Describe this document..."></textarea>
                </div>
                <div class="text-end">
                    <button type="button" onclick="removeItem(this)" class="btn-remove btn-remove-lg">
                        <i class="bx bx-trash"></i> Remove
                    </button>
                </div>
            </div>
        </div>
    `);
    });

    // hide any empty states once page loads so that existing cards are visible
    $(function() {
        updateEmptyStates();
    });
</script>
@endpush