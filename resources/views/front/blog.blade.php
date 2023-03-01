@include("front.layout.header")
    <link rel="stylesheet" href="{{ asset('assets/css/head_foot.css') }}?v{{ get("css_version") }}">
    <link rel="stylesheet" href="{{ asset('assets/css/blog_detail.css') }}?v{{ get("css_version") }}">
</head>

<body>
    @include("front.layout.main-menu")
    @php
        $post_id = get_postid('post_id');
        $tviews = total_views(get_postid('post_id'), get_postid('page_id'), 'blogs-detail');
        $title = $blog['title'] != '' ? '<h1>' . $blog['title'] . '</h1>' : '';
        $views = $blog['views'] != '' ? '<span class="icon-eye"></span> ' . $tviews : '';
        $date = $blog['date'] != '' ? '<span class="icon-calendar"></span> Updated: ' . date('d M Y', $blog['date']) : '';
        $content = $blog['content'] != '' ? $blog['content'] : '';
        $cat = $blog['category_id'] != '' ? (array) get_catByname($blog['category_id']) : '';
        $c_url = $blog['category_id'] != '' ? get_catinfo($blog['category_id']) : '';

        $c_title = isset($cat['title']) ? $cat['title'] : '';
        $InternalLinks = new \App\Helpers\InternalLinks();
        $i_tags = $InternalLinks->allDBLinks();
    @endphp
    <div class="page-header">
        <div class="wrapper_con">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><i class="icon-location2 me-2 me-sm-3"></i><a
                                    href="{{ route('HomeUrl') }}">Home</a></li>
                            @if ($c_url != null)
                                <li class="breadcrumb-item"><a href="{{ $c_url['url'] }}">{{ $c_url['title'] }}</a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">{{ $blog['title'] }}</li>
                            @isset (auth("admin")->user()->id)
                            <li class="breadcrumb-item _edit">
                                <a href="{{ route('HomeUrl')."/".admin."/blogs?edit=".$post_id }}" style="float: right;color: red;" target="_blank">Edit</a>
                            </li>
                            @endisset
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="blog-details py-3 py-sm-4 py-md-5">
        <div class="wrapper_con">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
                    <article class="blog_detail">
                        <!-- Title -->
                        <div class="title-head">
                            {!! $title !!}
                        </div>
                        <!-- Post views -->
                        <hr class="hr-dual">
                        <div class="blog_views d-flex justify-content-between">
                            <p data-title="Published">
                                {!! $date !!} </p>
                            <p data-title="Views"> {!! $views !!}</p>
                        </div>
                        <hr class="hr-dual">
                        @php
                            $tags = explode(',', $blog['meta_tags']);
                            $titles = $blog['title'];
								$content = str_replace('[[urdu]]','<div class="_urdu">',$content);
								$content = str_replace('[[/urdu]]','</div>',$content);
                            $content = do_short_code($content, $blog['id'], 'blogs', $titles, $tags);
                              if(strpos($content , "[[auto-toc]]") >= 0){
                                $ct = toc($content);
                                $content = $ct['content'];
                                $tc = ['ct' => $ct['table']];
                                $table = View::make('front/temp/table-of-content', $tc)->render();
                                $content = str_replace('[[auto-toc]]', $table, $content);
                            }else{
                                if(strpos($content , "[[toc]]")){
                                    $ct = table_of_content($content);
                                    $content = $ct['content'];
                                    $tc = ['ct' => $ct['table']];
                                    $table = View::make('front/temp/table-of-content', $tc)->render();
                                    $content = str_replace('[[toc]]', $table, $content);
                                }
                            }

                            $content = $InternalLinks->building($blog['id'], $content, $i_tags);
                            $content = lazy_content($content);
                            preg_match_all("@\[([^<>&/\[\]=]++)@", $content, $new_matchs);
                            if(isset($new_matchs[1][0])){
                                $nm_t = $new_matchs[1][0];
                                $content = str_replace("[[$nm_t]]" ,"", $content);
                                $content = str_replace("[[/$nm_t]]" ,"", $content);

                            }
							$content = replace_tag($content);
                        @endphp
                        {!! $content !!}
                        <hr class="line-hr">
                    </article>
                    @php
                        $author_id[] = $blog['author_id'];
                    @endphp
                    @if ($blog['author_id'] > 0)
                        @include( "front.temp.author" , $author_id )
                    @endif
                    <!-- FB PLUGIN CODE -->
                    <!-- facebook comments starts -->
                    <div class="fb-comments-plugin" id="fb-commentbox">
                        <h6 class="comment-title text-center"> <u><i>Please Write Your Comments</i> </u></h6>
                        <!--              <div id="fb-root"></div>-->
                        <div class="fb-comments" data-href="{{ url()->full() }}" data-numposts="5" data-width="100%"
                            data-order-by="reverse_time"></div>
                    </div>
                    <!-- facebook comments ends -->
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3 position-relative">
                    <!--Sidebar Starts-->
                    @include("front.sidebar.common")
                    <!--End Sidebar-->
                </div>
            </div>
        </div>
    </div>
    @include("front.layout.footer")

    @php
        refresh_views($tviews, get_postid('post_id'), get_postid('page_id'), 'blogs-detail');
    @endphp

</body>

</html>
