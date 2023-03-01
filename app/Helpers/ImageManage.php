<?php
namespace App\Helpers;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use WebPConvert\WebPConvert;
use WebPConvert\Convert\Converters\Gd;
class ImageManage{

	private $file;
	public $Common;
	public $Request;
	public $thumb = false;
	public $mid = false;
	public $main = false;
	public $type = "input"; // input or object
	public $path = "";
	public $name = "";

	function __construct($options=array()){
		$this->config($options);
	}

	function config($options){
		$this->file = (isset($options["file"])) ? $options["file"] : "";
	$this->Request = (isset($options["request"])) ? $options["request"] : "";
		$this->thumb  = (isset($options["thumb"]))  ? (bool) $options["thumb"] : false;
		$this->mid  = (isset($options["mid"]))  ? (bool) $options["mid"] : false;
		$this->main  = (isset($options["main"]))  ? (bool) $options["main"] : false;
		$this->type = (isset($options["type"]))  ? $options["type"] : "input";
		$this->path = (isset($options["path"])) ? $options["path"] : public_path().'/images/';
		$this->name = (isset($options["name"])) ? $options["name"] : "" ;
	}

	function get_newHeightWidth($image, $sizes=array()){
		$width = $sizes["width"];
		$height = $sizes["height"];
		$org_width = Image::make($image)->width();
		$org_height = Image::make($image)->height();
		$imageratio = $org_width/$org_height;
		if($org_width > $org_height){
			$newwidth = $width;
			$newheight = floor(($org_height/$org_width)*$width);
		}else{
			$newwidth  = floor(($org_width/$org_height)*$height);
			$newheight = $height;
		};
		//echo "$org_width:$org_height $newwidth:$newheight";
		//die();
		return array($newwidth, $newheight);
	}

	/*array(
		"mid"=>array("width"=>300,"height"=>300),
		"thumb"=>array("width"=>100,"height"=>100),
	)
	*/
	function upload($sizes = array()){
		$arr = array();
		if ($this->type=="input" and $this->Request->hasFile($this->file)){
			$image = $this->Request->file($this->file);
		}elseif($this->type=="object" and is_object($this->file)){
			$image = $this->file;
		}
		$arr = array();
		if (is_object($image)){
			$fileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
			$fileName .=".".pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
			$fileName = unique_filename(public_path().'/images/', $fileName);
			$r = rand(100,999).rand(100,999).rand(100,999).rand(100,999);
			$this->name = ($this->name=="") ? $fileName: $this->name;
			$ext = $image->getClientOriginalExtension();
			$thumb = $this->name."-thumb.".$ext;
			$mid = $this->name."-mid.".$ext;
			$main = $this->name."-main.".$ext;
			$fileName=$this->name.".".$ext;
			$destinationPath = $this->path;
			$image->move($destinationPath,$fileName);
			//Storage::putFileAs("",$this->Request->file($this->file), $fileName);
			$img=$this->path.$fileName;

			$arr["full"] = $fileName;
			if(is_valid_image($img)==false){
				unlink($img);
			}else{
				$cmp = $destinationPath."/$fileName";
				$arr["full"] = $fileName;
				if($ext !="webp"){
					try{
						$cmp = $destinationPath."/$fileName";
						$arr["full"] = $fileName;
						// $source = $cmp;
						// $destination = $this->path . '/'. $this->name.'.webp';
						// Gd::convert($source, $destination, $options=[]);

						if (count($sizes)==0){
							if ($this->mid==true){
								$s = array("width"=>300,"height"=>300);
								$arr["mid"] = $this->generate_thumb($img, $this->path,$s, "mid");
							}if ($this->main==true){
								$s = array("width"=>900,"height"=>900);
								$arr["main"] = $this->generate_thumb($img, $this->path,$s, "main");
							}
							if ($this->thumb==true){
								$s = array("width"=>100,"height"=>100);
								$arr["thumb"] = $this->generate_thumb($img, $this->path,$s, "thumb");
							}
						}else{
							if ($this->mid==true){
								$width = $sizes["mid"]["width"];
								$height = $sizes["mid"]["height"];
								$s = array("width"=>$width,"height"=>$height);
								$arr["mid"] = $this->generate_thumb($img, $this->path,$s, "mid");
							}if ($this->main==true){
								$width = $sizes["main"]["width"];
								$height = $sizes["main"]["height"];
								$s = array("width"=>$width,"height"=>$height);
								$arr["main"] = $this->generate_thumb($img, $this->path,$s, "main");
							}
							if ($this->thumb==true){
								$width = $sizes["thumb"]["width"];
								$height = $sizes["thumb"]["height"];
								$s = array("width"=>$width,"height"=>$height);
								$arr["thumb"] = $this->generate_thumb($img, $this->path,$s, "thumb");
							}
						}
					}catch (Exception $e) {
						unlink($img);
					}
				}
			}
		}
		return $arr;
	}
	function ecape_name_by_source($source = ""){
		$exp = explode("/", $source);
		$filename = end($exp);
		$ext = explode(".", $filename);
		$ext = end($ext);
		$org_name = str_replace(".$ext", "", $filename);
		$arr = array(
			"name" => $org_name,
			"filename" => $filename,
			"ext" => $ext,
		);
		return $arr;
	}

