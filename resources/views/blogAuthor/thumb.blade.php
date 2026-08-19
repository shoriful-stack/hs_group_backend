<div class="image-container">
    <img src="{{ asset($row->photo) }}" class="thumb" height="25" alt="{{ $row->name }}"/>
    <div class="preview">
        <img src="{{ asset($row->photo) }}" height="100" title="{{ $row->name }}"/>
    </div>
</div>
