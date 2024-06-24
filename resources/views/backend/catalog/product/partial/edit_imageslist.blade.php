@include('backend.layouts.head')

<div id="images_list" class="pt-1 ps-3 pe-3">

    <form id="imageform" hx-encoding='multipart/form-data'
          hx-post='{{ route('backend.catalog.products.add_image', $product) }}'
          hx-target="#images_list"
          hx-swap="outerHTML">
        @csrf
        <div class="input-group mb-4 mt-4 w-50 mx-auto hvr-float-shadow">
            <input type="file" accept=".jpeg, .png, .jpg, .gif, .svg" name="images[]" id="images" multiple
                   class="@error('images') is-invalid @enderror form-control"
                   value="{{ old('images') }}"></input>
            <button class="btn btn-success">
                <i class="fa-solid fa-plus"></i> Ajouter
            </button>
            @error('images')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </form>

    <form> @csrf  @method('PUT')
        <div class="row row-flex">
            @foreach($product->images as $image)
                <div class="col-md-2 col-6 mb-3 text-center">
                    <div id="image{{ $image->id }}" class="content">
                        <img src="{{ getImageUrl('/images/upload/catalog/products/'.$product->id.'/'.$image->name, 200) }}"
                             alt="{{ $image->name }}" class="w-auto mx-auto d-block mb-3" style="max-height: 150px;">
                        <button type="button" class="btn btn-danger"
                                hx-delete="{{ route('backend.catalog.products.destroy_image', $image) }}"
                                hx-target="#image{{ $image->id }}"
                                hx-swap="delete"
                                hx-indicator="#spinner{{ $image->id }}"
                        ><i class="fa-regular fa-trash"></i>
                        </button>

                        @if($image->id != $product->fav_image)
                            <button type="button" class="btn btn-primary" id="fav_image"
                                    hx-post="{{ route('backend.catalog.products.fav_image', $image) }}"
                                    hx-target="#images_list"
                                    hx-swap="outerHTML"
                            ><i class="fa-regular fa-star"></i></button>
                        @else
                            <div class="btn btn-primary "><i class="fa-solid fa-star"></i></div>
                        @endif
                    </div>
                    <span id="spinner{{ $image->id }}" class="htmx-indicator spinner-border spinner-border-sm"
                          role="status" aria-hidden="true"></span>
                </div>
            @endforeach
        </div>
    </form>
</div>


@include('backend.layouts.script')
