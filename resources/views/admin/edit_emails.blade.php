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
                <a href="{{url('/'.admin.'/send-email')}}" class="btn btn-info pull-right">Send Email</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
			
            <div class="col-md-12">
               @if (count($errors) > 0)
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
            	<form method='post' action='/{{ admin }}/edit-emails' 
							style='text-align:center;'>
				@csrf
				<div class='row'>
					<div class="form-group col-lg-4">
            @php
               $edit_id = request()->get('edit');
            @endphp
						<input type="hidden" name="id" value="{{ ($edit_id !="")?$edit_id:''}}">
					<input type='text' placeholder="example@gmail.com"  name='email' value='{{ isset($row)?$row->email:old('email')}}'
						class='form-control' style='margin-bottom:10px;'>
					</div>
          <div class="form-group col-lg-4">
          <input type='text' placeholder="Name" name='name' value='{{ isset($row)?$row->name:old('name')}}'
            class='form-control' style='margin-bottom:10px;'>
          </div>
					<div class="form-group col-lg-2">
						<input type='submit' name='submit' value='Save'
						class='btn btn-info pull-right'>
					</div>
				</div>
			</form>
			@if (Session::has('flash_message'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! Session('flash_message') !!}</strong>
                </div>
            @endif
              <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
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
                	@foreach($data as $key)
					<tr>
						<td>{{$key->id}}</td>
						<td>{{$key->name}}</td>
						<td>{{$key->email}}</td>
						<td>{{$key->type}}</td>
						<td>{{ date_create($key->created_at)->format('j M Y')}}</td>
						<td>
							<a href="{{url('/'.admin.'/edit-emails?edit='.$key->id)}}" class=" btn-success-soft fa fa-edit" title="Edit"></a> |
							<a href="{{url('/'.admin.'/send-email?id='.$key->id)}}" class=" btn-success-soft fa fa-envelope fa-lg" title="Send Email"></a>
							
						</td>
					 </tr>
					@endforeach
                </tbody>
              </table>
              
            </div>
         
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')