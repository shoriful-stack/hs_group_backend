@php
    $job = $careerJob ?? null;
    $val = fn ($key, $default = '') => old($key, $job?->{$key} ?? $default);
    $date = fn ($key) => old($key, optional($job?->{$key})->format('Y-m-d'));
    $lines = function ($key) use ($job) {
        $old = old($key);
        if ($old !== null) return $old;
        $arr = $job?->{$key};
        return is_array($arr) ? implode("\n", $arr) : '';
    };
    $departments = ['Engineering', 'Project Management', 'Sales & Business', 'Finance & Accounts', 'Operations', 'IT & Digital'];
    $types = ['Full-time', 'Contract', 'Internship'];
@endphp

<div class="row">
    <div class="form-group col-md-6 mb-2">
        <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
        <input class="form-control" name="title" type="text" id="title" value="{{ $val('title') }}" required />
    </div>
    <div class="form-group col-md-3 mb-2">
        <label for="department">{{ __('Department') }} <span class="text-danger">*</span></label>
        <input class="form-control" name="department" type="text" id="department" list="career-departments"
            value="{{ $val('department') }}" required />
        <datalist id="career-departments">
            @foreach ($departments as $dept)
                <option value="{{ $dept }}"></option>
            @endforeach
        </datalist>
    </div>
    <div class="form-group col-md-3 mb-2">
        <label for="type">{{ __('Type') }} <span class="text-danger">*</span></label>
        <select name="type" id="type" class="form-control" required>
            @foreach ($types as $type)
                <option value="{{ $type }}" {{ $val('type', 'Full-time') === $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-4 mb-2">
        <label for="location">{{ __('Location') }} <span class="text-danger">*</span></label>
        <input class="form-control" name="location" type="text" id="location" value="{{ $val('location') }}" required />
    </div>
    <div class="form-group col-md-4 mb-2">
        <label for="experience">{{ __('Experience') }}</label>
        <input class="form-control" name="experience" type="text" id="experience" value="{{ $val('experience') }}"
            placeholder="3–6 years" />
    </div>
    <div class="form-group col-md-2 mb-2">
        <label for="vacancy">{{ __('Vacancy') }} <span class="text-danger">*</span></label>
        <input class="form-control" name="vacancy" type="number" min="1" id="vacancy" value="{{ $val('vacancy', 1) }}" required />
    </div>
    <div class="form-group col-md-2 mb-2">
        <label for="serial_no">{{ __('Serial') }} <span class="text-danger">*</span></label>
        <input class="form-control" name="serial_no" type="number" id="serial_no" value="{{ $val('serial_no', 1) }}" required />
    </div>

    <div class="form-group col-md-4 mb-2">
        <label for="posted_at">{{ __('Posted Date') }} <span class="text-danger">*</span></label>
        <input class="form-control" name="posted_at" type="date" id="posted_at" value="{{ $date('posted_at') }}" required />
    </div>
    <div class="form-group col-md-4 mb-2">
        <label for="application_deadline">{{ __('Deadline') }}</label>
        <input class="form-control" name="application_deadline" type="date" id="application_deadline"
            value="{{ $date('application_deadline') }}" />
    </div>
    <div class="form-group col-md-4 mb-2">
        <label for="apply_email">{{ __('Apply Email') }}</label>
        <input class="form-control" name="apply_email" type="email" id="apply_email"
            value="{{ $val('apply_email', 'careers@hsgroup.com') }}" />
    </div>

    <div class="form-group col-md-12 mb-2">
        <label for="summary">{{ __('Summary') }} <span class="text-danger">*</span></label>
        <textarea name="summary" id="summary" class="form-control" rows="2" required>{{ $val('summary') }}</textarea>
    </div>
    <div class="form-group col-md-12 mb-2">
        <label for="overview">{{ __('Overview') }}</label>
        <textarea name="overview" id="overview" class="form-control" rows="3">{{ $val('overview') }}</textarea>
    </div>

    <div class="form-group col-md-6 mb-2">
        <label for="educational_qualifications">{{ __('Educational Qualifications') }} <small class="text-muted">(one per line)</small></label>
        <textarea name="educational_qualifications" id="educational_qualifications" class="form-control" rows="4">{{ $lines('educational_qualifications') }}</textarea>
    </div>
    <div class="form-group col-md-6 mb-2">
        <label for="experience_details">{{ __('Experience Details') }} <small class="text-muted">(one per line)</small></label>
        <textarea name="experience_details" id="experience_details" class="form-control" rows="4">{{ $lines('experience_details') }}</textarea>
    </div>
    <div class="form-group col-md-6 mb-2">
        <label for="responsibilities">{{ __('Responsibilities') }} <small class="text-muted">(one per line)</small></label>
        <textarea name="responsibilities" id="responsibilities" class="form-control" rows="5">{{ $lines('responsibilities') }}</textarea>
    </div>
    <div class="form-group col-md-6 mb-2">
        <label for="requirements">{{ __('Requirements') }} <small class="text-muted">(one per line)</small></label>
        <textarea name="requirements" id="requirements" class="form-control" rows="5">{{ $lines('requirements') }}</textarea>
    </div>
    <div class="form-group col-md-6 mb-2">
        <label for="nice_to_have">{{ __('Nice To Have') }} <small class="text-muted">(one per line)</small></label>
        <textarea name="nice_to_have" id="nice_to_have" class="form-control" rows="4">{{ $lines('nice_to_have') }}</textarea>
    </div>
    <div class="form-group col-md-6 mb-2">
        <label for="benefits">{{ __('Benefits') }} <small class="text-muted">(one per line)</small></label>
        <textarea name="benefits" id="benefits" class="form-control" rows="4">{{ $lines('benefits') }}</textarea>
    </div>

    <div class="form-group col-md-6 mb-2">
        <label for="contact_phones">{{ __('Contact Phones') }} <small class="text-muted">(one per line)</small></label>
        <textarea name="contact_phones" id="contact_phones" class="form-control" rows="2">{{ $lines('contact_phones') ?: "01886-775605\n01325-081300" }}</textarea>
    </div>
    <div class="form-group col-md-6 mb-2">
        <label for="application_instruction">{{ __('Application Instruction') }}</label>
        <input class="form-control" name="application_instruction" type="text" id="application_instruction"
            value="{{ $val('application_instruction') }}" placeholder="Write the job title in the email subject line." />
    </div>

    <div class="form-group col-md-6 mb-2">
        <label for="image">{{ __('Image') }}</label>
        <input class="form-control" id="image" name="image" type="file" accept="image/*" />
        @if($job?->image)
            <div class="mt-2">
                <img src="{{ str_starts_with($job->image, 'http') ? $job->image : asset($job->image) }}" alt="{{ $job->title }}" height="60">
            </div>
        @endif
    </div>
    <div class="form-group col-md-3 mb-2">
        <label class="d-block">{{ __('Featured') }}</label>
        <input type="hidden" name="featured" value="0">
        <input type="checkbox" name="featured" value="1" id="featured" {{ $val('featured') ? 'checked' : '' }}>
        <label for="featured">{{ __('Show as featured') }}</label>
    </div>
    @if($job)
        <div class="form-group col-md-3 mb-2">
            <label for="status">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ $job->status?->value === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
