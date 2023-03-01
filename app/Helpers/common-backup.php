<?php

use Illuminate\Support\Facades\DB;
function abortit() {
    return redirect()->action('Main_Ctrl@index');
    // return redirect('/');
    // dd('hello');
}
function s_img_values()
{
    $imgs = get_security_img();
    foreach ($imgs as $value) {
        $img_aray[$value['title']] = $value['value'];
    }
    return $img_aray;
}
//
function get_security_img()
{
    // echo _encrypt("8D83H4JJ5N");
    // die();
    $s_img = [
        ['title' => 'Aeroplane', 'i' => 'fa-plane', 'value' => 'SDF4N343L2'],
        ['title' => 'Bell', 'i' => 'fa-bell', 'value' => '8D83H4JJ5N'],
        ['title' => 'Star', 'i' => 'fa-star', 'value' => 'Y2U3N4M5L3'],
        ['title' => 'Football', 'i' => 'fa-futbol', 'value' => 'C73HK29D7W'],
        ['title' => 'Camera', 'i' => 'fa-camera', 'value' => '0WK3N4M27D'],
        ['title' => 'Book', 'i' => 'fa-book', 'value' => 'U2HD7S64N3'],
        ['title' => 'Car', 'i' => 'fa-car', 'value' => 'W3UM4N43M3'],
        ['title' => 'Heart', 'i' => 'fa-heart', 'value' => '7R6E5W7C6F'],
        ['title' => 'Mobile', 'i' => 'fa-mobile-alt', 'value' => '3MNTIR93K4'],
        ['title' => 'Bicycle', 'i' => 'fa-bicycle', 'value' => '7W6D4HSIW0'],
        ['title' => 'Umbrella', 'i' => 'fa-umbrella', 'value' => '0QMIRYC738'],
        ['title' => 'Home', 'i' => 'fa-home', 'value' => '7FME82KR74'],
        ['title' => 'Truck', 'i' => 'fa-truck', 'value' => '26YDNEM762'],
        ['title' => 'Hand', 'i' => 'fa-hand-paper', 'value' => '7RU4KF74HJ'],
        ['title' => 'Apple', 'i' => 'fa-apple-alt', 'value' => 'UMFY64HRY3'],
    ];
    return $s_img;
}

function script_redirect($url){
	echo "
		<script>
			window.location = '$url';
		</script>
	";
}

function sendEmail($Mail, $view, $data){
	$Mail::send($view, $data, function ($message) use ($data) {
		$from_email = $data["from"]["email"];
		$from_label = $data["from"]["label"];
		$to_email = $data["to"]["email"];
		$to_label = $data["to"]["label"];
		$subject = $data["subject"];
		$message->to($to_email)->subject($subject);
        $message->replyTo($from_email, $from_label);
		$message->from($from_email,$from_label);
	});
}

function saveToken($DB, $token, $path, $destroy = 3600, $info = array()){
	$info = (isset($info)) ? $info : array();
	$DB::table("bot")->insert([
		"token" => $token,
		"path" => $path,
		"destroy" => time() + $destroy,
		"info" => json_encode($info)
	]);
}

function get_postid($get = "slug") {
    $segment = request()->segment(1);
    $route = $segment;
    $exp = explode("-", $route);
    $last_id = end($exp);
    $page_id = substr($last_id, 0, 1);
    $post_id = substr($last_id, 1, 1000);
    $cat_id = substr($post_id, 0, 3);
    $slug = str_replace("-" . $last_id, "", $route);
    $seg = array(
        "full" => $route,
        "last_id" => $last_id,
        "page_id" => (is_numeric($page_id)) ? $page_id : 0,
        "post_id" => $post_id,
        "cat_id" => $cat_id,
        "slug" => $slug,
        "type" => ((is_numeric($last_id)) ? "int" : "string"),
    );
    if ($get == "") {
        return "";
    } else {
        return $seg[$get];
    }
}
function get_postid2($get = "slug") {
    $segment = request()->segment(2);
    $route = $segment;
    $exp = explode("-", $route);
    $last_id = end($exp);
    $page_id = substr($last_id, 0, 1);
    $post_id = substr($last_id, 1, 1000);
    $cat_id = substr($post_id, 0, 3);
    $slug = str_replace("-" . $last_id, "", $route);
    $seg = array(
        "full" => $route,
        "last_id" => $last_id,
        "page_id" => $page_id,
        "post_id" => $post_id,
        "cat_id" => $cat_id,
        "slug" => $slug,
        "type" => ((is_numeric($last_id)) ? "int" : "string"),
    );
    if ($get == "") {
        return "";
    } else {
        return $seg[$get];
    }
}
function is_valid_redirect() {
    $slug = get_postid("slug");
    $page_id = get_postid("page_id");
    $last_id = get_postid("post_id");
    $table_id = substr($last_id, 0, 3);
    $post_id = substr($last_id, 3);
    if ($page_id == 1) {
        $result = DB::select('select * from mobile_mobile_phones where id = ' . $post_id);
        if (empty($result)) {
            redirect(abort(404));
            exit();
        }
        $slg = str_slug($result[0]->title);
        $url = "/" . $slg . "-1" . $result[0]->page_id . $post_id;
        if ($slg != $slug) {
            return array($url);
        } elseif ($slg == "") {
            redirect(abort(404));
        }
    }
    if ($page_id == 2) {
        $result = \App\category::find($table_id);
        if (empty($result)) {
            redirect(abort(404));
            exit();
        }
        $slg = $result->slug;
        $url = "/" . $slg . "-2" . $table_id;
        if ($slg != $slug) {
            return array($url);
        } elseif ($slg == "") {
            redirect(abort(404));
        }
    }
	if ($page_id == 3) {
        $result = \App\User::find($table_id);
        if (empty($result)) {
			$url = route("HomeUrl")."/404";
			return $url;

        }
        $slg = str_slug($result->name);
        $url = route("HomeUrl")."/" . $slg . "-3" . $table_id;
        if ($slg != $slug) {
            return $url;
        } elseif ($slg == "") {
            redirect(abort(404));
        }
    }
}
function get_cat_name($id){
	$r = \App\category::where('id',$id)->first();
	if(is_object($r)){
		return $r;
	}
}
function unslash( $value ) {
    if ( is_array( $value ) ) {
        foreach ( $value as $k => $v ) {
            if ( is_array( $v ) ) {
                $value[$k] = unslash( $v );
            } else {
                $value[$k] = stripslashes( $v );
            }
        }
    } else {
        $value = stripslashes( $value );
    }
    return $value;
}
function trim_words( $text, $num_words = 55, $more = null ) {
    if ($more ==null) {
        $more = '&hellip;';
    }
    $original_text = $text;
    $text = strip_tags( $text );
    $text = strip_tags( $text );
    $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
    $sep = ' ';
    if ( count( $words_array ) > $num_words ) {
        array_pop( $words_array );
        $text = implode( $sep, $words_array );
        $text = $text . $more;
    } else {
        $text = implode( $sep, $words_array );
    }
    return $text;
}
function sort_by_time($a,$b)
{
  $a_time = strtotime($a->created_at);
  $b_time = strtotime($b->created_at);
  return $a_time < $b_time;
}
function fav() {
    if (Auth::check()) {
        $fav = array();
        $user_id = Auth::id();
        $bookmark = DB::select('select * from bookmarks where user_id =' . $user_id);
        if (count($bookmark) > 0) {
            $fav = array_column($bookmark, "product_id");
            return $fav;
        } else {
            $fav[] = "testing";
            return $fav;
        }
    }
}
function follow() {
    if (Auth::check()) {
        $follow = array();
        $user_id = Auth::id();
        $following = DB::select('select * from followers where follower_id =' . $user_id);
        if (count($following) > 0) {
            $following = array_column($following, "following_id");
            // dd($following);
            return $following;
        } else {
            $following[] = "testing";
            return $following;
        }
    }
}
function getcount($id) {
	$record = array();
	$data = array();
    $check = \App\category::where('parent_id',$id)->get();
	if(count($check)> 0 ){
		foreach($check as $chk){
			$tblid = $chk->id;
			$tblname = \App\M_Object::where('cat_id',$tblid)->first();
			if (isset($tblname->object_name)){
				$table = $tblname->object_name;
				$recorde = DB::SELECT("select * from $table where scene='public'");
				$record[] = $recorde;
			}else{
				$record[] = array();
			}

		}
		foreach ($record as $etm) {
               foreach ($etm as $ptm) {
               if (!empty($ptm)) {
                  $data[] = $ptm;
               	}
			 }
         }
		return(count($data));
	}else{
		$obj = \App\M_Object::where('cat_id',$id)->first();
		if (isset($obj->object_name)){
			$table = $obj->object_name;
			$item = DB::SELECT("select * from $table where scene= 'public'");
		}else{
			$item = array();
		}

		return count($item);
	}
}
function _get_cat_city_count($city){
	$tbl_data = array();
	$total_city = array();
	$tableid = get_postid("post_id");
	$tabel = \App\M_Object::where('cat_id',$tableid)->first();
	if(is_object($tabel)){
		$tablename = $tabel->object_name;
		$count = DB::SELECT("select * from $tablename where city='$city' and scene='public'");
		if($count){
			return count($count);
		}else{
			return 0;
		}
	}else{
		$p_id = \App\category::where('parent_id',$tableid)->get();
		if(is_object($p_id)){
			foreach($p_id as $rec){
				$table_id = $rec->id;
				$table_record = \App\M_Object::where('cat_id', $table_id)->first();
				$tablename = $table_record->object_name;
				$tbl_data[] = DB::select("select * from $tablename where city='$city' and scene='public'");
			}
			foreach($tbl_data as $tbl){
				foreach($tbl as $tbls){
					if(!empty($tbl)){
						$total_city[]= $tbl;
					}
				}
			}
			return count($total_city);
		}
	}
}
function getparentcount($id) {
    $data1 = array();
    $data = array();
    $parent = \App\category::where('parent_id', $id)->get();
    if ($parent) {
        foreach ($parent as $value) {
            $table_id = $value->id;
            $table_record = \App\M_Object::where('cat_id', $table_id)->first();
            $tablename = $table_record->object_name;
            $ckh_tbl_data = DB::select("select * from $tablename");
            if (count($ckh_tbl_data) > 0) {
                $data1 = DB::table($tablename)->where('scene','public')->get();
				foreach ($data1 as $item) {
				   if (!empty($item)) {
					   $data[] = $item;
				   }
				}
            }

        }
        return count($data);
    }
}
function _total_products_all() {
    $count = array();
    $getcount = array();
    $record = DB::select(" select object_name from objects");
    if (count($record) > 0) {
        foreach ($record as $records) {
            $table = $records->object_name;
            $count[] = DB::select("select * from $table");
        }
        foreach ($count as $counts) {
            foreach ($counts as $counting) {
                $getcount[] = $counting;
            }
        }
        return count($getcount);
    }
}

