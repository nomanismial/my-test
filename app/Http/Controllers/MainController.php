<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Faqs;
use App\Models\About;
use App\Models\Pages;
use App\Models\Author;
use App\Models\Privacy;
use App\Helpers\Options;
use App\Models\Category;
use App\Models\Homedata;
use App\Models\ContactUs;
use App\Models\WriteForUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public $Options;
    public function __construct()
    {
        $this->Options = new Options;
    }
    public function _dbUpdate()
    {
        $res    = DB::table("media")->get();
        $images = array();
        foreach ($res as $k => $v) {
            $id    = $v->id;
            $sizes = json_decode($v->sizes, true);
            $full  = json_decode($v->images, true);
            $_img  = array();
            if (isset($full["full"])) {
                $full         = $full["full"];
                $_img["full"] = $full;
                $path         = base_path("images/$full");
                if (file_exists($path)) {
                    $exp       = explode(".", $full);
                    $ext       = end($exp);
                    $file_name = str_replace(".$ext", "", $full);
                    foreach ($sizes as $size) {
                        $_nf   = $file_name . "-$size." . $ext;
                        $file_ = base_path("images/" . $_nf);
                        if (file_exists($file_)) {
                            $info     = getimagesize($file_);
                            $width    = $info[0];
                            $height   = $info[1];
                            $new_name = $file_name . "-" . $size . "x" . $height . "." . $ext;
                            //rename($file_, base_path("images/".$new_name));
                            $_img[$size] = $new_name;
                        }
                    }
                }
            }
            /*
            DB::table("media")->where("id", $id)->update([
            "images" => json_encode($_img)
            ]);*/
            $images[] = $_img;
        }
        echo "<pre>";
        print_r($images);
        die();
    }
    public function index()
    {
        // $data = Blog::where('id',1)->with('categories' , 'author')->first();
        // dd($data);
        $home = Homedata::first();
        $design = isset($home->home_design) ? json_decode($home->home_design) : array();
        $slider = isset($home['slider_images']) ? json_decode($home['slider_images']) : array();
        return view('front.home', compact('design','slider'));
    }
    /*AMP Blog Function*/
    public function ampblogs()
    {
        $page_id = get_postid2('page_id');
        $post_id = get_postid2('post_id');
        //checks if category id not numeric
        if (!is_numeric($post_id)) {
            return redirect(route("HomeUrl") . "/404");
        }
        //checks if category does not exists
        /*$blogs = Blog::whereRaw("FIND_IN_SET(?, category) > 0", [$post_id])->get();*/
        $blog = Blog::where('id', $post_id)->first();
        if (!isset($blog->id)) {
            return redirect(route("HomeUrl") . "/404");
        }

        $slug   = get_postid2("slug");
        $c_slug = $blog->slug;
        if ($slug != $c_slug) {
            return redirect(route("HomeUrl") . "/amp/" . $blog->slug . "-2" . $blog->id);
        }
        $cats = Category::select('id', 'title', 'slug')->get();
        return view('front.blog-amp', compact('blog', 'cats'));
    }
    public function single()
    {
        if (get_postid('page_id') == 1) {
            $page_id = get_postid('page_id');
            $post_id = get_postid('post_id');
            //checks if category id not numeric
            if (!is_numeric($post_id)) {
                return redirect(route("HomeUrl") . "/404");
            }
            //checks if category does not exists
            $cats = Category::where('id', $post_id)->first();
            if (!isset($cats->id)) {
                return redirect(route("HomeUrl") . "/404");
            }

            $slug   = get_postid("slug");
            $c_slug = $cats->slug;
            if ($slug != $c_slug) {
                return redirect(route("HomeUrl") . "/" . $cats->slug . "-1" . $cats->id);
            }
            $r = Category::where('id', $post_id)->select("before_popular", "after_popular", "popular_popular")->first();
            //dd($r);
            $pgnt = ($r["before_popular"] + $r["after_popular"]) * 4;
            // dd($pgnt);
            $blogs = Blog::orderBy('id', 'desc')->where('status', 'publish')->whereRaw("FIND_IN_SET(?, category_id) > 0", [$post_id])->paginate($pgnt);
            $limit = isset($r["popular_popular"]) ? $r["popular_popular"] * 2 : 4;
            $res   = Blog::orderBy('views', 'desc')->where('status', 'publish')->whereRaw("FIND_IN_SET(?, category_id) > 0", [$post_id])->get()->take($limit);
            //   dd($res);
            return view('front.blogcat', compact('cats', 'blogs', 'res'));
        } elseif (get_postid('page_id') == 2) {
            $page_id = get_postid('page_id');
            $post_id = get_postid('post_id');

            //checks if category id not numeric
            if (!is_numeric($post_id)) {
                return redirect(route("HomeUrl") . "/404");
            }
            //checks if category does not exists
            /*$blogs = Blog::whereRaw("FIND_IN_SET(?, category) > 0", [$post_id])->get();*/

            $blog = Blog::where(['id' => $post_id, 'status' => 'publish'])->first();
            if (!isset($blog->id)) {
                return redirect(route("HomeUrl") . "/404");
            }
            $slug   = get_postid("slug");
            $c_slug = $blog->slug;
            if ($slug != $c_slug) {
                return redirect(route("HomeUrl") . "/" . $blog->slug . "-2" . $blog->id);
            }
            $cats = Category::select('id', 'home_title', 'slug')->get();
            return view('front.blog', compact('blog', 'cats'));
        }
    }
    public function _contact()
    {
        $res = ContactUs::orderBy("id", "desc")->first();
        return view('front.contact-us', compact('res'));
    }
    public function privacy()
    {
        $data = Pages::where('page_name', 'privacy-policy')->first();
        return view('front.privacy', compact('data'));
    }
    public function about()
    {
        $data = About::first();
        return view('front.about', compact('data'));
    }
    public function WriteForUs()
    {
        $data = WriteForUs::first();
        return view('front.write', compact('data'));
    }
    public function _faqs()
    {
        $data = Faqs::orderBy('tb_order', 'asc')->get();
        return view('front.faqs', compact('data'));
    }
    public function terms()
    {
        $data = Pages::where('page_name', 'terms-conditions')->first();

        return view('front.terms', compact('data'));
    }
    public function search()
    {
        if (request()->has('q')) {
            $where = _clean(request()->get('q'));
            $data  = DB::table('blogs')
                ->where('status', 'publish')
                ->whereRaw("MATCH(title) AGAINST('$where')")
                ->orderBy('id', 'DESC')
                ->limit(4)->get();
            $where = $where;
            return view('front.temp.search', compact('data', 'where'));
        } else {
            $voew = view('front.404')->render();
            return response($voew, "404");
        }
    }
    public function more_post(Request $request)
    {
        // dd(request()->all());
        $limit  = 4;
        $output = '';
        $id     = request("id");
        $where  = _clean(request("query"));
        // dd($where);
        $posts = DB::table('blogs')
            ->where('id', '<', $id)
            ->where('status', 'publish')
            ->whereRaw("MATCH(title) AGAINST('$where')")
            ->orderBy('id', 'DESC')
            ->limit($limit)->get();
        // dd($posts);
        if (!$posts->isEmpty()) {
            foreach ($posts as $post => $v) {
                $title       = unslash($v->title);
                $short_title = strlen($title) > 60 ? substr($title, 0, 160) . '...' : $title;
                $content     = trim(trim_words(html_entity_decode($v->content), 35));
                $content     = clean_short_code(html_entity_decode($content));
                $image       = $v->cover;
                $date        = date('d M Y', $v->date);
                $views       = $v->views;
                $url         = route('HomeUrl') . '/' . $v->slug . '-2' . $v->id;
                $output .=
                '<div class="col">
                  <div class="card h-100 rounded-3">
                      <a href="' . $url . '">
                          <div class="image__ position-relative">
                              <img src="' . get_post_mid($image) . '" width="300" height="200"
                                  class="img-fluid card-img-top" alt="' . $title . '">
                              <div class="news__hover">
                                  <p class="news__hover-icon icon-link"> </p>
                              </div>
                          </div>
                      </a>
                      <div class="card-body">
                          <a href="' . $url . '" class="card-title">' . $title . '</a>
                      </div>
                      <hr class="hr-dual">
                      <div class="card__footer">
                          <div class="card__date"> <span class="card__icon icon-calendar" title="Published">
                              </span> <span class="card__text">' . $date . '</span> </div>
                          <div class="card__views"> <span class="card__icon icon-eye" title="Views"> </span>
                              <span class="card__text">' . $views . ' </span> </div>
                      </div>
                  </div>
              </div>';
            }

            $output .= '<div class="col-12 text-center viewMore mt-5 button-column"> <a id="btn-load" data-id="' . $v->id . '" data-query="' . $where . '" class="hvr-radial-out"> View More <span class="icon-arrow-right2"></span></a> </div>';

            echo $output;
        } else {
            $output .= '<div class="col-12 text-center viewMore mt-5 button-column"> <p> No More Record Available </p> </div>';

            echo $output;
        }
    }
    public function notFound()
    {
        $voew = view('front.404')->render();
        return response($voew, "404");
    }
}
