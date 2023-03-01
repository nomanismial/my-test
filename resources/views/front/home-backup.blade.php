@include( 'front.layout.header' )
<link rel="stylesheet" href="assets/css/head_foot.css?v{{ get("css_version") }}">
<link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
<div class="wrapper">
    @include( 'front.layout.topbar' )
    @php
        $home = \App\Models\Homedata::all()->map->toArray();
        $meta = $home[0]['home_meta'];
        $design = $home[0]['home_design'];
        $slider = $home[0]['slider_images'];
        $meta = json_decode($meta);
        $design = json_decode($design);
        $slider = json_decode($slider);

    @endphp
	@if (\Jenssegers\Agent\Facades\Agent::isDesktop())
    <header class="bd-header">
	@if (count($slider) > 1)
		<div class="owl-slider">
			<div id="carousel" class="owl-carousel">
				@foreach ($slider as $k => $v)
                @php
                $img = $v;
                @endphp
				<div class="item">
					<img  src="{{ $img }}" width="1350" height="450" alt="Xray Blog Slider Image">
				</div>
				@endforeach
			</div>
		</div>
	@else
		@if (count($slider) >0)
        @php
            $img = $slider[0];
        @endphp
            @if (!empty($img))
            <div class="container-fluid p-0 center-align"> <img src="{{ $img }}" width="1350" height="450"  class="img-fluid" alt="{{ get_alt($img) }}"> </div>
            @endif
        @endif

	@endif
    </header>
	@endif
    @php
    foreach ($design as $key => $v) {
    $data = array(
        'num' => $key ,
        'title' => $v->title ,
        'category' => $v->category
        );
    if (is_numeric(trim($v->category))) {
        @endphp
            @include( "front.home-section.category" , $data)
        @php
    } else {
            @endphp
                @include( "front.home-section.popular" , $data)
            @php

        }
    }
    @endphp
    @php
        $row = \App\Models\Homedata::select('views')->first();
        refresh_views($row['views'] , 0 , 5 , get_postid('full'));
    @endphp
</div>
    @include('front.layout.footer')