function _total_views_all() {
    $result = DB::table("views")->sum('views');
    return $result;
}
function _total_products() {
	$user_id = auth()->user()->id;
    $count = array();
    $getcount = array();
    $record = DB::select(" select object_name from objects");
    if (count($record) > 0) {
        foreach ($record as $records) {
            $table = $records->object_name;
            $count[] = DB::select("select * from $table where user_id = '$user_id'");
        }
        foreach ($count as $counts) {
            foreach ($counts as $counting) {
                $getcount[] = $counting;
            }
        }
        return count($getcount);
    }
}
function _total_products_admin($id) {
    $count = array();
    $getcount = array();
    $record = DB::select(" select object_name from objects");
    if (count($record) > 0) {
        foreach ($record as $records) {
            $table = $records->object_name;
            $count[] = DB::select("select * from $table where user_id = '$id'");
        }
        foreach ($count as $counts) {
            foreach ($counts as $counting) {
                $getcount[] = $counting;
            }
        }
        return count($getcount);
    }
}
function _total_views() {
	$user_id = auth()->user()->id;
    $result = DB::table("views")->sum('views');
    return $result;
}
function _total_visits($id) {
    $result = DB::table("user_views")->where('visiting_id',$id)->sum('total_views');
    return $result;
}
function _get_total_users(){
	$users = \App\User::get()->all();
	if(count($users)> 0){
		return count($users);
	}
}
function _get_all_likes() {
    $res = DB::select("select * from bookmarks");
    return count($res);
}
function _get_total_categories() {
    $res = DB::select("select * from categories");
    if (count($res) > 0) {
        return count($res);
    }
}
function getcityCount($city) {
    $table_id = get_postid("post_id");
    $records = DB::select("select object_name from objects where cat_id = '$table_id'");
    if (count($records) > 0) {
        $table = $records[0]->object_name;
        $res = DB::select("select * from $table where city='$city' and scene= 'public'");
        return count($res);
    }
}
function getcitiesads($city) {
    $res = array();
    $getcount = array();
    $records = DB::select("select * from objects");
    if (count($records) > 0) {
        foreach ($records as $record) {
            $table = $record->object_name;
            $res[] = DB::select("select * from $table where city = '$city' and scene= 'public' ");
        }
        foreach ($res as $counts) {
            foreach ($counts as $counting) {
                $getcount[] = $counting;
            }
        }
        return count($getcount);
    }
}
function getbreadcrumb($id) {
    $res = array();
    $data = array();
    $res[] = \App\category::where('id', $id)->first();
    // dd($res);
    $name = "abc";
    if ($res[0]->parent_id == 0) {
        $data['parent'] = $res;
        return $data;
    } elseif ($res[0]->parent_id > 0) {
        $data['child'] = $res;
        $parent = $data['child'][0]->parent_id;
        $data['parent'][0] = \App\category::where('id', $parent)->first();
        return $data;
    }
}
function _get_category_name($id){
	$res = \App\category::where('id',$id)->first();
	if(is_object($res)){
		return $res->name;
	}
}
function sanitize_title($title, $raw_title = '', $context = 'display') {
    $title = strip_tags($title);
    // Preserve escaped octets.
    $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
    // Remove percent signs that are not part of an octet.
    $title = str_replace('%', '', $title);
    // Restore octets.
    $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
    $title = strtolower($title);
    $title = preg_replace('/&.+?;/', '', $title); // kill entities
    $title = str_replace('.', '-', $title);
    if ('save' == $context) {
        // Convert nbsp, ndash and mdash to hyphens
        $title = str_replace(array('%c2%a0', '%e2%80%93', '%e2%80%94'), '-', $title);
        // Strip these characters entirely
        $title = str_replace(array(
            // iexcl and iquest
            '%c2%a1', '%c2%bf',
            // angle quotes
            '%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba',
            // curly quotes
            '%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d',
            '%e2%80%9a', '%e2%80%9b', '%e2%80%9e', '%e2%80%9f',
            // copy, reg, deg, hellip and trade
            '%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2',
            // acute accents
            '%c2%b4', '%cb%8a', '%cc%81', '%cd%81',
            // grave accent, macron, caron
            '%cc%80', '%cc%84', '%cc%8c',
        ), '', $title);
        // Convert times to x
        $title = str_replace('%c3%97', 'x', $title);
    }
    $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
    $title = preg_replace('/\s+/', '-', $title);
    $title = preg_replace('|-+|', '-', $title);
    $title = trim($title, '-');
    return $title;
}
function full_editor(){
    ?>
    <script src="<?php echo route("HomeUrl"); ?>/admin-assets/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        function _full_Ed(){
             tinymce.init({
             setup: function(editor) {
                editor.on("init", function(){
                    editor.shortcuts.remove('ctrl+s');
                });
            },
             mode : "specific_textareas",
            editor_selector: "oneditor",
            plugins: [
                 "advlist autolink link image lists charmap preview hr anchor pagebreak spellchecker",
                 "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
                 "table contextmenu directionality emoticons template paste textcolor"
           ],
				 rel_list: [
{title: 'None', value: ''},
{title: 'No Referrer', value: 'noreferrer'},
{title: 'No Opener', value: 'noopener'},
{title: 'No Follow', value: 'nofollow'}
],
target_list: [
{title: 'None', value: ''},
{title: 'Same Window', value: '_self'},
{title: 'New Window', value: '_blank'},
{title: 'Parent frame', value: '_parent'}
	],
           toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor emoticons ",
           theme_advanced_path : false,
           relative_urls : false,
           remove_script_host : false,
           theme_advanced_resizing: true,
           forced_root_block : 'div',
               style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Header 1', block: 'h1'},
                {title: 'Header 2', block: 'h2'},
                {title: 'Header 3', block: 'h3'},
                {title: 'Header 4', block: 'h4'},
                {title: 'Header 5', block: 'h5'},
                {title: 'Header 6', block: 'h6'},
            ]
         });
        }
        _full_Ed();
    </script>
   <?php
}
function tiny_editor(){

    ?>
    <script src="<?php echo route("HomeUrl"); ?>/admin-assets/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        function __tinyEd(){
            tinymce.init({
            mode : "specific_textareas",
            editor_selector: "tinyeditor",
            menubar:false,
            statusbar: false,
            plugins: [
            'advlist autolink lists link image charmap anchor',
            'searchreplace',
            'media table',
            'paste',

          ],
          toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link',
         paste_auto_cleanup_on_paste : true,
         paste_remove_styles: true,
         paste_remove_styles_if_webkit: true,
         paste_strip_class_attributes: true,
          forced_br_newline : true,
          force_br_newlines : false,
          force_p_newlines : false,
          forced_root_block : 'div',
         });
        }
        __tinyEd();
    </script>
