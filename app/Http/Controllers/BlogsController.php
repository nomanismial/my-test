<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BlogsController extends Controller
{

    public function addBlogsSave(Request $request)
    {

        if (request()->has("submit")) {
            // dd(request()->all());
            $ulinks = request("uLink");
            if (isset($ulinks[0]) && $ulinks[0] != null) {
                $rx = '~
                  ^(?:https?://)?                           # Optional protocol
                   (?:www[.])?                              # Optional sub-domain
                   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
                   ([^&]{11})                               # Video id of 11 characters as capture group 1
                    ~x';
                $this->validate(
                    $request,
                    [
                        'uLink.*' => ['required', 'regex:' . $rx],
                    ],
                    [
                        'uLink.*.regex'    => 'The Youtube Url format is invalid.',
                        'uLink.*.required' => 'The Youtube Url field is required.',
                    ]
                );
            }
            $uLink  = request('uLink');
            $uLinks = array();
            if (isset($uLink)) {
                for ($a = 0; $a < count($uLink); $a++) {
                    if ($uLink[$a] != "") {
                        $uLinks[] = array(
                            "uLink" => $uLink[$a],
                        );
                    }
                }
            }

            $uLinks = (json_encode($uLinks));

            $fbLink  = request('fbLink');
            $fbLinks = array();
            if (isset($fbLink)) {
                for ($a = 0; $a < count($fbLink); $a++) {
                    if ($fbLink[$a] != "") {
                        $fbLinks[] = array(
                            "fbLink" => $fbLink[$a],
                        );
                    }
                }
            }

            $fbLinks = (json_encode($fbLinks));
            request()->validate([
                'title'   => ['required'],
                'slug'    => ['required'],
                'content' => ['required'],
            ]);
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
            $schema   = (json_encode($schm));
            $category = (is_array(request('category'))) ? implode(",", request('category')) : request('category');
            $related  = (is_array(request('related'))) ? implode(",", request('related')) : request('related');
            $date     = (request()->filled('update_date')) ? strtotime(request('update_date')) : request('date');
            $question = request('question');
            $answer   = request('answer');
            $num      = request('num');
            // dd($num);
            $faqs = array();
            if (is_array(request("question"))) {
                for ($a = 0; $a < count($question); $a++) {
                    if ($question[$a] != "") {
                        $faqs[] = array(
                            "num"      => $num[$a],
                            "question" => $question[$a],
                            "answer"   => $answer[$a],
                        );
                    }
                }
            }
            $faqs = json_encode($faqs);

            $q_name    = request('q_name');
            $q_content = request('q_content');
            $num       = request('num');
            $quotes    = array();
            if (is_array(request("q_name"))) {
                for ($a = 0; $a < count($q_name); $a++) {
                    if ($q_name[$a] != "") {
                        $quotes[] = array(
                            "num"       => $num[$a],
                            "q_name"    => $q_name[$a],
                            "q_content" => $q_content[$a],
                        );
                    }
                }
            }
            $quotes     = json_encode($quotes);
            $green_text = "";
            $gr_heading = request('gr_heading');
            $gr_body    = request('gr_body');
            $gr_text    = array();
            if (is_array(request("gr_body"))) {
                for ($a = 0; $a < count($gr_heading); $a++) {
                    if ($gr_body[$a] != "") {
                        $gr_text[] = array(
                            "gr_heading" => $gr_heading[$a],
                            "gr_body"    => $gr_body[$a],
                        );
                    }
                }
            }
            $green_text  = json_encode($gr_text);
            $red_text    = "";
            $red_heading = request('red_heading');
            $red_body    = request('red_body');
            $red_t       = array();
            if (is_array(request("red_body"))) {
                for ($a = 0; $a < count($red_heading); $a++) {
                    if ($red_body[$a] != "") {
                        $red_t[] = array(
                            "red_heading" => $red_heading[$a],
                            "red_body"    => $red_body[$a],
                        );
                    }
                }
            }
            $red_text      = json_encode($red_t);
            $black_text    = "";
            $black_heading = request('black_heading');
            $black_body    = request('black_body');
            $black_text    = array();
            if (is_array(request("black_body"))) {
                for ($a = 0; $a < count($black_heading); $a++) {
                    if ($black_body[$a] != "") {
                        $black_text[] = array(
                            "black_heading" => $black_heading[$a],
                            "black_body"    => $black_body[$a],
                        );
                    }
                }
            }
            $black_text = json_encode($black_text);

            $btn_title = request('btn_title');
            $btn_text  = request('btn_text');
            $btn_url   = request('btn_url');
            $num       = request('num');
            // dd($num);
            $btn = array();
            if (is_array(request("btn_title"))) {
                for ($a = 0; $a < count($btn_title); $a++) {
                    if ($btn_title[$a] != "") {
                        $btn[] = array(
                            "num"       => $num[$a],
                            "btn_title" => $btn_title[$a],
                            "btn_text"  => $btn_text[$a],
                            "btn_url"   => $btn_url[$a],
                        );
                    }
                }
                $buy_btn = json_encode($btn);
            }
            //            dd(request('content'));
            $content = str_replace("<li>[[green]]", "<li class='green-tick'>", request('content'));
            $content = str_replace("<li>[[red]]", "<li class='red-tick'>", $content);
            $content = str_replace("<p>[[", "[[", $content);
            $content = str_replace('<p style="text-align: right;">[[', "[[", $content);
            $content = str_replace("]]</p>", "]]", $content);
            $content = str_replace("]]&nbsp;</p>", "]]", $content);

            // dd(request()->all());
            if (request()->has('id')) {
                $blog               = Blog::find(request('id'));
            } else {
                $blog               = new Blog();
            }
            $blog->title            = request('title');
            $blog->slug             = Str::slug(request('slug'), '-');
            $blog->meta_title       = request('meta_title');
            $blog->meta_description = request('meta_description');
            $blog->meta_tags        = request('meta_tags');
            $blog->cover            = request('cover-image');
            $blog->og_image         = request('og-image');
            $blog->status           = request('status');
            $blog->author_id           = request('author');
            $blog->category_id         = $category;
            $blog->related          = $related;
            $blog->faqs             = $faqs;
            $blog->quotes           = $quotes;
            $blog->green_text       = $green_text;
            $blog->red_text         = $red_text;
            $blog->black_text       = $black_text;
            $blog->youtube_videos   = $uLinks;
            $blog->facebook_videos  = $fbLinks;
            $blog->content          = $content;
            $blog->internal_links   = request('internal_links');
            $blog->status           = request('submit');
            $blog->date             = $date;
            $blog->microdata        = $schema;
            $blog->buy_btn          = $buy_btn;
            // dd($blog);
            // dd($data);
            if (request()->has('id')) {
                $blog->save();
                $id = $blog->id;
                $blog->categories()->sync(request('category'));
                return redirect(route('save-blog') . '?edit=' . $id)->with('flash_message', 'Blog Record Updated Successfully');
            } else {
                $blog->save();
                $id = $blog->id;
                $blog->categories()->attach(request('category'));
                return redirect(route('save-blog') . '?edit=' . $id)->with('flash_message', 'Blog Record Inserted Successfully');
            }
        }
        if (request('edit')) {
            $auth = DB::table('authors')->where('status', 'publish')->select('id', 'name')->get();
            $cats = DB::table('categories')->orderBy("tb_order", "asc")->select('id', 'name')->get();
            $id   = request('edit');
            $data = DB::table('blogs')->where('id', $id)->first();
            return view('admin.blogs', compact('data', 'cats', 'auth'));
        }
        if (request('delete')) {
            $id   = request('delete');
            $data = DB::table('blogs')->where('id', $id)->delete();
            return back()->with('flash_message', 'Blog Post is deleted Successfully');
        }
        if (request('publish')) {
            $id = request('publish');
            DB::table('blogs')->where('id', $id)->update(['status' => 'publish']);
            return redirect('/' . admin . '/blogs/list')->with('flash_message', 'Blog Post Status is Changed To Publish Successfully');
        }
        if (request('draft')) {
            $id = request('draft');
            DB::table('blogs')->where('id', $id)->update(['status' => 'draft']);
            return redirect('/' . admin . '/blogs/list')->with('flash_message2', 'Blog Post Status is Changed To Draft Successfully');
        }
        $auth = DB::table('authors')->where('status', 'publish')->select('id', 'name')->get();
        $cats = DB::table('categories')->orderBy("tb_order", "asc")->select('id', 'name')->get();
        return view('admin.blogs', compact('cats', 'auth'));
    }

    public function blogsList(Request $request)
    {
        $auth = DB::table('authors')->where('status', 'publish')->select('id', 'name')->get();
        $cats = DB::table('categories')->orderBy("tb_order", "asc")->select('id', 'name')->get();
        return view('admin.blogs_list', compact('auth', 'cats'));
    }
    public function blogsListData(Request $request)
    {

        if ($request->ajax()) {
            $data = Blog::select('id',  'status', 'title', 'slug', 'created_at');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status === 'publish') {
                        $url = url('/' . admin . '/blogs?draft=' . $row->id);
                        $icon = "text-success fa fa-check";
                        $title = "Publish";
                        return '<a href="' . $url . '" class="' . $icon . ' fa-lg change-status" data-id="' . $row->id . '" title="' . $title . '"></a>';
                    } else {
                        $icon = "text-danger fa fa-times";
                        $title = "Draft";
                        $url = url('/' . admin . '/blogs?publish=' . $row->id);
                        return '<a href="' . $url . '" class="' . $icon . ' fa-lg change-status" data-id="' . $row->id . '" title="' . $title . '"></a>';
                    }
                })
                ->addColumn('id', function ($row) {
                    return $row->id;
                })
                ->addColumn('title', function ($row) {
                    $url = route('HomeUrl') . "/" . $row->slug . "-2" . $row->id;
                    $title = '<a href="' . $url . '" target="blank">' . $row->title . '</a>';
                    return $title;
                })
                ->addColumn('created_at', function ($row) {
                    return date("d M Y", strtotime($row->created_at));
                })
                ->addColumn('views', function ($row) {
                    return total_views($row->id, 2, "blogs-detail");
                })
                ->addColumn('actions', function ($row) {
                    $editUrl = url('/'.admin.'/blogs?edit='.$row->id);
                    $deleteUrl = url('/'.admin.'/blogs?delete='.$row->id);
                    $action = '<a href="'.$editUrl.'" class="btn-success-soft  mr-1 fa fa-edit" title="Edit"></a>';
                    $action .= '<a href="'.$deleteUrl.'" class="btn-danger-soft  fa fa-trash sconfirm" title="Delete"></a>';
                    return $action;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == 'publish' || $request->get('status') == 'draft') {
                        $instance->where('status', $request->get('status'));
                    }
                    if ($request->get('author')) {
                        $instance->where('author_id', $request->get('author'));
                    }
                    if ($request->get('category')) {
                        $instance->where('category_id', $request->get('category'));
                    }

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('title', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['id', 'title', 'views', 'created_at', 'status' , 'actions'])
                ->make(true);
        }
    }
    public function meta()
    {

        if (request('submit')) {
            request()->validate([
                'meta_title' => ['required'],
            ]);
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
            $schema = (json_encode($schm));
            DB::table('meta')->updateOrInsert(
                ['id' => request('id')],
                [
                    'page_name'        => request('page_name'),
                    'meta_title'       => request('meta_title'),
                    'meta_description' => request('meta_description'),
                    'meta_tags'        => request('meta_tags'),
                    'microdata'        => $schema,
                    'og_image'         => request('og_image'),
                ]
            );
            return back()->with('flash_message', 'Settings are Updated successfully');
        } else {
            $data = DB::table('meta')->where('page_name', 'blogs')->first();
            return view('admin.meta', compact('data'));
        }
    }
    public function blogCategory()
    {
        if (request('edit')) {
            $id   = request('edit');
            $edit = Category::where('id', $id)->first();
            $cats = Category::all()->sortBy('tb_order');
            return view('admin.blogcats', compact('edit', 'cats'));
        }
        if (request('del')) {
            $id     = request('del');
            $delete = Category::where('id', $id)->first();
            $delete->delete();
            return back()->with('flash_message', 'Category is Deleted successfully');
        }
        $edit = "";
        $cats = Category::all()->sortBy('tb_order');

        return view('admin.blogcats', compact('cats', 'edit'));
    }
    public function catsStore()
    {
        // dd(request()->all());
        request()->validate([
            'name'       => ['required'],
            'slug'       => ['required'],
            'meta_title' => ['required'],
        ]);
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
        $schema = (json_encode($schm));
        //  dd($schema);
        // store and update categories
        Category::updateOrCreate(
            ['id' => request('id')],
            [
                'before_title'     => request('before_title'),
                'after_title'      => request('after_title'),
                'home_title'       => request('home_title'),
                'popular_title'    => request('popular_title'),
                'slug'             => request('slug'),
                'name'             => request('name'),
                'meta_title'       => request('meta_title'),
                'meta_description' => request('meta_description'),
                'before_details'   => request('before_details'),
                'after_details'    => request('after_details'),
                'home_details'     => request('home_details'),
                'popular_details'  => request('popular_details'),
                'meta_tags'        => request('meta_tags'),
                'before_popular'   => request('before_popular'),
                'after_popular'    => request('after_popular'),
                'home_popular'     => request('home_popular'),
                'popular_popular'  => request('popular_popular'),
                'og_image'         => request('og_image'),
                'microdata'        => $schema,
            ]
        );

        return back()->with('flash_message', 'Category Record is Updated Successfully');
    }

    public function catsorder()
    {
        $orders = request('order');
        foreach ($orders as $k => $v) {
            $page = Category::find($v);
            if ($page) {
                $page->tb_order = $k;
                $page->save();
            }
        }
        return back()->with('flash_message2', 'Categories Order Updated Successfully');
    }
}
