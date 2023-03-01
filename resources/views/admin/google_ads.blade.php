@include('admin.layout.header')
@php
  if(!empty(old())){
    $google_ads = old("google_ads"); 
    $title = old("title"); 
    $num = old("num");  
    $ads = array();
    if(!empty($google_ads)){
        foreach($google_ads as $k=>$v){
         $t = isset($title[$k])?$title[$k]:"";
        //dd();
        $ads[] = array("google_ads"=>$v, "title"=>$t);
      }
    }
  }elseif(isset($data) and !empty($data)){
    $ads = (!empty($data->google_ads))?json_decode($data->google_ads , true) : array();
  }else{
    $ads = array();
    $title ="";
  }
@endphp
<div class="body-content">
  <div class="row">
    <div class="col-md-10 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Google Adv </h6>
            </div>
            <div class="text-right">
               <div class="actions">
                <a href="{{ route('ads') }}" class="btn {{ Request::segment(2)=='ads'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Image Adv</a>
                <a href="{{ route('ga-adv') }}" class="btn {{ Request::segment(2)=='ga-adv'  && Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Google Adv</a>
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
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul> 
          </div>
          @endif
          <form method="POST" action="{{ route('ga-adv') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-10 col-md-10">
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                <div class="form-group col-md-10 p-0">
                  <div class="ADs">
                    <div class="form-rows">
                      @php

                      $rev_count = (count($ads)==0) ? 0 : count($ads) - 1;
                      for ($n=0; $n <=$rev_count; $n++){
                      $google_ads = (isset($ads[$n]["google_ads"])) ? $ads[$n]["google_ads"]: "";
                      $title = (isset($ads[$n]["title"])) ? $ads[$n]["title"]: "";
                      $num = $n + 1;
                      $image = "img".$n;
                      $google_ads_error = "google_ads";
                      //dd($date);
                      @endphp
                      <div class="new-Adv border row">
                        <span class="clear-data">x</span>
                        <input type="hidden" name="num[]" value="{{ $num }}">
                        <div class="col-lg-12">
                          <input type="hidden" name="ads_id[]" value="{{ $n+1 }}">
                          <div class="form-group">
                            <label class="font-weight-600">Title :</label>
                            <input type="text" name="title[]" class="form-control" value="{{ $title }}">
                          </div>
                          <div class="form-group">
                            <label class="font-weight-600">Google Adv :</label>
                            <textarea name="google_ads[]" class="form-control" rows="5">{{ $google_ads}}</textarea>
                            @if ($errors->has("google_ads"))
                                <div class="text-danger">google_ads Field is Missing</div>
                                  @endif
                        
                          </div>
                        </div>
                      </div>
                      @php
                      }
                      @endphp
                    </div>
                  </div>
                  <br>
                  <div style="text-align:right;">
                    <a href="" class="btn btn-success add-Adv"><i class="fa fa-plus"></i></a>
                  </div>
                </div>
                <div class="form-group col-md-10 p-0">
                  <button type="submit" name="submit" value="submit" class="btn btn-info float-right">Submit <span class="fa fa-paper-plane"></span></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')
<script>
    $(document).ready(function() {  
    var clone = '<div class="new-Adv border row">'+
                  '<span class="clear-data">x</span>'+
                  '<input type="hidden" name="num[]" value="">'+
  
              ' <div class="col-lg-12">'+
                    '<input type="hidden" name="ads_id[]" value="">'+
                    '<div class="form-group">'+
                     '<label class="font-weight-600">Title :</label>'+
                      '<input type="text" name="title[]" class="form-control" value="">'+
                          '</div>'+
                     '<div class="form-group">'+
                       ' <label class="font-weight-600">Google Adv  :</label>'+
                      ' <textarea name="google_ads[]" rows="5" class="form-control"></textarea>'+
                       ' <div class="text-danger"> </div>'+
                     ' </div>'+
                   ' </div>'+
              '</div>'
      $(".add-Adv").click(function(e) {
        e.preventDefault();
        var html_obj = clone;
        var ln = $(".form-rows .row").length;
        $(html_obj).find("input").each(function(){
          $(this).attr("value", "");
        });
        $(html_obj).find("textarea").each(function(){
          $(this).text("");
        });
        $(html_obj).find("img").remove();
        
        $(".ADs .form-rows").append(html_obj);
        var n = $(".ADs .form-rows").find(".new-Adv").length;
        var el =  $(".ADs .form-rows .new-Adv:nth-child("+n+")");

        el.find(".uc-image").find("#img").attr("id", "img"+ln);
        el.find(".uc-image").find(".img").attr("class", "img"+ln);
        el.find(".uc-image").find(".image_display").attr("id", "img"+ln);
        el.find(".uc-image").find("input").attr("name", "img"+ln);
        el.find(".uc-image").find("a").attr("data-return", "#img"+ln);
        el.find(".uc-image").find("a").attr("data-link", "img"+ln);
         el.find(".no").text(n);
       // el.find("input[type=hidden").attr("value"  , n);
        return false;
      });
      $(document).on("click", ".clear-data", function() {
        var v = window.confirm("Do you want to delete data?");
        if (v) {
          $(this).closest(".row").remove();
        }
      });
    });

  </script>