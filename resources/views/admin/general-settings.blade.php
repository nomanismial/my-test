@include('admin.layout.header')
@php
if(!empty(old())){
  $meta_title = old('meta_title');
  $meta_description = old('meta_description');
  $meta_tags = old('meta_tags');
  $schema_g = old("schema");
  $type_g = old("type");
  $schema = array();
  $t_quotes = count($schema_g);
  foreach($schema_g as $k=>$v){
    $type = $type_g[$k];
    $schema[] = array("schema"=>$v, "type"=>$type);
  }
}elseif(isset($settings) and !empty($settings)){
  $meta_title = get("meta_title");
  $meta_tags = $settings->meta_tags;
  $meta_description = $settings->meta_description;
  $schema = isset($settings->microdata) ? json_decode($settings->microdata , true) : array();
}else{
  $schema = array();
  $meta_title = $meta_tags = $meta_description  =  "" ;
}
full_editor();
@endphp
<style>
span.required {
color: red;
}
</style>
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-10">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">General Settings</h6>
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
          <form method="POST" action="{{ route('general-setting') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ isset($settings->id)? $settings->id : "" }}" >
            <div class="form-row">
              <div class="form-group col-lg-3 col-md-3 logo-img">
                <label class="font-weight-600">Logo : &nbsp; &nbsp; Size : 300 x 70 </label>
                <div class="uc-image" style="width: 97%;">
                  <span class="clear-image-x">x</span>
                  <input type="hidden" name="logo" value="{{ get("logo") }}">
                  <div id="logo" class="image_display">
                    <img src="{{ get("logo") }}" alt="">
                  </div>
                  <div style="margin-top:10px;">
                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#logo" data-link="logo">Add Image</a>
                  </div>
                </div>
              </div> 
{{--               <div class="form-group col-lg-3 col-md-3 logo-img">
                <label class="font-weight-600">Short Logo :  Size : 100 x 50  </label>
                <div class="uc-image" style="width: 97%;">
                  <span class="clear-image-x">x</span>
                  <input type="hidden" name="short_logo" value="{{ get("short_logo") }}">
                  <div id="short_logo" class="image_display">
                    <img src="{{ get("short_logo") }}" alt="">
                  </div>
                  <div style="margin-top:10px;">
                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#short_logo" data-link="short_logo">Add Image</a>
                  </div>
                </div>
              </div> --}}              
              <div class="form-group col-lg-3 col-md-3 logo-img">
                <label class="font-weight-600"> Favicon:  Size : 16 x 16  </label>
                <div class="uc-image" style="width: 97%;">
                  <span class="clear-image-x">x</span>
                  <input type="hidden" name="favicon" value="{{ get("favicon") }}">
                  <div id="favicon" class="image_display">
                    <img src="{{ get("favicon") }}" alt="">
                  </div>
                  <div style="margin-top:10px;">
                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#favicon" data-link="favicon">Add Image</a>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-3 col-md-3 logo-img">
                <label class="font-weight-600">OG Image: Size : 1200 x 627  </label>
                <div class="uc-image" style="width: 97%;">
                  <span class="clear-image-x">x</span>
                  <input type="hidden" name="og" value="{{ get("og") }}">
                  <div id="og" class="image_display">
                    <img src="{{ get("og") }}" alt="">
                  </div>
                  <div style="margin-top:10px;">
                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#og" data-link="og">Add Image</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group col-md-9">
              @php
                $meta = array(
                  'default' => "" , 
                  'nofollow' => "nofollow" , 
                  'noindex' => "noindex" , 
                  'nofollow , noindex' => "nofollow , noindex" , 
                );
              @endphp
               <label class="font-weight-600">Meta Robots</label>
              <select name="meta_robots" class="form-control">
                @foreach ($meta as $k => $v)
                  @php
                    $sel = ($v == get("meta_robots")) ? "selected=selected" : "";
                  @endphp
                  <option value="{{ $v }}" {{ $sel }}>{{ $k }}</option>
                @endforeach
                
              </select>
            </div>  <br>
            <div class="form-group col-md-9">
              <label>Website Name</label><span class="float-right infoSec" ><i class="fa fa-info" data-toggle="tooltip" data-placement="left" title="Website name is used in 'Email Footer' " ></i></span>
              <input type="text" class="form-control" placeholder="example.com" name="website_name" value="{{ get("website_name") }}">
            </div>
			       <div class="form-group col-md-9">
              <label>Website Title</label><span class="float-right infoSec" ><i class="fa fa-info" data-toggle="tooltip" data-placement="left" title="Website Title is used in 'Popups' and 'Email Label' " ></i></span>
              <input type="text" class="form-control" placeholder="Eg Digital Applications" name="website_title" value="{{ get("website_title") }}">
            </div>
            <div class="form-group col-md-9">
              <label>Google Analytics:</span></label>
              <textarea   name="google_analytics" rows="3" class="form-control" placeholder="Google Analytics">{{ get("google_analytics") }}</textarea>
            </div>
            <!-- webnmaster tool-->
            <div class="form-group col-md-9">
              <label>Google Web Master Tools Meta Tags:</label>
              <textarea  name="web_master" rows="3" class="form-control" placeholder="Web Master Tools Meta Tags">{{ get("web_master") }}</textarea>
            </div>
            <div class="form-group col-md-9">
              <label>Bing Master Tools Meta Tags:</label>
              <textarea  name="bing_master" rows="3" class="form-control" placeholder="Bing Master Tools Meta Tags">{{ get("bing_master") }}</textarea>
            </div>
            <div class="form-group col-md-9">
              <label>Header Script:</label>
              <textarea  name="header_script" rows="3" class="form-control" placeholder="Header Script">{{ get("header_script") }}</textarea>
            </div>
			     <div class="form-group col-md-9">
              <label>Subscriber Text</label>
              <input type="text" class="form-control" placeholder="Subscriber Text" name="subscriber_text" value="{{ get("subscriber_text") }}">
            </div>
			
            <div class="form-group col-md-9">
              <label>Facebook Url</label>
              <input type="text" class="form-control" placeholder="Facebook Url" name="facebook_url" value="{{ get("facebook_url") }}">
            </div>
			
            <div class="form-group col-md-9">
              <label>Twitter Url</label>
              <input type="text" class="form-control" placeholder="Twitter Url" name="twitter_url" value="{{ get("twitter_url") }}">
            </div>
			
            <div class="form-group col-md-9">
              <label>Instagram Url</label>
              <input type="text" class="form-control" placeholder="Instagram Url" name="instagram_url" value="{{ get("instagram_url") }}">
            </div>
			
           <div class="form-group col-md-9">
              <label>Linkedin Url</label>
              <input type="text" class="form-control" placeholder="Linkedin Url" name="linkedin_url" value="{{ get("linkedin_url") }}">
            </div>
			
            <div class="form-group col-md-9">
              <label>Youtube Url</label>
              <input type="text" class="form-control" placeholder="Youtube Url" name="youtube_url" value="{{ get("youtube_url") }}">
            </div>
			
            <div class="form-group col-md-9">
              <label>Copyright Text</label>
              <input type="text" class="form-control" placeholder="Copyright Text" name="copy_rights" value="{{ get("copy_rights") }}">
            </div>
			
            <div class="form-group col-md-9">
             <input type="hidden" name="submit">
              <button type="submit" value="Publish" class="btn btn-info float-right submit-btn float-right">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')
<script type="text/javascript">
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
</script>