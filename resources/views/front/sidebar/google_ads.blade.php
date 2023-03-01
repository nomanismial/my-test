@php
	$style = ($ad['end'] == "true") ? "fixme" : "style='position:relative'" ;
@endphp
<div class="googleads {{ $style }}">
	{!! $ad['google_ads'] !!}
</div>