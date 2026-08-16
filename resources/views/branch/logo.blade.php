<div class="image-container">
    <img src="{{ asset($row->image) }}" class="thumb" height="25" alt="{{ $row->name }}"/>
    <div class="preview">
        <img src="{{ asset($row->image) }}" height="60"  title="{{ $row->name }}"/>
    </div>
</div>
