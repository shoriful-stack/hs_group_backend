@if($type === 'main' && $row->main_image)
    <div class="image-container">
        <img src="{{ asset($row->main_image) }}" class="thumb" height="25" alt="{{ $row->title }} Main" />
        <div class="preview">
            <img src="{{ asset($row->main_image) }}" height="60" title="{{ $row->title }} Main" />
        </div>
    </div>
@endif

@if($type === 'sub' && $row->sub_image)
    <div class="image-container">
        <img src="{{ asset($row->sub_image) }}" class="thumb" height="25" alt="{{ $row->title }} Sub" />
        <div class="preview">
            <img src="{{ asset($row->sub_image) }}" height="60" title="{{ $row->title }} Sub" />
        </div>
    </div>
@endif
