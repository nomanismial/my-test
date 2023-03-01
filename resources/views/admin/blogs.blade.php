@include('admin.layout.header')
@php
full_editor();
if(!empty(old())){
    $btn_title          = old("btn_title");
    $btn_text           = old("btn_text");
    $btn_url            = old("btn_url");
    $title              = old("title");
    $slug               = old("slug");
    $content            = old("content");
    $meta_title         = old("meta_title");
    $meta_description   = old("meta_description");
    $meta_tags          = old("meta_tags");
    $category           = old("category");
    $btn = array();
    if(!empty($btn_title)){
        foreach($btn_title as $k=>$v){
            $txt    = isset($btn_text[$k]) ? $btn_text[$k] : "";
            $url    = isset($btn_url[$k]) ? $btn_url[$k] : "";
            $btn[]  = array("btn_title"=>$v , "btn_text"=>$txt , "btn_url"=>$url);
        }
    }

    $schema     = old("schema");
    $type       = old("type");
    $microdata = array();
    if(!empty($schema)){
        foreach($schema as $k=>$v){
            $_type       = isset($type[$k]) ? $type[$k] : "";
            $microdata[] = array("schema"=>$v , "type"=>$_type);
        }
    }

    $question   = old("question");
    $answer     = old("answer");
    $faqs       = array();
    if(!empty($question)){
        foreach($question as $k=>$v){
            $_answer    = isset($answer[$k]) ? $answer[$k] : "";
            $faqs[]     = array("question"=>$v , "answer"=>$_answer);
        }
    }

    $gr_heading     = old("gr_heading");
    $gr_body        = old("gr_body");
    $green_text     = array();
    if(!empty($gr_heading)){
        foreach($gr_heading as $k=>$v){
            $_gr_body       = isset($gr_body[$k]) ? $gr_body[$k] : "";
            $green_text[]   = array("gr_heading"=>$v , "gr_body"=>$_gr_body);
        }
    }

    $q_name     = old("q_name");
    $q_content  = old("q_content");
    $Quotes     = array();
    if(!empty($q_name)){
        foreach($q_name as $k=>$v){
            $_q_content = isset($q_content[$k]) ? $q_content[$k] : "";
            $Quotes[]   = array("q_name"=>$v , "q_content"=>$_q_content);
        }
    }

    $red_heading    = old("red_heading");
    $red_body       = old("red_body");
    $red_text       = array();
    if(!empty($red_heading)){
        foreach($red_heading as $k=>$v){
            $_red_body  = isset($red_body[$k]) ? $red_body[$k] : "";
            $red_text[] = array("red_heading"=>$v , "red_body"=>$_red_body);
        }
    }

    $black_heading  = old("black_heading");
    $black_body     = old("black_body");
    $black_text     = array();
    if(!empty($black_heading)){
        foreach($black_heading as $k=>$v){
            $_black_body    = isset($black_body[$k]) ? $black_body[$k] : "";
            $black_text[]   = array("black_heading"=>$v , "black_body"=>$_black_body);
        }
    }

}elseif(isset($data) and !empty($data)){
    $microdata          = isset($data->microdata) ?  json_decode($data->microdata , true) : array();
    $green_text         = isset($data->green_text) ?  json_decode($data->green_text , true) : array();
    $red_text           = isset($data->red_text) ?  json_decode($data->red_text , true) : array();
    $black_text         = isset($data->black_text) ?  json_decode($data->black_text , true) : array();
    $btn                = isset($data->buy_btn) ?  json_decode($data->buy_btn , true) : array();
    $faqs               = isset($data->faqs) ?  json_decode($data->faqs , true) : array();
    $Quotes             = isset($data->quotes) ?  json_decode($data->quotes , true) : array();
    $btn_title          = isset($btn['btn_title'] ) ?  $btn['btn_title'] : "";
    $btn_text           = isset($btn['btn_text'] ) ? $btn['btn_text'] : "";
    $btn_url            = isset($btn['btn_url'] )? $btn['btn_url'] : "";
    $title              = isset($data->title )? $data->title : "";
    $slug               = isset($data->slug )? $data->slug : "";
    $content            = isset($data->content )? $data->content : "";
    $meta_title         = isset($data->meta_title )? $data->meta_title : "";
    $meta_description   = isset($data->meta_description )? $data->meta_description : "";
    $meta_tags          = isset($data->meta_tags )? $data->meta_tags : "";
    $category           = (isset($data)) ? explode("," , $data->category_id) : array();
}else{
    $btn_title      = $btn_text = $btn_url = $meta_title = $title = $slug = $content = $meta_description = $meta_tags = $schema = $type = "";
    $btn        = array();
    $microdata  = array();
    $green_text = array();
    $red_text   = array();
    $black_text = array();
    $faqs       = array();
    $Quotes     = array();
    $category     = array();
}

