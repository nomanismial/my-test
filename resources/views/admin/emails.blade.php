@include('admin.layout.header')
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Email List</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/edit-emails')}}" class="btn btn-info pull-right">Add Email</a>
                <a href="{{url('/'.admin.'/send-email')}}" class="btn btn-info pull-right">Send Email</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">

            <div class="col-md-12">
               @if (Session::has('flash_message'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session('flash_message') !!}</strong>
          </div>
          @endif
          @if (Session::has('deletd_message'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session('deletd_message') !!}</strong>
          </div>
          @endif
          @if (count($errors) > 0)
          <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
              <table id="myTable" class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
                <thead>
                  <tr>
                    <td><strong>#</strong></td>
                    <td><strong>Name</strong></td>
                    <td><strong>Email</strong></td>
                    <td><strong>Type</strong></td>
                    <td><strong>Date</strong></td>
                    <td><strong>Action</strong></td>
                  </tr>
                </thead>
                <tbody>
					@php
					$n = count($data);
					@endphp
                  @foreach($data as $k => $key)
                  <tr>
                    <td>{{$n}}</td>
                    <td>{{$key->name}}</td>
                    <td>{{$key->email}}</td>
                    <td>{{$key->type}}</td>
                    <td>{{ date_create($key->created_at)->format('j M Y')}}</td>
                    <td>
                      <a href="{{url('/'.admin.'/edit-emails?edit='.$key->id)}}" class=" btn-success-soft fa fa-edit" title="Edit"></a> |
                      <a href="{{url('/'.admin.'/edit-emails?del='.$key->id)}}" class=" btn-success-soft fa fa-trash sconfirm" title="Delete"></a> |
                      <a href="{{url('/'.admin.'/send-email?id='.$key->id)}}" class=" btn-success-soft fa fa-envelope fa-lg" title="Send Email"></a>
                    </td>
                  </tr>
					@php
					$n = $n-1;
					@endphp
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')