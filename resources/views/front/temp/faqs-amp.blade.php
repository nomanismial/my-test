@if (count($data) > 0)
@php
$n =rand(0,35);
@endphp
<div class="faqs-accrd">
	<amp-accordion id="faqs-section"  animate expand-single-section>
		@foreach ($data as $k => $v)
		@php
			$num = $k+1 . ".";
		@endphp
		<section class="faqs-item">
			<h3>{{ $v['question'] }}</h3>
			<div class="faqs-body">
				{!! $v['answer'] !!}
			</div>
		</section>
		@endforeach
	</amp-accordion>
</div>
@endif