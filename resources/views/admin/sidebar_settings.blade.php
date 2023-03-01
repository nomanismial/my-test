@include('admin.layout.header')
@php
$pages = array(
  "11" => "Author's Choice",
  "12" => "Categories",

);
$adsCount = 0;
$page_name = (isset($_GET['pg'])) ? $_GET['pg'] : "";
$page =  str_replace("-", ' ', $page_name);
$adss =  DB::table("ads")->select("ads")->get();
 // dd($adss);

if ($adss != "") {
  
  $ads =  isset($adss[0]->ads) ? json_decode($adss[0]->ads, true) : array();
  //dd($ads);
  if(!is_array($ads)){
	$ads = array();
	}
   $adsCount  = count($ads);
  	$ads_ids = array();
	foreach($ads as $k=>$v){
	  $ads_ids[$v["ads_id"]] = $v;
	}
}

$ga_ads =  DB::table("ads")->select("google_ads")->get();

if (count($ga_ads) > 0) {
  $ga_ads = isset($ga_ads[0]->google_ads) ? json_decode($ga_ads[0]->google_ads, true) : ""; 
	if($ga_ads != null){
	$ga_ads_ids = array();
	foreach($ga_ads as $k=>$v){
	  $ga_ads_ids[$v["ads_id"]] = $v;
	}
	}
}

$order = array();
$update = false;
$rec = DB::table("sidebar_settings")->where("page_name" , "=" , "$page_name")->get();
if($rec){
  if (!empty($rec[0]->data_order)){
    $order = explode(",",$rec[0]->data_order);
    $update = true;
  }
}
if ($page_name == "blog") {
    $page_name = "Blog Detail";
  }elseif($page_name == "blogs"){
    $page_name = "Blog List";
  }
@endphp

<div class="body-content">
  <div class="row">
    <div class="col-md-6 col-lg-6">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0"><b>{{ ucwords($page) }}</b> Sidebar Item</h6>
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
          <table class="table table-borderd"> 
                <tbody class="pages_list">
                  @php
                    $n = 1;
                    foreach($pages as $k=>$v){
                      $sel = (in_array($k, $order)) ? "checked" : "";
                  @endphp
                  <tr>
                    <th>
                      {{ $n." - ".$v }}                      
                    </th>
                    <td><input type="checkbox" name="image" class="check_list" data-id="{{ $k }}" {{ $sel }}></td>              
                  </tr>
                  @php
                  $n = $n+1;
                    }
                    foreach($ads as $k => $v){
                      $title = isset($v["title"]) ? $v["title"] :  "Image Ads ";
                      $ads_id = isset($v["ads_id"]) ? $v["ads_id"] :  0;
                      $sel = (in_array($v["ads_id"], $order)) ? "checked" : "";
                   @endphp
                  <tr>
                    <th>
                      {{ $n." - ".$title }}
                    </th>
                    <td><input type="checkbox" name="image" class="check_list" data-id="{{ $ads_id }}" {{ $sel }}></td> 
                  </tr>
                  @php
                  $n = $n+1;
                    }
                  @endphp
                  @php
                    // dd($ga_ads);
                  if($ga_ads !=null){
                    foreach($ga_ads as $k => $v){
                      $title = isset($v["title"]) ? $v["title"] :  "Google Ads ".$k+1;
                      $ads_id = isset($v["ads_id"]) ? $v["ads_id"] : 0;
                      $sel = (in_array($v["ads_id"], $order)) ? "checked" : "";
                   @endphp
                  <tr>
                    <th>
                      {{ $n." - ".$title }}
                    </th>
                    <td><input type="checkbox" name="image" class="check_list" data-id="{{ $ads_id }}" {{ $sel }}></td> 
                  </tr>

                  @php
                  $n = $n+1;
                    }
                    }
                  @endphp
                </tbody>
              </table>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-6">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Order for <b>{{ ucwords($page) }}</b></h6>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="/{{ admin }}/sorting" method="post">
            @csrf
            <div class="row">
              <div class="col-lg-12 col-sm-12">
                @if (Session::has('sidebar_message'))
                <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>{!! Session('sidebar_message') !!}</strong>
                </div>
                @endif
                @if (Session::has('error_message'))
                <div class="alert alert-danger alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>{!! Session('error_message') !!}</strong>
                </div>
                @endif
              <div class="row">
                <form action="" method="post">
                    <div class="col-lg-12 col-sm-12">
                      <input type="hidden" name="page" value="{{ request('pg') }}">
                      <div class="form-group">

                        <ol class='m-t todo-list msortable'>
                          @foreach ($order as $v)

                            @php
                              $pg_name = (array_key_exists($v, $pages)) ? $pages[$v] : "";
                              if($v>30){
                                $id = substr($v, 1);
                                if(isset($ga_ads[$id-1])){
                                    $ga_adss = $ga_ads[$id-1];
                                    $pg_name = isset($ga_adss["title"]) ? $ga_adss["title"] : "Google Ads ".$id;

                                }                                
                              }elseif($v>20){
                                $id = substr($v, 1);
                                $id - 1;
                                if(isset($ads[$id-1])){
                                    $adss = $ads[$id-1];
                                    $pg_name = isset($adss["title"]) ? $adss["title"] : "Image Ads ".$id;
                                }                                
                              }
                            @endphp
                              <li id='li{{$v}}'><b>{{$pg_name}}</b><input type='hidden' name='order[]' value='{{$v}}' class='form-control'/> <span class='menu-del list-del float-right' data-id='x'>x</span>
                              </li>                            
                          @endforeach
                        </ol>
                       {{--  <ol class='m-t todo-list msortable'>
                          @php
                          $pg_name="";
                            foreach($order as $v){
                              $cont =  2+$adsCount;
                              if (($v > 2) and isset($ads_ids)  ){
                                if ($v > $cont){
                               $id = $v-$cont;
                                if(isset($ga_ads_ids[$id])){
                                  $ga_ads = $ga_ads_ids[$id];
                                  $pg_name = isset($ga_ads["title"]) ? $ga_ads["title"] : "Google Ads ".$id;
                                    }
                                  }else{
                                    $id = $v-2;
                                    if(isset($ads_ids[$id])){
                                      $ads = $ads_ids[$id];
                                      $pg_name = isset($ads["title"]) ? $ads["title"] : "Ad ".$id;
                								    }
                                   } 
                                }else{
                                   		$pg_name = (array_key_exists($v, $pages)) ? $pages[$v] : "";
                                  }
                                  if ($pg_name !="") {
                             
                                    echo "
                                      <li id='li$v'><b>$pg_name</b><input type='hidden' name='order[]' value='$v' class='form-control'/> <span class='menu-del list-del float-right' data-id='x'>x</span>
                                      </li>
                                    ";
                                  }                          
                          } 
                          @endphp
                        </ol> --}}
                      </div>
                      @php
                        $css = "";
                        $count = count($order);
                        if($count == 0){
                          $css = "style=display:none";
                        }
                      @endphp
                      <div class="form-group _subButton" {{ $css }}>
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary float-right"/>
                      </div>
                    </div>
                  <br>
                </form>
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