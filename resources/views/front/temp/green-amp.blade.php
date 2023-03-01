@if (count($data) > 0)
<table class="table tbl-border tbl-green my-2">
    <tbody>
      <tr>
        @if ($data['gr_heading'] !="")
             <th class="bg-green text-light">{{ $data['gr_heading'] }}</th>
      @endif
      </tr>
      <tr>
        <td class="box-content">
           @if ($data['gr_body'] !="")
             {!! $data['gr_body'] !!}
           @endif
        </td>
      </tr>
    </tbody>
  </table>
@endif


