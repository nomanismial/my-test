@php
    $segment = request()->segment(1);
    $route = $segment;
    $page_name = get_postid("full");
    $page_id = get_postid("page_id");
    $post_id = get_postid("post_id");
    $favicon =  get("favicon");
    $og_image = get("og");
    $schema = array();
	$web_master =  get("web_master");
	$data = \App\Models\ContactUs::first();
	$email = isset($data->email_1) ? $data->email_1 : "";
    if($page_name == ""){
        $data = \App\Models\Homedata::first();
        $schema   = isset($data['microdata'] )? json_decode($data['microdata']  , true) : array();
        $data   = isset($data['home_meta'])? json_decode($data['home_meta']  , true) : array();
        $meta_title = (isset($data["meta_title"]) and $data["meta_title"] !="") ? $data["meta_title"] : "";
        $meta_description = (isset($data["meta_description"]) and  $data["meta_description"]!="") ? $data["meta_description"] : "";
        $meta_tags = (isset($data["meta_tags"]) and $data["meta_tags"] !="") ? $data["meta_tags"] : "";
        $og_image = (isset($data["og_image"])) ? $data["og_image"] : $og_image ;
    }elseif($page_name == "blogs"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->og_image)?$r->og_image:$og_image;
    }elseif($page_name == "careers"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->meta_tags)?$r->meta_tags:$og_image;
    }elseif($page_name == "faqs"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
		  $schema   = isset($data->microdata)? json_decode($data->microdata  , true) : array();
        $meta_title = isset($r->meta_title)?$r->meta_title:'';
        $meta_description = isset($r->meta_description)?$r->meta_description:'';
        $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
        $og_image = isset($r->og_image)?$r->meta_tags:$og_image;
    }elseif($page_name == "contact-us"){
        $data = \App\Models\ContactUs::first();
        $schema   = isset($data->microdata)? json_decode($data->microdata  , true) : array();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }elseif($page_name == "privacy-policy"){
        $data = DB::table("pages")->where('page_name', 'privacy-policy')->first();
		$schema   = isset($data->microdata)? json_decode($data->microdata  , true) : array();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }elseif($page_name == "about"){
        $data = DB::table("about")->first();
     	$schema   = isset($data->microdata)? json_decode($data->microdata  , true) : array();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }elseif($page_name == "write-for-us"){
        $data = DB::table("write_us")->first();
        $schema   = isset($data->microdata)? json_decode($data->microdata  , true) : array();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }elseif($page_name == "terms-conditions"){
        $data = DB::table("pages")->where('page_name', 'terms-conditions')->first();
		$schema   = isset($data->microdata)? json_decode($data->microdata  , true) : array();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }elseif($page_name == "404"){
        $meta_title = "Page Not Found";
        $meta_description = "Page Not Found";
        $meta_tags = "";
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }elseif($page_name == "search"){
        if (request()->has('q')) {
               $meta_title = (!empty(request()->get('q'))) ? "Search - ".request()->get('q') : "Search - ".str_replace("-", " ", config('app.name') );
        }else{
            $meta_title = "Search Result - ".str_replace("-", " ", config('app.name') );
        }
        $meta_description = "Search Result - ".str_replace("-", " ", config('app.name') );
        $meta_tags = "";
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }else{
        switch ($page_id) {
            case 2:
                $r = \App\Models\Blog::find($post_id);
                    $meta_title = isset($r->meta_title)?$r->meta_title:'';
                    $meta_description = isset($r->meta_description)?$r->meta_description:'';
                    $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
                    $og_image = isset($r->og_image)?$r->og_image:"";
                    $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
                    break;
            case 1:
                    $r = \App\Models\Category::find($post_id);
                    $meta_title = isset($r->meta_title)?$r->meta_title:'';
                    $meta_description = isset($r->meta_description)?$r->meta_description:'';
                    $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
                    $og_image = isset($r->og_image)?$r->og_image:$og_image;
                    $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
                    break;
            default:
                $meta_title = $meta_title;
                $meta_description =$meta_description;
                $meta_tags = $meta_tags;
                $og_image = $og_image;
        }
          $og_image;
}
@endphp
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta http-equiv="Content-Security-Policy" content="base-uri 'self'">
	<meta name="theme-color" content="{{get("theme_color")}}"/>
	<meta name="msapplication-navbutton-color" content="{{get("theme_color")}}">
	<meta name="apple-mobile-web-app-status-bar-style" content="{{ get("theme_color") }}">
	<title>{{$meta_title}}</title>
	<meta name="description" content="{{$meta_description}}">
	<meta name="keywords" content="{{ $meta_tags }}">
	<link rel="icon" href="{{$favicon}}" type="image/x-icon" sizes="16x16">
	<link rel="apple-touch-icon" href="{{$favicon}}">
	<link rel="canonical" href="{{ url('/'.$page_name) }}" />
	<meta property="og:type" content="website">
	<meta property="og:url" content="{{ url('/'.$page_name) }}">
	<meta property="og:title" content="{{$meta_title}}">
	<meta property="og:description" content="{{$meta_description}}">
	<meta property="og:image" content="{{$og_image}}">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:url" content="{{ url('/'.$page_name) }}">
	<meta name="twitter:title" content="{{$meta_title}}">
	<meta name="twitter:description" content="{{$meta_description}}">
	<meta name="twitter:image" content="{{$og_image}}">
	<meta name="revisit-after" content="1 day">
	<meta name="author" content="{{ config('app.name')}}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
@if($email !="")
	<meta name="contact" content="{{ $email }}">
@endif
	<meta name="copyright" content="Digital Applications" />
	<meta name="distribution" content="global">
	<meta name="language" content="English" />
	<meta name="rating" content="general">
@if($email !="")
	<meta name="reply-to" content="{{{ $email }}}">
@endif
	<meta name="web_author" content="Digital Applications">
	{!! $web_master !!}
@foreach ($schema as $element)
@if(strpos($element['schema'], "script") !==false)
	{!! $element['schema'] !!}
@endif
@endforeach


