<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Blogs;
use DB;
use Illuminate\Http\Request;

class AdminAjaxController extends Controller
{

    public function Croppie()
    {
        $image_n = explode("/", $_GET['img']);

        $imgname  = explode(".", end($image_n));
        $imge_exe = $imgname[1];

        $nw_name   = explode("-", $imgname[0]);
        $last_node = end($nw_name);
        if (is_numeric($last_node)) {
            $nw_name = str_replace("-$last_node", "", $imgname[0]);
            $nw_name = $nw_name . "-300";
        } else {
            $nw_name = $imgname[0] . "-300";
        }
        $image_name = $nw_name . "." . $imgname[1];
        $fileType   = pathinfo($_GET['img'], PATHINFO_EXTENSION);
        $dest       = ImageCreateTrueColor(300, 200);
        switch ($fileType) {
            case "jpg":
            case "jpeg":
                $src = imagecreatefromjpeg($_GET['img']);
                imagecopyresampled($dest, $src, 0, 0, $_GET['x'], $_GET['y'], 300, 200, $_GET['w'], $_GET['h']);
                if (isset($_GET["ret"])) {
                    return url("images/" . $image_name);
                }
                header('Content-type: image/jpeg');
                if (isset($_GET["sv"])) {
                    imagejpeg($dest, base_path("images/" . $image_name));
                }
                imagejpeg($dest);
                break;
            case "png":
                $src = imagecreatefrompng($_GET['img']);
                imagecopyresampled($dest, $src, 0, 0, $_GET['x'], $_GET['y'], 300, 200, $_GET['w'], $_GET['h']);
                if (isset($_GET["ret"])) {
                    return url("images/" . $image_name);
                }
                header('Content-type: image/jpeg');
                if (isset($_GET["sv"])) {
                    imagepng($dest, base_path("images/" . $image_name));
                }
                imagepng($dest);
                break;
            case "gif":
                $src = imagecreatefromgif($_POST['image_path']);
                imagecopyresampled($dest, $src, 0, 0, $_POST['x'], $_POST['y'], $_POST['dimension_x'], $_POST['dimension_y'], $_POST['w'], $_POST['h']);
                imagegif($dest, $_POST['image_destination'] . '.gif');
                imagedestroy($dest);
                imagedestroy($src);
                break;
        }
        // $img_r = imagecreatefromjpeg($_GET['img']);
        // $dst_r = ImageCreateTrueColor( $_GET['w'], $_GET['h'] );
        // imagecopyresampled($dst_r, $img_r, 0, 0, $_GET['x'], $_GET['y'], $_GET['w'], $_GET['h'], $_GET['w'],$_GET['h']);
        // if(isset($_GET["ret"])){
        //     return url("images/".$image_name);
        // }
        // header('Content-type: image/jpeg');
        // if(isset($_GET["sv"])){
        //     imagejpeg($dst_r, base_path("images/".$image_name));
        // }
        // imagejpeg($dst_r);
        exit;
    }

    public function get_views()
    {
        if (request('v') == "daily") {
            $data  = array();
            $today = date("d");
            $d     = array();
            $v     = array();
            $days  = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            for ($n = 1; $n <= $days; $n++) {
                $n     = ($n < 10) ? "0$n" : $n;
                $date  = (date("y") . "-" . date("m") . "-$n");
                $sql   = "select sum(views) as views from views where view_date='$date' GROUP BY view_date";
                $row   = DB::select($sql);
                $views = (count($row) > 0) ? $row[0]->views : 0;
                $d[]   = $n;
                $v[]   = $views;}
            $data["d"] = $d;
            $data["v"] = $v;
        } elseif (request('v') == "yearly") {
            $yr = array(
                '2019' => '2019',
                '2020' => '2020',
                '2021' => '2021',
                '2022' => '2022',
                '2023' => '2023',
                '2024' => '2024',
                '2025' => '2025',
                '2026' => '2026',
                '2027' => '2027',
                '2028' => '2028',
                '2029' => '2029',
                '2030' => '2030',
            );
            $data  = array();
            $today = date("d");
            $d     = array();
            $v     = array();
            $days  = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            foreach ($yr as $y) {

                $date  = ("$y");
                $sql   = "select sum(views) as views from views where YEAR(view_date) = '$y' ";
                $row   = DB::select($sql);
                $views = (count($row) > 0) ? $row[0]->views : 0;
                $views = (is_numeric($views)) ? $views : 0;
                $d[]   = $y;
                $v[]   = $views;}
            $data["d"] = $d;
            $data["v"] = $v;
        } elseif (request('v') == "monthly") {
            $mth = array(
                '1'  => 'January',
                '2'  => 'February',
                '3'  => 'March',
                '4'  => 'April',
                '5'  => 'May',
                '6'  => 'June',
                '7'  => 'July',
                '8'  => 'August',
                '9'  => 'September',
                '10' => 'October',
                '11' => 'November',
                '12' => 'December',
            );
            $data  = array();
            $month = intval(date("m"));
            $year  = date("Y");
            $d     = array();
            $v     = array();
            for ($n = 1; $n <= 12; $n++) {
                $m    = ($n < 10) ? "0$n" : $n;
                $date = (date("Y") . "-" . date($m) . "-");
                $sql  = "select sum(views) as views from views where view_date like '%$date%' GROUP BY view_date";
                $row  = DB::select($sql);
                $sum  = 0;
                foreach ($row as $k) {
                    $sum += $k->views;
                }
                $views = (count($row) > 0) ? $row[0]->views : 0;
                $d[]   = $mth[$n];
                $v[]   = $sum;
            }
            $data["d"] = $d;
            $data["v"] = $v;
        } else {
            $data  = array();
            $today = date("d");
            $d     = array();
            $v     = array();
            $days  = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            for ($n = 1; $n <= $days; $n++) {
                $n     = ($n < 10) ? "0$n" : $n;
                $date  = (date("y") . "-" . date("m") . "-$n");
                $sql   = "select sum(views) as views from views where view_date='$date' GROUP BY view_date";
                $row   = DB::select($sql);
                $views = (count($row) > 0) ? $row[0]->views : 0;
                $d[]   = $n;
                $v[]   = $views;}
            $data["d"] = $d;
            $data["v"] = $v;
        }
        return json_encode($data);
    }
    public function get_internalLinks()
    {
        $id      = request('id');
        $result  = array();
        $result1 = array();
        $res     = Blog::select("internal_links")->get();

        foreach ($res as $value) {
            $result[] = $value->internal_links;
        }
        $result          = array_filter($result);
        $expected_result = implode(",", $result);
        return $expected_result;
    }
}
