<div class="image-container">
    <img src="{{ asset($row->thumb_image) }}" class="thumb" height="25" alt="{{ $row->name }}" />
    <div class="preview">
        <img src="{{ asset($row->background_image) }}" height="60" title="{{ $row->name }}" />
    </div>
</div>
