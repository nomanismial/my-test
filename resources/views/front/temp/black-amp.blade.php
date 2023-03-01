  @if (count($data) > 0)
<table class="table tbl-border tbl-dark my-2">
    <tbody>
      <tr>
        @if ($data['black_heading'] !="")
             <th class="bg-dark">{{ $data['black_heading'] }}</th>
      @endif
      </tr>
      <tr>
        <td>
           @if ($data['black_body'] !="")
             {!! $data['black_body'] !!}
           @endif
        </td>
      </tr>
    </tbody>
  </table>
@endif


