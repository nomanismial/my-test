@if (count($data) > 0)
<table class="border border-2 border-danger table my-4">
    <tr>
      @if ($data['red_heading'] !="")
      @php
      $words = $data['red_heading'];
      preg_match("/\[\[urdu\]\]/", $words , $matches);
      if($matches){
        $rtl = "dir=rtl";
      }else{
        $rtl = "";
      }
    @endphp
             <th class="bg-danger text-light" {{ $rtl }}><p>{{ $data['red_heading'] }}</p></th>
      @endif
    </tr>
    <tr>
      <td>
       @if ($data['red_body'] !="")
         {!! $data['red_body'] !!}
       @endif
      </td>
    </tr>
</table>
@endif
