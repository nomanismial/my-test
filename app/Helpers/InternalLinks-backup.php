<?php
namespace App\Helpers;
use App\Helpers\Options;
use Illuminate\Support\Facades\DB;
class InternalLinks {
	var $content = "";
	var $urlTemplate = "";
	var $urlPattern = "";
	var $termDelimiter = "";
	var $target_of_link  = "_self";
	var $type_of_link = "";
	var $max_links = 10;
	var $max_same_url_same_text = 1;
	var $max_url_current_post = 1;
	var $max_same_url_different_text = 1;
	var $max_url_one_post = 2;
	var $all_matches = array();
	var $linkage = array();
	var $link_len_type = "fixed";
	var $base_url = "";
	function __construct(){
		//parent::__construct();
		$this->base_url = url('/');
		$this->urlPattern = "<a\s[^>]*href=(\"??)([^\">]*?)\\1[^>]*>(.*)<\/a>";
        $this->urlTemplate = '<a href="%s" class="ilgen" %s %s>%s</a>';
        $this->termDelimiter = '#';
		$this->setting();
	}
	//Remove previous tags link in the contnet.
	function remove($content = ""){
		"|<a.*(?=href=\"([^\"]*)\")[^>]*>([^<]*)</a>|i";
		$pattren = '/<a.*>.*<\/a>/';
		
		preg_match_all($pattren, $content, $matches);
		$matches = (isset($matches[0])) ? $matches[0] : array();
		foreach($matches as $k=>$v){
			$tag  = $v;
			if (preg_match("/ilgen/i", $tag)){
				$tag = strip_tags($tag);
				$content = str_replace($v,$tag,$content);
			}
		}
		return $content;
	}
	
	function search_links(){
		
	}
	
