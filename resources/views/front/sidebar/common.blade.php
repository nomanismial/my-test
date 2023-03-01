<aside class="side_bar "> 
@php
   $page_id = get_postid("page_id");
  $slug = get_postid("full");
  if($slug == "privacy-policy"){
      $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "$slug")->get();
  }elseif($slug == "terms-conditions"){
      $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "$slug")->get();
  }elseif($slug == "write-for-us"){
      $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "$slug")->get();
  }elseif($slug == "about"){
      $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "$slug")->get();
  }elseif($page_id == 2){
    $r =  DB::table("sidebar_settings")->where("page_name" , "=" , "blog")->get();
  }
  $order = array();
  if (isset($r[0]->data_order)){
    $order = explode(",",$r[0]->data_order);
  }
       $res  = DB::table("ads")->get();
      $ads = (isset($res[0]->ads)) ? json_decode($res[0]->ads , true) : array();
      $google_ads = (isset($res[0]->google_ads))? json_decode($res[0]->google_ads , true) : array();
 
   if (count($order) > 0) {
    //dd($order);
    foreach ($order as $value) {
       $end = (!next( $order)) ? "true" : "false" ;
       if($value == 11) {
		$ad['end'] = $end;
       @endphp 
        @include( "front.sidebar.trending" , $ad)
       @php
      }elseif($value == 12) { 
		$ad['end'] = $end;
        @endphp
         @include( "front.sidebar.blogcats" , $ad)
         @php
      }else{
      if($value > 30){
          $id = substr($value, 1);
          if(isset($google_ads[$id-1])){
            $ad = $google_ads[$id-1];
			$ad['end'] = $end;
            @endphp
            @include( "front.sidebar.google_ads" , $ad)
            @php  
        }
        }elseif($value > 20){
          
          $id = substr($value, 1);
          if(isset($ads[$id-1])){
              $ad = $ads[$id-1];
              $ad['end'] = $end;
              @endphp
              @include( "front.sidebar.ads" , $ad)
              @php 
          }
        }
      }   
   }
  }
 @endphp
</aside>
