@include('admin.layout.header')
@php
  if(!empty(old())){
    $title = old("title");
    $alt = old("alt");       
    $url = old("url");  
    $num = old("num");  
    $ads = array();
    if(!empty($title)){
        foreach($title as $k=>$v){
         $t = isset($alt[$k])?$alt[$k]:"";
         $u = isset($url[$k])?$url[$k]:"";
         $n = isset($num[$k])?$num[$k]:0;
         $im = old("img".$k);
        //dd();
        $ads[] = array("title"=>$v, "alt"=>$t ,  "url" => $u , "img" => $im, "num" => $n);
      }
    }
  }elseif(isset($data) and !empty($data)){
    $ads = (!empty($data->ads))?json_decode($data->ads , true) : array();
  }else{
    $ads = array();
  }
@endphp
<div class="body-content">
  <div class="row">
    <div class="col-md-10 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Image Adv</h6>
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
          <form method="POST" action="{{ route('ads') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-10 col-md-10">
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                <div class="form-group col-md-12 p-0">
                  <div class="ADs">
                    <div class="form-rows">
                      @php

                      $rev_count = (count($ads)==0) ? 0 : count($ads) - 1;
                      for ($n=0; $n <=$rev_count; $n++){
                      $title = (isset($ads[$n]["title"])) ? $ads[$n]["title"]: "";
                      $alt = (isset($ads[$n]["alt"])) ? $ads[$n]["alt"]: "";
                      $url = (isset($ads[$n]["url"])) ? $ads[$n]["url"]: "";
                      $img = (isset($ads[$n]["img"])) ? $ads[$n]["img"]: "";
                      $num = $n + 1;
                      $image = "img".$n;
                      $title_error = "title";
                      //dd($date);
                      @endphp
                      <div class="new-Adv border row">
                        <span class="clear-data">x</span>
                        <input type="hidden" name="num[]" value="{{ $num }}">
                        <div class="form-group col-lg-5" style="text-align: center;">
                          <label class="font-weight-600 req">Adv Image {{ $n+1 }} :</label>
                          <br>
                          <div class="uc-image" style="width:150px;height:150px;">
                            <span class="clear-image-x">x</span>
                            <input type="hidden" name="img<?php echo $n; ?>" value="<?php echo $img ?>">
                            @php
                            $ad_img = ($img !="") ? "<img src=".$img." alt=''>" : "";
                            @endphp
                            <div id="img<?php echo $n; ?>" class="image_display">
                              {!! $ad_img !!}
                            </div>
                            <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#img<?php echo $n; ?>" data-link="img<?php echo $n; ?>">Add Image</a></div>
                          </div>
                          
                          <br> 
                          <label class="font-weight-600">Size : 300 x 600</label>
                          <br>
                          @if ($errors->has($image))
                                <div class="text-danger">Adv Image is Missing</div>
                          @endif
                        </div>
                        <div class="col-lg-7">
                          <input type="hidden" name="ads_id[]" value="{{ $n+1 }}">
                          <div class="form-group">
                            <label class="font-weight-600">Title :</label>
                            <input type="text" name="title[]" class="form-control" value="{{ $title }}"/>
                            @if ($errors->has($title_error))
                                <div class="text-danger">Title Field is Missing</div>
                          @endif
                          </div>
                          <div class="form-group">
                            <label class="font-weight-600">Alt Text :</label>
                            <input type="text" name="alt[]" class="form-control" value="{{ $alt }}"/>
                            
                          </div>
                          <div class="form-group">
                            <label class="font-weight-600">URL :</label>
                            <input type="text" name="url[]" class="form-control" value="{{ $url }}"/>
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
                <div class="form-group col-md-12 p-0">
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
                '<div class="form-group col-lg-5" style="text-align: center;">'+
                  '<label class="font-weight-600 req">Adv Image <span class="no" ></span> :</label>'+
                  '<br>'+
                  '<div class="uc-image" style="width:150px;height:150px;">'+
                        '<span class="clear-image-x">x</span>'+
                        '<input type="hidden" name="img" >'+
                        '<div id="img" class="image_display"></div>'+
                        '<div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#img" data-link="img">Add Image</a></div>'+
                  '</div><br>'+
                  '<label class="font-weight-600">Size : 300 x 600</label>'+
                  ' <br></div>'+
              ' <div class="col-lg-7">'+
                    '<input type="hidden" name="ads_id[]" value="">'+
                     ' <div class="form-group">'+
                       ' <label class="font-weight-600">Title  :</label>'+
                      '  <input type="text" name="title[]" class="form-control" value=""/>'+
                       ' <div class="text-danger"> </div>'+
                     ' </div>'+
                     ' <div class="form-group">'+
                       ' <label class="font-weight-600">Alt Text :</label>'+
                      '  <input type="text" name="alt[]" class="form-control" value=""/>'+
                       ' <div class="text-danger"> </div>'+
                     ' </div>'+
                      '<div class="form-group">'+
                       ' <label class="font-weight-600">URL :</label>'+
                       ' <input type="text" name="url[]" class="form-control" value=""/>'+
                        '<div class="text-danger"> </div>'+
                      '</div>'+
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
        el.find("input[type=hidden").attr("value"  , n);
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