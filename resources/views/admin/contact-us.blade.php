
@include('admin.layout.header')
@php
tiny_editor();
@endphp
<div class="body-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Contact us </h6>
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
                     @if (count($errors) > 0)
                      <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
            {{--             <ul>
                          @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                          @endforeach
                        </ul> --}}
                      </div>
                      @endif
                    <form method="POST" action="{{ route('contactus') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                @php
                                    $url = (Request::get('edit')) !="" ? "":"slug";
                                @endphp
                                    <div class="form-group col-md-12 p-0">
                                        <label class="font-weight-600 req">Meta Title</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ (!empty($data->meta_title))?$data->meta_title:''}}" data-count="text">
                                            <div class="input-group-append">
                                                <span class="input-group-text count countshow">{{ (!empty($data->meta_title))?strlen($data->meta_title):'0'}}</span>
                                            </div>
                                        </div>
                                        @error('meta_title')
                                          <div class="text-danger">{{ $message }}</div>
                                          @enderror
                                    </div>
                                    <div class="form-group col-md-12 p-0">
                                        <label class="font-weight-600 req">Meta Description</label>
                                        <div class="input-group">
                                            <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ (!empty($data->meta_description))?$data->meta_description:''}}</textarea>
                                            <div class="input-group-append">
                                                <span class="input-group-text count countshow">{{ (!empty($data->meta_description))?strlen($data->meta_description):'0'}}</span>
                                            </div>
                                        </div>
                                        @error('meta_description')
                                          <div class="text-danger">{{ $message }}</div>
                                          @enderror
                                    </div>
                                    <div class="form-group col-md-12 p-0">
                                        <label class="font-weight-600">Meta Tags</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control tcount" data-count="tags" data-role="tagsinput" name="meta_tags" value="{{ (!empty($data->meta_tags))?$data->meta_tags:''}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text count countshow">{{ (!empty($data->meta_tags))?count(explode(",",$data->meta_tags)):'0'}}</span>
                                            </div>
                                        </div>
                                        @error('meta_tags')
                                          <div class="text-danger">{{ $message }}</div>
                                          @enderror
                                    </div>
                                    <div class="form-group col-md-12 p-0">
                                         <div class="schema">
                                            <div class="schema-rows">
                                              @php
                                                if(!empty(old())){
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
                                                    $schema = isset($data->microdata) ? json_decode($data->microdata , true) : array();
                                                  }else{
                                                      $schema = array();
                                                  }
                                              @endphp
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
                                            <a href="" class="btn btn-info add-more-schema text-white"><b>Add More</b></a>
                                          </div>
                                    </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Receiving Email <small> Multiple Emails seprated by comma</small></label>
                                    <input type="text" name="r_email" class="form-control" data-role="tagsinput"  value="{{ isset($data)?$data->r_email:''}}" >
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Office Details </b>
                                        </div>
                                        @php
                                            $email = (!empty($data->email))?$data->email:'';
                                            $phone = (!empty($data->phone))?$data->phone:'';
                                        @endphp
                                        <div class="card-body">

                                            <div class="form-row">
                                                <div class="form-group col-lg-12 col-md-12 ">
                                                    <label class="font-weight-600">Email</label>
                                                    <input type="email" name="email" class="form-control" placeholder="example@gmail.com" value="{{ $email }}">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-12 col-md-12 ">
                                                    <label class="font-weight-600">Phone </label>
                                                    <input type="text" name="phone" class="form-control" placeholder="+93 343 786 1234" value="{{ $phone }}">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-12 col-md-12 ">
                                                    <label class="font-weight-600">Address </label>
                                                    <textarea class="form-control" placeholder="Address" rows="2" name="address" >{!! isset($data)?$data->address:'' !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <span><b> Cover Image [ Exact Size <small> 300 x 200</small>  ] </b> <a  class="text-white float-right" href="" ></a></span>
                                        </div>
                                        <div class="card-body">
                                            @php
                                            $cover = (isset($data) !="" and $data->cover_image !="") ? "<img class='crop-img' src=".$data->cover_image." alt=''>" : "";
                                            @endphp
                                            <div class="uc-image" style="width: 97%;">
                                                <input type="hidden" name="cover-image" value="{{ isset($data)? $data->cover_image :"" }}">
                                                <div id="coover" class="image_display" style="display:block;">
                                                    {!! $cover !!}
                                                </div>
                                                <div style="margin-top:10px;">
                                                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#coover" data-link="cover-image">Add Image</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <span style="font-weight: 600;"> OG Image [ Min Size: <small> 1200 x 630 </small>  ] </span>
                                        </div>
                                        <div class="card-body">
                                            @php
                                            $og_image = (isset($data) !=""  and $data->og_image !="") ? "<img src=".$data->og_image." alt=''>" : "";
                                            @endphp
                                            <div class="uc-image" style="width: 97%;">
                                                <input type="hidden" name="og-image" value="{{ isset($data->og_image)?$data->og_image :"" }}">
                                                <div id="og-image" class="image_display" style="display:block;">
                                                    {!! $og_image !!}
                                                </div>
                                                <div style="margin-top:10px;">
                                                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#og-image" data-link="og-image">Add Image</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12">
                                <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Submit </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
  @include('admin.layout.footer')
