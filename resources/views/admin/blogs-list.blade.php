@include('admin.layout.header')
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Blogs List</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/blogs')}}" class="btn {{ Request::segment(2)=='blogs'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a>
                <a href="{{url('/'.admin.'/blogs/list')}}" class="btn {{ Request::segment(2)=='blogs'  && Request::segment(3)=='list'  ? 'btn-inverse' : 'btn-info' }} pull-right">Blogs List</a>
                <a href="{{url('/'.admin.'/blogs/category')}}" class="btn {{ Request::segment(2)=='blogs'  && Request::segment(3)=='category'  ? 'btn-inverse' : 'btn-info' }} pull-right">Add Category</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
           @if (Session::has('flash_message'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session('flash_message') !!}</strong>
          </div>
          @endif
           @if (Session::has('flash_message2'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session('flash_message2') !!}</strong>
          </div>
          @endif
          <div class="row">
            <div class="col-md-12 table-responsive">
              <table id="myTable" class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
                <thead>
                  <tr>
                    <td><strong>#</strong></td>
                    <td><strong>Title</strong></td>
                    <td><strong>Status</strong></td>
                    <td><strong>Views</strong></td>
                    <td><strong>Date</strong></td>
                    <td><strong>Action</strong></td>
                  </tr>
                </thead>
                <tbody>
                 {{--  @php
                    $i = $data->perPage() * ($data->currentPage() - 1);
                  @endphp --}}
                  @foreach($data as $k => $key)
                  @php
                    $tviews = total_views( $key->id ,2, "blogs-detail");
                  @endphp
                  <tr>
                    <td>{{ $key->id }}</td>
                    <td><a href='{{ route('HomeUrl')."/".$key->slug."-2".$key->id }}' target="_blank">{{$key->title}}</a></td>
                     @if ($key->status ==="publish")
                    @php
                    $icon = "text-success fa fa-check";
                    $title = "Publish";
                    $url = url('/'.admin.'/blogs?draft='.$key->id);
                    $n = 1;
                    @endphp
                    @else
                    @php
                    $icon = "text-danger fa fa-times";
                    $title = "Draft";
                    $url = url('/'.admin.'/blogs?publish='.$key->id);
                    $n = 0;
                    @endphp

                    @endif
                    <td class="text-center"> <span style="display: none">{{ $n }}</span>
                      <a href="{{ $url }}" class="{{ $icon }} fa-lg change-status" data-id="{{ $key->id }}" title="{{ $title }}"></a>
                    </td>
                    <td>{{ $tviews}}</td>
                    <td style="width: 11%"> <span style="display: none;">{{ strtotime($key->created_at)}}</span>{{ date("d M Y", strtotime($key->created_at))}}</td>
                    <td>
                      <a href="{{url('/'.admin.'/blogs?edit='.$key->id)}}" class="btn-success-soft  mr-1 fa fa-edit" title="Edit"></a>
                      <a href="{{url('/'.admin.'/blogs?delete='.$key->id)}}" class="btn-danger-soft  fa fa-trash sconfirm" title="Delete"></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
      $(function () {

      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url: "{{ route('list-data') }}",
            data: function (d) {
                  d.status = $('#status').val(),
                  d.search = $('input[type="search"]').val()
              }
          },
          columns: [
              {data: 'id', name: 'id'},
              {data: 'title', title: 'title'},
              {data: 'status', name: 'status'},
              {data: 'status', name: 'status'},
          ]
      });

      $('#status').change(function(){
          table.draw();
      });

    });
</script>
@include('admin.layout.footer')