<?php
}
function chat_token($user_id = 0, $product_id = 0){
	$rn = rand(1000000,9999999);
	if (is_numeric($user_id) and $user_id > 0){
		$token = $rn."-".$user_id."-".$product_id;
	}else{
		$token = $rn;
	}
	return base64_encode($token);
}
function reverse_chat_token($token){
	return base64_decode($token);
}

function user_option($options, $get = ""){
	$options = collect($options);
	$f = $options->keyBy("option_key")->get($get);
	$f = (isset($f->option_value)) ? $f->option_value : 0;
	return $f;
}

function score_keywords(){
	$arr = array(
		"email_verify" => "Email Verified",
		"mobile_verify" => "Mobile Number Verified",
		"login_facebook" => "FB Account Verfified",
		"login_linkedin" => "Linkedin Account Verified",
		"login_twitter" => "Twitter Account Verified",
		"affiliate" => "Affiliate Membber",
		"advertiser" => "Mentioned our Advertiser on Social Media",
		"app" => "App Installed",
		"followers" => "100+ Followers",
		"indentify" => "Identity Verified using documents as like freelancer",
	);
	return $arr;
}

function get_score_level($collections){
	$rates = array();
	$options = score_keywords();
	$total = 0;
	$total_scores = 0;
	$verified = 0;
	$verified_score = 0;
	$unverified = 0;
	$unverified_score = 0;

	foreach($options as $k=>$v){
		$op = $collections->keyBy("option_key")->get($k);
		$op = (isset($op->option_value)) ? $op->option_value : 0;
		$link = "";
		$sc = 55;
		$total_scores+=$sc;
		if ($op==1){
			$verified_score+=$sc;
			$verified+=1;
		}else{
			$unverified_score+=$sc;
			$unverified+=1;
		}
	}
	$rates["total"] = count($options);
	$rates["total_score"] = $total_scores;
	$rates["total_verified"] = $verified;
	$rates["score_verified"] = $verified_score;
	$rates["total_unverified"] = $unverified;
	$rates["score_unverified"] = $unverified_score;
	return $rates;
}


function nofollow($html, $skip = null) {
    return preg_replace_callback(
        "#(<a[^>]+?)>#is", function ($mach) use ($skip) {
            return (
                !($skip && strpos($mach[1], $skip) !== false) &&
                strpos($mach[1], 'rel=') === false
            ) ? $mach[1] . ' rel="nofollow">' : $mach[0];
        },
        $html
    );
}

function custom_date($date = "", $format=""){
	$format = ($format!="") ? $format : config("format.date_format_display");
	if (is_numeric($date)){
		$date = date($format, $date);
	}else{
		$date = strtotime($date);
		$date = date($format, $date);
	}

	return $date;
}

/* Start File Functions*/
//Check image type of valid or not.
function is_valid_image($image = ""){
	$s = false;
	if (is_file($image)){
		$allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/webp'];
		$contentType = mime_content_type($image);
		if(in_array($contentType, $allowedMimeTypes) ){
			$s = true;
		}
	}
	return $s;
}

function no_post_image(){
    $path = base_path();
    $noimage = route("HomeUrl")."/images/default-img.png";
    return $noimage;
}

function get_image($image=""){
    $path = base_path();
    if ($image==""){
        return no_post_image();
    }else{
        $exp = explode("/", $image);
        $file = end($exp);
        $exp = explode(".", $file);
        $ext = end($exp);
        $rep = str_replace(".$ext", "",$file);
        $full='/images/'."$rep.$ext";
        if(file_exists($path.$full)){
            $rep = route("HomeUrl").$full;
        }elseif(file_exists($path.$full)){
            $rep = route("HomeUrl").$full;
        }else{
            $rep = "";
        }

        return $rep;
    }
}

