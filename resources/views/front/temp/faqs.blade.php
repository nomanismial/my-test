
@if (count($data) > 0)
@php
  $n =rand(0,35);
@endphp
    @foreach ($data as $k =>  $v)
    @php
		$num = $k+1 . ":";
		$visible = ($k==0) ? "visible" : "" ;
		$icon = ($k==0) ? "minus-icon" : "plus-icon" ;

		$words = $v['question'];
		preg_match("/\[\[urdu\]\]/", $words , $matches);
		if($matches){
		  $rtl = "questionnaire_rtl";
		}else{
		  $rtl = "questionnaire";
		}
	@endphp
<div class="{{$rtl}}">
  <div class="quest">
    <h5>{{ $v['question'] }}</h5>
  </div>
  <div class="answ">
    {!! $v['answer'] !!}
  </div>
</div>
@endforeach
@endif


