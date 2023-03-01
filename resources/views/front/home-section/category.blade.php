
 @php
  $limit = _getLimit("home_popular" , $data['category']);
//   dd($limit);
  $limit = $limit*4;
  $cat = get_catinfo($data['category']);
  $catHomeTitle = isset($cat["home_title"])?$cat["home_title"]:"";
  $blogs = \App\Models\Blog::orderBy('id', 'desc')->where('status' , 'publish')->whereRaw("FIND_IN_SET(?, category_id) > 0", $data['category'])->take($limit)->get();
  $heading = ( isset($data['num']) && $data['num'] == 0) ? '<h1 class="first_cat_title text-center">'.$catHomeTitle.'</h1><div class="stroke-shape mb-lg-5 mb-md-3 mb-2"></div>' : '<h2 class="first_cat_title text-center">'.$catHomeTitle.'</h2><div class="stroke-shape mb-lg-5 mb-md-3 mb-2"></div>' ;

@endphp
<!--  On Page SEO-->
@if (count($blogs) > 0)
  <section class="first_category py-5">
  <div class="container wrapper_con">
    <div class="row">
      <div class="col-12">
        {!! $heading !!}
        <div class="first_Cat_descp text-center text-muted mx-auto lh-base">
          {!! $cat['home_details'] !!}
        </div>
      </div>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 my-2">
      @foreach ($blogs as $k => $v)
      @php
        $nu = $k+1;
        $title = unslash( $v->title );
        $short_title = ( strlen( $title ) > 100 ) ? substr( $title, 0, 100 ) . "...": $title;
        $content = trim(trim_words( html_entity_decode($v->content), 35 ));
        $content = clean_short_code(html_entity_decode($content));
        $content =  str_replace("\xc2\xa0",' ',$content);
        $image = $v->cover;
        $date = date("d M Y", $v->date );
        $views =  $v->views;
        $url = route('HomeUrl')."/".$v->slug."-2".$v->id;
		    get_post_mid($image);
      @endphp
      <div class="col">
        <div class="card h-100 rounded-3">
            <a href="{{ $url }}">
              <div class="image__ position-relative">
                <img src="{{ asset('preeloader.gif') }}" data-src="{{ get_post_mid($image) }}" width="300" height="200" class="img-fluid card-img-top lazyload" alt="{{ $title }}">
                <div class="news__hover">
                <p class="news__hover-icon icon-link"> </p> </div>
              </div>
            </a>
            <div class="card-body">
              <a href="{{$url}}" class="card-title">{{$short_title}}</a>
            </div>
            <hr class="hr-dual">
            <div class="card__footer">
              <div class="card__date"> <span class="card__icon icon-calendar" title="Published"> </span> <span class="card__text">{{$date}}</span> </div>
              <div class="card__views"> <span class="card__icon icon-eye" title="Views"> </span> <span class="card__text">{{ $views  }}</span> </div>
            </div>
          </div>
      </div>
      @endforeach
    </div>
    @if (_getCatPostCount($data['category']) > $limit)
      <div class="col-12 text-center viewMore mt-5"> <a href="{{ $cat['url'] }}" class="hvr-radial-out"> View More <span class="icon-arrow-right2"></span></a> </div>
    @endif

  </div>
</section>
@endif

<!--  On Page SEO Ends-->
