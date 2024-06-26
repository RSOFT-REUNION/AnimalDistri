<div id="carousel" class="carousel slide mb-4" data-bs-ride="carousel" data-aos="zoom-in"  data-aos-duration="600">
    <div class="carousel-inner">
        @php $len = count($sliders); @endphp
        @foreach($sliders as $index => $slide)
            <div class="carousel-item @if($index == 0) active @endif">
                <img src="{{ getImageUrl('/upload/content/carousel/'.$slide->image, 1920, 600, 'crop') }}" alt="{{ $slide->name }}">
                {{--@if($slide->description)
                    <div class="carousel-caption d-none d-md-block" >
                        <div class="card bg-primary p-5 shadow-xl">
                            <p>{{ $slide->description }}</p>
                        </div>
                    </div>
                @endif--}}
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
