<div id="carousel" class="carousel slide mt-3 mb-4" data-bs-ride="carousel" data-aos="zoom-in"  data-aos-duration="600">
    <div class="carousel-inner">
        @php $len = count($sliders); @endphp
        @foreach($sliders as $index => $slide)
            <div class="carousel-item @if($index == 0) active @endif">
                <img src="/storage/upload/content/carousel/{{ $slide->image }}" class="d-block w-100" alt="{{ $slide->name }}">
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
