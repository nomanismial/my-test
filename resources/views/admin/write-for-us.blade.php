@include('admin.layout.header')
@php
full_editor();
@endphp
<div class="body-content">
    <div class="row">
        <div class="col-md-112 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Write For Us</h6>
                        </div>
                        <div class="text-right">
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
                    <form method="POST" action="{{ route('write-us') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                            <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                <input type="hidden" name="date" value="{{ isset($data)? $data->date : time() }}">
                                <div class="form-group">
                                    <label class="req">Post Title</label>
                                    @php
                                    $url = (Request::get('edit')) !="" ? "":"slug";
                                    @endphp
                                    <input type="text" name="title" class="form-control cslug" value="{{ isset($data)?$data->title:''}}" data-link="{{ $url }}">
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Meta Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ isset($data)?$data->meta_title:''}}" data-count="text">
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_title):'0'}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Meta Description</label>
                                    <div class="input-group">
                                        <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ isset($data)?$data->meta_description:''}}</textarea>
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_description):'0'}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Meta Tags</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" data-role="tagsinput" data-count="tags" data-role="tagsinput" name="meta_tags" value="{{ isset($data)?$data->meta_tags:''}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ isset($data)?count(explode(",",$data->meta_tags)):'0'}}</span>
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
                                                    $schema = isset($data)? json_decode($data->microdata , true) : array();
                                                    $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                                                    for ($n=0; $n <=$t_quotes; $n++){
                                                    $schema_d=(isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "" ;
                                                    $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                                                    $style=(Request::get('edit') and isset($schema[$n]["type"])  ) ? 'style="display: none;"': "" ;
                                                    $icon=(Request::get('edit') and isset($schema[$n]["type"] )) ? '<i class="fa fa-edit"></i>': '' ;
                                                    @endphp <div class="new-schema border row p-2">
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
                                                    @php
                                                    }
                                                    @endphp
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
                                                    $res = (isset($data) and $data->green_text !="" ) ? json_decode($data->green_text , true) : array();
                                                    $g_text = (count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$g_text; $n++){ $gr_heading=(isset($res[$n]["gr_heading"])) ? $res[$n]["gr_heading"]: "" ; $gr_body=(isset($res[$n]["gr_body"])) ? $res[$n]["gr_body"]: "" ; @endphp 
                          <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <div class="col-lg-12">
                                                            <p class="mx-auto text-center"><b> Green Text {{ $n+1 }}</b></p>
                                                            <div class="form-group">
                                                                <label>Heading</label>
                                                                <input type="text" name="gr_heading[]" placeholder="Heading text..." class="form-control" value="{{ $gr_heading }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Body</label>
                                                                <textarea rows="3" name="gr_body[]" class="form-control oneditor" placeholder="Answer"> {{ $gr_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php } @endphp
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
                                                    $res =  (isset($data) and $data->red_text !="" )? json_decode($data->red_text , true) : array();
                                                    $r_text = (count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$r_text; $n++){ $red_heading=(isset($res[$n]["red_heading"])) ? $res[$n]["red_heading"]: "" ; $red_body=(isset($res[$n]["red_body"])) ? $res[$n]["red_body"]: "" ; @endphp <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> Red Text {{ $n+1 }}</b></p>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Heading</label>
                                                                <input type="text" name="red_heading[]" placeholder="Heading text..." class="form-control" value="{{ $red_heading }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Body</label>
                                                                <textarea rows="3" name="red_body[]" class="form-control oneditor" placeholder="Answer"> {{ $red_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php } @endphp
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
                                                    $res =  (isset($data) and $data->black_text !="" )? json_decode($data->black_text , true) : array();
                                                    $b_text = (count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$b_text; $n++){ $black_heading=(isset($res[$n]["black_heading"])) ? $res[$n]["black_heading"]: "" ; $black_body=(isset($res[$n]["black_body"])) ? $res[$n]["black_body"]: "" ; @endphp <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> Black Text {{ $n+1 }}</b></p>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Heading</label>
                                                                <input type="text" name="black_heading[]" placeholder="Heading text..." class="form-control" value="{{ $black_heading }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Body</label>
                                                                <textarea rows="3" name="black_body[]" class="form-control oneditor" placeholder="Answer"> {{ $black_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php } @endphp
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-black"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Inernal link Tags</label>
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
                                                $youtubeLink = isset($data->youtube_videos)? json_decode($data->youtube_videos , true) : array();
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
                                <div class="form-group">
                                    <label class="font-weight-600 req">Content:</label>
                                    <div class="row d-flex justify-content-between">
                                        <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="editor" data-return="#oneditor" data-link="image" >Add Image</a> <span>&nbsp; Image Size [ width = <small>800px </small> ]</span> </div>
                                        <div style="margin-top:10px;">  <a type="button" class="btn btn-info btn-sm float-right " data-toggle="modal" data-target="#shortcode-model"><i class="fa fa-info"></i> &nbsp; Short Codes Discription</a> </div>
                                    </div>
                                    <textarea class="form-control oneditor" rows="35" name="content" id="oneditor">{{ isset($data)?$data->content:''}}</textarea>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Blog FAQs </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="faqs">
                                                <div class="form-rows faqs-rows">
                                                    @php
                                                    $res = (isset($data) and $data->faqs!=null )? json_decode($data->faqs , true) : array();
                                                    $f_count = (count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$f_count; $n++){ $question=(isset($res[$n]["question"])) ? $res[$n]["question"]: "" ; $answer=(isset($res[$n]["answer"])) ? $res[$n]["answer"]: "" ; @endphp <div class="new-faqs border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> FAQs {{ $n+1 }}</b></p>
                                                        <input type="hidden" name="num[]" value="{{ $n+1 }}">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Question</label>
                                                                <input type="text" name="question[]" placeholder="Question" class="form-control" value="{{ isset($data)? $question:"" }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Answer</label>
                                                                <textarea rows="3" name="answer[]" class="form-control oneditor" placeholder="Answer">{{ isset($data)? $answer:"" }}</textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                    }
                                                    @endphp
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
                                                    $res = (isset($data) && $data->quotes !=Null )? json_decode($data->quotes , true) : array();
                                                    $f_count = (count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$f_count; $n++){ $q_name=(isset($res[$n]["q_name"])) ? $res[$n]["q_name"]: "" ; $q_content=(isset($res[$n]["q_content"])) ? $res[$n]["q_content"]: "" ; @endphp <div class="new-quotes border row">
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
                                                    @php
                                                    }
                                                    @endphp
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
                                 <div class="form-group col-lg-12 col-md-12 ">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b><span> <b>Updated Date : </b> {{ isset($data)?date("d M Y" , $data->date) : "" }} </span></b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-lg-12">
                                                <label for="example-date-input" class=" col-form-label font-weight-600">Updated Date</label>
                                                <div class="col-lg-12" style="position: relative">
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
<div class="modal fade" id="shortcode-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Description For Short Codes</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th> Short Code</th>
                        <th> Description</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td> Related Post: </td>
                        <td> [[related:2]] </td>
                        <td> [[related : Limits of url / Quantity]] <br> <b>For Example : [[related : 2]] </b> 2 Links will Generate where we use this code </td>
                    </tr>
                    <tr>
                        <td> 2 </td>
                        <td> Image Ads In Article:</td>
                        <td> [[img-adv : 2]] </td>
                        <td> [[img-adv : index of Ad that shown in article]] <br> <b>For Example : [[img-adv : 2]] </b> 2nd Ad will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 3 </td>
                        <td> Google Ads In Article:</td>
                        <td> [[ga-adv:2]] </td>
                        <td> [[ga-adv : index of Ad that shown in article]] <br> <b>For Example : [[ga-adv : 2]] </b> 2nd Ad will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 4 </td>
                        <td> Table of Content:</td>
                        <td> [[toc]] </td>
                        <td> use this code <b>[[toc]]</b> where u want to show table of content in article</b></td>
                    </tr>
                    <tr>
                        <td> 5 </td>
                        <td> Heading:</td>
                        <td> [[t]] Heading [[/t]] </td>
                        <td> <b>Example</b> Heading no 1 : [[t1]]Heading no 1[[/t1]] <br> Heading no 2 : [[t2]]Heading no 2[[/t2]] </td>
                    </tr>
                    <tr>
                        <td> 6 </td>
                        <td> Sub Heading:</td>
                        <td> [[t1-s1]] Sub Heading of Headin 1 [[/t1-s1]] </td>
                        <td> <b>Example</b> <b>1st Sub Heading of Heading 1 </b>: [[t1-s1]]1st Sub Heading of Heading 1[[/t1-s2]] <br> <b>2nd Sub Heading of Heading 1 </b>: [[t1-s2]]2nd Sub Heading of Heading 1[[/t1-s2]] </td>
                    </tr>
                    <tr>
                        <td> 7 </td>
                        <td> Child of Sub Heading:</td>
                        <td> [[t1-s1-c1]] chlid of1st Sub Heading of Headin 1 [[/t1-s1-c1]] </td>
                        <td> <b>Example</b> <b>Child of 1st Sub Heading of Heading 1 </b>: [[t1-s1-c1]] Child of 1st Sub Heading of Heading 1[[/t1-s1-c1]] </td>
                    </tr>
                    <tr>
                        <td> 8 </td>
                        <td> Green Text:</td>
                        <td> [[green:2]] </td>
                        <td> [[green : index of Green Text that is listed above]] <br> <b>For Example : [[green : 2]] </b> 2nd Green text will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 9 </td>
                        <td> Red Text:</td>
                        <td> [[red:2]] </td>
                        <td> [[red : index of Red Text that is listed above]] <br> <b>For Example : [[Red : 2]] </b> 2nd Red text will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 10 </td>
                        <td> black Text:</td>
                        <td> [[black:2]] </td>
                        <td> [[black : index of Black Text that is listed above]] <br> <b>For Example : [[Black : 2]] </b> 2nd Green text will shown where we use this code </td>
                    </tr>
					<tr>
                        <td> 11 </td>
                        <td> Green & Red Text:</td>
                        <td> [[green:1 - red:1]] </td>
                        <td> [[green: index of Green Text  <b>-</b>  red: index of Red Text ]] <br> <b>For Example : [[green:1 - red : 2]] </b> 1st Green and 2st Red text will shown as comparison where we use this code </td>
                    </tr>
                    <tr>
                        <td> 12 </td>
                        <td> Faqs </td>
                        <td> [[faqs:2]] </td>
                        <td>
                        [[faqs:index of FAQs that is listed above]] 
                            <br> <b>Example</b> <b>[[faqs:1-4]]</b> place this code if u want to show faqs no 1 2 3 and 4
                        <br> <b>[[faqs:1,3,5,7]]</b> place this code if u want to show randomly faqs for example 1 3 5 7 </td>
                    </tr>
                    <tr>
                        <td> 13 </td>
                        <td> Quote </td>
                        <td>[[quote:2]] </td>
                        <td> 
                            [[Quote:index of Quote that is listed above]]  <br>
                            <b>Example</b> <b>[[quote:1-4]]</b> place this code if u want to show Quote no 1 2 3 and 4
                        <br> <b>[[quote:1,3,5,7]]</b> place this code if u want to show randomly Quote for example 1 3 5 7 </td>
                    </tr>
					 <tr>
                        <td> 14 </td>
                        <td> Youtube Videos:</td>
                        <td> [[youtube:2]] </td>
                        <td> [[youtube : index of youtube videos that is listed above]] <br> <b>For Example : [[youtube : 2]] </b> 2nd youtube Video will shown where we use this code </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="crop-model" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Image Croping</h4>
                <a href="" class="crpMdlHide"><i class="fa fa-times"></i></a>
            </div>
            <div class="modal-body">
               <div class="row div-flex text-center">
                <div class="col-lg-6 crop-sec">
                    <label>Width</label>
                    <input type="text" id="hfWidth" value="">
                    <label>Height</label>
                    <input type="text" id="hfHeight" value="">
                    <br> <br>
                    <div class="i-bx text-center">
                        <div class="-cp-img">
                            <img src="" id="cropbox" class="img" style="width: 100%;" /><br />
                        </div>

                        <span id="hfX"></span> <span id="hfY"></span>
                        <br> <br>
                        <div class="text-center">
                            <input type='button' id="crop" value='Show Preview'>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="crop-imgbox">
                        <img src="#" id="cropped_img" style="display: none;">
                    </div>
                    <div class="text-center updBtn" style="display: none">
                        <br> <br>
                        <input type='button' id="update" value='Crop & Update'>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@include('admin.layout.footer')
<script>

$(document).ready(function() {

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
    $( document ).on( "click", ".clear-item", function () {
        var v = window.confirm( "Do you want to delete data?" );
        if ( v ) {
            $( this ).closest( "tr" ).remove();
        }
    });
});
</script>