function get_post_thumbnail($image="" , $default = ""){
    $path = base_path();
    if ($image==""){
        return no_post_image();
    }else{
        $exp = explode("/", $image);
        $file = end($exp);
        $exp = explode(".", $file);
        $ext = end($exp);
        $rep = str_replace(".$ext", "",$file);
        $thumb='/images/'.$rep."-100.$ext";
        $mid='/images/'."$rep-100.$ext";
        $full = '/images/'.$rep.".$ext";
        if(file_exists($path."/".$thumb)){
            $rep = route("HomeUrl")."/".$thumb;
        }elseif(file_exists($path.$mid)){
            $rep = route("HomeUrl").$mid;
        }elseif(file_exists($path.$full)){
            $rep = route("HomeUrl").$full;
        }else{
            $rep = "";
        }
        $rep = ($rep!="") ? $rep : $default;
        $rep = ($rep=="") ? no_post_image() : $rep;
        return $rep;
    }
}
function get_post_mid($image="",  $default = ""){

    $path = base_path();
    if ($image==""){
        return no_post_image();
    }else{
        $exp = explode("/", $image);
        $file = end($exp);
        $exp = explode(".", $file);
        $ext = end($exp);
        $rep = str_replace(".$ext", "",$file);
        $mid='/images/'."$rep-300.$ext";

        $full = '/images/'.$rep.".$ext";
        if(file_exists($path.$mid)){
             $rep = route("HomeUrl").$mid;
        }elseif(file_exists($path.$full)){
            $rep = route("HomeUrl").$full;
        }else{
            $rep = "";
        }
        $rep = ($rep!="") ? $rep : $default;
        $rep = ($rep=="") ? no_post_image() : $rep;
        return $rep;
    }
}
function get_post_main($image="",  $default = ""){
    $path = base_path();
    if ($image==""){
        return no_post_image();
    }else{
        $exp = explode("/", $image);
        $file = end($exp);
        $exp = explode(".", $file);
        $ext = end($exp);
        $rep = str_replace(".$ext", "",$file);
        $main='/images/'."$rep-800.$ext";
        $full = '/images/'.$rep.".$ext";
        if(file_exists($path.$main)){
            $rep = route("HomeUrl").$main;
        }elseif(file_exists($path.$full)){
            $rep = route("HomeUrl").$full;
        }else{
            $rep = "";
        }
        $rep = ($rep!="") ? $rep : $default;
        $rep = ($rep=="") ? no_post_image() : $rep;
        return $rep;
    }
}
function get_post_full_attachment($image="", $default = ""){
    $path = base_path();
    if ($image==""){
        return no_post_image();
    }else{
        $exp = explode("/", $image);
        $file = end($exp);
        $exp = explode(".", $file);
        $ext = end($exp);
        $rep = str_replace(".$ext", "",$file);
        $full = '/images/'.$rep.".$ext";
        if(file_exists($path.$full)){
            $rep = route("HomeUrl").$full;
        }else{
            $rep = "";
        }
        $rep = ($rep!="") ? $rep : $default;
        $rep = ($rep=="") ? no_post_image() : $rep;
        return $rep;
    }
}
/*
    array(
        "image" => json encoded  or image name,
        "dir" => user_dir is user_id,
        "is_single" => true / false  - checks if it is false image key is json encoded, if it is true image key is image name,
        type => full or main or thumb
    )
*/
function get_post_attachment($options=array()){
    $image = (isset($options["image"])) ? $options["image"] : "";
    $type = (isset($options["type"])) ? $options["type"] : "";
    $default = (isset($options["default"])) ? $options["default"] : "";
    switch($type){
        case "full":
            $get = get_post_full_attachment($image , $default);
            break;
        case "mid":
            $get = get_post_mid($image , $default);
            break;
        case "main":
            $get = get_post_main($image , $default);
            break;
        case "thumb":
            $get = get_post_thumbnail($image , $default);
            break;
        default:
            $get = no_post_image();
    }
    return $get;
}

function get_user_image($image=  ""){
	$path = base_path()."/images/users/";
	$default = "avatar1.jpg";
	if ($image==""){
		$image=  route("HomeUrl")."/images/$default";
	}elseif(!file_exists($path.$image)){
		$image=  route("HomeUrl")."/images/$default";
	}else{
		$image=  route("HomeUrl")."/images/users/$image";
	}
	return $image;
}
/* End File Functions*/
function set_price($data, $country=""){
	$currency = "Rs.";
	if ($country=="india"){
		$currency = "Inr.";
	}
	if ($price=="" or $price==0){
		$price = "";
	}else{
		$price = $currency." ".number_format($price);
	}
	return $price;
}
function paginateCollection($items, $perPage = 15, $page = null, $options = [])
{
    $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
    return new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}

// Sanitize file name
function sanitize_file_name( $filename ) {
	$filename_raw = $filename;
	$special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", "%", "+", chr(0));
	$filename = preg_replace( "#\x{00a0}#siu", ' ', $filename );
	$filename = str_replace( $special_chars, '', $filename );
	$filename = str_replace( array( '%20', '+' ), '-', $filename );
	$filename = preg_replace( '/[\r\n\t -]+/', '-', $filename );
	$filename = trim( $filename, '.-_' );
	$parts = explode('.', $filename);
	$filename = array_shift($parts);
	$extension = array_pop($parts);
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif' => 'image/gif',
		'png' => 'image/png',
		'bmp' => 'image/bmp');
	foreach ( (array) $parts as $part) {
		$filename .= '.' . $part;
		if ( preg_match("/^[a-zA-Z]{2,5}\d?$/", $part) ) {
			$allowed = false;
			foreach ( $mimes as $ext_preg => $mime_match ) {
				$ext_preg = '!^(' . $ext_preg . ')$!i';
				if ( preg_match( $ext_preg, $part ) ) {
					$allowed = true;
					break;
				}
			}
			if ( !$allowed )
				$filename .= '_';
		}
	}
	$filename .= '.' . $extension;
	return $filename;
}

// Generate Unique Filename
function unique_filename( $dir, $filename, $dimen="" ) {
	// Sanitize the file name before we begin processing.
    $filename = strtolower(sanitize_file_name(trim($filename)));

    // Separate the filename into a name and extension.
    $ext = pathinfo( $filename, PATHINFO_EXTENSION );
    $name = pathinfo( $filename, PATHINFO_BASENAME );
    $org_filename = pathinfo( $filename, PATHINFO_FILENAME);
    if ( $ext ) {
        $ext = '.' . $ext;
    }

    // Edge case: if file is named '.ext', treat as an empty name.
    if ( $name === $ext ) {
        $name = '';
    }
	$number = 0;
	$dm = $dimen;
	$file = $dir . "$filename" ;
	while ( file_exists( $dir . "$filename" ) ) {
		$filename = str_replace( array( "-$number$ext", "$ext" ), "-" . ++$number ."". $ext, $filename );
	}
	if ($number==""){
		$filename = $org_filename;
	}else{
		$filename = $org_filename."-$number";
	}
	return $filename;
}
function  get_catByname($category = array()){
    $res = array();
    $cat = explode("," , $category);
    $id = $cat[0];
    $res =  DB::table('blog_categories')->select('id' , 'title' , 'slug')->where('id' , $id)->first();
    return $res;
}
function  get_catUrl($category = array()){
    $res = array();
    $cat = explode("," , $category);
    $id = $cat[0];
    $res =  DB::table('blog_categories')->select('id' , 'title' , 'slug')->where('id' , $id)->first();
    if(isset($res->id)){
        $url = route("HomeUrl")."/".$res->slug."-1".$res->id;
    }else{
        $url = "";
    }

    return $url;
}
function search_toc_pattren($keyword="", $content=""){
    $pattren = "/([[)($keyword+)(]])(.+)(\[\[\/)($keyword+)(\]\])/";
    preg_match_all($pattren, $content, $matches, PREG_OFFSET_CAPTURE);
    return $matches;
}

