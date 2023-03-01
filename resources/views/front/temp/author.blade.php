
@php
    $d = \App\Models\Author::where('id' , $author_id[0])->first();
    $s = isset( $d[ 'social_links' ]) ? json_decode( $d[ 'social_links' ], true ) : array();
	$cover = isset($d['cover'])? get_post_thumbnail($d['cover']) : "";
@endphp
@if (isset($d))
<div class="blog-author my-3">
    <div class="media d-md-flex d-sm-block d-block align-items-start">
    @isset($d['cover'])
    <img src="{{ get_post_thumbnail($d['cover']) }}" alt="{{ $d['name'] }}" height="120" width="120" class="media-img-auto">
    @endisset
      <div class="media-body ms-0 ms-md-4 flex-grow-1 flex-shrink-1">
      @isset($d['name'])
        <h4 class="item-title">{{ $d['name'] }}</h4>
      @endisset
        {!! isset($d['details'] ) ? $d['details'] : ""  !!}
        <ul class="item-social">

            @foreach ($s as $k)
      @if($k['link'] !=null)
          <li><a href="{{ $k['link']}}" target="_blank" ><span class="{{ $k['icon'] }}"></span></a></li>
      @endif
          @endforeach
        </ul>
      </div>
    </div>
</div>
@endif