@endphp
<div class="body-content">
    <div class="row">
        <div class="col-md-112 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if (request()->has('edit'))
                            <h6 class="fs-17 font-weight-600 mb-0">Edit Blog</h6>
                            @else
                            <h6 class="fs-17 font-weight-600 mb-0">Create New Blog</h6>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="actions">
                                <a href="{{url('/'.admin.'/blogs')}}" class="btn {{ Request::segment(2)=='blogs'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a>
                                <a href="{{url('/'.admin.'/blogs/list')}}" class="btn {{ Request::segment(2)=='blogs'  && Request::segment(3)=='list'  ? 'btn-inverse' : 'btn-info' }} pull-right">Blogs List</a>
                                <a href="{{url('/'.admin.'/blogs/category')}}" class="btn {{ Request::segment(2)=='blogs'  && Request::segment(3)=='category'  ? 'btn-inverse' : 'btn-info' }} pull-right">Add Category</a>
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
                    <form method="POST" action="/{{ admin }}/blogs" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                @if (Request::get('edit') !="")
                                    <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                @endif
                                <input type="hidden" name="date" value="{{ isset($data)? $data->date : time() }}">
                                <div class="form-group">
                                    <label class="req">Post Title</label>
                                    @php
                                    $url = (Request::get('edit')) !="" ? "":"slug";
                                    @endphp
                                    <input type="text" name="title" class="form-control cslug" value="{{ $title }}" data-link="{{ $url }}">
                                </div>
                                @error('title')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="form-group">
                                    <label class="req">Slug</label>
                                    <input type="text" name="slug" value="{{ $slug }}" class="form-control">
                                </div>
                                @error('slug')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Meta Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ $meta_title }}" data-count="text">
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{strlen($meta_title)}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Meta Description</label>
                                    <div class="input-group">
                                        <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ $meta_description }}</textarea>
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ strlen($meta_description) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Meta Tags</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" data-role="tagsinput" data-count="tags" data-role="tagsinput" name="meta_tags" value="{{ $meta_tags }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ count(explode(",",$meta_tags)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Schema </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="schema">
                                                <div class="schema-rows">
                                                    @php
                                                    $t_quotes = (count($microdata)==0) ? 0 : count($microdata) - 1;
                                                    @endphp
                                                    @for($n=0; $n <=$t_quotes; $n++)
                                                    @php
                                                    $schema_d=(isset($microdata[$n]["schema"])) ? $microdata[$n]["schema"]: "" ;
                                                    $type=(isset($microdata[$n]["type"])) ? $microdata[$n]["type"]: "" ;
                                                    $style=(Request::get('edit') and isset($microdata[$n]["type"])  ) ? 'style="display: none;"': "" ;
                                                    $icon=(Request::get('edit') and isset($microdata[$n]["type"] )) ? '<i class="fa fa-edit"></i>': '' ;
                                                    @endphp
                                                     <div class="new-schema border row p-2">
                                                        <span class="clear-data2">x</span>
                                                        <div class="col-lg-12">
                                                            <div class="flex-center"><b><span class="no">{{ $n+1 }} &nbsp; - &nbsp; </span></b> <span class="schma_type">{{ $type }} {!! $icon !!}</span> <input  type="text" name="type[]" placeholder="schema name here" value="{{ $type }}"  {!! $style !!} >  </div> <br>
                                                            <div class="form-row">
                                                                <div class="form-group col-lg-12">
                                                                    <textarea rows="6" name="schema[]" class="form-control" placeholder="Schema here..."> {!! $schema_d !!} </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div style="text-align:right;">
                                                <a href="" class="btn btn-info add-more-schema text-white"><b>Add More</b></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-success text-white">
                                            <b> Green Text </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="green">
                                                <div class="form-rows green-rows">
                                                    @php
                                                        $g_text = (count($green_text)==0) ? 0 : count($green_text) - 1;
                                                    @endphp
                                                    @for($n=0; $n <=$g_text; $n++)
                                                    @php
                                                        $gr_heading=(isset($green_text[$n]["gr_heading"])) ? $green_text[$n]["gr_heading"]: "" ;
                                                        $gr_body=(isset($green_text[$n]["gr_body"])) ? $green_text[$n]["gr_body"]: "" ;
                                                    @endphp
                                                    <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <div class="col-lg-12">
                                                            <p class="mx-auto text-center"><b> Green Text {{ $n+1 }}</b></p>
                                                            <div class="form-group">
                                                                <label>Heading</label> <span class="float-right infoSec"><i class="fa fa-info" data-toggle="tooltip" data-placement="center" title="For Urdu Text Use [[urdu]] Short Code at the end of string"></i></span>
                                                                <input type="text" name="gr_heading[]" placeholder="Heading text..." class="form-control" value="{{ $gr_heading }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Body</label>
                                                                 <div class="d-flex justify-content-between">
                                                                     <a type="button" class="text-white btn btn-info btn-sm float-right " data-toggle="modal" data-target="#shortcode-model" title="Short Code Description"> Short Codes </a > <a type="button" class="text-white btn btn-info btn-sm float-right" data-toggle="modal" data-target="#shortcode-model1" title="Notes">Notes </a>
                                                                </div>
                                                                <textarea rows="3" name="gr_body[]" class="form-control oneditor" placeholder="Answer"> {{ $gr_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endfor
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-green"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-danger text-white">
                                            <b> Red Text </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="red">
                                                <div class="form-rows red-rows">
                                                    @php
                                                    $r_text = (count($red_text)==0) ? 0 : count($red_text) - 1;
                                                    @endphp
                                                    @for($n=0; $n <=$r_text; $n++)
                                                    @php
                                                        $red_heading=(isset($red_text[$n]["red_heading"])) ? $red_text[$n]["red_heading"]: "" ;
                                                        $red_body=(isset($red_text[$n]["red_body"])) ? $red_text[$n]["red_body"]: "" ;
                                                         @endphp
                                                    <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> Red Text {{ $n+1 }}</b></p>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Heading</label>  <span class="float-right infoSec"><i class="fa fa-info" data-toggle="tooltip" data-placement="center" title="For Urdu Text Use [[urdu]] Short Code at the end of string"></i></span>
                                                                <input type="text" name="red_heading[]" placeholder="Heading text..." class="form-control" value="{{ $red_heading }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Body</label>
                                                                <div class="d-flex justify-content-between">
                                                                     <a type="button" class="text-white btn btn-info btn-sm float-right " data-toggle="modal" data-target="#shortcode-model" title="Short Code Description"> Short Codes </a > <a type="button" class="text-white btn btn-info btn-sm float-right" data-toggle="modal" data-target="#shortcode-model1" title="Notes">Notes </a>
                                                                </div>
                                                                <textarea rows="3" name="red_body[]" class="form-control oneditor" placeholder="Answer"> {{ $red_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endfor
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-red "><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-dark text-white">
                                            <b> black Text </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="black">
                                                <div class="form-rows black-rows">
                                                    @php
                                                        $b_text = (count($black_text)==0) ? 0 : count($black_text) - 1;
                                                    @endphp
                                                    @for($n=0; $n <=$b_text; $n++)
                                                    @php
                                                        $black_heading=(isset($black_text[$n]["black_heading"])) ? $black_text[$n]["black_heading"]: "" ;
                                                        $black_body=(isset($black_text[$n]["black_body"])) ? $black_text[$n]["black_body"]: "" ;
                                                    @endphp
                                                        <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> Black Text {{ $n+1 }}</b></p>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Heading</label> <span class="float-right infoSec"><i class="fa fa-info" data-toggle="tooltip" data-placement="center" title="For Urdu Text Use [[urdu]] Short Code at the end of string"></i></span>
                                                                <input type="text" name="black_heading[]" placeholder="Heading text..." class="form-control" value="{{ $black_heading }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Body</label>
                                                                <div class="d-flex justify-content-between">
                                                                     <a type="button" class="text-white btn btn-info btn-sm float-right " data-toggle="modal" data-target="#shortcode-model" title="Short Code Description"> Short Codes </a > <a type="button" class="text-white btn btn-info btn-sm float-right" data-toggle="modal" data-target="#shortcode-model1" title="Notes">Notes </a>
                                                                </div>
                                                                <textarea rows="3" name="black_body[]" class="form-control oneditor" placeholder="Answer"> {{ $black_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endfor
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-black"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Ineternal link Tags</label>
                                    <div class="input-group">
                                        <input type="text" name="internal_links" class="form-control tcount tags_input"  data-count="tags"  placeholder="Intternal links tags" name="internal_links" value="{{ isset($data)?$data->internal_links:''}}" data-id="{{ isset($data)?$data->id:''}}" autocomplete="off">

                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ isset($data)?count(explode(",",$data->internal_links)):'0'}}</span>
                                        </div>
                                        <div class='search-tags'></div>
                                    </div>
                                </div>
                                <div class="card">
                                  <div class="card-header card bg-secondary text-white">
                                    <b> Youtube Video Url </b>
                                  </div>
                                  <div class="card-body">
                                    <div class="youtubeLink">
                                      <div class="form-rows">
                                        <table class="table table-bordered">
                                          <thead>
                                            <tr>
                                              <th>#</th>
                                              <th>link</th>
                                              <th></th>
                                            </tr>
                                          </thead>
                                          <tbody  id="sortable" class=" youLinks m-tbc todo-list msortable ui-sortable">
                                            @php
                                            if(!empty(old())){
                                                $uLink = old("uLink");
                                                $youtubeLink = array();
                                                if(!empty($uLink)){
                                                    $t_link = count($uLink);
                                                    foreach($uLink as $k=>$v){
                                                        $lk = $uLink[$k];
                                                        $youtubeLink[] = array("uLink"=>$lk);
                                                    }
                                                }
                                            }elseif(isset($data) and !empty($data)){
                                                $youtubeLink = ($data->youtube_videos !="")? json_decode($data->youtube_videos , true) : array();
                                            }else{
                                                $youtubeLink = array();
                                                $times = array();
                                            }
                                            @endphp
                                            @php
                                            // dd($youtubeLink);
                                            $t_link = (count($youtubeLink)==0) ? 0 : count($youtubeLink) - 1;
                                            for ($n=0; $n<=$t_link; $n++){
                                            $uLk=( isset($youtubeLink[$n][ "uLink"])) ? $youtubeLink[$n][ "uLink"]: "";

                                            $ulinkerror = "uLink.".$n;
                                            @endphp
                                            <tr class="tr-row">
                                              <td>{{ $n+1 }}</td>
                                              <td>
                                                <div class="form-group m-0">
                                                  <input type="text" name="uLink[]" placeholder="Video Link" class="form-control" value="{{ $uLk }}"/>
                                                  @if ($errors->has($ulinkerror))
                                                  <div class="text-danger">{{ $errors->first($ulinkerror)}}</div>
                                                  @endif
                                                </div>
                                              </td>
                                              <td class="text-center"> <i class="fa fa-trash text-danger clear-item mx-auto my-auto"></i>
                                              </td>
                                            </tr>
                                            @php } @endphp
                                          </tbody>
                                        </table>
                                        <div style="text-align:right;">
                                          <a href="" class="btn btn-success add-youtube-link text-white"><i class="fa fa-plus"></i></a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <br>
                                <div class="card">
                                  <div class="card-header card bg-secondary text-white">
                                    <b> Facebook Video Url </b>
                                  </div>
                                  <div class="card-body">
                                    <div class="facebookLink">
                                      <div class="form-rows">
                                        <table class="table table-bordered">
                                          <thead>
                                            <tr>
                                              <th>#</th>
                                              <th>link</th>
                                              <th></th>
                                            </tr>
                                          </thead>
                                          <tbody  id="sortable" class=" fbLinks m-tbc todo-list msortable ui-sortable">
                                            @php
                                            if(!empty(old())){
                                                $fbLink = old("fbLink");
                                                $facebookLink = array();
                                                if(!empty($fbLink)){
                                                    $t_link = count($fbLink);
                                                    foreach($fbLink as $k=>$v){
                                                        $lk = $fbLink[$k];
                                                        $facebookLink[] = array("fbLink"=>$lk);
                                                    }
                                                }
                                            }elseif(isset($data) and !empty($data)){
                                                $facebookLink = ($data->facebook_videos !="")? json_decode($data->facebook_videos , true) : array();
                                            }else{
                                                $facebookLink = array();
                                                $times = array();
                                            }
                                            @endphp
                                            @php
                                            // dd($facebookLink);
                                            $t_link = (count($facebookLink)==0) ? 0 : count($facebookLink) - 1;
                                            for ($n=0; $n<=$t_link; $n++){
                                            $uLk=( isset($facebookLink[$n][ "fbLink"])) ? $facebookLink[$n][ "fbLink"]: "";

                                            $fblinkerror = "fbLink.".$n;
                                            @endphp
                                            <tr class="tr-row">
                                              <td>{{ $n+1 }}</td>
                                              <td>
                                                <div class="form-group m-0">
                                                  <input type="text" name="fbLink[]" placeholder="Fb Video Link : https://www.facebook.com/Qasim.Ali.Shah/videos/393010515873683/ " class="form-control" value="{{ $uLk }}"/>
                                                  @if ($errors->has($fblinkerror))
                                                  <div class="text-danger">{{ $errors->first($fblinkerror)}}</div>
                                                  @endif
                                                </div>
                                              </td>
                                              <td class="text-center"> <i class="fa fa-trash text-danger clear-item mx-auto my-auto"></i>
                                              </td>
                                            </tr>
                                            @php } @endphp
                                          </tbody>
                                        </table>
                                        <div style="text-align:right;">
                                          <a href="" class="btn btn-success add-facebook-link text-white"><i class="fa fa-plus"></i></a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <br>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                <div class="card">
                                    <div class="card-header card bg-secondary text-white">
                                        <b> Buy Button </b>
                                    </div>
                                    <div class="card-body">
                                        <div class="s-srvc">
                                            <div class="form-rows s-srvc-rows">
                                                @php
                                                $f_count = (count($btn)==0) ? 0 : count($btn) - 1;
                                                @endphp
                                                @for($n=0; $n <=$f_count; $n++)
                                                @php
                                                  $btn_text=(isset($btn[$n]["btn_text"])) ? $btn[$n]["btn_text"]: "" ;
                                                  $btn_title=(isset($btn[$n]["btn_title"])) ? $btn[$n]["btn_title"]: "" ;
                                                  $btn_url=(isset($btn[$n]["btn_url"])) ? $btn[$n]["btn_url"]: "" ;
                                                @endphp
                                                   <div class="new-s-srvc border row">
                                                    <span class="clear-data2">x</span>
                                                    <p class="mx-auto text-center"><b> Buy Button {{ $n+1 }}</b></p>
                                                    <input type="hidden" name="num[]" value="{{ $n+1 }}">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Title Text :</label>
                                                            <textarea rows="3" name="btn_title[]" class="form-control oneditor" placeholder="Title Text">{!! $btn_title !!}</textarea>
                                                            <div class="text-danger"> </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6">
                                                                <label>Button Text</label>
                                                                <input type="text" name="btn_text[]" placeholder="like : Buy Now" class="form-control" value="{{ $btn_text }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <label>Url :</label>
                                                                <input type="text" name="btn_url[]" placeholder="Url" class="form-control" value="{{ $btn_url }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                      </div>
                                                    </div>
                                                </div>
                                                @endfor
                                            </div>
                                            <div style="text-align:right;">
                                                <a href="" class="btn btn-info add-s-srvc"><b>Add More</b></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="form-group">
                                    <label class="font-weight-600 req">Content:</label>
                                    <div class="d-flex justify-content-between">
                                        <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="editor" data-return="#oneditor" data-link="image" >Add Image</a> <span>&nbsp; Image Size [ width = <small>800px </small> ]</span> </div>
                                        <div style="margin-top:10px;">  <a type="button" class="text-white btn btn-info btn-sm float-right " data-toggle="modal" data-target="#shortcode-model" title="Short Code Description"> Short Codes </a > <a type="button" class="text-white btn btn-info btn-sm float-right mr-2" data-toggle="modal" data-target="#shortcode-model1" title="Notes">Notes </a></div>
                                    </div>
                                    <textarea class="form-control oneditor" rows="35" name="content" id="oneditor">{{ isset($data)?$data->content:''}}</textarea>
                                </div>
                                @error('content')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Blog FAQs </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="faqs">
                                                <div class="form-rows faqs-rows">
                                                    @php
                                                    $f_count = (count($faqs)==0) ? 0 : count($faqs) - 1;
                                                    @endphp
                                                    @for($n=0; $n <=$f_count; $n++)
                                                    @php
                                                        $question=(isset($faqs[$n]["question"])) ? $faqs[$n]["question"]: "" ;
                                                        $answer=(isset($faqs[$n]["answer"])) ? $faqs[$n]["answer"]: "" ;
                                                        @endphp
                                                        <div class="new-faqs border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> FAQs {{ $n+1 }}</b></p>
                                                        <input type="hidden" name="num[]" value="{{ $n+1 }}">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Question</label>
                                                                <span class="float-right infoSec"><i class="fa fa-info" data-toggle="tooltip" data-placement="center" title="For Urdu Text Use [[urdu]] Short Code at the end of string"></i></span>
                                                                <input type="text" name="question[]" placeholder="Question" class="form-control" value="{{ isset($data)? $question:"" }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Answer</label>
                                                                <div class="d-flex justify-content-between">
                                                                     <a type="button" class="text-white btn btn-info btn-sm float-right " data-toggle="modal" data-target="#shortcode-model" title="Short Code Description"> Short Codes </a > <a type="button" class="text-white btn btn-info btn-sm float-right" data-toggle="modal" data-target="#shortcode-model1" title="Notes">Notes </a>
                                                                </div>
                                                                <textarea rows="3" name="answer[]" class="form-control oneditor" placeholder="Answer">{{ isset($data)? $answer:"" }}</textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endfor
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-faqs"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Quotes </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="quotes">
                                                <div class="form-rows quotes-rows">
                                                    @php
                                                    $f_count = (count($Quotes)==0) ? 0 : count($Quotes) - 1;
                                                    @endphp
                                                    @for($n=0; $n <=$f_count; $n++)
                                                        @php
                                                            $q_name=(isset($Quotes[$n]["q_name"])) ? $Quotes[$n]["q_name"]: "" ;
                                                            $q_content=(isset($Quotes[$n]["q_content"])) ? $Quotes[$n]["q_content"]: "" ;
                                                        @endphp
                                                    <div class="new-quotes border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> Quote {{ $n+1 }}</b></p>
                                                        <input type="hidden" name="num[]" value="{{ $n+1 }}">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Author</label>
                                                                <input type="text" name="q_name[]" placeholder="Author" class="form-control" value="{{ isset($data)? $q_name:"" }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Quote</label>
                                                                <textarea rows="3" name="q_content[]" class="form-control" placeholder="Quote">{{ isset($data)? $q_content:"" }}</textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endfor
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-quotes"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Category </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="skin-line">
                                                @foreach ($cats as $ct)
                                                <div class="i-check">
                                                    <input tabindex="17" type="checkbox" value="{{ $ct->id }}" name="category[]" id="line-checkbox-1" {{ (in_array($ct->id, $category))?'checked':''}}>
                                                    <label for="line-checkbox-1">{{ $ct->name }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 ">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Author </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="skin-line">
                                                @php
                                                $author = isset($data->author_id) ? $data->author_id : "" ;
                                                @endphp
                                                <select name="author" class="form-control">
                                                    <option value="">Please Select Author</option>
                                                    @foreach ($auth as $k => $v)
                                                    @php
                                                    $selected = ($v->id == $author) ? "selected=selected" : "" ;
                                                    @endphp
                                                    <option value="{{ $v->id}}" {{ $selected }}>{{ $v->name}}</option>
                                                    @endforeach
                                                </select>
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
                                            $cover = (isset($data) !="" and $data->cover !="") ? "<img class='crop-img' src=".$data->cover." alt=''>" : "";
                                            @endphp
                                            <div class="uc-image" style="width: 97%;">
                                                <span class="clear-image-x">x</span>
                                                <input type="hidden" name="cover-image" value="{{ isset($data)? $data->cover :"" }}">
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
                                                <span class="clear-image-x">x</span>
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
                                <div class="form-group col-lg-12 col-md-12 _Wd ">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b><span> <b>Updated Date : </b> {{ isset($data)?date("d M Y" , $data->date) : "" }} </span></b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-lg-12">
                                                <label for="example-date-input" class=" col-form-label font-weight-600">Updated Date</label>
                                                <div class="col-lg-12" style="position: relative">
                                                    {{-- <input class="form-control update_date" name="update_date" type="date" value="" > --}}
                                                    <input type="text" class="form-control" name="update_date" placeholder="dd/mm/yyyy" id="datepicker" value="{{ isset($data)?date("d-m-Y" , $data->date) : "" }}"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 w-100 " style="position: relative;">
                                    <div class="card _card fixme">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Submit Record</b>
                                        </div>
                                        <div class="card-body">
                                            <button type="submit" name="submit" value="draft" class="btn btn-info float-left">Draft </button> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                            <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Publish </button>
                                        </div>
                                    </div>
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


var cloneSrvc = '<div class="new-s-srvc border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> Buy Button <span class="no"></span> </b></p>' +
    '<input type="hidden" name="num[]" value="">' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Title Text :</label>' +
            '<textarea rows="3" name="btn_title[]" class="form-control oneditor" placeholder="Title Text" ></textarea>' +
            '<div class="text-danger"> </div>' +
        ' </div>' +
        '<div class="form-row">'+
            '<div class="form-group col-lg-6">' +
                '<label>Button Text :</label>' +
                '<input type="text" name="btn_text[]" placeholder="Like : Buy Now" class="form-control" value=""/>' +
                '<div class="text-danger"> </div>' +
            '</div>' +
            '<div class="form-group col-lg-6">' +
                '<label>Url :</label>' +
                '<input type="text" name="btn_url[]" placeholder="Url" class="form-control" value=""/>' +
                '<div class="text-danger"> </div>' +
            '</div>' +
        '</div>'+
    '</div>' +
'</div>';
$(".add-s-srvc").click(function(e) {
    e.preventDefault();
    var html_obj = cloneSrvc;
    $(".s-srvc .s-srvc-rows").append(html_obj);
    var n = $(".s-srvc .s-srvc-rows").find(".new-s-srvc").length;
    var el = $(".s-srvc .s-srvc-rows .new-s-srvc:nth-child(" + n + ")");
    el.find(".no").text(n);
    el.find('input[name="num[]"]').val(n);
    _full_Ed();
    return false;
});

var cloneg = '<div class="new-review border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> Green Text <span class="no"></span> </b></p>' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Heading</label>' +
            '<input type="text" name="gr_heading[]" placeholder="Heading text..." class="form-control" value=""/>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
        '<div class="form-group">' +
            '<label>Body</label>' +
            '<textarea rows="3" name="gr_body[]" class="form-control oneditor" placeholder="Body text..." ></textarea>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
    '</div>' +
'</div>'
$(".add-green").click(function(e) {
e.preventDefault();
var html_obj = cloneg;
var ln = $(".form-rows .row").length;
$(html_obj).find("input").each(function() {
$(this).attr("value", "");
});
$(html_obj).find("textarea").each(function() {
$(this).text("");
});
$(html_obj).find("img").remove();
$(".green .form-rows").append(html_obj);
var n = $(".green .form-rows").find(".new-review").length;
var el = $(".green .form-rows .new-review:nth-child(" + n + ")");
el.find(".no").text(n);
_full_Ed();
return false;
});

var cloner = '<div class="new-review border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> Red Text <span class="no"></span> </b></p>' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Heading</label>' +
            '<input type="text" name="red_heading[]" placeholder="Heading text...." class="form-control" value=""/>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
        '<div class="form-group">' +
            '<label>Body</label>' +
            '<textarea rows="3" name="red_body[]" class="form-control oneditor" placeholder="Body text..." ></textarea>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
    '</div>' +
'</div>'
$(".add-red").click(function(e) {
e.preventDefault();
var html_obj = cloner;
var ln = $(".form-rows .row").length;
$(html_obj).find("input").each(function() {
$(this).attr("value", "");
});
$(html_obj).find("textarea").each(function() {
$(this).text("");
});
$(html_obj).find("img").remove();
$(".red .form-rows").append(html_obj);
var n = $(".red .form-rows").find(".new-review").length;
var el = $(".red .form-rows .new-review:nth-child(" + n + ")");
el.find(".no").text(n);
_full_Ed();
return false;
});
var cloneb = '<div class="new-review border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> Black Text <span class="no"></span> </b></p>' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Heading</label>' +
            '<input type="text" name="black_heading[]" placeholder="Heading text..." class="form-control" value=""/>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
        '<div class="form-group">' +
            '<label>Body</label>' +
            '<textarea rows="3" name="black_body[]" class="form-control oneditor" placeholder="body tex...t" ></textarea>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
    '</div>' +
'</div>'
$(".add-black").click(function(e) {
e.preventDefault();
var html_obj = cloneb;
var ln = $(".form-rows .row").length;
$(html_obj).find("input").each(function() {
$(this).attr("value", "");
});
$(html_obj).find("textarea").each(function() {
$(this).text("");
});
$(html_obj).find("img").remove();
$(".black .form-rows").append(html_obj);
var n = $(".black .form-rows").find(".new-review").length;
var el = $(".black .form-rows .new-review:nth-child(" + n + ")");
el.find(".no").text(n);
_full_Ed();
return false;
});
var clonefaqs = '<div class="new-faqs border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> FAQs <span class="no"></span> </b></p>' +
    '<input type="hidden" name="num[]" value="">' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Question</label>' +
            '<input type="text" name="question[]" placeholder="Question" class="form-control" value=""/>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
        ' <div class="form-group">' +
            '<label>Answer</label>' +
            '<textarea rows="3" name="answer[]" class="form-control oneditor" placeholder="Answer" ></textarea>' +
            '<div class="text-danger"> </div>' +
        ' </div>' +
    '</div>' +
'</div>';
    $(".add-faqs").click(function(e) {
        e.preventDefault();
        var html_obj = clonefaqs;
        $(".faqs .faqs-rows").append(html_obj);
        var n = $(".faqs .faqs-rows").find(".new-faqs").length;
        var el = $(".faqs .faqs-rows .new-faqs:nth-child(" + n + ")");
        el.find(".no").text(n);
        el.find('input[name="num[]"]').val(n);
        _full_Ed();
        return false;
    });

    var clonequotes = '<div class="new-quotes border row">'+
                    '<span class="clear-data2">x</span>'+
                    '<p class="mx-auto text-center"><b> Quote <span class="no"></span></b></p>'+
                    '<input type="hidden" name="num[]" value="">'+
                    '<div class="col-lg-12">'+
                        '<div class="form-group">'+
                            '<label>Author</label>'+
                            '<input type="text" name="q_name[]" placeholder="Author" class="form-control" value="" />'+
                            '<div class="text-danger"> </div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label>Quote</label>'+
                            '<textarea rows="3" name="q_content[]" class="form-control" placeholder="Quote"></textarea>'+
                            '<div class="text-danger"> </div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
    $(".add-quotes").click(function(e) {
        e.preventDefault();
        var html_obj = clonequotes;
        $(".quotes .quotes-rows").append(html_obj);
        var n = $(".quotes .quotes-rows").find(".new-quotes").length;
        var el = $(".quotes .quotes-rows .new-quotes:nth-child(" + n + ")");
        el.find(".no").text(n);
        el.find('input[name="num[]"]').val(n);
        _full_Ed();
        return false;
    });
    $( ".add-youtube-link" ).click( function () {
        var html_obj = $( ".youLinks tr" ).first().clone();
        var ln = $( ".youLinks tr" ).length;
        $( html_obj ).find( "input" ).each( function () {
            $( this ).attr( "value", "" );
        });
        $( html_obj ).find( "textarea" ).each( function () {
            $( this ).text( "" );
        });
        html_obj.find( "td:first-child" ).text( parseInt( ln ) + 1 );
        $( ".youtubeLink .youLinks" ).append( "<tr>" + html_obj.html() + "</tr>" );
        return false;
    });
    $( ".add-facebook-link" ).click( function () {
        var html_obj = $( ".fbLinks tr" ).first().clone();
        var ln = $( ".fbLinks tr" ).length;
        $( html_obj ).find( "input" ).each( function () {
            $( this ).attr( "value", "" );
        });
        $( html_obj ).find( "textarea" ).each( function () {
            $( this ).text( "" );
        });
        html_obj.find( "td:first-child" ).text( parseInt( ln ) + 1 );
        $( ".facebookLink .fbLinks" ).append( "<tr>" + html_obj.html() + "</tr>" );
        return false;
    });
    $( document ).on( "click", ".clear-item", function () {
        var v = window.confirm( "Do you want to delete data?" );
        if ( v ) {
            $( this ).closest( "tr" ).remove();
        }
    });
});
</script>
