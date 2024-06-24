<li class="list-group-item" data-id="{{ $category->id }}">
    <i class="fa-solid fa-arrows-alt"></i>&nbsp;{{ $category->name }}
    @if ($category->childrenCategories->isNotEmpty())
        <ul class="list-group sortable-subcategories">
            @foreach ($category->childrenCategories as $subCategory)
                @include('backend.catalog.category.order_item', ['category' => $subCategory])
            @endforeach
        </ul>
    @endif
</li>
