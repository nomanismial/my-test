@php
	$style = ($ad['end'] == "true") ? "fixme" : "style='position:relative'" ;
	$width = "";
	$height ="";
	if(checkFile($ad['img']) == true){
		$data = getimagesize($ad['img']);
		$width = $data[0];
		$height = $data[1];
	}
@endphp
<div class="googleads text-center {{ $style }}"> <a href="{{ $ad['url'] }}" target="_blank"><img src="{{ asset('preeloader.gif') }}" data-src="{{ get_image($ad['img']) }}" height="{{ $height }}" width="{{$width}}" title="{{ $ad['title'] }}" alt="{{ $ad['alt'] }}" class="m-auto rounded lazyload"></a>
	 </div> 