@include('admin.layout.header')
<div class="body-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Home Page</h6>
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
                    </div>
                    @endif
                    <form method="POST" action="/{{ admin }}/homepage" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                @php
                                $m_data = (!empty($data->home_meta))? json_decode($data->home_meta): "" ;
                                @endphp
                                @isset ($data)
                                 <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                @endisset
                                <div class="form-group col-12 col-md-8 p-0">
                                    <label class="font-weight-600 req">Meta Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ (isset($m_data) and !empty($m_data) )?$m_data->meta_title:''}}" data-count="text">
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ (isset($m_data) and !empty($m_data))?strlen($m_data->meta_title):'0'}}</span>
                                        </div>
                                    </div>
                                    @error('meta_title')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-8 p-0">
                                    <label class="font-weight-600 req">Meta Description</label>
                                    <div class="input-group">
                                        <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ (isset($m_data) and !empty($m_data))?$m_data->meta_description:''}}</textarea>
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ (isset($m_data) and !empty($m_data))?strlen($m_data->meta_description):'0'}}</span>
                                        </div>
                                    </div>
                                     @error('meta_description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-8 p-0">
                                    <label class="font-weight-600">Meta Tags</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" data-count="tags" data-role="tagsinput" name="meta_tags" value="{{ (isset($m_data) and !empty($m_data))?$m_data->meta_tags:''}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ (isset($m_data) and !empty($m_data))?count(explode(",",$m_data->meta_tags)):'0'}}</span>
                                        </div>
                                    </div>
                                     @error('meta_tags')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                @php
                                    if(isset($m_data) and !empty($m_data)){
                                        $og = $m_data->og_image;
                                    }else{
                                        $og = "";
                                    }
                                @endphp
                                <div class="form-row">
                                    <div class="form-group col-lg-3">
                                        <label class="font-weight-600">OG Image <Small><b>Size</b> 1200 x 627</Small></label> <br>
                                         @php
                                            $og_image = ($og !="") ? "<img src=".$og." alt=''>" : "";
                                            @endphp
                                            <div class="uc-image" style="width: 97%;">
												<span class="clear-image-x">x</span>
                                                <input type="hidden" name="og-image" value="{{ ($og !="")?$og :"" }}">
                                                <div id="og-image" class="image_display" style="display:block;">
                                                    {!! $og_image !!}
                                                </div>
                                                <div style="margin-top:10px;">
                                                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#og-image" data-link="og-image">Add Image</a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="card col-10">
                                   <div class="card-header card bg-secondary text-white">
                                        <b> Home Page Slider <small>Size : 1350 x 450 </small></b>
                                    </div>
                                    <div class="card-body slidr-div">
                                        @php
                                        $slider_images = (!empty($data->slider_images) )? json_decode($data->slider_images , true) : array();
                                       $total = count($slider_images);
                                        $stotal = ($total == 0)? 0: $total;
                                        $t_total = ($total==0) ? 0 : $total-1;
                                        @endphp
                                    <div class="form-group">
                                             <input type="hidden" name="total_images" value="{{ $stotal }}"/>
                                        @php
                                            for($n=0; $n <= $t_total; $n++){
                                                $image = (isset($slider_images[$n])) ? $slider_images[$n] : "";
                                        @endphp
                                        <div class="uc-image2" style="width:150px;height:150px;">
                                        <?php
                                            //if ($n > 0){
                                        ?>
                                        <span class="close-image-x2">x</span>
                                        <?php //} ?>
                                        <input type="hidden" name="image{{ $n+1 }}"
                                        value="{{ $image }}"/>
                                        <div class="image{{ $n+1 }} image_display">
                                            @php if ($image!=""){ @endphp
                                            <img src="{{ $image }}" alt='Product Image'/>
                                            @php } @endphp
                                        </div>
                                        <div style="margin-top:10px;">
                                            <a class="insert-media btn btn-danger btn-sm" data-type="image"
                                            data-for="display"
                                            data-return=".image{{ $n+1 }}"
                                            data-link="image{{ $n+1 }}">Add Image</a>
                                       </div>
                                        </div>
                                       @php  } @endphp

                                       <div class="ext-image">

                                       </div>
                                       <div class="add-more-images">
                                            <a href="#" class="btn btn-success float-right">Add More</a>
                                       </div>
                                    </div>
                                    </div>
                                </div>
                                <br> <br>
                                <div class="card col-md-10 ">
                                    @php
                                    $home_design = (!empty($data->home_design) )? json_decode($data->home_design , true) : array();
                                    $cat = array();
                                    $cat = array_column($home_design, 'category');
                                    @endphp
                                    <div class="card-header card bg-secondary text-white">
                                        <b> Home Page Design</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="homeDesign">
                                            <div class="form-rows">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Row</th>
                                                            <th>Title</th>
                                                            <th>Category</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="sortable" class=" home-design m-tbc todo-list msortable ui-sortable">
                                                        @php
                                                        $rev_count = (count($home_design)==0) ? 0 : count($home_design) - 1;
                                                        for ($n=0; $n<=$rev_count; $n++){
                                                        $title=( isset($home_design[$n][ "title"])) ? $home_design[$n][ "title"]: "";
                                                        $category=( isset($home_design[$n][ "category"])) ? $home_design[$n][ "category"]: "";
                                                        @endphp
                                                        <tr class="tr-row">
                                                            <td>{{ $n+1 }}</td>
                                                            <td>
                                                                <div class="form-group m-0">
                                                                    <input type="text" name="title[]" placeholder="Row Title" class="form-control" value="{{ $title }}" />
                                                                    <div class="text-danger"> </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @php
                                                                $res2 = array();
                                                                $res = array();
                                                                $res = DB::table("categories")->select('id' , 'name' , 'slug')->orderBy( 'tb_order' )->get();
                                                                $res2 = array(
                                                                array("id"=>"popular1","name"=>"Popular 1","slug"=>"popular-1"),
                                                                array("id"=>"popular2","name"=>"Popular 2","slug"=>"popular-2"),
                                                                array("id"=>"popular3","name"=>"Popular 3","slug"=>"popular-3")
                                                                );
                                                                $res = json_decode(json_encode($res), true);

                                                                $res = array_merge($res , $res2);

                                                                @endphp
                                                                <div class="form-group m-0">
                                                                    <select name="category[]" class="form-control">
                                                                        <option value="">Pease Select Category</option>
                                                                        @foreach ($res as $k => $v)
                                                                        @php
                                                                        if(!empty($cat)){

                                                                            $selected = ($v['id'] == $cat[$n]) ? "selected=selected" : "" ;
                                                                        }else{
                                                                            $selected = "";
                                                                        }

                                                                        @endphp
                                                                        <option value="{{ $v['id']}}" {{ $selected }}>{{ $v['name']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td class="text-center"> <i class="fa fa-trash text-danger clear-item mx-auto my-auto"></i>
                                                            </td>
                                                        </tr>
                                                        @php } @endphp
                                                    </tbody>
                                                </table>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-success add-home-design text-white"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br> <br>
                                <div class="form-group col-md-10 p-0">
                                    <div class="schema">
                                     <div class="schema-rows">
                                        @php
                                        $schema = isset($data)? json_decode($data->microdata , true) : array();
                                        $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                                        for ($n=0; $n <=$t_quotes; $n++){ $schema_d=(isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "" ;
                                         $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                                        $style=( isset($schema[$n]["type"]) and $schema[$n]["type"] !="" ) ? 'style="display: none;"': "" ;
                                        $icon=(isset($schema[$n]["type"]) and $schema[$n]["type"] !="") ? '<i class="fa fa-edit"></i>': '' ;
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
                                <div class="form-group col-md-12 p-0">
                                    <button type="submit" name="submit" value="Submit" class="btn btn-info float-right">Submit </button>
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
$(".add-home-design").click(function() {
    var html_obj = $(".home-design tr").first().clone();
    var ln = $(".home-design tr").length;
    $(html_obj).find("input").each(function() {
    $(this).attr("value", "");
});
$(html_obj).find("option").each(function() {
    $(this).removeAttr('selected')        });
    $(html_obj).find("textarea").each(function() {
    $(this).text("");
});
;
html_obj.find("td:first-child").text(parseInt(ln) + 1);
    $(".homeDesign .home-design").append("<tr>" + html_obj.html() + "</tr>");
    return false;
});
$(document).on("click", ".clear-item", function() {
    var v = window.confirm("Do you want to delete data?");
    if (v) {
    $(this).closest("tr").remove();
    }
});
</script>
