<?php
namespace App\Http\Controllers;

use App\Helpers\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralsettingController extends Controller
{

    public $Options;
    public function __construct()
    {
        $this->Options = new Options;
    }
    public function theme()
    {
        if (request()->has('submit')) {
            // dd(request()->all());
            $this->saveOtion("theme_color", request("theme_color"));
            $theme_color = "--site-color:" . request("theme_color");
            $this->saveOtion("title_color", request("title_color"));
            $title_color = "--title-color:" . request("title_color");
            $this->saveOtion("anchor_color", request("anchor_color"));
            $link_color = "--link-color:" . request("anchor_color");
            $this->saveOtion("blog_h1_color", request("blog_h1_color"));
            $blog_h1_color = "--blog-detail-h1:" . request("blog_h1_color");
            $this->saveOtion("blog_h2_color", request("blog_h2_color"));
            $blog_h2_color = "--blog-detail-h2:" . request("blog_h2_color");
            $this->saveOtion("blog_h3_color", request("blog_h3_color"));
            $blog_h3_color = "--blog-detail-h3:" . request("blog_h3_color");
            $this->saveOtion("css_version", request("css_version"));
            $file     = file_get_contents(url("assets/css/head_foot.css"));
            $file2    = file_get_contents(url("assets/css/blog_detail.css"));
            $file     = preg_replace("/--site-color:#[0-9A-Za-z]+/", $theme_color, $file);
            $file     = preg_replace("/--title-color:#[0-9A-Za-z]+/", $title_color, $file);
            $file     = preg_replace("/--link-color:#[0-9A-Za-z]+/", $link_color, $file);
            $file2    = preg_replace("/--blog-detail-h1:#[0-9A-Za-z]+/", $blog_h1_color, $file2);
            $file2    = preg_replace("/--blog-detail-h2:#[0-9A-Za-z]+/", $blog_h2_color, $file2);
            $file2    = preg_replace("/--blog-detail-h3:#[0-9A-Za-z]+/", $blog_h3_color, $file2);
            $mfile    = fopen(base_path("assets/css/head_foot.css"), "w");
            $blogfile = fopen(base_path("assets/css/blog_detail.css"), "w");
            fwrite($mfile, $file);
            fclose($mfile);
            fwrite($blogfile, $file2);
            fclose($blogfile);
            return redirect(route('theme-setting'))->with('flash_message', 'Theme Settings Record Updated Successfully');
        }
        return view('admin.theme-settings');
    }
    public function index()
    {
        if (request()->has('submit')) {
            // dd(request()->all());
            $schema = request('schema');
            $type   = request('type');
            $schm   = array();
            if ($type != "") {
                for ($a = 0; $a < count($type); $a++) {
                    if ($type[$a] != "") {
                        $schm[] = array(
                            "schema" => $schema[$a],
                            "type"   => $type[$a],
                        );
                    }
                }
            }
            $this->saveOtion("logo", request("logo"));
            $this->saveOtion("short_logo", request("short_logo"));
            $this->saveOtion("favicon", request("favicon"));
            $this->saveOtion("og", request("og"));
            $this->saveOtion("google_analytics", request("google_analytics"));
            $this->saveOtion("web_master", request("web_master"));
            $this->saveOtion("bing_master", request("bing_master"));
            $this->saveOtion("header_script", request("header_script"));
            $this->saveOtion("subscriber_text", request("subscriber_text"));
            $this->saveOtion("website_name", request("website_name"));
            $this->saveOtion("website_title", request("website_title"));
            $this->saveOtion("facebook_url", request("facebook_url"));
            $this->saveOtion("twitter_url", request("twitter_url"));
            $this->saveOtion("instagram_url", request("instagram_url"));
            $this->saveOtion("linkedin_url", request("linkedin_url"));
            $this->saveOtion("youtube_url", request("youtube_url"));
            $this->saveOtion("copy_rights", request("copy_rights"));

            return redirect(route('general-setting'))->with('flash_message', 'General Settings Record Updated Successfully');
        }
        return view('admin.general-settings');
    }
    public function saveOtion($key, $value)
    {
        $r    = DB::table("common_options")->where("option_key", $key)->first();
        $data = array(
            "option_key"   => $key,
            "option_value" => $value,
        );
        if (isset($r->id)) {
            DB::table("common_options")->where("option_key", $key)->update($data);
        } else {
            DB::table("common_options")->insert($data);
        }
    }
    public function menu(Request $request)
    {
        if (request()->has('save')) {
//            dd(request()->all());
            $this->saveOtion("menu", request("data"));
            return back()->with('flash_message', 'Menu is saved successfully..');
        }

        if (request()->has('link-submit') and request("link-submit") == "Submit") {
            // dd(request()->all());
            $this->validate($request, [
                'empty_link' => ['required', 'min:2', 'max:100'],

            ]);
            $empty_link = request('empty_link');
            $rec        = array(
                'name'     => $empty_link,
                'tb_order' => 0,
            );
            $id = DB::table("empty_links")->insertGetId($rec);
            return back()->with('flash_message', 'Yours Record is updated successfully');
        } elseif (request("link-submit") == "Update") {
            $empty_link = request('empty_link');
            $rec        = array(
                'name'     => $empty_link,
                'tb_order' => 0,
            );
            DB::table("empty_links")->where("id", request('id'))->update($rec);
            return back()->with('flash_message', 'Empty Links Record is  updated successfully');
        }
        if (request()->has('del') and is_numeric(request('del'))) {
            DB::table("courses")->where('id', request('del'))->delete();
            return back()->with('flash_message', 'Course is  deleted successfully');
        }
        if (request()->has('edit')) {
            $Options = $this->Options;
            $edit    = DB::table("empty_links")->where('id', request('edit'))->first();
            $links   = DB::table("empty_links")->orderby('name', 'asc')->get();
            return view('admin.menu', compact('edit', 'Options', 'links'));
        }
        $Options = $this->Options;
        $links   = DB::table("empty_links")->get();
        return view('admin.menu', compact('Options', 'links'));
    }
    public function addCourse(Request $request)
    {

        $data  = DB::table("courses")->get();
        $data2 = DB::table("courses")->orderBy('tb_order', 'ASC')->get();
        return view('admin.users.add-course', compact("data", "data2"));
    }
}
