@include("front.layout.header")
    <link rel="stylesheet" href="{{ asset('assets/css/head_foot.css') }}?v{{ get("css_version") }}">
    <link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}?v{{ get("css_version") }}">
</head>

<body>
    @php
        $before_title = $cats['before_title'] != '' ? $cats['before_title'] : '';
        $before_details = $cats['before_details'] != '' ? $cats['before_details'] : '';
        $after_details = $cats['after_details'] != '' ? $cats['after_details'] : '';
        $popular_details = $cats['popular_details'] != '' ? $cats['popular_details'] : '';
        $popular_title = $cats['popular_title'] != '' ? "<h2 class='first_cat_title text-center'>" . $cats['popular_title'] . '</h2>' : '';
        $after_title = $cats['after_title'] != '' ? "<h2 class='first_cat_title text-center'>" . $cats['after_title'] . '</h2>' : '';
        $pg = (request()->has("page") !="") ? " [ Page ".request()->get("page")." ]" : "";
        $class = (request()->has("page") !="") ? "" : "py-3 py-md-4 py-lg-5";
        $clas = (request()->has("page")) ? "pt-3 pt-md-4 pt-lg-5" : "py-3 py-md-4 py-lg-5";
        $before_title = $cats['before_title'] != '' ? "<h1 class='first_cat_title text-center'>" . $cats['before_title'] .$pg. '</h1>' : '';
        $bf = $cats['before_popular'] != '' ? $cats['before_popular'] : 2;
        $st = $bf * 4;
        $aftr = $cats['after_popular'] != '' ? $cats['after_popular'] : 2;
        $nd = $aftr * 4;
        $c_url = $cats['id'] != '' ? get_catinfo($cats['id']) : '';

    @endphp
    @include("front.layout.main-menu")
    <div class="page-header">
        <div class="wrapper_con">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-start">
                            <li class="breadcrumb-item"><i class="icon-location2 me-2 me-sm-3"></i><a
                                    href="{{ route('HomeUrl') }}">Home</a></li>
                            @if ($c_url != null)
                                <li class="breadcrumb-item"><a href="{{ $c_url['url'] }}">{{ $c_url['title'] }}</a>
                                </li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--    On Page SEO-->
    <section class="first_category {{ $clas }}">
        <div class="container wrapper_con">
            <div class="row">
                <div class="col-12">
                    {!! $before_title !!}
                    <div class="stroke-shape mb-lg-5 mb-md-3 mb-2"></div>
                    @if(!request()->get("page"))
                    <div class="first_Cat_descp text-center text-muted mx-auto lh-base">
                        {!! $before_details !!}
                    </div>
                    @endif
                </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 my-2">
                @php
                    $blog = json_decode(json_encode($blogs), true);
                    // dd($blog["data"]);
                    $blog1 = array_slice($blog['data'], 0, $st);
                    $blog2 = array_slice($blog['data'], $st);
                @endphp
                @isset($blog1)
                    @foreach ($blog1 as $v)
                        @php
                            $title = unslash($v['title']);
                            $short_title = strlen($title) > 60 ? substr($title, 0, 160) . '...' : $title;
                            $content = trim(trim_words(html_entity_decode($v['content']), 35));
                            $content = clean_short_code(html_entity_decode($content));
                            $content = str_replace("\xc2\xa0", ' ', $content);
                            $image = $v['cover'];
                            $date = date('d M Y', $v['date']);
                            $views = $v['views'];
                            $url = route('HomeUrl') . '/' . $v['slug'] . '-2' . $v['id'];
                        @endphp
                        <div class="col">
                            <div class="card h-100 rounded-3">
                                <a href="{{ $url }}">
                                    <div class="image__ position-relative">
                                        <img src="{{ asset('preeloader.gif') }}"
                                            data-src="{{ get_post_mid($image) }}" width="300" height="200"
                                            class="img-fluid card-img-top lazyload" alt="{{ $title }}">
                                        <div class="news__hover">
                                            <p class="news__hover-icon icon-link"> </p>
                                        </div>
                                    </div>
                                </a>
                                <div class="card-body">
                                    <a href="{{ $url }}" class="card-title">{{ $short_title }}</a>
                                </div>
                                <hr class="hr-dual">
                                <div class="card__footer">
                                    <div class="card__date"> <span class="card__icon icon-calendar" title="Published">
                                        </span> <span class="card__text">{{ $date }}</span> </div>
                                    <div class="card__views"> <span class="card__icon icon-eye" title="Views"> </span> <span
                                            class="card__text">{{ $views }}</span> </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </section>
    <!--    On Page SEO Ends-->
    @if(!request()->get("page"))
    @if(count($res) > 0)
    <!--    Popular Post Starts-->
    <section class="popular_post bg-light {{ $class }}">
        <div class="container wrapper_con">
            @if(!request()->get("page"))
            <div class="row">
                <div class="col-12">
                    {!! $popular_title !!}
                    <div class="stroke-shape mb-lg-5 mb-md-3 mb-2"></div>
                    <div class="first_Cat_descp text-center text-muted lh-base">
                        {!! $popular_details !!}
                    </div>
                </div>
            </div>
            @endif
            <div class="row row-cols-1 row-cols-lg-2 g-3 my-2">
                @foreach ($res as $k => $v)
                    @php
                        $title = unslash($v->title);
                        $short_title = strlen($title) > 100 ? substr($title, 0, 100) . '...' : $title;
                        $content = trim(trim_words(html_entity_decode($v->content), 25));
                        $content = clean_short_code(html_entity_decode($content));
                        $content = str_replace("\xc2\xa0", ' ', $content);
                        $image = $v->cover;
                        $date = date('d M Y', $v->date);
                        $views = $v->views;
                        $url = route('HomeUrl') . '/' . $v->slug . '-2' . $v->id;
                    @endphp
                    <div class="col">
                        <div class="card h-100 mb-3 px-2 rounded-3">
                            <div class="row g-0">
                                <div class="col-3 col-sm-4 align-self-center position-relative">
                                    <a href="{{ $url }}"><img
                                            src="{{ asset('preeloader.gif') }}"
                                            data-src="{{ get_post_mid($image) }}" height="200" width="300"
                                            class="img-fluid rounded lazyload" alt="Popular Post Image">
                                        <div class="news__hover">
                                            <p class="news__hover-icon icon-link"> </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-9 col-sm-8">
                                    <div class="card-body">
                                        <a class="card-title" href="{{ $url }}">{{ $title }}</a>
                                        <p class="card-text">{!! trim(strip_tags($content)) !!}</p>
                                        <div class="card__footer p-0">
                                            <div class="card__date"> <span class="card__icon icon-calendar"
                                                    title="Published"> </span> <span
                                                    class="card__text">{{ $date }}</span> </div>
                                            <div class="card__views"> <span class="card__icon icon-eye"
                                                    title="Views"></span> <span
                                                    class="card__text">{{ $views }}</span> </div>
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
    @endif
    <!--Popular Post Ends-->
    <!--    SEO Tips-->
    @if(count($blog2) > 0)
        <section class="first_category {{ $class }}">
            <div class="container wrapper_con">
                @if(!request()->get("page"))
                <div class="row">
                    <div class="col-12">
                        {!! $after_title !!}
                        <div class="stroke-shape mb-lg-5 mb-md-3 mb-2"></div>
                        <div class="first_Cat_descp text-center text-muted mx-auto lh-base">
                           {!! $after_details !!}
                        </div>
                    </div>
                </div>
                @endif
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 my-2">
                    @foreach ($blog2 as $v)
                        @php
                            $title = unslash($v['title']);
                            $short_title = strlen($title) > 60 ? substr($title, 0, 160) . '...' : $title;
                            $content = trim(trim_words(html_entity_decode($v['content']), 35));
                            $content = clean_short_code(html_entity_decode($content));
                            $content = str_replace("\xc2\xa0", ' ', $content);
                            $image = $v['cover'];
                            $date = date('d M Y', $v['date']);
                            $views = $v['views'];
                            $url = route('HomeUrl') . '/' . $v['slug'] . '-2' . $v['id'];
                        @endphp
                        <div class="col">
                            <div class="card h-100 rounded-3">
                                <a href="{{ $url }}">
                                    <div class="image__ position-relative">
                                        <img src="{{ asset('preeloader.gif') }}"
                                            data-src="{{ get_post_mid($image) }}" width="300" height="200"
                                            class="img-fluid card-img-top lazyload" alt="{{ $title }}">
                                        <div class="news__hover">
                                            <p class="news__hover-icon icon-link"> </p>
                                        </div>
                                    </div>
                                </a>
                                <div class="card-body">
                                    <a href="{{ $url }}" class="card-title">{{ $short_title }}</a>
                                </div>
                                <hr class="hr-dual">
                                <div class="card__footer">
                                    <div class="card__date"> <span class="card__icon icon-calendar" title="Published">
                                        </span> <span class="card__text">{{ $date }}</span> </div>
                                    <div class="card__views"> <span class="card__icon icon-eye" title="Views"> </span> <span
                                            class="card__text">{{ $views }}</span> </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!--    SEO Tips Ends-->
    {{ $blogs->links('front.layout.pagination') }}
    @php
        $tviews = total_views(get_postid('post_id'), get_postid('page_id'), 'blogs-category');
        refresh_views($tviews, get_postid('post_id'), get_postid('page_id'), 'blogs-category');
    @endphp
    @include("front.layout.footer")
</body>

</html>
