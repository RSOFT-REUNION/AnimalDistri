<div class="row row-flex">
    @foreach($category_list as $category)
        <div class="col-12 col-md-3">
            <div class="content text-center category-container">
                <a class="text-decoration-none text-reset" href="/nos-produits/{{ $category->slug }}">
                    <img class="category-image" src="{{ getImageUrl('/upload/catalog/category/'.$category->image, 300, 300, 'fill-max') }}" alt="{{ $category->name }}">
                    <p class="category-title p-3 rounded-3 shadow">{{ $category->name }}</p>
                </a>
            </div>
        </div>
    @endforeach
</div>
