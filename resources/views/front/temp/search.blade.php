@include("front.layout.header")
<link rel="stylesheet" href="assets/css/head_foot.css">
<link rel="stylesheet" href="assets/css/blog.css">
<style>
	.error-page-box .error-title {
  font-size: 40px;
  font-weight: 300;
  color: #111111;
  margin-bottom: 26px;
  line-height: 1.2;
}
.error-page-box p {
  width: 70%;
  margin: 0 auto 55px;
  color: var(--title-color);
}
.error-page-box .error-newsletter .stylish-input-group {
  border: 1px solid #d7d7d7;
  height: 60px;
  border-radius: 4px;
  padding: 0 1rem;
  max-width: 540px;
  margin: 50px auto;
}
.error-page-box .error-newsletter .stylish-input-group .form-control {
  border: none;
  box-shadow: none;
  border-radius: 0;
  background: transparent;
  color: #111111;
  font-size: 14px;
  height: 60px;
}
.error-page-box .error-newsletter .stylish-input-group .input-group-addon {
  display: flex;
  padding: 0;
  border: none;
  border-radius: 0;
  background: transparent !important;
}
.error-page-box .error-newsletter .stylish-input-group .input-group-addon button {
  cursor: pointer;
  background: transparent;
  border: 0;
  -webkit-transition: all 0.5s ease-out;
  -moz-transition: all 0.5s ease-out;
  -ms-transition: all 0.5s ease-out;
  -o-transition: all 0.5s ease-out;
  transition: all 0.5s ease-out;
}
.error-page-box .error-newsletter .stylish-input-group .input-group-addon button i:before {
  color: #646464;
  font-size: 20px;
  font-weight: 700;
  margin-left: 0;
  -webkit-transition: all 0.5s ease-out;
  -moz-transition: all 0.5s ease-out;
  -ms-transition: all 0.5s ease-out;
  -o-transition: all 0.5s ease-out;
  transition: all 0.5s ease-out;
}
</style>
</head>

<body>
    @include("front.layout.main-menu")
    <div class="page-header">
        <div class="wrapper_con">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-start">
                            <li class="breadcrumb-item"><i class="icon-location2 me-2 me-sm-3"></i><a
                                    href="{{ route('HomeUrl') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('search') }}">Search</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $where }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--  On Page SEO-->
    <section class="first_category py-3 py-md-4 py-lg-5">
        <div class="container wrapper_con">
            @if (count($data) == 0)
               <div class="row error-page-box">
      <div class="col-12 col-md-12 col-lg-12 text-center">
        <p class="error-title"><span class="text-danger">Sorry!! </span> There is No Record Found
                            Related to Your Search</p>
		  <form role="search" action="/search">
        <div class="error-newsletter">
          <div class="input-group stylish-input-group">
            <input type="search" name="q" class="form-control" value="{{ (request()->has('q')) ? request()->get('q') : "" }}" placeholder="SEARCH KEYWORDS . . .">
            <span class="input-group-addon">
            <button type="submit"> <i class="icon-search"></i> </button>
            </span> </div>
        </div>
		  </form> </div>
      
  </div>
            @endif
            @if (count($data) > 0)
                <div class="row">
				  <div class="col-12 text-center mb-4">
                        <h2 class="first_cat_title"> <span class="text-danger">Result For  </span>"{{ ucfirst(str_replace("-" , " " , $where )) }}"</h2>
                    </div>
				</div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 my-2 append-row">
                    @foreach ($data as $v)
                        @php
                            $title = unslash($v->title);
                            $short_title = strlen($title) > 60 ? substr($title, 0, 160) . '...' : $title;
                            $content = trim(trim_words(html_entity_decode($v->content), 35));
                            $content = clean_short_code(html_entity_decode($content));
                            $image = $v->cover;
                            $date = date('d M Y', $v->date);
                            $views = $v->views;
                            $url = route('HomeUrl') . '/' . $v->slug . '-2' . $v->id;

                        @endphp
                        <div class="col">
                            <div class="card h-100 rounded-3">
                                <a href="{{ $url }}">
                                    <div class="image__ position-relative">
                                        <img src="{{ get_post_mid($image) }}" width="300" height="200"
                                            class="img-fluid card-img-top" alt="{{ $title }}">
                                        <div class="news__hover">
                                            <p class="news__hover-icon icon-link"> </p>
                                        </div>
                                    </div>
                                </a>
                                <div class="card-body">
                                    <a href="{{ $url }}" class="card-title">{{ $title }}</a>
                                </div>
                                <hr class="hr-dual">
                                <div class="card__footer">
                                    <div class="card__date"> <span class="card__icon icon-calendar" title="Published">
                                        </span> <span class="card__text">{{ $date }}</span> </div>
                                    <div class="card__views"> <span class="card__icon icon-eye" title="Views"> </span>
                                        <span class="card__text">{{ $views }} </span> </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if (count($data) > 3)
                    @isset ($v->id)
                     <div class="col-12 text-center viewMore mt-5 button-column"> <a id="btn-load" data-id="{{ isset($v->id)? $v->id : 0 }}" data-query="{{ (Request::has('q')) ? Request::get('q') : "" }}" class="hvr-radial-out"> View More <span class="icon-arrow-right2"></span></a> </div>
                    @endisset
                @endif

            @endif
        </div>
    </section>
    <!--  On Page SEO Ends-->

    @include("front.layout.footer")
</body>

</html>
