@if ($item->hasMedia('preview'))
    <img src="{{ url($item->getFirstMediaUrl('preview', 'preview_admin')) }}" class=" m-b-md img-fluid" alt="product_image">
@endif
