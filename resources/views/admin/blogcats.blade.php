@include('admin.layout.header')
@php
  full_editor();
@endphp
@php
if(!empty(old())){
  $meta_title = old('meta_title');
  $name = old('name');
  $meta_description = old('meta_description');
  $meta_tags = old('meta_tags');
  $before_title = old('before_title');
  $before_details = old('before_details');
  $after_title = old('after_title');
  $after_details = old('after_details');
  $home_title = old('home_title');
  $home_details = old('home_details');
  $popular_title = old('popular_title');
  $popular_details = old('popular_details');
  $before_popular = old('before_popular');
  $after_popular = old('after_popular');
  $popular_popular = old('popular_popular');
  $slug = old('slug');
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
}elseif(isset($edit) and !empty($edit)){
  $name = $edit->name;
  $meta_title = $edit->meta_title;
  $meta_tags = $edit->meta_tags;
  $meta_description = $edit->meta_description;
  $before_title = $edit->before_title;
  $before_details = $edit->before_details;
  $after_title = $edit->after_title;
  $after_details = $edit->after_details;
  $home_title = $edit->home_title;
  $home_details = $edit->home_details;
  $popular_title = $edit->popular_title;
  $popular_details = $edit->popular_details;
  $before_popular = $edit->before_popular;
  $after_popular = $edit->after_popular;
  $popular_popular = $edit->popular_popular;
  $slug = $edit->slug;
  $og_image = $edit->og_image;
  $schema = ($edit->microdata !=null)?json_decode($edit->microdata , true) : array();
}else{
  $schema = array();
  $meta_title = $name = $meta_tags = $meta_description  = $before_title = $before_details = $after_title = $after_details = $home_title = $home_details = $popular_title = $popular_details = $slug  = $og_image =  "" ;
  $before_popular = $after_popular = $popular_popular = 1;
}
@endphp
  <div class="body-content">
  <div class="row">
      <div class="col-md-6 col-lg-8">
      <div class="card mb-4">
          <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
              <div>
              <h6 class="fs-17 font-weight-600 mb-0">Add Category</h6>
            </div>
              <div class="text-right">
              <div class="actions"> <a href="{{url('/'.admin.'/blogs')}}" class="btn {{ Request::segment(2)=='blogs'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a> <a href="{{url('/'.admin.'/blogs/list')}}" class="btn {{ Request::segment(2)=='blogs'  && Request::segment(3)=='list'  ? 'btn-inverse' : 'btn-info' }} pull-right">Blogs List</a> </div>
            </div>
            </div>
        </div>
          <div class="card-body"> @if (Session::has('flash_message'))
          <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>{!! Session('flash_message') !!}</strong> </div>
          @endif
          @if (count($errors) > 0)
          <div class="alert alert-danger"> <strong>Whoops!</strong> There were some problems with your input.<br>
              <br>
            </div>
          @endif
          <form method="POST" action="/{{ admin }}/blogs/cats-store" enctype="multipart/form-data">
              @csrf
              @php
              $url = (Request::get('edit')) !="" ? "":"slug";
              @endphp
              <div class="row">
              <div class="col-lg-12 col-md-12">
                  <input type="hidden" name="id" value="{{ ($edit !="")?$edit->
                  id:''}}">
                  <div class="form-group col-md-12 p-0">
                      <label class="font-weight-600 req">Name </label>
                      <input type="text" name="name" class="form-control cslug"  value="{{ $name }}"  data-link="{{ $url }}">
                      @error('name')
                      <p class="text-danger">{{ $message }}</p>
                      @enderror
                  </div>
                  <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600 req">Slug</label>
                  <input type="text" name="slug" value="{{ $slug }}" class="form-control">
                  @error('slug')
                  <p class="text-danger">{{ $message }}</p>
                  @enderror </div>
                  <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600 req">Meta Title</label>
                  <div class="input-group">
                      <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ $meta_title }}" data-count="text">
                      <div class="input-group-append"> <span class="input-group-text count countshow">{{ ($edit !="")?strlen($edit->meta_title):'0'}}</span> </div>
                    </div>
                  @error('meta_title')
                  <p class="text-danger">{{ $message }}</p>
                  @enderror </div>
                  <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Description</label>
                  <div class="input-group">
                      <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ $meta_description }}</textarea>
                      <div class="input-group-append"> <span class="input-group-text count countshow">{{ ($edit !="")?strlen($edit->meta_description):'0'}}</span> </div>
                    </div>
                </div>
                  <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Tags</label>
                  <div class="input-group">
                      <input type="text" class="form-control tcount" data-count="tags" data-role="tagsinput" name="meta_tags" value="{{ $meta_tags }}">
                      <div class="input-group-append"> <span class="input-group-text count countshow">{{ ($edit !="")?count(explode(",",$edit->meta_tags)):'0'}}</span> </div>
                    </div>
                </div>
                  <div class="form-group col-md-12 p-0">
                  <div class="schema">
                      <div class="schema-rows"> @php
                      $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                      for ($n=0; $n <=$t_quotes; $n++){
                      $schema_d = (isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "";
                      $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                      $style=(isset($schema[$n]["type"]) and $schema[$n]["type"] !="" ) ? 'style="display: none;"': "" ;
                      $icon=(isset($schema[$n]["type"]) and $schema[$n]["type"] !="") ? '<i class="fa fa-edit"></i>': '' ;
                      @endphp
                      <div class="new-schema border row p-2"> <span class="clear-data2">x</span>
                          <div class="col-lg-12">
                          <div class="flex-center"><b><span class="no">{{ $n+1 }} &nbsp; - &nbsp; </span></b> <span class="schma_type">{{ $type }} {!! $icon !!}</span>
                              <input  type="text" name="type[]" placeholder="schema name herre" value="{{ $type }}"  {!! $style !!} >
                            </div>
                          <br>
                          <div class="form-row">
                              <div class="form-group col-lg-12">
                              <textarea rows="6" name="schema[]" class="form-control" placeholder="type Your Quotes heere..." > {!! $schema_d !!} </textarea>
                            </div>
                            </div>
                        </div>
                        </div>
                      @php
                      }
                      @endphp </div>
                    </div>
                  <div style="text-align:right;"> <a href="" class="btn btn-success add-more-schema text-white">Add More</a> </div>
                </div>
                  <div class="form-group col-lg-6">
                  <label class="font-weight-600">OG Image <small>Size: 1200 x 630 </small></label>
                  <br>
                  <div class="uc-image" style="width: 97%;">
                      <input type="hidden" name="og_image" value="{{ $og_image }}">
                      <div id="og_image" class="image_display" > @if ($og_image !="") <img src="{{ $og_image }}" alt="OG Image"> @endif </div>
                      <div style="margin-top:10px;"> <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#og_image" data-link="og_image">Add Image</a> </div>
                    </div>
                </div>
                <fieldset>
                  <legend> Before Popular </legend>
                  <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-600 req">Title Before Popular Post</label>
                            <input type="text" name="before_title" class="form-control cslug"  value="{{ $before_title }}">
                            @error('before_title')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-600">No. Of Row Before Popular Post</label>
                            <div class="input-group">
                            <input type="number" class="form-control tcount" placeholder="" name="before_popular" value="{{ $before_popular }}" > </div>
                          </div>
                        <div class="form-group col-lg-12 p-0">
                            <label class="font-weight-600">Details</label>
                            <textarea class="form-control oneditor"  rows="5" name="before_details" data-count="text">{{ $before_details }}</textarea>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                  <legend> After Popular </legend>
                  <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-600">Title After Popular Post</label>
                            <input type="text" name="after_title" class="form-control cslug"  value="{{ $after_title }}">
                            @error('after_title')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-600">No. Of Row After Popular Post</label>
                            <div class="input-group">
                            <input type="number" class="form-control tcount" placeholder="" name="after_popular" value="{{ $after_popular }}" > </div>
                          </div>
                        <div class="form-group col-lg-12 p-0">
                            <label class="font-weight-600">Details</label>
                            <textarea class="form-control oneditor"  rows="5" name="after_details" data-count="text">{{ $after_details }}</textarea>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                  <legend> Popular </legend>
                  <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-600">Title Popular Post</label>
                            <input type="text" name="popular_title" class="form-control cslug"  value="{{ $popular_title }}">
                            @error('popular_title')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-600">No. Of Row Popular Post</label>
                            <div class="input-group">
                            <input type="number" class="form-control tcount" placeholder="" name="popular_popular" value="{{ $popular_popular }}" > </div>
                          </div>
                        <div class="form-group col-lg-12 p-0">
                            <label class="font-weight-600">Details</label>
                            <textarea class="form-control oneditor"  rows="5" name="popular_details" data-count="text">{{ $popular_details }}</textarea>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                  <legend> Home Page </legend>
                  <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-600">Title Home Page </label>
                            <input type="text" name="home_title" class="form-control cslug"  value="{{ $home_title }}">
                            @error('home_title')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-600">No. Of Row Home Page </label>
                            <div class="input-group">
                            <input type="number" class="form-control tcount" placeholder="" name="home_popular" value="{{ ($edit !="")?$edit->
                            home_popular:1}}" > </div>
                          </div>
                        <div class="form-group col-lg-12 p-0">
                            <label class="font-weight-600">Details</label>
                            <textarea class="form-control oneditor"  rows="5" name="home_details" data-count="text">{{ $home_details }}</textarea>
                        </div>
                    </div>
                </fieldset>
                <br>
                  <div class="form-group col-md-12 p-0">
                    <button type="submit" name="submit" value="submit" class="btn btn-info float-right">Submit <span class="fa fa-paper-plane"></span></button>
                  </div>
                </div>
            </div>
            </form>
        </div>
        </div>
    </div>
      <div class="col-md-6 col-lg-4">
      <div class="card mb-4">
          <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
              <div>
              <h6 class="fs-17 font-weight-600 mb-0">Category List</h6>
            </div>
              <div class="text-right">
              <div class="actions"> </div>
            </div>
            </div>
        </div>
          <div class="card-body"> @if (Session::has('flash_message2'))
          <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>{!! Session('flash_message2') !!}</strong> </div>
          @endif
          <form action="{{ route('category-order') }}" method="post">
              @csrf
              <div class="row">
              <div class="col-lg-12">
                  <div class="form-group">
                  <ol id="sortable" class="m-tbc todo-list msortable ui-sortable">
                      @foreach($cats as $cat)
                      <li title="">
                      <input type="hidden" name="order[]" value="{{ $cat->id }}" class="form-control"/>
                      <b>{{$cat->name}}</b>
                      <div class="float-right"> <a href="{{url('/'.admin.'/blogs/category?edit='.$cat->id)}}" class="btn-success-soft  mr-1 fa fa-edit fa-lg" title="Edit"></a> <a href="{{url('/'.admin.'/blogs/category?del='.$cat->id)}}" class="btn-danger-soft  fa fa-trash fa-lg sconfirm" title="Delete"></a> </div>
                    </li>
                      @endforeach
                    </ol>
                </div>
                  <div class="form-group">
                  <input type="submit" name="submit_order" value="submit" class="btn btn-info float-right"/>
                </div>
                </div>
            </div>
              <br>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>
@include('admin.layout.footer')
