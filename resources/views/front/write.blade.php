@include("front.layout.header")
    <link rel="stylesheet" href="{{ asset('assets/css/head_foot.css') }}?v{{ get("css_version") }}">
    <link rel="stylesheet" href="{{ asset('assets/css/blog_detail.css') }}?v{{ get("css_version") }}">
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
                            <li class="breadcrumb-item active" aria-current="page">Write For Us</li>
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
                            <h1>{{ isset($data['title']) ? $data['title'] : ''}}</h1>
                        </div>
                        <hr class="hr-dual">
                        @php
                            $content = isset($data['content']) ? $data['content'] : '';
                            $tags = isset($data['meta_tags']) ? explode(',', $data['meta_tags']): "" ;
                             $titles = isset($data['title']) ? $data['title'] : "";
                             $id = isset($data['id'])? $data['id'] : 0;
                            $content = do_short_code($content, $id, 'about', $titles, $tags);
                            $ct = table_of_content($content);
                            $content = $ct['content'];
                            $tc = ['ct' => $ct['table']];
                            $table = View::make('front/temp/table-of-content', $tc)->render();
                            $content = str_replace('[[toc]]', $table, $content);
                            $content = lazy_content($content);
                            $content = replace_tag($content);
                        @endphp
                        {!! $content !!}
                    </article>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">

                    <!--Sidebar Starts-->
                    @include("front.sidebar.common")
                    <!--End Sidebar-->
                </div>
            </div>
        </div>
    </div>
    @include("front.layout.footer")
    @php
        $tviews = total_views(0, 0, get_postid('full'));
        refresh_views($tviews, 0, 0, get_postid('full'));
    @endphp
</body>

</html>
