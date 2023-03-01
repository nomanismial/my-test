

@php
$count = substr($data["category"], -1);
$blogs = \App\Models\Blog::where('status' , 'publish')->orderBy('views', 'desc')->take(12)->get()->toArray();
$blogs = array_chunk($blogs, 4);
if ($count ==1) {
$blogs = isset($blogs[0])?$blogs[0]:array();
} elseif($count ==2) {
$blogs = isset($blogs[1])?$blogs[1]:array();
}elseif($count ==3) {
$blogs = isset($blogs[2])?$blogs[2]:array();
}else{
$blogs = isset($blogs[0]) ? $blogs[0] : array();
}
@endphp
@if (count($blogs)> 0)
<!--  Popular Post Starts-->
<section class="popular_post bg-light py-3 py-md-4 py-lg-5">
  <div class="container wrapper_con">
    <div class="row">
      <div class="col-12">
        <h2 class="first_cat_title text-center">{{ $data["title"] }}</h2>
        <div class="stroke-shape mb-lg-5 mb-md-3 mb-2"></div>
      </div>
    </div>
    <div class="row row-cols-1 row-cols-lg-2 g-3 my-2">
        @foreach ($blogs as $v)
        @php
        $title = unslash( $v['title'] );
        $short_title = ( strlen( $title ) > 75 ) ? substr( $title, 0, 140 ) . "...": $title;
        $content = trim(trim_words( clean_short_code($v['content']), 35 ));
        $content = trim(clean_short_code(html_entity_decode($content)));
        $content =  str_replace("\xc2\xa0",' ',$content);
        $image = $v['cover'];
        $date = date("d M Y", $v['date'] );
        $views =  $v['views'];
        $url = route('HomeUrl')."/".$v['slug']."-2".$v['id'];
        @endphp
      <div class="col">
        <div class="card h-100 mb-3 px-2 rounded-3">
          <div class="row g-0">
            <div class="col-3 col-sm-4 align-self-center position-relative">
              <a href="{{ $url }}"><img src="{{ asset('preeloader.gif') }}" data-src="{{ get_post_mid($image) }}" height="200" width="300" class="img-fluid rounded lazyload" alt="Popular Post Image">
              <div class="news__hover">
                <p class="news__hover-icon icon-link"> </p>
              </div></a>
            </div>
            <div class="col-9 col-sm-8">
              <div class="card-body">
                <a class="card-title" href="{{ $url }}">{{ $title }}</a>
                <p class="card-text">{!! trim(strip_tags($content)) !!}</p>
                <div class="card__footer p-0">
                  <div class="card__date"> <span class="card__icon icon-calendar" title="Published"> </span> <span class="card__text">{{$date}}</span> </div>
                  <div class="card__views"> <span class="card__icon icon-eye" title="Views"></span> <span class="card__text">{{ $views }}</span> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif
<!--Popular Post Ends-->
