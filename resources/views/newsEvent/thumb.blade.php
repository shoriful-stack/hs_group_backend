<div class="image-container">
    <img src="{{ str_starts_with($row->image, 'http') ? $row->image : asset($row->image) }}" class="thumb" height="25" alt="{{ $row->title }}"/>
    <div class="preview">
        <img src="{{ str_starts_with($row->image, 'http') ? $row->image : asset($row->image) }}" height="100" title="{{ $row->title }}"/>
    </div>
</div>
