@include("front.layout.header")
    <link rel="stylesheet" href="{{ asset('assets/css/head_foot.css') }}?v{{ get("css_version") }}">
    <link rel="stylesheet" href="{{ asset('assets/css/privacy.css') }}?v{{ get("css_version") }}">
</head>
<body>
@include("front.layout.main-menu")
<div class="page-header">
   <div class="wrapper_con">
      <div class="row">
         <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb float-start">
                    <li class="breadcrumb-item"><i class="icon-location2 me-2 me-sm-3"></i><a href="{{ route('HomeUrl') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
                </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<!--Starts Terms Content Section -->

<section class="section__terms my-3">
  <div class="container">
    <div class="row">
      <div class="wrapper main__article">
        @php
            $content = isset($data["content"] ) ? $data["content"]: "";
        @endphp
            {!! $content !!}
      </div>
    </div>
  </div>
</section>
<!--end about Content Section -->
  @php
    $tviews = total_views( 0 , 0 , get_postid("full"));
    refresh_views($tviews , 0,  0 , get_postid("full"));
  @endphp
@include("front.layout.footer")
</body>
</html>
