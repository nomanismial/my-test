@include('front.layout.header')
 	<link rel="preload stylesheet" href="{{ asset('assets/css/head_foot.css') }}?v{{ get("css_version") }}" as="style" type="text/css" crossorigin="anonymous">
	<link rel="preload stylesheet" href="{{ asset('assets/css/index.css') }}?v{{ get("css_version") }}" as="style" type="text/css" crossorigin="anonymous">
</head>
<body>

 @include('front.layout.main-menu')

@if (count($slider) > 0)
<!--	Slider-->
<div class="mainSlider d-none d-sm-block">
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      @foreach ($slider as $k => $v)
      @php
        $class = ($k==0)?"class=active" : "";
      @endphp
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $k }}" {{ $class }} aria-current="true" aria-label="Slide {{ $k }}"></button>
      @endforeach
    </div>
<!--	image Size 1300 x 450 -->
    <div class="carousel-inner">
	@foreach ($slider as $k => $v)
	@php
		$img = $v;
		$class = ($k==0)?"active" : "";
	@endphp
    <div class="carousel-item {{ $class }}">
		<img src="{{ get_post_thumbnail($img) }}" onload="this.onload=null;this.src='{{ get_image($img) }}'"  width="1300" height="450" class="w-100 img-fluid" alt="{{ get_alt($img) }}">
	</div>
			@endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev"> 		<span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next"> 		<span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span> </button>
  </div>
</div>
<!--	Slider Ends-->
@endif
	@php

    foreach ($design as $key => $v) {
    $data = array(
        'num' => $key ,
        'title' => $v->title ,
        'category' => $v->category
    );
	if($v->category != ""){
		if (is_numeric(trim($v->category))) {
			@endphp
				@include( "front.home-section.category" , $data)
			@php
		}else{
			@endphp
				@include( "front.home-section.popular" , $data)
			@php
			}
		}
	}

    @endphp
    @php
        $tviews = total_views(  0,  0 , "home");
        refresh_views($tviews , 0 , 0 , "home");
    @endphp
 @include('front.layout.footer')
</body>
</html>

