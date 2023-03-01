
@include('admin.layout.header')
@php
	full_editor();
@endphp
<div class="body-content">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Send Email</h6>
						</div>
						<div class="text-right">
							<div class="actions">
								<a href="{{url('/'.admin.'/edit-emails')}}" class="btn btn-info pull-right">Add Email</a>
                				<a href="{{url('/'.admin.'/emails')}}" class="btn btn-info pull-right">Email List</a>
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
					           @if (count($errors) > 0)
					          <div class="alert alert-danger">
					              <strong>Whoops!</strong> Some Input Fields Are Missing.<br><br>
					              <ul class="list-unstyled text-left mb-0">
					                @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					                @endforeach
					              </ul>
					          </div>
					          @endif
							<form method="post" action="/<?= admin ?>/multiEmail" enctype="multipart/form-data">
								@csrf
								<div class="col-md-9">
									<div class="row">
										<br>
										@php
										$row = DB::table('contact_users')->where('id', '=', request('id'))->first();
										@endphp
										@if (request("id"))
										<input type="hidden" name="userid" value="{{ request("id") }}">
										<div class="col-md-6">
											<div class="form-group">
												<label class="req">Email Adress</label>
												<input type="text" name="email" id="email" class="form-control" value="{{ $row->email}}">
											</div>
										</div>
										@else
										<div class="col-md-6">
											<div class="form-group">
												<label class="req">Select id from</label>
												<input type="number" name="id_from" id="title" class="form-control" min="{{ (!empty($first_id))?$first_id:0 }}" max="{{ (!empty($last_id))?$last_id:0 }}" value="{{ (!empty($first_id))?$first_id:0 }}">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="req">Select id to</label>
												<input type="number" name="id_to" id="title" class="form-control" min="{{ (!empty($first_id))?$first_id:0 }}" max="{{ (!empty($last_id))?$last_id:0 }}" value="{{ (!empty($last_id))?$last_id:0 }}">
											</div>
										</div>
										@endif
									</div>
									<div class="form-group">
										<label class="req">Subject</label><br>
										<input type="text" name="subject" class="form-control">
									</div>
									<div class="form-group">
										<label class="req">Detail</label><br>
										<div>
											<a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="editor" data-return="#oneditor" data-link="image">Add Image</a>
										</div>
										<textarea name="content" class="form-control oneditor" id="oneditor" rows="25"  aria-hidden="true"></textarea>
										<div class="text-danger"></div>
									</div>
									<div style="padding:10px;">
										<button type="submit" name="submit" value="send" class="btn btn-info float-right submit-btn">Send Email</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
      <div class="gif-div">
    <img src="{{ asset('admin-assets/uploading-gif.gif') }}" alt="uploading gif">
  </div>
@include('admin.layout.footer')

