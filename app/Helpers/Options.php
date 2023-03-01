<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Options{
	function __construct(){

	}

	function insert($data=array()){
		foreach($data as $k=>$v){
			$opton_key = $k;
			$option_value = $v;
			$r = $this->get($opton_key);
			$data = array(
				"option_key" => $opton_key,
				"option_value" => $option_value
			);
			if (trim($r)==""){
				DB::table("common_options")->insert($data);
			}else{
				DB::table("common_options")->where("option_key", $opton_key)->update($data);
			}
		}
	}

	function get($key=""){
		$r = DB::table("common_options")->where("option_key", $key)->first();
		if (isset($r->id)){
			return $r->option_value;
		}
		return "";
	}

}
