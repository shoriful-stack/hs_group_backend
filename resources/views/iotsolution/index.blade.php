@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="breadcrumb-modern d-none d-sm-flex align-items-center">
        <div class="d-flex align-items-center">
            <i class="bx bx-home-alt me-2 text-muted"></i>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">IOT</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card">
                <div class="card-header">
                    <h5>IOT Section Management</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('iot.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">

                            <!-- Title -->
                            <div class="col-md-12">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $data->title ?? '') }}" required>
                            </div>

                            <!-- Sub Title -->
                            <div class="col-md-12">
                                <label>Sub Title <span class="text-danger">*</span></label>
                                <input type="text" name="sub_title" class="form-control"
                                    value="{{ old('sub_title', $data->sub_title ?? '') }}" required>
                            </div>

                            <!-- Section Heading -->
                            <div class="col-md-6">
                                <label>Section Heading <span class="text-danger">*</span></label>
                                <input type="text" name="section_heading" class="form-control"
                                    value="{{ old('section_heading', $data->section_heading ?? '') }}">
                            </div>

                            <!-- Section Sub Heading -->
                            <div class="col-md-6">
                                <label>Section Sub Heading <span class="text-danger">*</span></label>
                                <input type="text" name="section_sub_heading" class="form-control"
                                    value="{{ old('section_sub_heading', $data->section_sub_heading ?? '') }}">
                            </div>

                            <!-- Features -->
                            <div class="col-md-12">
                                <label class="form-label">Features <span class="text-danger">*</span></label>

                                @php
                                $features = old('features', $data->features ?? []);
                                if (is_string($features)) {
                                $decoded = json_decode($features, true);
                                $features = is_array($decoded) ? $decoded : [];
                                }
                                $features = is_array($features) ? $features : [];
                                @endphp

                                @for($i = 0; $i < 5; $i++)
                                    <input type="text"
                                    name="features[]"
                                    class="form-control mb-2"
                                    placeholder="Feature {{ $i + 1 }}"
                                    value="{{ $features[$i] ?? '' }}">
                                    @endfor
                            </div>

                            <!-- Images -->
                            <div class="col-md-4">
                                <label>Main Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control">
                                @if($data?->image)
                                <img src="{{ asset($data->image) }}" width="100">
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label>Sub Image <span class="text-danger">*</span></label>
                                <input type="file" name="sub_image" class="form-control">
                                @if($data?->sub_image)
                                <img src="{{ asset($data->sub_image) }}" width="100">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label>{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach (\App\Enums\Status::options() as $key => $label)
                                    <option value="{{ $key }}" {{ $data->status?->value === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button class="btn btn-primary">
                                {{ $data?->id ? 'Update' : 'Save' }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection