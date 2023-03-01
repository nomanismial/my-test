@if (count($data) > 0)
<table class="border border-2 border-dark table my-4">
    <tr>
      @if ($data['black_heading'] !="")
          @php
    $words = $data['black_heading'];
    preg_match("/\[\[urdu\]\]/", $words , $matches);
    if($matches){
      $rtl = "dir=rtl";
    }else{
      $rtl = "";
    }
    @endphp
             <th class="bg-dark text-light" {{ $rtl }}><p>{{ $data['black_heading'] }}</p></th>
      @endif
    </tr>
    <tr>
      <td>
       @if ($data['black_body'] !="")
         {!! $data['black_body'] !!}
       @endif
      </td>
    </tr>
</table>
@endif



            