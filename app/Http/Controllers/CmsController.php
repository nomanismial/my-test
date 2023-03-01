<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\ContactUs;
use App\Models\Faqs;
use App\Models\Pages;
use App\Models\WriteForUs;
use App\Privacy;
use App\TermsCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CmsController extends Controller
{

    // // Contact us
    public function ContactUs()
    {
        // dd(request()->all());

        if (request('submit')) {
            // dd(request()->all());
            request()->validate([
                'meta_title'       => ['required', 'max:255'],
                'meta_description' => ['required', 'max:500'],
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
            ContactUs::updateOrInsert(
                ['id' => request('id')],
                [
                    'meta_title'       => request('meta_title'),
                    'meta_description' => request('meta_description'),
                    'meta_tags'        => request('meta_tags'),
                    'r_email'          => request('r_email'),
                    'detail'           => request('detail'),
                    'email'            => request('email'),
                    'phone'            => request('phone'),
                    'address'          => request('address'),
                    'google_map'       => request('google_map'),
                    'cover_image'      => request('cover-image'),
                    'og_image'         => request('og-image'),
                    'microdata'        => $schema,
                ]
            );
            return back()->with('flash_message', 'Settings are Updated successfully');
        } else {
            $data = ContactUs::first();
            return view('admin.contact-us', compact('data'));
        }
    }
    public function delete(AboutUs $record)
    {
        // deleting selected category
        $record->delete();
        // returning back to the same page
        return back()->with('flash_message', 'Yours settings are updated successfully');
    }
    /*    public function contactstore() {
    request()->validate([
    'meta_title' => ['required', 'min:3'],
    'meta_description' => ['required', 'min:5'],
    'title' => ['required', 'min:5'],
    'meta_tags' => ['required'],
    'content' => ['required'],
    ]);
    // store and update categories
    ContactUs::updateOrCreate(
    ['id' => request('id')]
    , [
    'meta_title' => request('meta_title'),
    'meta_descp' => request('meta_description'),
    'title' => request('title'),
    'meta_tags' => request('meta_tags'),
    'content' => request('content'),
    ]);
    return back()->with('flash_message', 'Yours settings are updated successfully');
    }*/
    //Terms Condition
    public function privacy()
    {

        if (request('submit')) {
            //dd(request()->all());
            request()->validate([
                'meta_title'       => ['required', 'max:255'],
                'meta_description' => ['required', 'max:500'],
                'content'          => ['required'],

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
            Pages::updateOrInsert(
                [
                    'id' => request('id'),
                ],
                [
                    'page_name'        => request('page_name'),
                    'meta_title'       => request('meta_title'),
                    'meta_description' => request('meta_description'),
                    'meta_tags'        => request('meta_tags'),
                    'content'          => request('content'),
                    'microdata'        => $schema,
                    'og_image'         => request('og_image'),
                    'updated_at'       => date("y-m-d h:i:s"),
                ]
            );
            return back()->with('flash_message', 'Record is Updated successfully');
        } else {
            $data = Pages::where('page_name', 'privacy-policy')->first();
            return view('admin.privacy', compact('data'));
        }
    }
    public function about(Request $request)
    {

        if (request('submit')) {
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
            request()->validate([
                'title'   => ['required'],
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

            About::updateOrInsert(
                [
                    'id' => request('id'),
                ],
                [
                    "title"            => request('title'),
                    "meta_title"       => request('meta_title'),
                    "meta_description" => request('meta_description'),
                    "meta_tags"        => request('meta_tags'),
                    "cover"            => request('cover-image'),
                    "og_image"         => request('og-image'),
                    "status"           => request('status'),
                    "author"           => request('author'),
                    "faqs"             => $faqs,
                    "quotes"           => $quotes,
                    "green_text"       => $green_text,
                    "red_text"         => $red_text,
                    "black_text"       => $black_text,
                    "youtube_videos"   => $uLinks,
                    "content"          => request('content'),
                    "internal_links"   => request('internal_links'),
                    "status"           => request('submit'),
                    "date"             => $date,
                    "microdata"        => $schema,
                ]
            );
            return back()->with('flash_message', 'Record is Updated successfully');
        } else {
            $data = About::first();
            return view('admin.about', compact('data'));
        }
    }

    //Write For Us
    public function writeUs(Request $request)
    {

        if (request('submit')) {
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
            request()->validate([
                'title'   => ['required'],
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

            WriteForUs::updateOrInsert(
                [
                    'id' => request('id'),
                ],
                [
                    "title"            => request('title'),
                    "meta_title"       => request('meta_title'),
                    "meta_description" => request('meta_description'),
                    "meta_tags"        => request('meta_tags'),
                    "cover"            => request('cover-image'),
                    "og_image"         => request('og-image'),
                    "status"           => request('status'),
                    "author"           => request('author'),
                    "faqs"             => $faqs,
                    "quotes"           => $quotes,
                    "green_text"       => $green_text,
                    "red_text"         => $red_text,
                    "black_text"       => $black_text,
                    "youtube_videos"   => $uLinks,
                    "content"          => request('content'),
                    "internal_links"   => request('internal_links'),
                    "status"           => request('submit'),
                    "date"             => $date,
                    "microdata"        => $schema,
                ]
            );
            return back()->with('flash_message', 'Record is Updated successfully');
        } else {
            $data = WriteForUs::first();
            return view('admin.write-for-us', compact('data'));
        }
    }
    //Terms Condition
    public function termscondition()
    {

        if (request('submit')) {
            //dd(request()->all());
            request()->validate([
                'meta_title'       => ['required', 'max:255'],
                'meta_description' => ['required', 'max:500'],
                'content'          => ['required'],

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
            Pages::updateOrInsert(
                [
                    'id' => request('id'),
                ],
                [
                    'page_name'        => request('page_name'),
                    'meta_title'       => request('meta_title'),
                    'meta_description' => request('meta_description'),
                    'meta_tags'        => request('meta_tags'),
                    'content'          => request('content'),
                    'microdata'        => $schema,
                    'og_image'         => request('og_image'),
                    'updated_at'       => date("y-m-d h:i:s"),
                ]
            );
            return back()->with('flash_message', 'Record is Updated successfully');
        } else {
            $data = Pages::where('page_name', 'terms-conditions')->first();
            return view('admin.terms-condition', compact('data'));
        }
    }

    // FAQs
    // FAQs
    public function faqs()
    {
        if (request()->isMethod('post')) {
            //dd(request()->all());
            request()->validate([
                'question' => ['required', 'min:10', 'max:250'],
                'answer'   => ['required', 'min:10', 'max:2000'],
            ]);
            // store and update categories
            Faqs::updateOrCreate(
                ['id' => request('id')],
                [
                    'question' => request('question'),
                    'answer'   => request('answer'),
                ]
            );
            return back()->with('flash_message', 'Yours settings are updated successfully');
        } else {
            if (request('edit')) {
                $id   = request('edit');
                $edit = Faqs::where('id', $id)->first();
                $faqs = Faqs::all()->sortBy('tb_order');
                return view('admin.faqs', compact('edit', 'faqs'));
            }
            if (request('del')) {
                $id     = request('del');
                $delete = Faqs::where('id', $id)->first();
                $delete->delete();
                return back()->with('flash_message', 'Yours settings are updated successfully');
            }
            $edit = "";
            $faqs = Faqs::all()->sortBy('tb_order');
            return view('admin.faqs', compact('faqs', 'edit'));
        }
    }
    public function allfaqs()
    {
        $faqs = Faqs::orderBy('id', 'desc')->get();
        return view('admin.faqs_list', compact('faqs'));
    }
    public function faqsorder()
    {
        if (request('submit-order')) {
            $orders = request('order');
            foreach ($orders as $k => $v) {
                $page = Faqs::find($v);
                if ($page) {
                    $page->tb_order = $k;
                    $page->save();
                }
            }
            return back()->with('faqs_order', 'FAQs Order updated successfully');
        }
    }
    public function faqs_meta()
    {
        if (request('submit')) {
            $schema = request('schema');
            $type   = request('type');
            $schm   = array();
            if ($schema != "") {
                for ($a = 0; $a < count($type); $a++) {
                    if ($schema[$a] != "") {
                        $schm[] = array(
                            "schema" => $schema[$a],
                            "type"   => $type[$a],
                        );
                    }
                }
            }

            $schema = (json_encode($schm));
            request()->validate([
                'meta_title'       => ['required', 'max:255'],
                'meta_description' => ['required', 'max:500'],
            ]);
            DB::table('meta')->updateOrInsert(
                ['id' => request('id')],
                [
                    'page_name'        => request('page_name'),
                    'meta_title'       => request('meta_title'),
                    'meta_description' => request('meta_description'),
                    'meta_tags'        => request('meta_tags'),
                    'og_image'         => request('og_image'),
                    'microdata'        => $schema,
                ]
            );
            return back()->with('flash_message', 'FAQs Meta Updated successfully');
        } else {
            $data = DB::table('meta')->where('page_name', 'faqs')->first();
            return view('admin.faqs_meta', compact('data'));
        }
    }
}
