@php
if(get_postid("page_id") == 2){
    $blogs = \App\Models\Blog::where('status', 'publish')
     ->where('id', "!=" , get_postid("post_id"))
    ->orderBy('views', 'desc')
    ->take(4)
    ->get();
}else{
        $blogs = \App\Models\Blog::where('status', 'publish')
    ->orderBy('views', 'desc')
    ->take(4)
    ->get();
}
@endphp
@php
	$style = ($ad['end'] == "true") ? "fixme" : "style='position:relative'" ;
@endphp
<div class="sidebar-widget {{ $style }}">
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
                    <a href="{{ $url }}"> <img src="{{ asset('preeloader.gif') }}" data-src="{{ get_post_thumbnail($image) }}" height="70" width="70" class="img-thumbnail lazyload" alt="{{ $title }}"> </a>
                </div>
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
