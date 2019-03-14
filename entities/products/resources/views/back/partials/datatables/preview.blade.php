@if ($item->hasMedia('preview'))
    <img src="{{ url($item->getFirstMediaUrl('preview', 'preview_admin')) }}" class=" m-b-md img-responsive" alt="product_image">
@endif
