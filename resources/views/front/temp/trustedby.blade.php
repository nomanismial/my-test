<section class="our-partners">
	<div class="container-fluid bg-lred">
		<div class="container">
			<div class="text-center py-3">
				<h3 class="text-light section-title sec-heading">BACKED BY</h3>
				<p class="text-light">They're happy about doing business with us</p>
			</div>
		</div>
	</div>
	@php
	$data = App\Models\Homedata::first();
	$backed_by = ( $data[ 'backed_by' ] != "" ) ? json_decode( $data[ 'backed_by' ], true ) : array();
	@endphp
	<div class="container-fluid bg-red">
		<div class="container">
			<div class="partners owl-carousel py-6">
				@foreach ($backed_by as $element => $v )
				@php
					$title = (isset($v["title"])) ? $v["title"]: "";
					$url = (isset($v["url"])) ? $v["url"]: "";
					$type = (isset($v["type"])) ? $v["type"]: "";
					$img = (isset($v["img"])) ? $v["img"]: "";
					if (get_postid("full") == ""){
						$type = $type;
					}else{
						$type = " rel='nofollow' ";
					}
				@endphp
					<div class="item">
						<a href="{{ $url }}" {!! $type !!} target="_blank"><img src="{{ $img }}" alt="{{ $title }}" class="img-fluid"></a>
					</div>
					@endforeach
			</div>
		</div>
	</div>
</section>
<section class="hosting-section">
	<div class="container-fluid bg-light">
		<div class="container">
			<div class="text-center py-3">
				<h3 class="text-purple section-title sec-heading">TRUSTED BY</h3>
				<p class="text-purple">Choose the perfect solution for your business
				</p>
			</div>
		</div>
	</div>
	@php
	$trusted_by = ( $data[ 'trusted_by' ] != "" ) ? json_decode( $data[ 'trusted_by' ], true ) : array();
	@endphp
	@if (count($trusted_by) > 0)
	<div class="container-fluid bg-white trusted-by">
		<div class="container py-4">
			<div class="row">
				@foreach ($trusted_by as $element => $v )
				@php
					$title = (isset($v["title"])) ? $v["title"]: "";
					$url = (isset($v["url"])) ? $v["url"]: "";
					$type = (isset($v["type"])) ? $v["type"]: "";
					$img = (isset($v["img"])) ? $v["img"]: "";
					if (get_postid("full") == ""){
						$type = $type;
					}else{
						$type = " rel='nofollow' ";
					}
				 @endphp
				<div class="col-6 col-sm-6 col-md-3">
					<a href="{{ $url }}" {!! $type !!} target="_blank"><img src="{{ $img }}" alt="{{ $title }}" class="img-fluid"></a>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	@endif
</section>
