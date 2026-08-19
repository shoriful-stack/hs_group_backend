@extends('layouts.app')

@section('content')
<div class="modern-contact-form">
    <div class="container-fluid px-4">
        <div class="breadcrumb-modern d-none d-sm-flex align-items-center">
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Sustainability</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card form-card">
                    <div class="card-body px-4">
                        <form method="POST" action="{{ route('sustainability.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-section mb-2">
                                <h5 class="form-section-title">Sustainability</h5>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Title') }}</label>
                                        <input type="text" name="title" class="form-control" value="{{ old('title', $data->title ?? '') }}" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Subtitle') }}</label>
                                        <textarea name="subtitle" class="form-control" rows="3">{{ old('subtitle', $data->subtitle ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Commitment Title') }}</label>
                                        <input type="text" name="sub_title" class="form-control" value="{{ old('sub_title', $data->sub_title ?? '') }}" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Commitment Content') }}</label>
                                        <textarea name="contents" class="form-control" rows="4">{{ old('contents', $data->content ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Quote') }}</label>
                                        <textarea name="quote" class="form-control" rows="2">{{ old('quote', $data->quote ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Closing') }}</label>
                                        <input type="text" name="closing" class="form-control" value="{{ old('closing', $data->closing ?? '') }}" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Image') }}</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" />
                                        @if(!empty($data->image))
                                            <img src="{{ asset($data->image) }}" alt="" height="80" class="mt-2" />
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <button type="submit" class="btn btn-primary px-4">
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
