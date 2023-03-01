@include('admin.layout.header')
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Login Settings</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <!-- <a href="#" class="action-item"><i class="ti-reload"></i></a>
                <a href="#" class="action-item"><i class="ti-reload"></i></a>
                <div class="dropdown action-item" data-toggle="dropdown">
                  <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item">Refresh</a>
                    <a href="#" class="dropdown-item">Manage Widgets</a>
                    <a href="#" class="dropdown-item">Settings</a>
                  </div>
                </div> -->
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
          @if (count($errors) > 0)
          <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
<!--
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
-->
          </div>
          @endif
              <form action="{{ route('login-info') }}" method="Post">
      @csrf
      <div class="card-body">
            @if(session()->has("success"))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session("success") !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
          @if(session()->has("error"))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {!! session("error") !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
        <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="" class="font-weight-600">Admin Path <span class="required">*</span></label>
                <input type="text" name="slug" class="form-control" value="{{ _decrypt($admin->slug) }}">
                @if(count($errors) > 0)
                  @foreach($errors->get('slug') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for=" " class="font-weight-600">Email <span class="required">*</span></label>
                <input type="text" name="email" class="form-control" value="{{ $admin->email }}">
                @if(count($errors) > 0)
                  @foreach($errors->get('email') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="" class="font-weight-600">Old Password <span class="required">*</span></label>
                <input type="password" name="old_password" class="form-control">
                <span toggle="#password-field" class="fa fa-fw field-icon toggle-password fa-eye-slash"></span>
                @if(count($errors) > 0)
                  @foreach($errors->get('old_password') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="" class="font-weight-600">New Password <span class="required">*</span></label>
                <input type="password" name="new_password" class="form-control">
                <span toggle="#password-field" class="fa fa-fw field-icon toggle-password fa-eye-slash"></span>
                @if(count($errors) > 0)
                  @foreach($errors->get('new_password') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="" class="font-weight-600">Confirm Password <span class="required">*</span></label>
                <input type="password" name="confirm_password" class="form-control">
                <span toggle="#password-field" class="fa fa-fw field-icon toggle-password fa-eye-slash"></span>
                @if(count($errors) > 0)
                  @foreach($errors->get('confirm_password') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
              </div>
            </div>
            <div class="col-md-6">
              @php
              $last_seen = time_elapsed_string($admin->updated_at);
              $date1 = date('d-m-Y');
              $date2 = date("d-m-Y" , strtotime($admin->updated_at));
              $days = dateDiffInDays($date1 , $date2);
              $class = ($days > 30) ?"bg-danger" : "bg-success";
              @endphp
               <div class="p-2 {{$class}} text-white rounded mb-3 p-3 shadow-sm text-center">
                    <div class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Password Changed</div>
                    <div class="fs-32 text-monospace">{{$last_seen}}</div>
                    <small>Last Update Settings : {{date_create($admin->updated_at)->format('j M Y g:i A')}}</small>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <label for="" class="font-weight-600">Old Security image <span class="required">*</span></label>
                <div style="color: red" class="_errsecurity_img"></div>
                @if(count($errors) > 0)
                  @foreach($errors->get('old_security_image') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
                <div class="security" style="box-sizing: border-box;">
                  
                  <div class="d-flex flex-row mb-3 " style="flex-wrap: wrap;">
                    @php 
                      $shuffle_img = get_security_img();
                    @endphp
                    @foreach($shuffle_img as $v)
                      <label title="{{ $v['title'] }}">
                        <input type="radio" name="old_security_image" value="{{ $v['value'] }}" class="radio-input old_security_image"> 
                        <i class="fa {{ $v['i'] }}" aria-hidden="true"></i>
                      </label>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <label for="" class="font-weight-600">New Security image <span class="required">*</span></label>
                <div style="color: red" class="_errsecurity_img"></div>
                @if(count($errors) > 0)
                  @foreach($errors->get('new_security_image') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
                <div class="security" style="box-sizing: border-box;">
                  
                  <div class="d-flex flex-row mb-3 " style="flex-wrap: wrap;">
                    @php 
                      $shuffle_img = get_security_img();
                    @endphp
                    @foreach($shuffle_img as $v)
                      <label title="{{ $v['title'] }}">
                        <input type="radio" name="new_security_image" value="{{ $v['value'] }}" class="radio-input new_security_image"> 
                        <i class="fa {{ $v['i'] }}" aria-hidden="true"></i>
                      </label>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mt-2 mr-3">
                <button class="btn btn-primary float-right" type="submit">Submit</button>
              </div>
            </div>
        </div>
        <div class="row">
        </div>
      </div>
    </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <script>
    $(document).ready(function(){
      $('.old_security_image').change(function(){
        $('.old_security_image').next("i").css('border','2px solid rgb(0, 128, 0)');
        $('.old_security_image').next("i").css('color','rgb(0, 128, 0)');
        if($(this).prop("checked") == true){
          $(this).parent().find('i').css('border','3px solid #b212e6');
          $(this).parent().find('i').css('color','#b212e6');
        }
      })
      $('.new_security_image').change(function(){
        $('.new_security_image').next("i").css('border','2px solid rgb(0, 128, 0)');
        $('.new_security_image').next("i").css('color','rgb(0, 128, 0)');
        if($(this).prop("checked") == true){
          $(this).parent().find('i').css('border','3px solid #b212e6');
          $(this).parent().find('i').css('color','#b212e6');
        }
      })
      // $radio.closest('label') .css('color','green');
    })
  </script>
@include('admin.layout.footer')