function table_of_content($content = ""){
    $table = "";
    $pattren = "/([[)(t[0-9]+)(]])(.+)(\[\[\/)(t[0-9]+)(\]\])/";
    $matches = search_toc_pattren("t[0-9]", $content);
  $all_pattren = array();
  if (count($matches[1]) > 0){
      $table.="<ul class='first'>";
      foreach($matches[1] as $k=>$v){
          $open_tag = "[[".$matches[5][$k][0]."]]";
          $close_tag = "[[/".$matches[5][$k][0]."]]";
          $ft = Str::slug($matches[3][$k][0]);
          $span = "<span id='$ft'></span>";
          $content = str_replace($open_tag,$span,$content);
          $content = str_replace($close_tag,"",$content);
          $main = $matches[3][$k][0];
          $ar_main = explode(" ", $main);
          $li_text = "";
          foreach ($ar_main as $ab => $value) {
            $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
            if ($ab< count($ar_main)) {
                    $li_text .=" ";
                }
          }
          $table.="<li><a class='smooth-goto' href='#$ft' class='flex align-items-start smooth-goto'> <span>".($k+1). "&nbsp;-&nbsp;". "</span>$li_text</a>";

          $st  = $matches[5][$k][0];
          $st  = "$st-s[0-9]";
          $matches_s = search_toc_pattren($st, $content);
         if (count($matches_s[1]) > 0){

             $table .="<ul class='second'>";
             foreach($matches_s[1] as $sk=>$sv){
                  $open_tag = "[[".$matches_s[5][$sk][0]."]]";
                  $close_tag = "[[/".$matches_s[5][$sk][0]."]]";
                  $ft = Str::slug($matches_s[3][$sk][0]);
                  $span = "<span id='$ft'></span>";
                  $content = str_replace($open_tag,$span,$content);
                  $content = str_replace($close_tag,"",$content);
                  $main = $matches_s[3][$sk][0];
                  $ar_main = explode(" ", $main);
                  $li_text = "";
                  foreach ($ar_main as $ab => $value) {
                    $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
                    if ($ab< count($ar_main)) {
                                $li_text .=" ";
                            }
                  }
                  //$matches_s[4][$sk][0]."<br>";
                  $table.="<li><a class='smooth-goto'  href='#$ft' class='flex align-items-start smooth-goto'> <span>".($k+1).".".($sk+1)."&nbsp;-&nbsp;". "</span>".$li_text."</a>";

                  $ct  = $matches_s[5][$sk][0];
                  $ct  = "$ct-c[0-9]";
                  $matches_c = search_toc_pattren($ct, $content);
                  if (count($matches_c[1]) > 0){
                     $table .="<ul class='third'>";
                    foreach($matches_c[1] as $kc=>$vc){
                        $open_tag = "[[".$matches_c[5][$kc][0]."]]";
                        $close_tag = "[[/".$matches_c[5][$kc][0]."]]";
                        $ft = Str::slug($matches_c[3][$kc][0]);
                        $span = "<span id='$ft'></span>";
                        $content = str_replace($open_tag,$span,$content);
                        $content = str_replace($close_tag,"",$content);
                        $main = $matches_c[3][$kc][0];
                        $ar_main = explode(" ", $main);
                        $li_text = "";
                        foreach ($ar_main as $ab => $value ) {
                            $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
                            if ($ab< count($ar_main)) {
                                $li_text .=" ";
                            }
                        }
                        $table.="<li class='li-end'><a class='smooth-goto'  href='#$ft' class='flex align-items-start smooth-goto'> <span>".($k+1).".".($sk+1).".".($kc+1). "&nbsp;-&nbsp;"."</span>".$li_text."</a></li>";
                    }
                      $table .="</ul>";
                  }
                 $table.="</li>";
             }
             $table.="</ul>";
         }
           $table.="</li>";
      }
      $table.="</ul>";
  }
    return array("content"=>$content, "table"=>$table);
}
function table_of_content2($content = ""){
    $table = "";
    $pattren = "/([[)(t[0-9]+)(]])(.+)(\[\[\/)(t[0-9]+)(\]\])/";
    $matches = search_toc_pattren("t[0-9]", $content);
    $all_pattren = array();
    if (count($matches[1]) > 0){
      $table.="<ol class='outer'>";
      foreach($matches[1] as $k=>$v){
          $open_tag = "[[".$matches[5][$k][0]."]]";
          $close_tag = "[[/".$matches[5][$k][0]."]]";
          $ft = Str::slug($matches[3][$k][0]);
          $span = "<span id='$ft'></span>";
          $content = str_replace($open_tag,$span,$content);
          $content = str_replace($close_tag,"",$content);
          $main = $matches[3][$k][0];
          $ar_main = explode(" ", $main);
          $li_text = "";
          foreach ($ar_main as $ab => $value) {
            $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
            if ($ab< count($ar_main)) {
                    $li_text .=" ";
                }
          }

          $table.="<li><a href='#$ft'class='smooth-goto'>$li_text</a>";

          $st  = $matches[5][$k][0];
          $st  = "$st-s[0-9]";
          $matches_s = search_toc_pattren($st, $content);
         if (count($matches_s[1]) > 0){

             $table .="<ol  class='nested-1'>";
             foreach($matches_s[1] as $sk=>$sv){
                  $open_tag = "[[".$matches_s[5][$sk][0]."]]";
                  $close_tag = "[[/".$matches_s[5][$sk][0]."]]";
                  $ft = Str::slug($matches_s[3][$sk][0]);
                  $span = "<span id='$ft'></span>";
                  $content = str_replace($open_tag,$span,$content);
                  $content = str_replace($close_tag,"",$content);
                  $main = $matches_s[3][$sk][0];
                  $ar_main = explode(" ", $main);
                  $li_text = "";
                  foreach ($ar_main as $ab => $value) {
                    $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
                    if ($ab< count($ar_main)) {
                                $li_text .=" ";
                            }
                  }
                  //$matches_s[4][$sk][0]."<br>";
                  $table.="<li><a href='#$ft' class='smooth-goto'>".$li_text."</a>";

                  $ct  = $matches_s[5][$sk][0];
                  $ct  = "$ct-c[0-9]";
                  $matches_c = search_toc_pattren($ct, $content);
                  if (count($matches_c[1]) > 0){
                     $table .="<ol  class='nested-1'>";
                    foreach($matches_c[1] as $kc=>$vc){
                        $open_tag = "[[".$matches_c[5][$kc][0]."]]";
                        $close_tag = "[[/".$matches_c[5][$kc][0]."]]";
                        $ft = Str::slug($matches_c[3][$kc][0]);
                        $span = "<span id='$ft'></span>";
                        $content = str_replace($open_tag,$span,$content);
                        $content = str_replace($close_tag,"",$content);
                        $main = $matches_c[3][$kc][0];
                        $ar_main = explode(" ", $main);
                        $li_text = "";
                        foreach ($ar_main as $ab => $value ) {
                            $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
                            if ($ab< count($ar_main)) {
                                $li_text .=" ";
                            }
                        }
                        $table.="<li><a href='#$ft' class='smooth-goto'>".$li_text."</a></li>";
                    }
                      $table .="</ol>";
                  }
                 $table.="</li>";
             }
             $table.="</ol>";
         }
           $table.="</li>";
      }
      $table.="</ol>";
  }
    return array("content"=>$content, "table"=>$table);
}
    function excape_words(){

        $r = array("is", "am", "are", "might", "a", "an", "the", "what", "it", "this", "that", "those", "there", "i", "my", "me", "mine", "for" , "your" ,"you" ,"of", "for" ,"the" ,"there" ,"will" ,"shall","go","who","in" ,"to" ,"?" ,"should" , "why" , "your" , "," , "-" , ":" , "_" , "|" , "where" , "Where" , "?" , "-" , "_" , "," , "'");

        return $r;

    }
    function get_related_post($limit , $tables, $id, $titles = array() , $tags = array()){
		$esp = array("where" , "Where" , "?" , "-" , "_" , "," , "'");
		$titles = str_replace($esp , "", $titles);
		//dd($titles);
         $r = DB::table("blogs")->where('status', 'publish')
        ->whereRaw("MATCH(title) AGAINST('$titles')")
        ->orderBy('id', 'desc')
        ->limit($limit)
        ->get();
        $d=" ";
        if (count($r) > 0){
            $d = "<div class='row related-row'>";
            $d .= "<div class='col-md-12 py-3'>";
            $d .="<h5 class='text-capitalize pl-3'>You may also Like these posts</h5>";
            $d .="<ul class='nav pl-5'>";
            foreach($r as $k=>$v){
                    $link = route("HomeUrl")."/".$v->slug."-2".$v->id;
                    $d.="<li class='nav-item'><a class='nav-link' href='$link' target='_blank' ><span class='icon'><i class='icon-chright'></i></span> <span class='text'>$v->title</span></a></li>";
            }
            $d.="</ul>";
            $d.="</div>";
            $d.="</div>";
        }
        return $d;

    }
    function get_related_post2($limit , $tables, $id, $titles = array() , $tags = array()){
        $icon = route("HomeUrl")."/amp-img/arrow.svg";
        $excape  = excape_words();
        $ts = array();
        $joins = array_merge($titles, $tags);
        foreach($joins as $k=>$v){
            if (!in_array(strtolower($v), $excape)){
                if (trim($v)!=""){
                    $ts[] = " title like '%$v%' OR meta_tags like '%$v%' ";
                }
            }
        }
        $titles = [];
        if (count($ts) > 0){
            $titles = implode(" or ", $ts);
        }
        $titles = " and ($titles)";
        $query  = "select * from $tables WHERE id !=$id and status = 'publish' $titles  order by rand() limit $limit";

        $r = DB::select( $query );
        $d=" ";
        if (count($r) > 0){
            $d = "<div class='row related-row'>";
            $d .="<h5 class='text-capitalize pl-3'>You may also Like these posts</h5>";
            $d .="<ul class='nav pl-5'>";
            foreach($r as $k=>$v){
                    $link = route("HomeUrl")."/".$v->slug."-2".$v->id;
                    $d.="<li class='nav-item'><a href='$link' target='_blank'  class='nav-link' ><span class='icon'><i class='icon-chright'></i></span><span class='text'>$v->title</span></a></li>";
            }
            $d.="</ul>";
            $d.="</div>";
        }
        return $d;

    }
    function _get_faqs($num , $id){
        $res =  DB::table('blogs')->select('faqs')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->faqs , true) : array();
         $num =  explode("-" , $num);
         $start = $num[0]-1;
         $end = $num[1] - $start;
         $data = array_slice($data, $start, $end);
        if (count($data) > 0 ) {
            $d = view( 'front.temp.faqs', compact( 'data' ) );
        }else{
            $d="";
        }
        return $d;
    }
    function get_faqs($num , $id){
        $res =  DB::table('blogs')->select('faqs')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->faqs , true) : array();
       //  dd($data);
         $num =  explode("," , $num);
         $ndata = array();
         foreach ($num as $k => $v) {
            $n = $v-1;
           if(array_key_exists($n, $data)){
                $ndata[] = $data[$n];
           }
         }
        $data = $ndata;
        if (count($data) > 0 ) {
            $d = view( 'front.temp.faqs', compact( 'data' ) );
        }else{
            $d=" ";
        }
       return $d;
    }
     function _get_faqs2($num , $id){
        $res =  DB::table('blogs')->select('faqs')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->faqs , true) : array();
         $num =  explode("-" , $num);
         $start = $num[0]-1;
         $end = $num[1] - $start;
         $data = array_slice($data, $start, $end);
        if (count($data) > 0 ) {
            $d = view( 'front.temp.faqs-amp', compact( 'data' ) );
        }else{
            $d="";
        }
        return $d;
    }
    function get_faqs2($num , $id){
        $res =  DB::table('blogs')->select('faqs')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->faqs , true) : array();
         $num =  explode("," , $num);
         $ndata = array();
         foreach ($num as $k => $v) {
             $n = $v-1;
           if(array_key_exists($n, $data)){
                $ndata[] = $data[$n];
           }
         }
        $data = $ndata;
        if (count($data) > 0 ) {
            $d = view( 'front.temp.faqs-amp', compact( 'data' ) );
        }else{
            $d="";
        }
       return $d;
    }
   function get_green($num , $id){
        $res =  DB::table('blogs')->select('green_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->green_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.green', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
     function get_red($num , $id){
        $res =  DB::table('blogs')->select('red_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->red_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.red', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
    function get_black($num , $id){
        $res =  DB::table('blogs')->select('black_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->black_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.black', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
    function get_green2($num , $id){
        $res =  DB::table('blogs')->select('green_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->green_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.green-amp', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
     function get_red2($num , $id){
        $res =  DB::table('blogs')->select('red_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->red_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.red-amp', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
    function get_black2($num , $id){
        $res =  DB::table('blogs')->select('black_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->black_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.black-amp', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
    function get_ads($num , $id){
        $res =  DB::table('ads')->select('ads')->first();
         $data   = isset($res)? json_decode($res->ads , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $url = ($data['url'] !="") ? $data['url'] : "";
            $img = ($data['img'] !="") ? $data['img'] : "";
            $title = ($data['title'] !="") ? $data['title'] : "";
            $alt = ($data['alt'] !="") ? $data['alt'] : "";
             $opt = array(
            "image" => $img,
            "type" => "main",
          );
          $img =  get_post_attachment($opt);
            $d = "<div class='ads-img'>";
                $d .="<a href='$url' title ='$title' target='_blank'> <img class='img-fluid w-100 lazy img-thumbnail' src='$img'  alt='$alt'></a>";
            $d .="</div>";
        }else{
           $d = "";
        }
        return $d;
    }
    function get_youtube($num , $id){
        $res =  DB::table('blogs')->where('id' , $id)->select('links')->first();
         $data   = isset($res)? json_decode($res->links , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $url = ($data['u_links'] !="") ? $data['u_links'] : "";
            $parts = parse_url($url);
            parse_str($parts['query'], $query);
            $v=$query['v'];
            $d = "<div class='u-wrapper'>";
                $d .="<div class='youtube' data-embed='$v' >";
                $d .="<div class='play-button'></div>";
                $d .="</div>";
            $d .="</div>";
        }else{
           $d = "";
        }
        return $d;
    }
    function get_youtube2($num , $id){
        $res =  DB::table('blogs')->where('id' , $id)->select('links')->first();
         $data   = isset($res)? json_decode($res->links , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $url = ($data['u_links'] !="") ? $data['u_links'] : "";
            $parts = parse_url($url);
            parse_str($parts['query'], $query);
            $v=$query['v'];
            $d = "<amp-youtube
                  data-videoid='$v'
                  layout='responsive'
                  width='480'
                  height='270'
                ></amp-youtube>";
        }else{
           $d = "";
        }
        return $d;
    }
    function get_gallery($id){
        $res =  DB::table('blogs')->select('gallery_images')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->gallery_images , true) : array();
        if (count($data) > 0 ) {
            $d = view( 'front.temp.gallery', compact( 'data' ) );
        }else{
            $d="";
        }
        return $d;
    }
    function talk_start($id){
        $d = "<div class='talk'>";
        return $d;
    }
    function talk_end($id){
        $d = "</div>";
        return $d;
    }
    function do_short_code($content,$id, $tables, $titles, $tags = array()){
        preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
              $matches = (isset($matches[1])) ? $matches[1] : array();
                  foreach($matches as $k=>$v){
                    $exp = explode(":", $v);
                    $r = "";
                    if ($exp[0]=="related"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_related_post("$e" , $tables, $id, $titles, $tags);
                      }
                    }elseif ($exp[0]=="faqs"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and strpos($e, '-') !== false){
                         $r= _get_faqs("$e" , $id);
                      }elseif(!empty($e) and strpos($e, ',') !== false){
                         $r= get_faqs("$e" , $id);
                      }else{
                         $r= get_faqs("$e" , $id);
                      }
                    }elseif ($exp[0]=="green"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_green("$e" , $id);
                      }
                    }elseif ($exp[0]=="red"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_red("$e" , $id);
                      }
                    }elseif ($exp[0]=="black"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_black("$e" , $id);
                      }
                    }elseif ($exp[0]=="ads"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_ads("$e" , $id);
                      }
                    }elseif ($exp[0]=="youtube"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_youtube("$e" , $id);
                      }
                    }elseif ($v=="gallery"){
                         $r= get_gallery($id);
                    }elseif ($exp[0]=="talk"){
                         $r= talk_start($id);
                    }elseif ($exp[0]=="end-talk"){
                         $r= talk_end($id);
                    }
                    if($r !=""){
                        $content = str_replace("[[$v]]", $r, $content);
                    }
                  }
         return $content;
    }
    function do_short_code2($content,$id, $tables, $titles, $tags = array()){
        preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
              $matches = (isset($matches[1])) ? $matches[1] : array();
                  foreach($matches as $k=>$v){
                    $exp = explode(":", $v);
                    $r = "";
                    if ($exp[0]=="related"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_related_post2("$e" , $tables, $id, $titles, $tags);
                      }
                    }elseif ($exp[0]=="faqs"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and strpos($e, '-') !== false){
                         $r= _get_faqs2("$e" , $id);
                      }elseif(!empty($e) and strpos($e, ',') !== false){
                         $r= get_faqs2("$e" , $id);
                      }else{
                         $r= get_faqs2("$e" , $id);
                      }
                    }elseif ($exp[0]=="green"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_green2("$e" , $id);
                      }
                    }elseif ($exp[0]=="red"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_red2("$e" , $id);
                      }
                    }elseif ($exp[0]=="black"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_black2("$e" , $id);
                      }
                    }elseif ($exp[0]=="youtube"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_youtube2("$e" , $id);
                      }
                    }elseif ($exp[0]=="ads"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_ads("$e" , $id);
                      }
                    }elseif ($v=="gallery"){
                         $r= get_gallery($id);
                    }elseif ($exp[0]=="talk"){
                         $r= talk_start($id);
                    }elseif ($exp[0]=="end-talk"){
                         $r= talk_end($id);
                    }
                    if($r !=""){
                        $content = str_replace("[[$v]]", $r, $content);
                    }
                  }
         return $content;
    }
    function clean_short_code($content = ""){
        dd("ok");
    // Remove TOC
    $content = str_replace("[[toc]]", "", $content);
    // Remove Table of Content Shortcode
    $content = table_of_content($content);
    $content = $content["content"];
    //Remove Related, download tags
    preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
    $matches = (isset($matches[1])) ? $matches[1] : array();
    foreach($matches as $k=>$v){
        $exp = explode(":", $v);
        $r = "";
        if ($exp[0]=="related"){
          $e  = (isset($exp[1])) ? $exp[1] : "";
          if (!empty($e) and is_numeric($e)){
             $r = "";
          }
        }elseif ($exp[0]=="download"){
          $e  = (isset($exp[1])) ? $exp[1] : "";
          if (!empty($e) and is_numeric($e)){
             $r = "";
          }
        }elseif ($exp[0]=="ads"){
          $e  = (isset($exp[1])) ? $exp[1] : "";
          if (!empty($e) and is_numeric($e)){
             $r = "";
          }
        }
        $content = str_replace("[[$v]]", $r, $content);
    }
    return $content;
}
function clean($str)
{
    $str = trim($str);
    return $str;
}
function refresh_views($views = 0, $post_id, $page_id , $full ){
            if($page_id == 2){
                //die("okkkk");
                \App\Models\Blog::where('id', $post_id)->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['view_date',"=", $today]
                        ])->get();

                if (count($row) == 0){
                   \App\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($page_id == 1){
                \App\Models\BlogCategory::where('id', $post_id)->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($page_id == 5){
                    if($full == "faqs"){
                     DB::table("meta")->where('page_name', $full)->update(['views' => $views+1]);
                    $today = date("y-m-d");
                    $row = \App\Views::where([
                                ['post_id', "=",$post_id],
                                ['page_id', "=",$page_id],
                                ['page_name', "=",$full],
                                ['view_date',"=", $today]
                            ])->get();
                    if (count($row) == 0){
                       \App\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                    }else{
                         $vid = $row[0]->id;
                         $views = $row[0]->views +1;
                         \App\Views::where('id', $vid)->update(['views' => $views]);
                    }
                }elseif($full == "contact"){
                     DB::table("contact_us")->update(['views' => $views+1]);
                    $today = date("y-m-d");
                    $row = \App\Views::where([
                                ['post_id', "=",$post_id],
                                ['page_id', "=",$page_id],
                                ['page_name', "=",$full],
                                ['view_date',"=", $today]
                            ])->get();
                    if (count($row) == 0){
                       \App\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                    }else{
                         $vid = $row[0]->id;
                         $views = $row[0]->views +1;
                         \App\Views::where('id', $vid)->update(['views' => $views]);
                    }
                }elseif($full == ""){
                    $full = "home";
                     DB::table("homedata")->update(['views' => $views+1]);
                    $today = date("y-m-d");
                    $row = \App\Views::where([
                                ['post_id', "=",$post_id],
                                ['page_id', "=",$page_id],
                                ['page_name', "=",$full],
                                ['view_date',"=", $today]
                            ])->get();
                    if (count($row) == 0){
                       \App\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                    }else{
                         $vid = $row[0]->id;
                         $views = $row[0]->views +1;
                         \App\Views::where('id', $vid)->update(['views' => $views]);
                    }
                }elseif($full == "privacy-policy"){
                     DB::table("privacies")->update(['views' => $views+1]);
                    $today = date("y-m-d");
                    $row = \App\Views::where([
                                ['post_id', "=",$post_id],
                                ['page_id', "=",$page_id],
                                ['page_name', "=",$full],
                                ['view_date',"=", $today]
                            ])->get();
                    if (count($row) == 0){
                       \App\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                    }else{
                         $vid = $row[0]->id;
                         $views = $row[0]->views +1;
                         \App\Views::where('id', $vid)->update(['views' => $views]);
                    }
                }elseif($full == "terms-conditions"){
                     DB::table("terms_conditions")->update(['views' => $views+1]);
                    $today = date("y-m-d");
                    $row = \App\Views::where([
                                ['post_id', "=",$post_id],
                                ['page_id', "=",$page_id],
                                ['page_name', "=",$full],
                                ['view_date',"=", $today]
                            ])->get();
                    if (count($row) == 0){
                       \App\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                    }else{
                         $vid = $row[0]->id;
                         $views = $row[0]->views +1;
                         \App\Views::where('id', $vid)->update(['views' => $views]);
                    }
                }
            }

        }
    function popular_post($page_id = "" ,  $post_id = "" , $slug = ""){
        if ($page_id == 3) {
              $r = \App\Models\Blog::where('id','!=',$post_id)->orderBy('views', 'desc')->limit(5)->get();
        }elseif ($page_id == 2) {
              $r = \App\Models\Blog::orderBy('views', 'desc')->limit(5)->get();
        }elseif ($page_id == 4) {
              $r = \App\Models\Blog::orderBy('views', 'desc')->limit(5)->get();
        }elseif ($slug == "blogs") {
              $r = \App\Models\Blog::orderBy('views', 'desc')->limit(5)->get();
        }elseif ($slug == "careers") {
              $r = \App\Models\Blog::orderBy('views', 'desc')->limit(5)->get();
        }
        $res = "";
        foreach ($r as $kv) {
          $title = unslash( $kv->title );
          $short_title = ( strlen( $title ) > 20 ) ? substr( $title, 0, 40 ) . "...": $title;
          $content = trim(trim_words( html_entity_decode($kv->content), 35 ));
          $image = $kv->cover;
          $date = date("d M Y", $kv->date );
          $opt = array(
            "image" => $image,
            "type" => "thumb",
          );
          $thumb =  get_post_attachment($opt);
          $cover =  get_post_attachment(array("image"=>$image , "type"=>"full"));
          $url = route('HomeUrl')."/".$kv->slug."-3".$kv->id;
           $res .= "<div class='col-lg-12 col-md-6 col-sm-6 latest-border'>
                        <li class='list-item'>
                        <div class='row'>
                             <div class='col-4 col-lg-5 pl-0'>
                               <a href='$url'><img src='$thumb' class='img-fluid' alt='$title'></a>
                            </div>
                            <div class='col-8 col-lg-7 pl-0'>
                                 <a href='$url'>$title</a>
                            </div>
                        </div>
                     </li>
                 </div>";
            }
            if (count($r) >0) {
               echo " <div class='sidebar-ribbon my-3'>
                 <h6 class='side-heading px-2'>Popular</h6>
                 </div>
                 <ul class='nav latest-entries'>"
                . $res.
                 "</ul>";
            }

    }
    // Default Image loader
function default_image_loader(){
    return route("HomeUrl")."/images/Preloader1.gif";
}
    function lazy_content($content = ""){
    if ($content==""){
        return $content;
    }else{

        $dom = new DOMDocument;
		@$dom->loadHTML($content, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);
        @$images = $dom->getElementsByTagName('img');
        if (isset($images->length) and $images->length > 0){
            foreach($images as $image){
                @$old_src = $image->getAttribute('src');
                @$new_src_url = 'image/catalog/blank.gif';
                @$image->setAttribute('src',  default_image_loader() );
                @$image->setAttribute('data-src', $old_src);
                @$image->setAttribute('class', "lazy");
            }
            @$content= $dom->saveHTML();
            return $content;
        }else{
            return $content;
        }
    }
}
  function amp_image($content = ""){
    if ($content==""){
        return $content;
    }else{

        $dom = new DOMDocument;
        @$dom->loadHTML($content);
        @$images = $dom->getElementsByTagName('img');
        if (isset($images->length) and $images->length > 0){
            foreach($images as $image){
                @$old_src = $image->getAttribute('src');
                if(file_exists($old_src)){
                    list($width, $height) = getimagesize($old_src);
                }else{
                    $width = "700";
                    $height = "500";
                 }
                @$image->setAttribute('layout', "responsive");
                @$image->setAttribute('width', $width);
                @$image->setAttribute('height', $height);
            }
            @$content= $dom->saveHTML();
            $content = str_replace("<img", "<amp-img", $content);
            return $content;
        }else{
            return $content;
        }
    }
}
  function amp_youtube($content = ""){
    if ($content==""){
        return $content;
    }else{

        $dom = new DOMDocument;
        @$dom->loadHTML($content);
        @$youtube_div = $dom->getElementById('dom_id');
            foreach($youtube_div as $div){
                @$vid = $div->getAttribute('data-vid');
                @$div->setAttribute('layout', "responsive");
                @$div->setAttribute('width', $width);
                @$div->setAttribute('height', $height);
            }
            @$content= $dom->saveHTML();
            $content = str_replace("<img", "<amp-img", $content);
            return $content;
    }
}
function daily_views($id = ""){
    $date= $today = date( "Y-m-d" );
    $sum  = DB::table("views")->where([
            ['view_date' , '=' , $today] ,
            ['page_id' , '=' , 2] ,
            ['post_id' , '=' , $id] ,
    ])->sum("views");
    return $sum;
}
function monthly_views($id = ""){
    $date= date( "Y-m" );
        $sum  = DB::table("views")->where([
            ['view_date' , 'like' , "%$date%"] ,
            ['page_id' , '=' , 2] ,
            ['post_id' , '=' , $id] ,
    ])->sum("views");
    return $sum;
}
function yearly_views($id = ""){
    $date= date( "Y" );
        $sum  = DB::table("views")->where([
            ['view_date' , 'like' , "%$date%"] ,
            ['page_id' , '=' , 2] ,
            ['post_id' , '=' , $id] ,
    ])->sum("views");
    return $sum;
}
function total_views($id = ""){
    $row=DB::table("views")->where("post_id" , $id)->where('page_id' , 2)->sum('views');
    return $row;
}


// Encrypt Data
function _encrypt($str=""){
    $key = env('APP_KEY');
    $code = $key."--".$str."--".$key;
    return base64_encode($code);
}

// Decrypt data
function _decrypt($str=""){
    $code = base64_decode($str);
    $exp = explode("--",$code);
    $code = (isset($exp[1])) ? $exp[1] : "";
    return $code;
}
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
function _slider_img(){
	$home = \App\Models\Homedata::all()->map->toArray();
	$slider = $home[0]['slider_images'];
	$slider = json_decode($slider);
	return count($slider);

}
 function updateEnv($data = array()){
		if (!count($data)) {
			return;
		}

		$pattern = '/([^\=]*)\=[^\n]*/';

		$envFile = base_path() . '/.env';
		$lines = file($envFile);
		$newLines = [];
		foreach ($lines as $line) {
			preg_match($pattern, $line, $matches);

			if (!count($matches)) {
				$newLines[] = $line;
				continue;
			}

			if (!key_exists(trim($matches[1]), $data)) {
				$newLines[] = $line;
				continue;
			}

			$line = trim($matches[1]) . "={$data[trim($matches[1])]}\n";
			$newLines[] = $line;
		}

		$newContent = implode('', $newLines);
		file_put_contents($envFile, $newContent);
	}

function adsViews($type = "current_month"){
        $vw = array();
        $new = array(
            "labels" => array(),
            "data1" => array(),
        );
        if ($type=="current_month" or $type==""){
            $date = date("Y-m");
            $days = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
            for($n=1; $n<=$days; $n++){
                if($n<10){
                    $date = date("Y-m")."-0$n";
                }else{
                    $date = date("Y-m")."-$n";
                }
                $hm = DB::table("views")->where([
                    ["view_date", "like", "%$date%"]
                ])->sum("views");

                $new["labels"][] = $n." ".date("M");
                $new["data1"][] = $hm;
            }

        }elseif($type=="monthly"){
            for($n=1; $n<=12; $n++){
                if($n < 10){
                    $date = date("Y")."-0$n";
                }else{
                    $date = date("Y")."-$n";
                }
                $hm = DB::table("views")->where([
                    ["view_date", "like", "%$date%"]
                ])->sum("views");
                $new["labels"][] = date("M y", strtotime($date));
                $new["data1"][] = $hm;
            }
        }elseif($type == "annually"){
            for($n=2019; $n<=2030; $n++){
                $hm = DB::table("views")->where([
                    ["view_date", "like", "%$n%"]
                ])->sum("views");
                $new["labels"][] = $n;
                $new["data1"][] = $hm;
            }
        }

        return $new;
    }

    function _getCatPostCount($id = 0){
        $post = DB::table("blogs")->whereRaw("FIND_IN_SET(?, category) > 0", [$id])->get();
        return count($post);
    }
    function file_exist($image = "")
    {
        $path = base_path();
        if ($image == "") {
            return false;
        } else {
            $exp   = explode("/", $image);
            $file  = end($exp);
            $exp   = explode(".", $file);
            $ext   = end($exp);
            $image = '/images/' . "$file";
            if (file_exists($path . $image)) {
                return $image;
            } else {
                return false;
            }
        }
    }

    function insert($data=array()){
        foreach($data as $k=>$v){
            $opton_key = $k;
            $option_value = $v;
            $r = get($opton_key);
            $data = array(
                "option_key" => $opton_key,
                "option_value" => $option_value
            );
            if ($r =="" ){
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
