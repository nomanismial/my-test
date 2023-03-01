<?php
namespace App\Helpers;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageManage;
use Illuminate\Support\Facades\DB;
class MediaPanel{
	//Start Media Panel

	function init(){

		$d["request"] = Request();

		$base_url = url('/');
		$res = $base_url."/resources/views/MediaPanel/";
		$image_url = $base_url."/images/";
		$d["res_url"] = $res;
		$d["img_url"] = $image_url;
		$d["base_url"] = $base_url;
		$d["up_path"] = Storage::disk('uploads')->getAdapter()->getPathPrefix();
		$d["Object"] = $this;
		return $d;
	}

	function load(){
		$d = $this->init();
		echo view("MediaPanel.index", $d)->render();
	}

	function button($d){
		if ($d["type"]=="display"){
			echo view("MediaPanel.sub.buttons.display", $d)->render();
		}elseif ($d["type"]=="editor"){
			echo view("MediaPanel.sub.buttons.editor", $d)->render();
		}
	}

	function get(){
		$method = Request()->input("method");
		if (method_exists($this, $method)){
			echo $this->{$method}();
		}
	}
	function _update_opt(){

		$id = request('id');
		$folder = request('folder');
		$title = request('title');
		$alt = request('alt');
		$data = array(
			"folder" => $folder,
			"title" => $title,
			"alt" => $alt
		);
		$res = DB::table("media")->where('id', $id)->update($data);
		if($res){
			$arr = array("resp"=>"success", "msg"=>"Record is updated Succesfully");
		}else{
			$arr = array("resp"=>"error", "msg"=>"There is an error");
		}
		echo json_encode($arr);
	}
	function get_images($offset = 0, $folder = ""){
		$d = $this->init();
		if ($folder==""){
			$r = DB::table("media")->orderBy("id", "desc")->get();
		}else{
			$r = DB::table("media")->whereRaw("find_in_set($folder,folder)")->orderBy("id", "desc")->get();
		}
		$d["images"] = $r;
		$d["folder"] = DB::table("media_category")->get();
		$d["folder_c"] = $folder;
		$html = view("MediaPanel.images", $d)->render();
		return $html;
	}
	function _loadPanel(){
		$d = $this->init();
		$d["images"] = $this->get_images(0);
		echo view("MediaPanel.template", $d)->render();
	}

	public function _search_images()
	{
		$d = $this->init();
		$key = Request()->input("f");
		$r = DB::table("media")->where("image","like","%" . $key . "%")->get();
		if ($r->isNotEmpty()) {
			$d["images"] = $r;
			$html = view("MediaPanel.search-images", $d)->render();
			return $html;
		}else{

			 echo '<div class="alert alert-info text-centre">No images found</div>';
		}
	}
	function _loadImages($offset = 0){
		echo $this->get_images($offset);
	}

	function _changeFolder(){
		$folder = Request()->input("f");
		echo $this->get_images(0, $folder);
	}

	function _loadUpload(){
		$d = $this->init();
		$d["folder"] = DB::table("media_category")->get();
		echo view("MediaPanel.upload", $d)->render();
	}

	function _loadFolder(){
		$d = $this->init();
		$d["folder"] = $this->get_folder_list();
		echo view("MediaPanel.gallery", $d)->render();
	}

	function _loadVideo(){
		$d = $this->init();
		echo view("MediaPanel.video", $d)->render();
	}

	function _upload(){
		$d = $this->init();
		//$options["common"] = $d["common"];
		$options["request"] = $d["request"];
		$options["file"] = "ufile";
		$options["thumb"] = true;
		$options["mid"] = true;
		$options["main"] = true;
		$options["path"] = public_path().'/images/';
		$media = new ImageManage($options);
		$up = $media->upload();
		$full = (isset($up["full"]))? $up["full"] : "";
		if ($full!="" and file_exists($d["up_path"].$full)){
			$folder = Request()->input("folder");
			$folder = implode(",",$folder);
			$mid = (isset($up["mid"]))? $up["mid"] : "";
			$main = (isset($up["main"]))? $up["main"] : "";
			$thumb = (isset($up["thumb"]))? $up["thumb"] : "";
			$r = array(
				"image" => $full,
				"mid_image" => $mid,
				"main_image" => $main,
				"thumb_image" => $thumb,
				"folder" => $folder
			);
			DB::table("media")->insert($r);
		}
		$this->_loadImages();
	}

