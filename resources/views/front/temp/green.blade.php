@if (count($data) > 0)
<table class="border border-2 border-success table my-4">
    <tr>
      @if ($data['gr_heading'] !="")
		@php
    $words = $data['gr_heading'];
    preg_match("/\[\[urdu\]\]/", $words , $matches);
    if($matches){
      $rtl = "dir=rtl";
    }else{
      $rtl = "";
    }
		@endphp
             <th class="bg-success text-light" {{$rtl}}><p>{!! $data['gr_heading'] !!}</p></th>
      @endif
    </tr>
    <tr>
      <td>
       @if ($data['gr_body'] !="")
         {!! $data['gr_body'] !!}
       @endif
      </td>
    </tr>
</table>
@endif


                   