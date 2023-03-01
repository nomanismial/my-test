@if (count($data) > 0)
<table class="table tbl-border tbl-red my-2">
    <tbody>
      <tr>
        @if ($data['red_heading'] !="")
            <th class="bg-red">{{ $data['red_heading'] }}</th>
      @endif
      </tr>
      <tr>
        <td>
          @if ($data['red_body'] !="")
            {!! $data['red_body'] !!}
          @endif
        </td>
      </tr>
    </tbody>
  </table>
@endif


