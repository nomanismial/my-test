@include("front.layout.header")
<link rel="stylesheet" href="assets/css/head_foot.css?v{{ get("css_version") }}">
<link rel="stylesheet" href="{{ asset('assets/css/404.css') }}">
</head><body>
@include("front.layout.main-menu")
<section class="error-page-wrap">
  <div class="container">
    <div class="row error-page-box">
      <div class="col-12 col-md-12 col-lg-8 text-center">
        <div class="error-logo"> <img src="{{ asset('assets/images/404.png') }}" width="400" height="250" alt="error"> </div>
        <p class="error-title">Sorry! Page Not Found!</p>
		  <form role="search" action="/search">
        <div class="error-newsletter">
          <div class="input-group stylish-input-group">
            <input type="search" name="q" class="form-control" placeholder="SEARCH KEYWORDS . . .">
            <span class="input-group-addon">
            <button type="submit"> <i class="icon-search"></i> </button>
            </span> </div>
        </div>
		  </form>
        <a href="{{ route("HomeUrl") }}" class="hvr-radial-out">GO TO HOME</a> </div>
      <div class="col-12 col-md-12 col-lg-4 mt-4 mt-lg-0"> @php
        $blogs = \App\Models\Blog::where('status', 'publish')
        ->orderBy('views', 'desc')
        ->take(5)
        ->get();
        @endphp
        <div class="sidebar-widget">
          <div class="tab-content">
            <h4 class="widget-title">Author's Choice</h4>
            <div class="stroke-shape"></div>
            <ul class="post_list">
              @foreach ($blogs as $v)
              @php
              $title = unslash($v->title);
              $short_title = strlen($title) > 60 ? substr($title, 0, 160) . '...' : $title;
              $content = trim(trim_words(html_entity_decode($v->content), 35));
              $content = clean_short_code(html_entity_decode($content));
              $image = $v->cover;
              $date = date('d M Y', $v->date);
              $views = total_views($v->id);
              $url = route('HomeUrl') . '/' . $v->slug . '-2' . $v->id;
              @endphp
              <li>
                <div class="post_img">
                  <!-- side image -->
                  <a href="{{ $url }}"> <img src="{{ asset('preeloader.gif') }}" data-src="{{ get_post_thumbnail($image) }}" height="70" width="70" class="img-thumbnail lazyload" alt="{{ $title }}"> </a> </div>
                <!-- side info -->
                <div class="post_info"> <a href="{{ $url }}" class="line-clamp-2">{{ $title }}</a>
                  <p title="Published"><span class="icon-calendar"></span> <span>{{ $date }}</span></p>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
          <!-- end -->
        </div>
      </div>
    </div>
  </div>
</section>
@include("front.layout.footer")
</body>
</html>
