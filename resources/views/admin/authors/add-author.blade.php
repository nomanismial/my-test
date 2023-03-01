@include('admin.layout.header')
@php
  if(!empty(old())){
    $name = old('name');
    $detail = old('detail');
    $cover_image = (old('cover_image') !=null)?old('cover_image'):"";
    $link = old("link");
    $icon = old("icon");
    $links = array();
    $t_links = count($link);
    if(!empty($links)){
        foreach($link as $k=>$v){
        $icon = $icon[$k];
        $links[] = array("link"=>$v, "icon"=>$icon);
      }
    }

  }elseif(isset($data) and !empty($data)){
    $name = $data->name;
    $detail = $data->details;
    $cover_image = $data->cover;
    $links = isset($data->social_links) ? json_decode($data->social_links , true) : array();

  }else{
    // $category = array();
    $links = array();
     $name = $detail = $cover_image =  "" ;
  }
full_editor();
@endphp
<div class="body-content">
  <div class="row">
    <div class="col-md-112 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              @if (request()->has('edit'))
              <h6 class="fs-17 font-weight-600 mb-0">Edit Author</h6>
              @else
              <h6 class="fs-17 font-weight-600 mb-0">Add New</h6>
              @endif
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{ route('add-author') }}" class="btn {{ Request::segment(2)=='add-author'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a>
                <a href="{{ route('authors-list') }}" class="btn {{ Request::segment(2)=='author-list'  && Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Authros List</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          @if (Session::has('success'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session('success') !!}</strong>
          </div>
          @endif
          @if (count($errors) > 0)
          <div class="alert alert-danger">
            <strong>Whoops!</strong> Some Input Fields Are Missing.<br><br>
                     <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <form method="POST" action="{{ (isset($data) and !empty($data))?route('add-author')."?edit=".request('edit'):route('add-author') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-8 col-md-12">
                @php
                //dd($data);
                @endphp
                <input type="hidden" name="id" value="">
                <div class="form-group">
                  <label class="req">Author Name</label>
                  <input type="text" name="name" class="form-control" value="{{ $name }}">
                  @if ($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name')}}</div>
                  @endif
                </div>
                <div class="col-lg-12 p-0">

                  <div class="card">
                      <div class="card-header card bg-secondary text-white">
                          <b> Social Media Links</b>
                      </div>
                      <div class="card-body">
                          <div class="socialmedia">
                              <div class="form-rows">
                                  <table class="table table-bordered">
                                      <thead>
                                          <tr>
                                              <th>#</th>
                                              <th>link</th>
                                              <th>icon</th>
                                          </tr>
                                      </thead>
                                      <tbody id="sortable" class=" social m-tbc todo-list msortable ui-sortable">
                                          @php
                                          $ic = array("icon-facebook" , "icon-twitter","icon-instagram" , "icon-youtube" , "icon-linkedin");
                                         $rev_count = (count($links)==0) ? 0 : count($links) - 1;
                                          for ($n=0; $n<=4; $n++){ $link=( isset($links[$n][ "link" ])) ? $links[$n][ "link" ]: "" ; $icon=( isset($links[$n][ "icon" ])) ? $links[$n][ "icon" ]: $ic[$n] ; @endphp <tr class="tr-row">
                                              <td>{{ $n+1 }}</td>
                                              <td>
                                                  <div class="form-group m-0">
                                                      <input type="text" name="link[]" placeholder="Social media link here" class="form-control" value="{{ $link }}" />
                                                      <div class="text-danger"> </div>
                                                  </div>
                                              </td>
                                              <td>
                                                  <div class="form-group m-0">
                                                      <div class="input-group">
                                                          <input type="text" name="icon[]" placeholder="" class="form-control" value="{{ $icon }}" readonly />
                                                      </div>
                                                  </div>
                                              </td>
                                              </tr>
                                              @php } @endphp
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <br>
                <div class="form-group">
                  <label class="req">Detail:</label>
                  <textarea class="form-control oneditor" rows="12" name="detail" id="oneditor">{{ $detail }}</textarea>
                   @if ($errors->has('detail'))
                    <div class="text-danger">{{ $errors->first('detail')}}</div>
                  @endif
                </div>
              </div>
              <div class="col-lg-4 col-md-12">
                <div class="form-group col-lg-12 col-md-12">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <span><b> Author Image : <small> 120 x 120</small> </b></span>
                    </div>
                    <div class="card-body">
                      <div class="uc-image" style="width: 97%;">
                        <span class="clear-image-x">x</span>
                        <input type="hidden" name="cover_image" value="{{ $cover_image }}">
                        <div id="cover_image" class="image_display" >
                          @if (file_exist($cover_image) and $cover_image !="")
                           <img src="{{ $cover_image }}" alt="Author Image">
                          @endif                        
                        </div>
                        <div style="margin-top:10px;">
                          <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#cover_image" data-link="cover_image">Add Image</a>
                        </div>
                      </div>
                      @if ($errors->has('cover_image'))
                      <div class="text-danger">{{ $errors->first('cover_image')}}</div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 justify-content-center">
                    <input type="submit" name="save"  value="{{ (isset($data) and !empty($data))?"Update":"Submit" }}"  class="btn btn-info btn-lg btn-block">
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