<!doctype html>
<html amp lang="en">

<head>
    @php
        $page_name = get_postid2("full");
        $page_id = get_postid2("page_id");
        $post_id = get_postid2("post_id");
        $setting = \App\generalsetting::first();
        $favicon =  (isset($setting->favicon)) ? $setting->favicon : "";
        $google_analytics =  (isset($setting->google_analytics)) ? $setting->google_analytics : "";
        $web_master =  (isset($setting->web_master)) ? $setting->web_master : "";
        $bing_master =  (isset($setting->bing_master)) ? $setting->bing_master : "";
        $og_image = (isset($setting->og)) ? $setting->og: "" ;
        $og_image =  $setting->og ;
        $r = \App\Models\Blog::find($post_id);
        $meta_title = isset($r->meta_title)?$r->meta_title:'';
        $meta_description = isset($r->meta_description)?$r->meta_description:'';
        $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
        $og_image = isset($r->og_image)?$r->og_image:$setting->og;
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $canonical = str_replace("/amp/" , "/" , Request::fullUrl() );
    @endphp
    <meta charset="utf-8" />
    <title>{{$meta_title}}</title>
    <meta name="theme-color" content="#4B9DD6"/>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="theme-color" content="#6773dd"/>
    <meta name="description" content="{{$meta_description}}">
    <meta name="keywords" content="{{ $meta_tags }}">
    <link href="{{$favicon}}" rel="shortcut icon" type="image/x-icon" />
    <link rel="canonical" href="{{ $canonical }}" />
    <meta property="og:url" content="{{ url('/'.$page_name) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
    <meta property="og:image" content="{{$og_image}}" />
    <meta name="twitter:card" content="photo">
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">
    <meta name="twitter:image" content="{{$og_image}}">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
    <script async custom-element="amp-facebook-comments" src="https://cdn.ampproject.org/v0/amp-facebook-comments-0.1.js"></script>
    <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
    <style amp-boilerplate>
        body {
            -webkit-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
            -moz-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
            -ms-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
            animation: -amp-start 8s steps(1, end) 0s 1 normal both
        }

        @-webkit-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @-moz-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @-ms-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @-o-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

    </style><noscript>
        <style amp-boilerplate>
            body {
                -webkit-animation: none;
                -moz-animation: none;
                -ms-animation: none;
                animation: none
            }

        </style>
    </noscript>
    <style amp-custom>
        @font-face {
            font-family: 'Roboto', sans-serif;
            src: url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap");
        }

        html {
            font-size: 1.4em;
            line-height: 1.65;
            font-family: 'Roboto', sans-serif;
            color: #2C2A29;
            background: #FBFBFB;
        }

        body {
            margin: 0;
            background: #EEEDE8;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            line-height: 1.1;
        }

        p {
            text-align: justify;
        }

        h1 {
            font-size: 1.3rem;
        }

        h2 {
            font-size: 1.1rem;
            color: #490080bd;
        }

        .d-flex {
            display: flex;
        }

        .flex-dir {
            flex-direction: row;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .list-style-disc {
            list-style: disc;
        }

        .list-style-decimal {
            list-style: decimal;
        }

        .bd-topnav {
            background: #4B9DD6;
            padding: 12px 0px;
        }

        .bd-container {
            padding: 0 60px;
            margin-left: 0;
            margin-right: 0;
        }

        .logo {
            width: 50%;
        }

        .site-main {
            display: flex;
        }

        .hamburger {
            width: 50%;
            text-align: right;
            font-size: 30px;
            color: #fff;
            outline: none;
            cursor: pointer;
        }
        .label .sidebar{
            padding: 0 5%;
        }
        #sidebar1 {
            background: #4B9DD6;
            color: #fff;
            width: 100%;
        }

        ul.sidebar {
            list-style: none;
            margin: 0;
        }

        ul.sidebar li {
            padding: 15px 5px;
        }

        ul.sidebar li:hover {
            background-color: #f1f1f1;
        }

        ul.sidebar li:hover a {
            color: #54585A;
        }

        ul.sidebar li:not(:last-child) {
            border-bottom: 1px solid #fff;
        }

        ul.sidebar li a {
            text-decoration: none;
            font-size: 20px;
            font-weight: 600;
            color: #fff;
        }

        .dropdown h4 {
            text-decoration: none;
            background-color: transparent;
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            border: none;
            outline: none;
            padding: 5px 5px;
        }

        ul.sidebar li:hover .dropdown h4 {
            color: #54585A;
        }

        .close-sidebar {
            margin: 4px 0px;
            padding: 4px 0px;
            border: 2px solid #fff;
            border-radius: 10px;
            width: 50px;
            text-align: center;
            margin-left: auto;
            cursor: pointer;
            outline: none;
        }

        .wrapper {
            display: grid;
            grid-template-columns: 1fr;
            grid-gap: 1em;
        }

        .icon i {
            color: #4B9DD6;
        }

        @media only screen and (max-width: 576px) {
            .wrapper {
                display: grid;
                grid-template-columns: 7fr;
                grid-gap: 1em;
            }

            .bd-container {
                padding: 0 10px;
                margin-left: 0;
                margin-right: 0;
            }

            .flex-dir {
                flex-direction: column;
            }

            .author-box {
                display: grid;
                grid-template-columns: 1fr;
                box-sizing: border-box;
                box-shadow: 0 0 10px lightgrey;
                padding: 20px;
                margin: 35px 0 0;
                border: 1px solid rgba(155, 155, 155, 0.17);
            }
        }

        span.share-text {
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 600;
        }

        .wrapper main.main-content {
            background: #fff;
            border-top: 3px solid #4B9DD6;
            border-radius: 5px;
            padding: 5px 15px;
            margin: 32px 0px;
        }

        .bd-sngtitle-bottom {
            margin: 10px 0;
            padding: 20px 0px;
            border-top: 1px solid #E7E5E5;
            border-bottom: 1px solid #E7E5E5;
        }

        /*Table of Content*/
        .tb-content {
            background-image:url({{ route('HomeUrl') }}/assets/images/post-bg.webp);
        background-size:cover;
        padding-bottom:15px;
        border:2px solid #ccc;
        margin-top:25px
        }

        background-size: cover;
        margin-top: 26px;
        padding-bottom: 15px;
        border: 2px solid #ccc
        }

        .tb-content legend {
            margin-left: 20px;
            font-weight: 700;
            text-transform: capitalize;
            left: 50%;
            color: #191919;
            font-size: 22px;
            padding: 0 10px;
            max-width: 35%
        }

        @media only screen and (max-width: 576px) {
            .tb-content {
                margin-top: 26px;
                padding-bottom: 15px;
                padding-left: 10px;
            }

            .tb-content legend {
                margin-left: 15px;
                font-weight: 700;
                padding: 0 10px;
                max-width: 80%
            }
        }

        .tb-content li a {
            color: #343a40;
        }

        .tb-content .outer {
            width: 100%;
            padding: 10px 0px;
            margin: -30px 0px;
        }

        .tb-content ol {
            counter-reset: item
        }

        .tb-content li:before {
            content: counters(item, ".") "-";
            color: #076785;
            font-size: 18px;
            display: table-cell;
            text-align: right;
            padding: 2px 0px;
            counter-increment: item;
        }

        .tb-content ol li {
            display: table;
            padding: 2px 0;
            transition: transform 0.4s;
        }

        .tb-content ol.outer>li {
            padding: 2px 0px;
        }

        .tb-content ol a {
            color: #076785;
            display: inline;
            font-weight: 500;
            font-size: 18px;
            padding: .5rem 0rem;
            text-decoration: none;
        }

        .tb-content .nav-link:hover {
            color: #81da9e;
            transition: all 250ms ease;
        }

        .tb-content li:hover {
            transform: translateX(10px);
        }

        .tb-content .outer .nested-1 {
            padding: 2px 0px;
        }

        .tb-content .outer .nested-2 {
            padding: 2px 0px;
        }

        .bg-dark {
            background-color: #343a40;
        }

        table {
            border-collapse: collapse
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529
        }

        .table td,
        .table th {
            padding: .2rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table th {
            font-size: 24px;
            font-weight: 500;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6
        }

        .table-sm td,
        .table-sm th {
            padding: .3rem
        }

        .table-bordered {
            border: 1px solid #dee2e6
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 2px
        }

        table.tbl-border {
            border-radius: 10px;
            border-collapse: 0;
        }

        table.tbl-dark {
            border: 3px solid #343a40;
        }

        table.tbl-green {
            border: 3px solid #28a745
        }

        table.tbl-red {
            border: 3px solid #dc3545;
        }

        .bg-red {
            background: #dc3545;
            color: #fff;
        }

        .bg-dark {
            background: #343a40;
            color: #fff;
        }

        .bg-green {
            background: #28a745;
            color: #fff;
        }

        .content-image {
            width: 75%;
            margin: 10px auto;
        }

        blockquote {
            position: relative;
            background: #e9e9e9;
            margin: 2px;
            padding: 12px 1rem 12px 1.7rem;
            font-size: 22px;
            line-height: 30px;
            border-left: 4px solid tomato;
        }

        blockquote .fa-quote-left {
            position: absolute;
            top: 18px;
            left: 8px;
            font-size: 16px;
            color: tomato
        }

        blockquote p {
            color: #000
        }

        @media only screen and (max-width: 576px) {
            blockquote {
                position: relative;
                background: #e9e9e9;
                margin: 2px;
                padding: 2px 1rem 12px 1.7rem;
            }

            amp-social-share:nth-child(4),
            amp-social-share:nth-child(5) {
                display: none;
            }
        }

        .share-this amp-social-share {
            margin: 2px;
        }

        .text-tomato {
            color: tomato
        }

        /* ==FAQS Section ==*/
        #faqs-section .faqs-item {
            margin-bottom: 5px;
            border: 2px solid #e4e4e4;
        }

        #faqs-section .faqs-item h3 {
            color: #343a40;
            background-color: #efefef;
            padding: 12px 5px;
			font-size: 16px;
    		font-weight: 600;
        }

        #faqs-section .faqs-item h3:hover {
            color: #4B9DD6;
        }

        #faqs-section .faqs-body {
            padding: 5px 10px;
        }

        .author-box {
            display: block;
            box-sizing: border-box;
            box-shadow: 0 0 10px lightgrey;
            padding: 20px;
            margin: 35px 0 0;
            border: 1px solid rgba(155, 155, 155, 0.17);
        }

        .author_image_col amp-img {
            border-radius: 50%;
            margin-top: 12px;
        }

        @media only screen and (max-width: 768px) {
            .author_image_col amp-img {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                margin: 30px auto;
            }

            .author_text_col p {
                font-size: 16px;
            }
        }

        .author_text_col h4 {
            color: #4B9DD6;
            margin-bottom: 0;
        }

        .author_text_col p {
            margin: 5px 0px;
            line-height: 1.4;
            color: #606770;
        }

        /* ==Related Post Section ==*/
        .related-row ul {
            padding: 0px 10px;
            font-family: 'Roboto';
        }

        .related-row li {
            list-style: none;
            padding: 4px 0px;
            color: #076785;
            border-bottom: 1px solid #ccc;
            transition: transform 0.4s;
        }

        .related-row li a {
            color: #076785;
            font-size: 18px;
            font-weight: 600;
            padding-left: 5px;
            padding-top: 1px;
            text-decoration: none;
            display: flex;
        }

        .related-row li a span.icon {
            display: block;
            width: 5%;
        }

        .related-row li a span.text {
            display: block;
            width: 95%;
        }

        @media only screen and (max-width: 576px) {
            .related-row li a span.icon {
                display: block;
                width: 10%;
            }

            .related-row li a span.text {
                display: block;
                width: 90%;
            }
        }

        .related-row li:hover {
            transform: translateX(10px);
        }

        .related-row li:hover a {
            color: #28a745;
        }

        .related-row li i.icon-chright {
            background-image:url({{ route('HomeUrl') }}/assets/images/web-icons.webp);
        background-repeat: no-repeat;
        background-position: -72px -61px;
        padding: 15px 12px;
        }

        .related-row li:hover i.icon-chright {
            background-image:url({{ route('HomeUrl') }}/assets/images/icons-web.png);
        background-position: -96px -61px;
        padding: 15px 12px;
        }

        .list-style-disc {
            list-style: disc;
        }

        .list-style-decimal {
            list-style: decimal;
        }



        /* ===== Newsletter Section ====*/
        .newsletter {
            background: #4B9DD6;
            padding: 30px 0px;
            color: #fff;
        }

        .newsletter h3 {
            font-size: 30px;
        }

        .newsletter .newsletter__input {
            display: flex;
            justify-content: flex-end;
        }

        @media only screen and (max-width:992px) {
            .newsletter .newsletter__input {
                display: flex;
                justify-content: center;
            }

            .newsletter h3 {
                line-height: 35px;
                margin-bottom: 20px;
                text-align: center;
            }
        }

        @media only screen and (max-width:576px) {
            .newsletter .newsletter__input {
                display: flex;
                justify-content: center;
            }

            .newsletter .newsletter__text {
                text-align: center;
            }

            .newsletter h3 {
                font-size: 24px;
                text-align: center;
                font-weight: 400;
            }
        }

        .newsletter input {
            outline: none;
            border: none;
            width: 60%;
            padding: 10px 10px;
            border-radius: 30px 0px 0px 30px;
        }

        .newsletter .btn-subscribe {
            outline: none;
            border: none;
            background: #edbb2b;
            padding: 10px 20px;
            height: 55px;
            border-radius: 0px 30px 30px 0px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .newsletter .btn-subscribe:hover {
            background: lightseagreen;
            color: #fff;
        }

        /* ===== Footer Section =====*/
        footer {
            padding-top: 1rem;
            background: #4B9DD6;
        }

        footer .amp-footer {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.5rem 0rem;
        }

        .amp-footer h3 {
            font-size: 30px;
            font-family: sans-serif;
            color: #e9db33;
        }

        footer .footer-logo {
            display: block;
            margin-right: 10px;
        }

        footer .amp-bottom {
            padding-top: 0px;
            font-size: .9em;
            text-align: center;
        }

        footer .amp-bottom .footer-nav {
            display: flex;
            justify-content: center;
            font-size: 14px;
            padding: 0;
        }

        footer .amp-bottom .footer-nav li {
            display: inline-block;
            margin: 2px 5px;
        }

        .amp-bottom a {
            color: #fff;
            text-decoration: underline;
            font-weight: 600;
            margin: 10px auto;
        }

        .amp-bottom p {
            font-size: 14px;
            color: #efefef;
        }

        .amp-bottom a:hover {
            color: #F1B624;
        }

        .social-links a {
            display: inline-block;
            margin: 2px 4px;
            border-radius: 50%;
            border: 1px solid #efefef;
            width: 38px;
            height: 38px;
            vertical-align: middle;
        }

        .social-links a i {
            margin-top: 10px;
        }

        .social-links a:hover {
            color: #F1B624;
            border: 1px solid #F1B624;
        }

        .social-links+p {
            background: rgba(0, 0, 0, 0.2);
            padding: 20px 0px;
			margin: 0;
        }

        .scroll-top {
            position: fixed;
            bottom: 50px;
            right: 10px;
            background: #4B9DD6;
            padding: 8px 5px;
            border-radius: 5px;
            opacity: 0.7;
            cursor: pointer;
            outline: none;
            border: none;
        }

        .scroll-top:hover {
            opacity: 1;
            box-shadow: 0 0 40px rgba(0, 0, 0, .4);
        }

        .scroll-top .icon-up {
            background-image: url("../images/arrow-up.png");
            background-repeat: no-repeat;
            background-position: center;
            padding: 10px 20px;
        }

        .text-center {
            text-align: center;
        }
		.author_nav{
			margin-top: 10px;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.author_nav li{
			list-style: none;
			margin-right: 10px;
		}
		img{
			object-fit: contain;
		}
		.author-info{
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.author-name h4{
			margin: 0;
		}
    </style>
</head>

<body>
    <header class="bd-topnav">
        <div class="bd-container">
            <div class="site-main">
                <div class="logo">
                    @php
                    $rec = DB::table("generalsettings")->first();
                    @endphp
                    @if ($rec->logo !="")
                    <a href="{{ route('HomeUrl') }}"><amp-img alt="{{ $rec->logo_text }}" src="{{ $rec->logo }}" width="200px" height="40px" layout="fixed"> </amp-img></a>
                    @endif
                </div>
                <div role="button" on="tap:sidebar1.toggle" tabindex="0" class="hamburger">☰</div>
            </div>
        </div>
    </header>
    <amp-sidebar class="sidebar" id="sidebar1" layout="nodisplay" side="right">
        <div role="button" aria-label="close sidebar" on="tap:sidebar1.toggle" tabindex="0" class="close-sidebar">✕</div>
        <nav class="nav">
            <ul class="label sidebar">
                @php

                function __has_children( $arr = array() ) {
                $r = false;
                foreach ( $arr as $k => $v ) {
                if ( isset( $v[ "children" ] ) ) {
                $r = true;
                }
                }
                return $r;
                }

                function __menu( $data, $level = 1 ) {

                foreach ( $data as $k => $v ) {
                if ( isset( $v[ "children" ] ) ) {
                $link = $v[ "link" ];
                $title = $v[ "title" ];
                $type = $v[ "type" ];
                $class = ( __has_children( $v[ "children" ] ) ) ? "sub-menu" : "sub-menu";
                echo "<amp-accordion animate>
                    <section class='dropdown'>
                        <h4><span>$title&nbsp;...</span></h4>
                        <ul class='label sidebar'>";
                            __menu( $v[ "children" ], $level++ );
                            echo "</ul>
                    </section>
                </amp-accordion>";
                } else {
                $link = $v[ "link" ];
                $exp = explode( "/", $link );
                $slug = $exp[ count( $exp ) - 1 ];
                $title = $v[ "title" ];
                $type = $v[ "type" ];
                // $selected = ( $slug == get_postid( "full" ) ) ? "class='m-active'" : "";
                echo "<li class='nav-item'><a href='$link'>$title</a></li>";
                }
                }
                }
                $Options = new App\Helpers\Options;
                $menu = $Options->get("menu");
                $data = ( $menu == "" ) ? array() : json_decode( $menu, true );
                @endphp
                @php
                __menu($data);
                @endphp
            </ul>
        </nav>
    </amp-sidebar>
    @php
    $title = ($blog['title'] !="") ? '<h1 class="section-title">'.$blog['title'].'</h1>' : "";
    $views = ($blog['views'] !="") ? '<div class="icon"><i class="fa fa-eye pr-2"></i> '.total_views($post_id) .'</div>' : "";
    $date = ($blog['date'] !="") ? '<div class="icon"><i class="fa fa-calendar pr-2"></i> '.date("d M Y",$blog['date']).'</div>' : "";
    $content = ($blog['content'] !="") ? $blog['content'] : "";
    $cat = ($blog['category'] !="") ? (Array)get_catByname($blog['category']) : "";
    $c_url = ($blog['category'] !="") ? get_catUrl($blog['category']) : "";

    $c_title = isset($cat['title']) ? $cat['title'] : "";
    @endphp
    <div class="wrapper bd-container">
        <main class="main-content">
            {!! $title !!}
            <div class="bd-sngtitle-bottom d-flex justify-content-between">
                {!! $date !!}
                {!! $views !!}
            </div>
            @php
            $content = ($blog['content'] !="") ? $blog['content'] : "";
            $tags = explode(",", $blog['meta_tags']);
            $titles = explode(" ", $blog['title']);
            $content = do_short_code2($content, $blog['id'] , "blogs",$titles, $tags);
            $ct = table_of_content2($content);
            $content = $ct["content"];
            $tc = array("ct"=>$ct["table"]);
            $table = View::make('front/temp/table-of-content', $tc)->render();
            $content = str_replace("[[toc]]", $table, $content);
            $content = amp_image($content);
            @endphp
            {!! $content !!}
            @php
            $author_id[] = $blog['author'];
            $blog['author'];
            @endphp
            @if ($blog['author'] >0)
            @php
            $d = \App\Authors::where('id' , $author_id[0])->first();
            $s = ( $d[ 'social_links' ] != "" ) ? json_decode( $d[ 'social_links' ], true ) : array();
            @endphp
            <div class="author-box">
                <div class="pr-0 author_image_col">
                    <amp-img src="{{ get_post_thumbnail($d['cover']) }}" alt="author-image" width="120" height="120" layout="responsive">
                    </amp-img>
                </div>

                <div class="author_text_col">
					<div class="author-info">
						<div class="author-name"><h4 class="text-lblue">{{ $d['name'] }}</h4></div>
						<div class="author-social">
						<div class="nav author_nav">
							@foreach ($s as $k)
							@php
								if ($k['icon'] == "icon-twitter") {
									$icon = '<i class="fa fa-2x fa-twitter-square"></i>';
								}elseif($k['icon'] == "icon-facebook") {
									$icon = '<i class="fa fa-2x fa-facebook-square"></i>';
								}elseif($k['icon'] == "icon-instagram") {
									$icon = '<i class="fa fa-2x fa-instagram"></i>';
								}elseif($k['icon'] == "icon-pintrest") {
									$icon = '<i class="fa fa-2x fa-pinterest-square"></i>';
								}elseif($k['icon'] == "icon-linkedin") {
									$icon = '<i class="fa fa-2x fa-linkedin-square"></i>';
								}elseif($k['icon'] == "icon-youtube") {
									$icon = '<i class="fa fa-2x fa-youtube-square"></i>';
								}elseif($k['icon'] == "icon-reddit") {
									$icon = '<i class="fa fa-2x fa-reddit-square"></i>';
								}
							@endphp
							<li> <a href="{{ $k['link']}}" class="" target="_blank"></a>{!! $icon !!} </li>
						@endforeach
						</div>
						</div>
					</div>

                    <p>{!! $d['details'] !!}</p>
                </div>
            </div>
            @endif
            <amp-facebook-comments width="486" height="657" layout="responsive" data-numposts="5" data-href="http://mblog.unifyp.com/amp/amp.quote-details.php">
            </amp-facebook-comments>
        </main>
    </div>
    @php
        $d = \App\Models\Homedata::select("social_links" , "copyrights")->first();
        $setting = \App\generalsetting::select("fbid")->first();
        $s = ( $d[ 'social_links' ] != "" ) ? json_decode( $d[ 'social_links' ], true ) : array();
        $c = ( $d[ 'copyrights' ] != "" ) ? json_decode( $d[ 'copyrights' ], true ) : array();
        $title = (isset($c['copyrights_title'])) ? $c['copyrights_title'] : "" ;
        $name = (isset($c['company_name'])) ? $c['company_name'] : "" ;
        $url = (isset($c['company_url'])) ? $c['company_url'] : "" ;
        if (get_postid("full") == ""){
            $type = "";
        }else{
            $type = " rel='nofollow noopener' ";
        }
    @endphp
	    @php
        $views = total_views($post_id);
        refresh_views($views , get_postid('post_id') , get_postid('page_id'), "" );
   @endphp
    <footer>
        <div class="amp-bottom">
            <p class="text-center mt-1x">{{ $title }} <a>{{ $name }}</a></p>
            <ul class="nav footer-nav">
                <li><a href="{{ route('HomeUrl') }}/contact" class="text-center">Contact Us</a></li>
                <li><a href="{{ route('HomeUrl') }}/privacy-policy" class="text-center">Privacy Policy</a></li>
                <li><a href="{{ route('HomeUrl') }}/terms-conditions" class="text-center">Terms & Conditions</a></li>
            </ul>
            <div class="social-links text-center">
                 @foreach ($s as $k)
                     <a href="{{ $k['link']}}" target="_blank"><i class="fa {{ str_replace("icon-", "fa-", $k['icon']) }}"></i></a>
                @endforeach
            </div>
            <p class="text-center mt-1x">Developed By: <a href="https://dgaps.com" rel='nofollow noopener' target="_blank">Digital Applications</a></p>
        </div>
    </footer>
</body>
</html>
