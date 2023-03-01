


          

@if (count($data) > 0)
@php
  $n =rand(0,35);
@endphp
    @foreach ($data as $k =>  $v)
    @php
      $num = $k+1 . ":";
      $visible = ($k==0) ? "visible" : "" ;
      $icon = ($k==0) ? "minus-icon" : "plus-icon" ;
    @endphp
          <blockquote class="mb-3">
            <span> {!! $v['q_content'] !!}
              <span class="qoute-subtitle">{{ $v['q_name'] }}</span></span>
          </blockquote>
          @endforeach
@endif