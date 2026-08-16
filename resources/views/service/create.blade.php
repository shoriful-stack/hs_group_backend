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
            <h2>{{ isset($service) ? 'Edit Service' : 'Create Service' }}</h2>
            <small class="text-muted">Manage service content dynamically</small>
        </div>
        <a href="{{ route('services.index') }}" class="btn-back">
            <i class="bx bx-arrow-back"></i> Back to Services
        </a>
    </div>

    <form action="{{ isset($service) ? route('services.update', $service->id) : route('services.store') }}" method="POST" enctype="multipart/form-data" class="py-3">
        @csrf
        @if(isset($service))
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
                                <input type="text" name="title" class="form-control" placeholder="e.g. Industrial Cleaning" value="{{ old('title', $service->title ?? '') }}" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Hero Image</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="image" class="form-control">
                                </div>
                                @if(isset($service) && $service->image)
                                <div class="mt-2">
                                    <img src="{{ asset($service->image) }}" alt="Current hero" class="img-fluid" style="max-height:100px;">
                                </div>
                                @endif
                                <div class="form-text">1920 × 1000 px recommended</div>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Full Description</label>
                                <textarea name="description" class="form-control editor" rows="4" placeholder="Detailed description of the service…">{{ old('description', $service->description ?? '') }}</textarea>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Short Description</label>
                                <textarea name="subtitle" class="form-control" rows="4" placeholder="Brief tagline or summary…">{{ old('subtitle', $service->subtitle ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- highlight --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Key Highlights</h6>
                        <button type="button" class="btn-add" id="addHighlight">
                            <i class="bx bx-plus"></i> Add Highlight
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="highlightsWrapper">
                            @if(old('highlights_title'))
                                @foreach(old('highlights_title') as $i => $title)
                                    <div class="repeater-card animate-slide-in">
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md-4">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="highlights_title[]" class="form-control" value="{{ $title }}" placeholder="Highlight title">
                                            </div>
                                            <div class="col-md-7">
                                                <label class="form-label">Value</label>
                                                <input type="text" name="highlights_value[]" class="form-control" value="{{ old('highlights_value.'.$i) }}" placeholder="Highlight Value">
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                                <button type="button" onclick="removeItem(this)" class="btn-remove">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($service))
                            @foreach($service->highlights as $highlight)
                                <div class="repeater-card animate-slide-in">
                                    <div class="row g-3 align-items-start">
                                        <div class="col-md-4">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="highlights_title[]" class="form-control" value="{{ $highlight->title }}" placeholder="Highlight title">
                                        </div>
                                        <div class="col-md-7">
                                            <label class="form-label">Value</label>
                                            <input type="text" name="highlights_value[]" class="form-control" value="{{ $highlight->value }}" placeholder="Highlight Value">
                                        </div>
                                        <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                            <button type="button" onclick="removeItem(this)" class="btn-remove">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif

                            <div class="empty-state" id="highlightsEmpty">
                                <i class="bx bx-star"></i>
                                <span>No highlights added yet. Click <strong>Add Highlight</strong> to start.</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- benefit --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Key Benefits</h6>
                        <button type="button" class="btn-add" id="addBenefit">
                            <i class="bx bx-plus"></i> Add Benefit
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="benefitsWrapper">
                            @if(old('benefits_title'))
                                @foreach(old('benefits_title') as $i => $title)
                                    <div class="repeater-card animate-slide-in">
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md-2">
                                                <label class="form-label">Icon Class</label>
                                                <input type="text" name="benefits_icon[]" class="form-control" value="{{ old('benefits_icon.'.$i) }}" placeholder="bx bx-star">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="benefits_title[]" class="form-control" value="{{ $title }}" placeholder="Benefit title">
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">Description</label>
                                                <textarea name="benefits_description[]" class="form-control" rows="2" placeholder="Describe this benefit…">{{ old('benefits_description.'.$i) }}</textarea>
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                                <button type="button" onclick="removeItem(this)" class="btn-remove">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($service))
                                @foreach($service->benefits as $benefit)
                                    <div class="repeater-card animate-slide-in">
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md-2">
                                                <label class="form-label">Icon Class</label>
                                                <input type="text" name="benefits_icon[]" class="form-control" value="{{ $benefit->icon }}" placeholder="bx bx-star">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="benefits_title[]" class="form-control" value="{{ $benefit->title }}" placeholder="Benefit title">
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">Description</label>
                                                <textarea name="benefits_description[]" class="form-control" rows="2" placeholder="Describe this benefit…">{{ $benefit->description }}</textarea>
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                                <button type="button" onclick="removeItem(this)" class="btn-remove">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <div class="empty-state" id="benefitsEmpty">
                                <i class="bx bx-star"></i>
                                <span>No benefits added yet. Click <strong>Add Benefit</strong> to start.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- scope of work --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Scope of Work</h6>
                        <button type="button" class="btn-add" id="addScope">
                            <i class="bx bx-plus"></i> Add Step
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="scopeWrapper">
                            @if(old('scope_title'))
                                @foreach(old('scope_title') as $i => $title)
                                    <div class="repeater-card animate-slide-in">
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md-1">
                                                <div class="step-badge">{{ $i + 1 }}</div>
                                            </div>
                                            <div class="col-md-1 d-none">
                                                <label class="form-label">Step #</label>
                                                <input type="number" name="scope_step[]" class="form-control" placeholder="1" value="{{ old('scope_step.'.$i, $i+1) }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="scope_title[]" class="form-control" value="{{ $title }}" placeholder="Step title">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Description</label>
                                                <textarea name="scope_description[]" class="form-control" rows="2" placeholder="What this step covers…">{{ old('scope_description.'.$i) }}</textarea>
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                                <button type="button" onclick="removeItem(this)" class="btn-remove">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($service))
                                @foreach($service->scopes as $scope)
                                    <div class="repeater-card animate-slide-in">
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md-1">
                                                <div class="step-badge">{{ $loop->iteration }}</div>
                                            </div>
                                            <div class="col-md-1 d-none">
                                                <label class="form-label">Step #</label>
                                                <input type="number" name="scope_step[]" class="form-control" placeholder="1" value="{{ $scope->step_number }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="scope_title[]" class="form-control" value="{{ $scope->title }}" placeholder="Step title">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Description</label>
                                                <textarea name="scope_description[]" class="form-control" rows="2" placeholder="What this step covers…">{{ $scope->description }}</textarea>
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                                <button type="button" onclick="removeItem(this)" class="btn-remove">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <div class="empty-state" id="scopeEmpty">
                                <i class="bx bx-list-check"></i>
                                <span>No scope steps added yet.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- capability --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Capabilities</h6>
                        <button type="button" class="btn-add" id="addCapability">
                            <i class="bx bx-plus"></i> Add Capability
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="capabilitiesWrapper">
                            @if(old('capabilities_title'))
                                @foreach(old('capabilities_title') as $i => $title)
                                    <div class="repeater-card animate-slide-in">
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md-4">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="capabilities_title[]" class="form-control" value="{{ $title }}" placeholder="Capability title">
                                            </div>
                                            <div class="col-md-7">
                                                <label class="form-label">Value</label>
                                                <input type="text" name="capabilities_value[]" class="form-control" value="{{ old('capabilities_value.'.$i) }}" placeholder="Capability Value">
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                                <button type="button" onclick="removeItem(this)" class="btn-remove">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($service))
                                @foreach($service->capabilities as $cap)
                                    <div class="repeater-card animate-slide-in">
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md-4">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="capabilities_title[]" class="form-control" value="{{ $cap->title }}" placeholder="Capability title">
                                            </div>
                                            <div class="col-md-7">
                                                <label class="form-label">Value</label>
                                                <input type="text" name="capabilities_value[]" class="form-control" value="{{ $cap->description }}" placeholder="Capability Value">
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                                <button type="button" onclick="removeItem(this)" class="btn-remove">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <div class="empty-state" id="capabilitiesEmpty">
                                <i class="bx bx-star"></i>
                                <span>No capabilities added yet. Click <strong>Add Capability</strong> to start.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- process --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Process &amp; Methodology</h6>
                        <button type="button" class="btn-add" id="addProcess">
                            <i class="bx bx-plus"></i> Add Process
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="processWrapper">
                            @if(old('process_title'))
                                @foreach(old('process_title') as $i => $title)
                                    <div class="repeater-card animate-slide-in">
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md-1">
                                                <div class="step-badge">{{ $i + 1 }}</div>
                                            </div>
                                            <div class="col-md-1 d-none">
                                                <label class="form-label">Serial</label>
                                                <input type="number" name="process_serial[]" class="form-control" placeholder="1" value="{{ old('process_serial.'.$i, $i+1) }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="process_title[]" class="form-control" value="{{ $title }}" placeholder="Process step title">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Description</label>
                                                <textarea name="process_description[]" class="form-control" rows="2" placeholder="Explain the methodology…">{{ old('process_description.'.$i) }}</textarea>
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                                <button type="button" onclick="removeItem(this)" class="btn-remove">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($service))
                                @foreach($service->processSteps as $step)
                                    <div class="repeater-card animate-slide-in">
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md-1">
                                                <div class="step-badge">{{ $loop->iteration }}</div>
                                            </div>
                                            <div class="col-md-1 d-none">
                                                <label class="form-label">Serial</label>
                                                <input type="number" name="process_serial[]" class="form-control" placeholder="1" value="{{ $step->serial_no }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="process_title[]" class="form-control" value="{{ $step->title }}" placeholder="Process step title">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Description</label>
                                                <textarea name="process_description[]" class="form-control" rows="2" placeholder="Explain the methodology…">{{ $step->description }}</textarea>
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                                <button type="button" onclick="removeItem(this)" class="btn-remove">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <div class="empty-state" id="processEmpty">
                                <i class="bx bx-cog"></i>
                                <span>No process steps added yet.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- equipment category --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Equipments</h6>
                        <button type="button" class="btn-add" id="addCategory">
                            <i class="bx bx-plus"></i> Add Equipment
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="equipmentWrapper">
                            @if(old('service_equipment_category_id'))
                                @foreach(old('service_equipment_category_id') as $i => $cat)
                                    <div class="repeater-card animate-slide-in">
                                        <div class="mb-3">
                                            <label class="form-label">Category Name</label>
                                            <select name="service_equipment_category_id[]" class="form-select custom-select">
                                                <option value="">Select Equipment Category</option>
                                                @foreach($equipmentCategories as $name => $id)
                                                    <option value="{{ $id }}" {{ $cat == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Equipment Items</label>
                                            <textarea name="equipment_items[]" class="form-control" rows="2" placeholder="Comma separated: Item A, Item B, Item C">{{ old('equipment_items.'.$i) }}</textarea>
                                        </div>
                                        <div class="text-end">
                                            <button type="button" onclick="removeItem(this)" class="btn-remove btn-remove-lg">
                                                <i class="bx bx-trash"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if (isset($service))
                            @foreach($equipmentGroups as $catId => $items)
                                <div class="repeater-card animate-slide-in">
                                    <div class="mb-3">
                                        <label class="form-label">Category Name</label>
                                        <select name="service_equipment_category_id[]" class="form-select custom-select">
                                            <option value="">Select Equipment Category</option>
                                            @foreach($equipmentCategories as $name => $id)
                                                <option value="{{ $id }}" {{ $catId == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Equipment Items</label>
                                        <textarea name="equipment_items[]" class="form-control" rows="2" placeholder="Comma separated: Item A, Item B, Item C">{{ $items->pluck('name')->implode(', ') }}</textarea>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" onclick="removeItem(this)" class="btn-remove btn-remove-lg">
                                            <i class="bx bx-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach                        
                            @endif

                            <div class="empty-state" id="equipmentEmpty">
                                <i class="bx bx-wrench"></i>
                                <span>No equipment categories added yet.</span>
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
                                    <option value="{{ $id }}" {{ old('category_id', $service->category_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <hr class="my-4">

                            <div class="seo-section">
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="seo_title" class="form-control" placeholder="SEO page title…" value="{{ old('seo_title', $service->seo_title ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <textarea name="seo_keywords" class="form-control" rows="2" placeholder="keyword1, keyword2, …">{{ old('seo_keywords', $service->seo_keywords ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="seo_description" class="form-control" rows="3" placeholder="Short page description for search engines…">{{ old('seo_description', $service->seo_description ?? '') }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn-save mt-4">
                                <i class="bx bx-check-circle" style="font-size:1.2rem;"></i>
                                Save Service
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
        ['highlights', 'benefits', 'scope', 'capabilities', 'process', 'equipment'].forEach(function(key) {
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
    /* highlights */
    $('#addHighlight').click(function() {
        hideEmpty('highlights');
        $('#highlightsWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="row g-3 align-items-start">
                <div class="col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="highlights_title[]" class="form-control" placeholder="Highlight title">
                </div>
                <div class="col-md-7">
                    <label class="form-label">Value</label>
                    <input type="text" name="highlights_value[]" class="form-control" placeholder="Highlight Value">
                </div>
                <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                    <button type="button" onclick="removeItem(this)" class="btn-remove">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `);
    });

    /* benefits */
    $('#addBenefit').click(function() {
        hideEmpty('benefits');
        $('#benefitsWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="row g-3 align-items-start">
                <div class="col-md-2">
                    <label class="form-label">Icon Class</label>
                    <input type="text" name="benefits_icon[]" class="form-control" placeholder="bx bx-star">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="benefits_title[]" class="form-control" placeholder="Benefit title">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Description</label>
                    <textarea name="benefits_description[]" class="form-control" rows="2" placeholder="Describe this benefit…"></textarea>
                </div>
                <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                    <button type="button" onclick="removeItem(this)" class="btn-remove">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `);
    });

    /* scope */
    $('#addScope').click(function() {
        hideEmpty('scope');
        const count = $('#scopeWrapper .repeater-card').length + 1;
        $('#scopeWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="row g-3 align-items-start">
                <div class="col-md-1">
                    <div class="step-badge">${count}</div>
                </div>
                <div class="col-md-1 d-none">
                    <label class="form-label">Step #</label>
                    <input type="number" name="scope_step[]" class="form-control" placeholder="1" value="${count}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="scope_title[]" class="form-control" placeholder="Step title">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <textarea name="scope_description[]" class="form-control" rows="2" placeholder="What this step covers…"></textarea>
                </div>
                <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                    <button type="button" onclick="removeItem(this)" class="btn-remove">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `);
    });
    /* capabilities */
    $('#addCapability').click(function() {
        hideEmpty('capabilities');
        $('#capabilitiesWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="row g-3 align-items-start">
                <div class="col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="capabilities_title[]" class="form-control" placeholder="Capability title">
                </div>
                <div class="col-md-7">
                    <label class="form-label">Value</label>
                    <input type="text" name="capabilities_value[]" class="form-control" placeholder="Capability Value">
                </div>
                <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                    <button type="button" onclick="removeItem(this)" class="btn-remove">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `);
    });
    /* process */
    $('#addProcess').click(function() {
        hideEmpty('process');
        const count = $('#processWrapper .repeater-card').length + 1;
        $('#processWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="row g-3 align-items-start">
                <div class="col-md-1">
                    <div class="step-badge">${count}</div>
                </div>
                <div class="col-md-1 d-none">
                    <label class="form-label">Serial</label>
                    <input type="number" name="process_serial[]" class="form-control" placeholder="1" value="${count}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="process_title[]" class="form-control" placeholder="Process step title">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <textarea name="process_description[]" class="form-control" rows="2" placeholder="Explain the methodology…"></textarea>
                </div>
                <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                    <button type="button" onclick="removeItem(this)" class="btn-remove">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `);
    });

    /* equipment */
    $('#addCategory').click(function() {
        hideEmpty('equipment');
        $('#equipmentWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <select name="service_equipment_category_id[]" class="form-select custom-select">
                    <option value="">Select Equipment Category</option>
                    @foreach($equipmentCategories as $name => $id)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Equipment Items</label>
                <textarea name="equipment_items[]" class="form-control" rows="2" placeholder="Comma separated: Item A, Item B, Item C"></textarea>
            </div>
            <div class="text-end">
                <button type="button" onclick="removeItem(this)" class="btn-remove btn-remove-lg">
                    <i class="bx bx-trash"></i> Remove
                </button>
            </div>
        </div>
    `);
    });

    // hide any empty states once page loads so that existing cards are visible
    $(function(){
        updateEmptyStates();
    });
</script>
@endpush