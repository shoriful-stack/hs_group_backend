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
            <h2>{{ isset($project) ? 'Edit Project' : 'Create Project' }}</h2>
            <small class="text-muted">Manage project content dynamically</small>
        </div>
        <a href="{{ route('projects.index') }}" class="btn-back">
            <i class="bx bx-arrow-back"></i> Back to Projects
        </a>
    </div>

    <form action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}" method="POST" enctype="multipart/form-data" class="py-3">
        @csrf
        @if(isset($project))
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
                            <div class="col-md-6">
                                <label class="form-label">Location *</label>
                                <input type="text" name="location" class="form-control" placeholder="e.g. Bangladesh" value="{{ old('location', $project->location ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Project Year *</label>
                                <input type="text" name="year" class="form-control" placeholder="e.g. 2024" value="{{ old('year', $project->year ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Duration *</label>
                                <input type="text" name="duration" class="form-control" placeholder="e.g. 18 Months" value="{{ old('duration', $project->duration ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Project Value *</label>
                                <input type="text" name="project_value" class="form-control" placeholder="e.g. Major Contract" value="{{ old('project_value', $project->project_value ?? '') }}" required>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Title *</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Industrial Cleaning" value="{{ old('title', $project->title ?? '') }}" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Hero Image</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="image" class="form-control">
                                </div>
                                @if(isset($project) && $project->image)
                                <div class="mt-2">
                                    <img src="{{ asset($project->image) }}" alt="Current hero" class="img-fluid" style="max-height:100px;">
                                </div>
                                @endif
                                <div class="form-text">1920 × 1000 px recommended</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control editor" rows="2" placeholder="Detailed description of the project...">{{ old('description', $project->description ?? '') }}</textarea>
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
                            @elseif(isset($project))
                            @foreach($project->highlights as $highlight)
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
                {{-- project Information --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Key Information</h6>
                        <button type="button" class="btn-add" id="addInformation">
                            <i class="bx bx-plus"></i> Add Information
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="informationsWrapper">
                            @if(old('informations_title'))
                            @foreach(old('informations_title') as $i => $title)
                            <div class="repeater-card animate-slide-in">
                                <div class="row g-3 align-items-start">
                                    <div class="col-md-2">
                                        <label class="form-label">Icon Class</label>
                                        <input type="text" name="informations_icon[]" class="form-control" value="{{ old('informations_icon.'.$i) }}" placeholder="bx bx-star">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="informations_title[]" class="form-control" value="{{ $title }}" placeholder="Information title">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Description</label>
                                        <textarea name="informations_description[]" class="form-control" rows="2" placeholder="Describe this information...">{{ old('informations_description.'.$i) }}</textarea>
                                    </div>
                                    <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                        <button type="button" onclick="removeItem(this)" class="btn-remove">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @elseif(isset($project))
                            @foreach($project->informations as $information)
                            <div class="repeater-card animate-slide-in">
                                <div class="row g-3 align-items-start">
                                    <div class="col-md-2">
                                        <label class="form-label">Icon Class</label>
                                        <input type="text" name="informations_icon[]" class="form-control" value="{{ $information->icon }}" placeholder="bx bx-star">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="informations_title[]" class="form-control" value="{{ $information->title }}" placeholder="Information title">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Description</label>
                                        <textarea name="informations_description[]" class="form-control" rows="2" placeholder="Describe this information...">{{ $information->description }}</textarea>
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

                            <div class="empty-state" id="informationsEmpty">
                                <i class="bx bx-star"></i>
                                <span>No information added yet. Click <strong>Add Information</strong> to start.</span>
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
                            @elseif(isset($project))
                            @foreach($project->scopes as $scope)
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

                {{-- challenges & solutions --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Challenges & Solutions</h6>
                        <button type="button" class="btn-add" id="addChallenge">
                            <i class="bx bx-plus"></i> Add New
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="challengeWrapper">
                            @if(old('challenge'))
                            @foreach(old('challenge') as $i => $val)
                            <div class="repeater-card animate-slide-in">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Challenge</label>
                                        <textarea name="challenge[]" class="form-control" rows="2" placeholder="Describe the challenge...">{{ old('challenge.'.$i) }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Solution</label>
                                        <textarea name="solution[]" class="form-control" rows="2" placeholder="Describe the solution...">{{ old('solution.'.$i) }}</textarea>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="button" onclick="removeItem(this)" class="btn-remove btn-remove-lg">
                                        <i class="bx bx-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                            @endforeach
                            @endif

                            @if (isset($project) && $project->problemSolvings)
                            @foreach($project->problemSolvings as $item)
                            <div class="repeater-card animate-slide-in">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Challenge</label>
                                        <textarea name="challenge[]" class="form-control" rows="2">{{ $item->challenge }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Solution</label>
                                        <textarea name="solution[]" class="form-control" rows="2">{{ $item->solution }}</textarea>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="button" onclick="removeItem(this)" class="btn-remove btn-remove-lg">
                                        <i class="bx bx-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                            @endforeach
                            @endif

                            <div class="empty-state {{ (old('challenge') || (isset($project) && count($project->problemSolvings) > 0)) ? 'd-none' : '' }}" id="challengeEmpty">
                                <i class="bx bx-wrench"></i>
                                <span>No challenge or solution added yet.</span>
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
                            @if(old('project_equipment_category_id'))
                            @foreach(old('project_equipment_category_id') as $i => $cat)
                            <div class="repeater-card animate-slide-in">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <select name="project_equipment_category_id[]" class="form-select custom-select">
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
                                <div class="mb-3">
                                    <label class="form-label">Equipment Description</label>
                                    <textarea name="equipment_icons[]" class="form-control" rows="2" placeholder="Comma separated: Description A, Description B, Description C">{{ old('equipment_icons.'.$i) }}</textarea>
                                </div>
                                <div class="text-end">
                                    <button type="button" onclick="removeItem(this)" class="btn-remove btn-remove-lg">
                                        <i class="bx bx-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @if (isset($project))
                            @foreach($equipmentGroups as $catId => $items)
                            <div class="repeater-card animate-slide-in">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <select name="project_equipment_category_id[]" class="form-select custom-select">
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
                                <div class="mb-3">
                                    <label class="form-label">Equipment Descriptions</label>
                                    <textarea name="equipment_icons[]" class="form-control" rows="2" placeholder="Comma separated: Description A, Description B, Description C">{{ $items->pluck('icon')->implode(', ') }}</textarea>
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

                {{-- impact --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Key Impact</h6>
                        <button type="button" class="btn-add" id="addImpact">
                            <i class="bx bx-plus"></i> Add Impact
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="impactsWrapper">
                            @if(old('impacts_title'))
                            @foreach(old('impacts_title') as $i => $title)
                            <div class="repeater-card animate-slide-in">
                                <div class="row g-3 align-items-start">
                                    <div class="col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="impacts_title[]" class="form-control" value="{{ $title }}" placeholder="Impact title">
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label">Value</label>
                                        <input type="text" name="impacts_value[]" class="form-control" value="{{ old('impacts_value.'.$i) }}" placeholder="Impact Value">
                                    </div>
                                    <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                        <button type="button" onclick="removeItem(this)" class="btn-remove">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @elseif(isset($project))
                            @foreach($project->impacts as $impact)
                            <div class="repeater-card animate-slide-in">
                                <div class="row g-3 align-items-start">
                                    <div class="col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="impacts_title[]" class="form-control" value="{{ $impact->title }}" placeholder="Impact title">
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label">Value</label>
                                        <input type="text" name="impacts_value[]" class="form-control" value="{{ $impact->value }}" placeholder="Impact Value">
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

                            <div class="empty-state" id="impactsEmpty">
                                <i class="bx bx-star"></i>
                                <span>No impacts added yet. Click <strong>Add Impact</strong> to start.</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- project Review --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Project Review</h6>
                        <button type="button" class="btn-add" id="addReview">
                            <i class="bx bx-plus"></i> Add Review
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="reviewsWrapper">
                            @if(old('reviews_department'))
                            @foreach(old('reviews_department') as $i => $department)
                            <div class="repeater-card animate-slide-in">
                                <div class="row g-3 align-items-start">
                                    <div class="col-md-2">
                                        <label class="form-label">Department</label>
                                        <input type="text" name="reviews_department[]" class="form-control" value="{{ old('reviews_department.'.$i) }}" placeholder="Operations">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Designation</label>
                                        <input type="text" name="reviews_designation[]" class="form-control" value="{{ $department }}" placeholder="Operations Director">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Review</label>
                                        <textarea name="reviews_description[]" class="form-control" rows="2" placeholder="Describe this review...">{{ old('reviews_description.'.$i) }}</textarea>
                                    </div>
                                    <div class="col-md-1 d-flex justify-content-end align-items-center" style="margin-top: 1.8rem;">
                                        <button type="button" onclick="removeItem(this)" class="btn-remove">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @elseif(isset($project))
                            @foreach($project->reviews as $review)
                            <div class="repeater-card animate-slide-in">
                                <div class="row g-3 align-items-start">
                                    <div class="col-md-2">
                                        <label class="form-label">Department</label>
                                        <input type="text" name="reviews_department[]" class="form-control" value="{{ $review->department }}" placeholder="Operations">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Designation</label>
                                        <input type="text" name="reviews_designation[]" class="form-control" value="{{ $review->designation }}" placeholder="Operations Director">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Review</label>
                                        <textarea name="reviews_description[]" class="form-control" rows="2" placeholder="Describe this review...">{{ $review->description }}</textarea>
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

                            <div class="empty-state" id="reviewsEmpty">
                                <i class="bx bx-star"></i>
                                <span>No review added yet. Click <strong>Add Review</strong> to start.</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- project cta --}}
                <div class="card animate-fade-up mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Project CTA</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Title *</label>
                                @if(empty($project))
                                <input type="text" name="question" class="form-control" placeholder="e.g. Have a Similar Telecom Infrastructure Requirement?" required>
                                @endif
                                @if(isset($project) && $project->ctas)
                                <input type="text" name="question" class="form-control" placeholder="e.g. Have a Similar Telecom Infrastructure Requirement?" value="{{ old('question', optional($project->ctas->first())->question) }}" required>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description *</label>
                                @if(empty($project))
                                <input type="text" name="answer" class="form-control" placeholder="e.g. Let our proven team handle your next large-scale network deployment project." required>
                                @endif
                                @if(isset($project) && $project->ctas)
                                <input type="text" name="answer" class="form-control" placeholder="e.g. Let our proven team handle your next large-scale network deployment project." value="{{ old('answer', $project->ctas->first()->answer ?? '') }}" required>
                                @endif
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
                                    <option value="{{ $id }}" {{ old('category_id', $project->category_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Customer *</label>
                                <select name="customer_id" class="form-select custom-select" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $name => $id)
                                    <option value="{{ $id }}" {{ old('customer_id', $project->our_customer_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Project Images (Multiple)</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="project_images[]" class="form-control" multiple>
                                </div>
                                @if(isset($project) && $project->galleries->isNotEmpty())
                                <div class="mt-2 d-flex flex-wrap gap-2">
                                    @foreach($project->galleries as $gallery)
                                    <div class="position-relative border rounded p-1" style="width: 120px;">
                                        <img src="{{ asset($gallery->image) }}" alt="Project image" class="img-fluid" style="height:80px; width:100%; object-fit:cover;">
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $gallery->id }}" id="del_img_{{ $gallery->id }}">
                                            <label class="form-check-label text-danger small" for="del_img_{{ $gallery->id }}">
                                                <i class="bx bx-trash"></i> Remove
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                <div class="form-text">1020 × 400 px recommended</div>
                            </div>

                            <hr class="my-4">

                            <div class="seo-section">
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="seo_title" class="form-control" placeholder="SEO page title…" value="{{ old('seo_title', $project->seo_title ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <textarea name="seo_keywords" class="form-control" rows="2" placeholder="keyword1, keyword2, …">{{ old('seo_keywords', $project->seo_keywords ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="seo_description" class="form-control" rows="3" placeholder="Short page description for search engines…">{{ old('seo_description', $project->seo_description ?? '') }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn-save mt-4">
                                <i class="bx bx-check-circle" style="font-size:1.2rem;"></i>
                                Save Project
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
        ['highlights', 'informations', 'scope', 'capabilities', 'challenge', 'equipment', 'impacts', 'reviews'].forEach(function(key) {
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

    /* informations */
    $('#addInformation').click(function() {
        hideEmpty('informations');
        $('#informationsWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="row g-3 align-items-start">
                <div class="col-md-2">
                    <label class="form-label">Icon Class</label>
                    <input type="text" name="informations_icon[]" class="form-control" placeholder="bx bx-star">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="informations_title[]" class="form-control" placeholder="Information title">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Description</label>
                    <textarea name="informations_description[]" class="form-control" rows="2" placeholder="Describe this information..."></textarea>
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

    /* challenge */
    $('#addChallenge').click(function() {
        hideEmpty('challenge');
        $('#challengeWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Challenge</label>
                    <textarea name="challenge[]" class="form-control" rows="2" placeholder="Describe the challenge..."></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Solution</label>
                    <textarea name="solution[]" class="form-control" rows="2" placeholder="Describe the solution..."></textarea>
                </div>
            </div>
            <div class="text-end">
                <button type="button" onclick="removeItem(this)" class="btn-remove btn-remove-lg">
                    <i class="bx bx-trash"></i> Remove
                </button>
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
                <select name="project_equipment_category_id[]" class="form-select custom-select">
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
            <div class="mb-3">
                <label class="form-label">Equipment Descriptions</label>
                <textarea name="equipment_icons[]" class="form-control" rows="2" placeholder="Comma separated: Description A, Description B, Description C"></textarea>
            </div>
            <div class="text-end">
                <button type="button" onclick="removeItem(this)" class="btn-remove btn-remove-lg">
                    <i class="bx bx-trash"></i> Remove
                </button>
            </div>
        </div>
    `);
    });

    /* impacts */
    $('#addImpact').click(function() {
        hideEmpty('impacts');
        $('#impactsWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="row g-3 align-items-start">
                <div class="col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="impacts_title[]" class="form-control" placeholder="Impact title">
                </div>
                <div class="col-md-7">
                    <label class="form-label">Value</label>
                    <input type="text" name="impacts_value[]" class="form-control" placeholder="Impact Value">
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

    /* reviews */
    $('#addReview').click(function() {
        hideEmpty('reviews');
        $('#reviewsWrapper').append(`
        <div class="repeater-card animate-slide-in">
            <div class="row g-3 align-items-start">
                <div class="col-md-2">
                    <label class="form-label">Department</label>
                    <input type="text" name="reviews_department[]" class="form-control" placeholder="Operations">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Designation</label>
                    <input type="text" name="reviews_designation[]" class="form-control" placeholder="Operations Director">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Review</label>
                    <textarea name="reviews_description[]" class="form-control" rows="2" placeholder="Describe this review..."></textarea>
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
    // hide any empty states once page loads so that existing cards are visible
    $(function() {
        updateEmptyStates();
    });
</script>
@endpush