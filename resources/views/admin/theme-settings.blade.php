@include('admin.layout.header')
@php
if(!empty(old())){
  $theme_color = old('theme_color');
  $title_color = old('title_color');
  $anchor_color = old('anchor_color');
}elseif(isset($settings) and !empty($settings)){
  $theme_color = get("theme_color");
  $anchor_color = $settings->anchor_color;
  $title_color = $settings->title_color;
  $schema = isset($settings->microdata) ? json_decode($settings->microdata , true) : array();
}else{
  $schema = array();
  $theme_color = $anchor_color = $title_color  =  "" ;
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
              <h6 class="fs-17 font-weight-600 mb-0">Theme Settings</h6>
            </div>
            <div class="text-right">
              <div class="actions">
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
          <form method="POST" action="{{ route('theme-setting') }}" enctype="multipart/form-data">
            @csrf
            @php
              $version = get("css_version");
              $version = ($version=="") ? 1 : $version + 1;
            @endphp
            <input type="hidden" name="css_version" value="{{ $version }}" >
              <div class="form-group col-md-10">
                <label> <b>Site Color:</b> &nbsp; <b>#336699</b> &nbsp;  <span style="background-color:#336699;color:#336699;"> <b>----</b></span></label>
                <span class="float-right infoSec" ><i class="fa fa-info" data-toggle="tooltip" data-placement="left" title="Website Theme Color"></i></span> 
                <input type="color" class="form-control form-control-color" name="theme_color" value="{{ (get("theme_color") =="")? "#336699" : get("theme_color") }}" title="Choose Site color">
              </div>
              <div class="form-group col-md-10">
                <label> <b>Title Color:</b> &nbsp; <b>#434244</b> &nbsp;  <span style="background-color:#434244;color:#434244;"> <b>----</b></span></label>
                <span class="float-right infoSec" ><i class="fa fa-info" data-toggle="tooltip" data-placement="left" title="Title color for homepage and list page"></i></span>
                <input type="color" class="form-control form-control-color" name="title_color" value="{{ (get("title_color") =="")? "#434244" : get("title_color") }}" title="Choose Title color">
              </div>
              <div class="form-group col-md-10">
                <label> <b>Anchor Color:</b> &nbsp; <b>#a11</b> &nbsp;  <span style="background-color:#a11;color:#a11;"> <b>----</b></span></label>
                <span class="float-right infoSec" ><i class="fa fa-info" data-toggle="tooltip" data-placement="left" title="Anchor Tag color for all over website"></i></span>
                <input type="color" class="form-control form-control-color" name="anchor_color" value="{{ (get("anchor_color") =="")? "#a11" : get("anchor_color") }}" title="Choose Anchor color">
              </div>
              <div class="form-group col-md-10">
                <label> <b>Blog H1 Color:</b> &nbsp; <b>#336699</b> &nbsp;  <span style="background-color:#336699;color:#336699;"> <b>----</b></span></label>
                <span class="float-right infoSec" ><i class="fa fa-info" data-toggle="tooltip" data-placement="left" title="H1 heading color for blog detial page "></i></span>
                <input type="color" class="form-control form-control-color" name="blog_h1_color" value="{{ (get("blog_h1_color") =="")? "#336699" : get("blog_h1_color") }}" title="Choose Anchor color">
              </div>
              <div class="form-group col-md-10">
                <label> <b>Blog H2 Color:</b> &nbsp; <b>#6773dd</b> &nbsp;  <span style="background-color:#6773dd;color:#6773dd;"> <b>----</b></span></label>
                <span class="float-right infoSec" ><i class="fa fa-info" data-toggle="tooltip" data-placement="left" title="H2 heading color for blog detial page"></i></span>
                <input type="color" class="form-control form-control-color" name="blog_h2_color" value="{{ (get("blog_h2_color") =="")? "#6773dd" : get("blog_h2_color") }}" title="Choose Anchor color">
              </div>
              <div class="form-group col-md-10">
                <label> <b>Blog H3 Color:</b> &nbsp; <b>#336699</b> &nbsp;  <span style="background-color:#336699;color:#336699;"> <b>----</b></span></label>
                <span class="float-right infoSec" ><i class="fa fa-info" data-toggle="tooltip" data-placement="left" title="H3 heading color for blog detial page"></i></span>
                <input type="color" class="form-control form-control-color" name="blog_h3_color" value="{{ (get("blog_h3_color") =="")? "#336699" : get("blog_h3_color") }}" title="Choose Anchor color">
              </div>
            <div class="form-group col-md-10">
             <input type="hidden" name="submit">
              <button type="submit" value="Submit" class="btn btn-info float-right submit-btn float-right">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')
<script>
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
</script>