	function generate_thumb($source="", $destination="", $sizes="", $append = "", $name=""){
		if (is_file($source) and file_exists($source)){

			if (is_array($sizes)){
				$width = (isset($sizes["width"])) ? $sizes["width"] : 100;
				$height = (isset($sizes["height"])) ? $sizes["height"] : 100;
			}else{
				if ($sizes=="thumb" or $sizes=="thumbnail" or $sizes=="small"){
					$width = 100;
					$height = 100;
				}elseif ($sizes=="main"){
					$width = 900;
					$height = 900;
				}
			}

			if ($name==""){
				$src = $this->ecape_name_by_source($source);
			}else{
				$src = $this->ecape_name_by_source($name);
			}

			if ($append==""){
				$append = "-".$width."x".$height;
				$new_name = $src["name"].$append.".".$src["ext"];
			}else{
				$append = "-".$append;
				$new_name = $src["name"].$append.".".$src["ext"];
			}
			$destination = rtrim($destination, "/");
			$path = $destination;
			$destination = $destination."/".$new_name;
			$sizes_n = array("width"=>$width,"height"=>$height);
			$r= $this->get_newHeightWidth($source,$sizes_n);
			$new_width = $r[0];
			$new_height = $r[1];
			Image::make($source)->resize($new_width, $new_height)->save($destination);
			// $source = $destination;
			// $destination = $path . '/'. $src["name"].$append.'.webp';
			// Gd::convert($source, $destination ,$options=[]);
			return $new_name;
		}else{
			return false;
		}
	}

	function generate_mid($source="", $destination="", $sizes="", $append = "", $name){
		if (is_file($source) and file_exists($source)){

			if (is_array($sizes)){
				$width = (isset($sizes["width"])) ? $sizes["width"] : 300;
				$height = (isset($sizes["height"])) ? $sizes["height"] : 300;
			}else{
				if ($sizes=="mid" or $sizes=="medium"){
					$width = 300;
					$height = 300;
				}
			}

			if ($name==""){
				$src = $this->ecape_name_by_source($source);
			}else{
				$src = $this->ecape_name_by_source($name);
			}

			if ($append==""){
				$append = "-".$width."x".$height;
				$new_name = $src["name"].$append.".".$src["ext"];
			}else{
				$append = "-".$append;
				$new_name = $src["name"].$append.".".$src["ext"];
			}
			$destination = rtrim($destination, "/");
			$destination = $destination."/".$new_name;
			$sizes_n = array("width"=>$width,"height"=>$height);
			$r= $this->get_newHeightWidth($source,$sizes_n);
			$new_width = $r[0];
			$new_height = $r[1];
			Image::make($source)->resize($new_width, $new_height)->save($destination);
			return $new_name;
		}else{
			return false;
		}
	}
	function onTimeUpload($field, $user_id=""){
		$user_folder  = "3$user_id";
		if (request()->hasFile($field)) {
			$path = base_path()."/images/".$user_folder."/temp/";
			$image = request()->file($field);
			$fileSize = request()->file($field)->getSize() / 1024;
			$fileLimitMax = config("dg.limit.image_upload_max_size");
			$fileLimitMin = config("dg.limit.image_upload_min_size");
			if ($fileSize > $fileLimitMax){
				$resp = array("resp"=>"error", "msg"=>"Image size is high.");
			}elseif ($fileSize < $fileLimitMin){
				$resp = array("resp"=>"error", "msg"=>"Image size is low.");
			}else{
				$exp = explode("_",request("name"));
				$org_counter = $exp[1];
				$filename = request()->file($field)->getClientOriginalName();
				$filename = unique_filename(public_path().'/images/'.$user_folder."/", $filename);

				$slg = $filename;
				$options["request"] = request();
				$options["file"] = "dropImage";
				$options["path"] = $path;
				$options["type"] = "input";
				$options["thumb"] = false;
				$options["mid"] = false;
				$options["name"] = "$org_counter"."_$slg";
				if (file_exists($path) and $handle = opendir($path)) {
					while (false !== ($entry = readdir($handle))) {
						if ($entry != "." && $entry != "..") {
							$exp = explode("_", $entry);
							$ct = $exp[0];
							$ext = end($exp);
							$c_f = str_replace(".$ext","",$entry);
							if ($org_counter==$ct){
								if (file_exists($path.$entry)){
									unlink($path.$entry); // Full Image
								}
								if (file_exists($path.$c_f."-mid.$ext")){
									unlink($path.$c_f."-mid.$ext"); // Mid Image
								}
								if (file_exists($path.$c_f."-thumb.$ext")){
									unlink($path.$c_f."-thumb.$ext"); // Thumb Image
								}
							}
						}
					}
					closedir($handle);
				}
				$this->config($options);
				$sizes = array(
					"mid"=>array("width"=>250,"height"=>130),
					"thumb"=>array("width"=>100,"height"=>100),
				);
				$up = $this->upload($sizes);
				$resp = array("resp"=>"success", "msg"=>$up["full"]);
			}
		}else{
			$resp = array("resp"=>"error", "msg"=>"Something is wrong.");
		}
		echo json_encode($resp);
	}
}