	// Exludes tags if text finds in any of the following tag. link not applies.
	function exclude_tags(){
		$arr = array('a', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre', 'code', 'kbd', "strong","b");
		return $arr;
	}
	
	//Setting of options saved in database, if no settings finds then auto setting will apply.
	function setting(){
		$Options = new Options;
        $arr = $Options->get("intanal_links_settings");
		if ($arr!=""){
			$arr = json_decode($arr, true);
			if (isset($arr['target'])) {
				$this->target_of_link = $arr['target'];
			}
			if (isset($arr['type'])){
				$this->type_of_link = $arr['type'];	
			}
			if (isset($arr['max_p'])){
				$this->max_same_url_same_text  = ( is_numeric($arr['max_p'])) ? $arr['max_p'] : $this->max_same_url_same_text;	
			}
			if (isset($arr['max_d'])){
				$this->max_same_url_different_text  = ( is_numeric($arr['max_d'])) ? $arr['max_d'] : $this->max_same_url_different_text;	
			}
			if (isset($arr['max'])){
				$this->max_links = ( is_numeric($arr['max'])) ? $arr['max'] : $this->max_links;
			}
			if (isset($arr['max_f'])){
				$this->link_len_type = (trim($arr['max_f'])=="") ? $this->link_len_type  :$arr['max_f'];	
			}
			if (isset($arr['max_s'])){
				$this->max_url_current_post = (trim($arr['max_s'])=="") ? $this->max_url_current_post  :$arr['max_s'];	
			}
			if (isset($arr['max_1'])){
				$this->max_url_one_post = (trim($arr['max_1'])=="") ? $this->max_url_one_post  :$arr['max_1'];	
			}
			
		}
	}
	
	//Gets all links saved in database
	function allDBLinks($post_id = 0){
		$r = DB::table('blogs')->where("status" , "publish")->select("id" , "slug" , "internal_links")->get();
		$arr = array();
		foreach($r as $k=>$v){
			$id = $v->id;
			$tags = explode(",",$v->internal_links);
			$slug = $v->slug;
			$link = $this->base_url."/".$slug."-2".$id;
			$arr[] = array(
					"id" => $id,
					"link" => $link,
					"tags" => $v->internal_links
				);	
		}
		return $arr;
	}
	
	//Finds in the content and fetches offset of the tag.
	function findings($keyword="", $plink=""){
		$keyword = trim($keyword);
		$tags = $this->exclude_tags();
		$exclude_tags = implode('|', $tags);
		$search_regex = "/(?<p>)/";
		//$url_regex = sprintf('/' . str_replace(array('"', '/'), array('\"', '\/'), $this->urlTemplate) . '/', preg_quote($target, '/'), '(.*)');
		$target = "";
		$type = "";
		if ($this->target_of_link!=""){
			$target = "target=\"".$this->target_of_link."\"";
		}
		if ($this->type_of_link!=""){
			$type = "";
		}
		if (preg_match($search_regex, $this->content, $match)){
			preg_match_all($search_regex, $this->content, $matches, PREG_OFFSET_CAPTURE);
			foreach($matches[1] as $_k=>$_v){
				$this->all_matches[$_v[1]] = $_v[0];
				$this->linkage[$_v[1]] = $plink;
			}
		}
	}
	
	//Builds tags and applies all conditions and fetches final result of the content
	function building($id , $content, $tags){
		if ($this->link_len_type!="fixed"){
			$per = $this->max_links;
			$ctn = strip_tags($content);
			$ctn_len = explode(" ", $ctn);
			$this->max_links = round(($this->max_links * count($ctn_len)) / 100);
		}
		$this->content = $content;
		$links = array();
		$smae_p = 1;
		// All tags of all posts with links.
		$tags = $this->allDBLinks();
		foreach($tags as $k=>$v){
			$splt = explode(",",$v["tags"]);
			foreach($splt as $kk){
				if (trim($kk)!=""){
					
						$links[] = array(
							"id" => $v["id"],
							"tag" => $kk,
							"link" => $v["link"]
						);
					
				}
			}
		}
		if (count($links)==0){
			return $this->content;	
		}
		// finds urls in the current post content
		foreach($links as $k=>$v){
			$this->findings( stripcslashes($v["tag"]), $v["link"] );
		}
		// Matched urls in the current post content
		$same_text = array();
		foreach($this->all_matches as $k=>$v){
			$offset = $k;
			$text = $v;
			if(preg_grep("/$text/i", $this->all_matches)){
				$lt = strtolower($v);
				$link = $this->linkage[$offset];
				$same_text[$link][$lt][] = array(
					"offset" => $offset,
					"text" => $v,
					"link" =>  $link,
				); 
			}
		}
		//Extract max urls on diffent text and max url on same text
		$sm_df_link = array();
		foreach($same_text as $k=>$v){
			$link = $k;
			$tx = count($v)-1;
			if ($this->max_same_url_different_text < count($v)){
				$keys = array_rand($v,$this->max_same_url_different_text);	
				$keys = (is_array($keys)) ? $keys  :array($keys);
			}else{
				$keys  =array_keys($v);
			}
			$keys = (is_array($keys)) ? $keys : array();
			foreach($keys as $nk=>$nv){
				$ct = count($v[$nv]) - 1;
				if ($this->max_same_url_same_text <= count($v[$nv])){
					$nkeys = array_rand($v[$nv],$this->max_same_url_same_text);	
					$nkeys = (is_array($nkeys)) ? $nkeys : array($nkeys);
				}else{
					$nkeys  = array_keys($v[$nv]);
				}

				$nkeys = (is_array($nkeys)) ? $nkeys  :array();
				foreach($nkeys as $dk=>$dv){
					$sm_df_link[$link][]= $v[$nv][$dv];
				}
			}
			$sk  = $v;
		}
		//Extract max urls of one post
		$mx_1_post = array();
		foreach($sm_df_link as $k=>$v){
			$ct = count($v) - 1;
			if ($this->max_url_one_post < count($v)){
				$nkeys = array_rand($v,$this->max_url_one_post);
				$nkeys = (is_array($nkeys)) ? $nkeys : array($nkeys);
			}else{
				$nkeys  =array_keys($v);
			}
			$nkeys = (is_array($nkeys)) ? $nkeys : array();
			foreach($nkeys as $dk=>$dv){
				$mx_1_post[]= $v[$dv];
			}
		}
		//Extract max urls of current post
		$max_c_post = array();
		$cr_m = 1;
		foreach($mx_1_post as  $k=>$v){
			$link = explode("-",$v["link"]);
			$cr_id = end($link);
			if ($cr_m <= $this->max_url_current_post){
				$max_c_post[] = $v;
			}
			if ($cr_id == get_postid("last_id")){
				$cr_m++;
			}
		}
		//Joins links with target and relation of url
		$new_textLInk =array();
		foreach($max_c_post as $k=>$v){
			if ($this->target_of_link!=""){
				$target = "target=\"".$this->target_of_link."\"";
			}
			if ($this->type_of_link!="" and $this->type_of_link=="nofollow"){
				$type = "rel=\"".$this->type_of_link."\"";
			}else{
				$type = "rel=\"".$this->type_of_link."\"";	
			}
			$offset = $v["offset"];
			$ph = $v["text"];
			$new_textLInk[] = array(
				"offset" => $offset,
				"text" => $ph,
				"link" => $v["link"],
				"target" => $target, 
				"type" => $type
			);
		}
		//Extract max links applied on one article
		$mt = ($this->max_links < count($new_textLInk)) ? $this->max_links : count($new_textLInk);
		if (count($new_textLInk) > 0){
			if (count($new_textLInk)==1){
				$keys = array_keys($new_textLInk);
			}else{
				$keys = array_rand($new_textLInk, $mt);
				$keys = (is_array($keys)) ? $keys : array($keys);
			}
			
			$new_s = array();
			$keys = (is_array($keys)) ? $keys : array($keys);
			foreach($keys as $v){
				$new_s[] = $new_textLInk[$v];
			}
		}else{
			$new_s = array();
		}
		usort($new_s, function($item1, $item2){
			return $item1["offset"] - $item2["offset"];
		});
		//Finds text offset in the content and applies link.
		$prv_offset = 0;
		$matched_content = $this->content;
		foreach($new_s as $kk=>$vv){
			$ph = $vv["text"];
			$type = $vv["type"];
			$target = $vv["target"];
			$offset = $vv["offset"];
			
			$plink = $vv["link"];
			$replacement = sprintf($this->urlTemplate, $plink,$target,$type,$ph);
			$limit = 1;
			$count = 1;

			$keyword = trim($ph);
			$tags = $this->exclude_tags();
			$exclude_tags = implode('|', $tags);
			$search_regex = "/(?<!\p{L})({$keyword})(?!\p{L})(?!(?:(?!<\/?(?:{$exclude_tags}).*?>).)*<\/(?:{$exclude_tags}).*?>)(?![^<>]*>)/ui";
			$rpl_txt = generateRandomString(strlen($ph));

			$new_repalce[] = $rpl_txt;
			$new_replace_links[] = $replacement;
			
			//$this->content = substr_replace($this->content, $rpl_txt, $offset, strlen($rpl_txt));
			if($kk==0){
				$this->content = substr_replace($this->content, $rpl_txt, $offset, strlen($rpl_txt));
			}else{
				$prv_offset  = $new_s[$kk-1]["offset"];
				if($offset - $prv_offset > 30){
					$this->content = substr_replace($this->content, $rpl_txt, $offset, strlen($rpl_txt));
				}
			}
		}
		//Final display result of content
		if (isset($new_repalce)){
			$this->content = str_replace($new_repalce, $new_replace_links, $this->content);	
			foreach($new_repalce as $k=>$rpl){
				//$this->content = str_replace($rpl, $new_replace_links[$k], $this->content);		
			}
			
		}
		
		
		return $this->content;
	}
	
	//Replaces the keys order of Associative Array
	function putinplace($string=NULL, $put=NULL, $position=false){
		$d1=$d2=$i=false;
		$d=array(strlen($string), strlen($put));
		if($position > $d[0]) $position=$d[0];
		for($i=$d[0]; $i >= $position; $i--) $string[$i+$d[1]]=$string[$i];
		for($i=0; $i<$d[1]; $i++) $string[$position+$i]=$put[$i];
		return $string;
	}
	
	// Adds settings in the database
	function _addSettings($obj){
		$args = array(
			"page_title" => "Internal Links Settings",
			"nav" => array(
						1 => array("name"=>"Internal Links Settings", "link"=>"internal-links", "active"=>true)
					)
		);
		$obj->_load_page("internal-links", $args);	
	}
	
	//Sorting of associative Array
	function ksort_arr (&$arr, $index_arr) {
		$arr_t=array();
		foreach($index_arr as $i=>$v) {
			foreach($arr as $k=>$b) {
				if ($k==$v) $arr_t[$k]=$b;
			}
		}
		$arr=$arr_t;
	}
	
}
?>