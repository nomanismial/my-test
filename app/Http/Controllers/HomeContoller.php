<?php

namespace App\Http\Controllers;

use App\Models\Homedata;

class HomeContoller extends Controller
{

    public function Home()
    {
        return "hello";
    }
    public function homemeta()
    {
        if (request()->has("submit")) {
            // dd(request()->all());
            $title    = request('title');
            $category = request('category');
            $design   = array();
            $count    = (is_array($category)) ? count($category) : 0;
            for ($a = 0; $a < $count; $a++) {
                $design[] = array(
                    "title"    => $title[$a],
                    "category" => $category[$a],
                );
            }
            $home_design = (json_encode($design));
            $total       = $_POST["total_images"];
            $images      = array();
            for ($n = 0; $n < $total; $n++) {
                if (isset($_POST["image" . ($n + 1)])) {
                    $images[] = $_POST["image" . ($n + 1)];
                }
            }
            $slider_images = json_encode($images);
            $homemeta      = array(
                'meta_title'       => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_tags'        => request('meta_tags'),
                'og_image'         => request('og-image'),

            );

            $schema = request('schema');
            $type   = request('type');
            $schm   = array();
            if ((count($type) > 0) or (count($schema) > 0)) {
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
            request()->validate([
                'meta_title'       => ['required', 'min:3', 'max:250'],
                'meta_description' => ['required', 'min:5', 'max:500'],
            ]);
            if (request()->has('id')) {

                Homedata::where('id', request('id'))->update([
                    'home_meta'     => json_encode($homemeta),
                    'microdata'     => $schema,
                    'home_design'   => $home_design,
                    'slider_images' => $slider_images,
                ]);
                return back()->with('flash_message', 'Home meta settings updated successfully');
            } else {
                Homedata::insert([
                    'home_meta'     => json_encode($homemeta),
                    'microdata'     => $schema,
                    'home_design'   => $home_design,
                    'slider_images' => $slider_images,
                ]);
                return back()->with('flash_message', 'Home meta settings updated successfully');
            }
        }
        $data = Homedata::select('id', 'home_meta', 'microdata', 'home_design', 'slider_images')->first();

        return view('admin.homemeta', compact('data'));
    }
    public function footer()
    {
        if (request()->has("submit")) {
            $icon  = request('icon');
            $link  = request('link');
            $links = array();
            for ($a = 0; $a < count($link); $a++) {
                if ($link[$a] != "") {
                    $links[] = array(
                        "link" => $link[$a],
                        "icon" => $icon[$a],
                    );
                }
            }
            $social_links = (json_encode($links));
            $footer       = array(
                'heading'     => request('heading'),
                'button'      => request('button'),
                'button_link' => request('button_link'),
            );
            $copyrights = array(
                'copyrights_title' => request('copyrights_title'),
                'company_name'     => request('company_name'),
                'company_url'      => request('company_url'),
            );
            if (request()->has('id')) {
                Homedata::where('id', request('id'))->update([
                    'footer'       => json_encode($footer),
                    'copyrights'   => json_encode($copyrights),
                    'social_links' => $social_links,
                ]);
                return back()->with('flash_message', 'Home footer data is  updated successfully');
            } else {
                Homedata::insert([
                    'footer'       => json_encode($footer),
                    'copyrights'   => json_encode($copyrights),
                    'social_links' => $social_links,
                ]);
                return back()->with('flash_message', 'Home footer data is  updated successfully');
            }
        }
        $data = Homedata::select('id', 'footer', 'copyrights', 'social_links')->first();
        return view('admin.footer', compact('data'));
    }
}
