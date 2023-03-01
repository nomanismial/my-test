@include('admin.layout.header')
@php
if(!empty(old())){
    $meta_title = old('meta_title');
    $meta_description = old('meta_description');
    $meta_tags = old('meta_tags');
    $og_image = (old('og_image') !=null)?old('og_image'):"";
    $schema_g = old("schema");
    $type_g = old("type");
    $schema = array();
    if(!empty($schema_g)){
      $t_quotes = count($schema_g);
      foreach($schema_g as $k=>$v){
      $type = $type_g[$k];
      $schema[] = array("schema"=>$v, "type"=>$type);
    }
  }
}elseif(isset($data) and !empty($data)){
  $meta_title = $data->meta_title;
  $meta_tags = $data->meta_tags;
  $meta_description = $data->meta_description;
  $og_image = $data->og_image;
  $schema = isset($data->microdata) ? json_decode($data->microdata , true) : array();
}else{
  $schema = array();
  $meta_title = $meta_tags = $meta_description  =  $og_image = "" ;
}
full_editor();
@endphp
<div class="body-content">
  <div class="row">
    <div class="col-md-10 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">FAQs Meta</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/faqs-list')}}" class="btn btn-info float-right">FAQs List</a>
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
          <form method="POST" action="/{{ admin }}/faqs/meta" enctype="multipart/form-data">
             @csrf
            <div class="row">
              <div class="col-lg-8 col-md-8">
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                <input type="hidden" name="page_name" value="{{ isset($data)?$data->page_name:'faqs'}}">
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600 req">Meta Title</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ $meta_title }}" data-count="text">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ (!empty($meta_title))?strlen($meta_title):'0'}}</span>
                    </div>
                  </div>
                  @if ($errors->has('meta_title'))
                  <div class="text-danger">{{ $errors->first('meta_title')}}</div>
                  @endif
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600 req">Meta Description</label>
                  <div class="input-group">
                    <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ $meta_description }}</textarea>
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ (!empty($meta_description))?strlen($meta_description):'0'}}</span>
                    </div>
                  </div>
                  @if ($errors->has('meta_description'))
                  <div class="text-danger">{{ $errors->first('meta_description')}}</div>
                  @endif
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Tags</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" data-count="tags" data-role="tagsinput" name="meta_tags" value="{{ $meta_tags }}">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ (!empty($meta_tags))?count(explode(",",$meta_tags)):'0'}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <div class="schema">
                    <div class="schema-rows">
                      @php
                      $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                      for ($n=0; $n <=$t_quotes; $n++){ $schema_d=(isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "" ;
                      $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                      $style=(isset($schema[$n]["type"])  ) ? 'style="display: none;"': "" ;
                      $icon=(isset($schema[$n]["type"] )) ? '<i class="fa fa-edit"></i>': '' ;
                      @endphp <div class="new-schema border row p-2">
                        <span class="clear-data2">x</span>
                        <div class="col-lg-12">
                          <div class="flex-center"><b><span class="no">{{ $n+1 }} &nbsp; - &nbsp; </span></b> <span class="schma_type">{{ $type }} {!! $icon !!}</span> <input  type="text" name="type[]" placeholder="schema name here" value="{{ $type }}"  {!! $style !!} >  </div> <br>
                          <div class="form-row">
                            <div class="form-group col-lg-12">
                              <textarea rows="6" name="schema[]" class="form-control" placeholder="Schema tag here...">{!! $schema_d !!}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      @php
                      }
                      @endphp
                    </div>
                  </div>
                  <div style="text-align:right;">
                    <a href="" class="btn btn-success add-more-schema text-white">Add More</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="card">
                  <div class="card-header card bg-secondary text-white">
                    <span style="font-weight: 600;"> OG Image &nbsp; &nbsp; &nbsp; Size: 1200 x 627 </span>
                  </div>
                  <div class="card-body">
                    <label class="font-weight-600">OG Image</label> <br>
                    <div class="uc-image" style="width: 97%;">
                      <input type="hidden" name="og_image" value="{{ $og_image }}">
                      <div id="og_image" class="image_display">
                        <img src="{{ $og_image }}" alt="">
                      </div>
                      <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#og_image" data-link="og_image">Add Image</a></div>
                    </div>
                  </div>

                </div>
                <div class="form-group col-md-12 p-0 mt-5">
                  <button type="submit" name="submit" value="submit" class="btn btn-info float-right btn-lg btn-block">Submit <span class="fa fa-paper-plane"></span></button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')
