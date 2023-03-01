@php
	$style = ($ad['end'] == "true") ? "fixme" : "style='position:relative'" ;
@endphp
@php
  $cats = DB::table("blog_categories")->orderBy("tb_order" , "asc")->get();
@endphp
@if (isset($cats))
@if (count($cats) > 0)
<div class="sidebar-widget {{ $style }}">
    <h4 class="widget-title">Categories</h4>
    <div class="stroke-shape"></div>
    <ul class="category-listing">
    @foreach ($cats as $k => $v)
        @php
        $id = $v->id;
        $slug = $v->slug;
        $title = $v->name;
        $url  = route('HomeUrl')."/".$slug."-1".$id;
        @endphp
      <li><a href="{{ $url }}" title="{{ $title }}">{{ $title }} <span>({{ _getCatPostCount($id) }})</span></a></li>
    @endforeach
    </ul>
  </div>
@endif
@endif