	function _createFolder(){
		$folder_name = Request()->input("t");
		$type = Request()->input("s");
		$data = array(
			"folder_type" => "folder",
			"folder_name" => $folder_name,
		);
		if($type=="new"){
			DB::table("media_category")->updateOrInsert(['folder_name'=>$folder_name],$data);
		}else{
			DB::table("media_category")->where("folder_name", $type)->update($data);
		}
		echo $this->get_folder_list();
	}

	function get_folder_list(){
		$r = DB::table("media_category")->get();
		return view("MediaPanel.folder-list", ["folders"=>$r])->render();
	}

	function _delFolder(){
		$folder_name = Request()->input("t");
		$row = DB::table("media_category")->where("folder_name",$folder_name)->first();
		if (is_object($row)){
			$r["folder"] = 0;
			DB::table("media")->where("folder", $row->id)->update($r);
			DB::table("media_category")->where("folder_name", $folder_name)->delete();
		}
	}

	function _delMedia(){
		$d = $this->init();
		$path = $d["up_path"];
		$id = Request()->input("t");
		$r = DB::table("media")->where("id", $id)->first();
		if (is_object($r)){
			$image  = $r->image;
			$mid = $r->mid_image;
			$thumb = $r->thumb_image;
			if ($image!="" and file_exists($path.$image)){
				$img = explode("." , $image);
				$ext = end($img);
				$wimage = str_replace(".$ext","",$image);
				$wimage .=".webp";
				unlink($path.$image);
				if ($wimage!="" and file_exists($path.$wimage)){
					unlink($path.$wimage);
				}
			}
			if ($mid!="" and file_exists($path.$mid)){
				$img = explode("." , $mid);
				$ext = end($img);
				$wmid = str_replace(".$ext","",$mid);
				$wmid .=".webp";
				unlink($path.$mid);
				if ($wmid!="" and file_exists($path.$wmid)){
					unlink($path.$wmid);
				}
			}
			if ($thumb!="" and file_exists($path.$thumb)){
				$img = explode("." , $thumb);
				$ext = end($img);
				$wthumb = str_replace(".$ext","",$thumb);
				$wthumb .=".webp";
				unlink($path.$thumb);
				if ($wthumb!="" and file_exists($path.$wthumb)){
					unlink($path.$wthumb);
				}
			}
			DB::table("media")->where("id", $id)->delete();
			echo "yes";
		}else{
			echo "no";
		}
	}


	function insertVideo(){
		$link= Request()->input("embed");
  		$source= Request()->input("source");
  		if($source=="facebook"){
	  		$parse = parse_url($link);
			$trim = trim($parse["path"],"/");
			$exp = explode("/",$trim);
			$page = $exp[0];
			$video_id = $exp[count($exp)-1];
			$embeded ="<iframe src='http://www.facebook.com/plugins/video.php?href=https://www.facebook.com/$page/videos/$video_id' width='560' height='393' class='embed-responsive-item' frameborder='0'></iframe>";
		}elseif($source=="tune.pk"){
			$parse = parse_url($link);
			$trim = trim($parse["path"], "/");
			$sp=explode("/",$trim);
			$v=$sp[1];
			$embeded ="<iframe width='600' height='336' src='http://tune.pk/player/embed_player.php?vid=$v&width=600&height=336&autoplay=no' class='embed-responsive-item' frameborder='0' allowfullscreen scrolling='no'></iframe>";
		}elseif($source=="dailymotion"){
			$rep=str_replace("http://","",$link);
			$sp=explode("/",$rep);
			$vl=explode("_",$sp[count($sp)-1]);
			$v=$vl[0];
			$embeded ="<iframe frameborder='0' width='600' height='336' src='//www.dailymotion.com/embed/video/$v' class='embed-responsive-item' allowfullscreen></iframe>";
		}elseif($source=="youtube"){
			$parts = parse_url($link);
			parse_str($parts['query'], $query);
			$v=$query['v'];
			$embeded ="<div class='amp-script-start'></div><div class='youtube-container home-youtube-container embed-responsive embed-responsive-16by9 embed-div-item videoPlayer' >
      				<div class='homeVideoThumbnail home-videoplayer' id='vid-$v'><img src='https://img.youtube.com/vi/$v/0.jpg' /><div class='u-icon'></div></div>
      				<i class='fa fa-youtube-play homeVideoPlayButton'></i>
   					 </div><div class='amp-script-end'></div>";
		}elseif ($source=="vimeo") {
			$link=str_replace("http://","",$link);
			$vf=explode("/",$link);
			$id=$vf[count($vf)-1];
			 $embeded="
			<iframe src='//player.vimeo.com/video/$id' width='600' height='336' frameborder='0' class='embed-responsive-item' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
		}
        echo  "<div class='embed-responsive embed-responsive-16by9'>".$embeded."</div>";
	}
}
