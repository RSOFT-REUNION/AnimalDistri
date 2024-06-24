<tr>
    <td class="text-center">{{ $child_category->id }}</td>
    <td class="text-center align-middle">
        @if($child_category->image != null)
            <img src="{{ getImageUrl('/upload/catalog/category/'.$child_category->image, 50, 50) }}" alt="{{ $child_category->name  }}">
        @endif
    </td>
    <td><i class="fa-light fa-turn-down-right"></i> {{ $child_category->name }}</td>
    <td> {{ $child_category->slug }}</td>
    <td>{{ $category->getCategoryName($child_category->category_id) }}</td>
    <td  class="text-center align-middle">{{ count($child_category->products) }}</td>
    <td  class="text-center align-middle">{{ getActive($child_category->is_menu) }}</td>
    <td  class="text-center align-middle">{{ getActive($child_category->active) }}</td>
    <td class="text-center">
        @can('catalog.categories.modifier')
            <a href="{{ route('backend.catalog.categories.edit', $child_category->id) }}"
               class="btn btn-success btn-sm hvr-grow" title="Modifier"><i
                    class="fa-solid fa-pen-to-square"></i></a>
        @endcan
        @can('catalog.categories.delete')
            <button type="button" class="btn btn-danger btn-sm hvr-grow"
                    title="Supprimer"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal{{ $child_category->id }}">
                <i class="fa-solid fa-trash"></i>
            </button>
        @endcan
    </td>
</tr>
@foreach ($child_category->categories as $childCategory)
    @include('backend.catalog.category.child_category', ['child_category' => $childCategory])
    @include('backend.layouts.modal-delete', ['id' => $childCategory->id, 'title' => 'Etes-vous sûr de vouloir supprimer '.$childCategory->name.' et toutes les sous-catégories ?', 'route' => 'backend.catalog.categories.destroy'])
@endforeach
