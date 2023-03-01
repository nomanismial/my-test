<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{

    public function index(Request $request)
    {

        if (request('submit')) {
            // dd(request()->all());
            $ads_id = request('ads_id');
            $title  = request('title');
            $alt    = request('alt');
            $url    = request('url');
            $num    = request('num');
            $_data  = array();
            $mi     = 0;
            // Store into database
            if (isset($num)) {
                for ($a = 0; $a < count($num); $a++) {
                    $mi  = (array_key_exists("img" . $mi, request()->all())) ? $mi : $mi + 1;
                    $img = (request()->has("img$mi")) ? request("img$mi") : "";
                    $_data[] = array(
                        "title"  => $title[$a],
                        "ads_id" => "2" . $ads_id[$a],
                        "alt"    => $alt[$a],
                        "url"    => $url[$a],
                        "num"    => $num[$a],
                        "img"    => $img,
                    );
                    $mi++;
                }
            }
            $ads = json_encode($_data);
            // dd($ads);
            DB::table('ads')->updateOrInsert(
                ['id' => request('id')],
                [
                    'ads' => $ads,
                ]
            );
            return back()->with('flash_message', 'Settings are Updated successfully');
        } else {
            $data = Ads::select('id', 'ads')->first();
            //dd($data);
            return view('admin.ads', compact('data'));
        }
    }
    public function _gaAdv(Request $request)
    {

        if (request('submit')) {
            // dd(request()->all());
            $google_ads = request('google_ads');
            $title = request('title');
            $ads_id = request('ads_id');
            $num    = request('num');
            $_data  = array();
            $mi     = 0;


            $this->validate(
                $request,
                [
                    'google_ads.*' => ['required'],
                ],
                [
                    'google_ads.*.required' => 'The Google Ads Input field is required.',
                ]
            );

            if (isset($num)) {
                for ($a = 0; $a < count($num); $a++) {
                    if ($google_ads != "") {
                        $_data[] = array(
                            "google_ads"  => $google_ads[$a],
                            "ads_id" => "3" . $ads_id[$a],
                            "title" => $title[$a],
                            "num"    => $num[$a],
                        );
                    }
                    $mi++;
                }
            }

            $ads = json_encode($_data);
            // dd($ads);
            DB::table('ads')->updateOrInsert(
                ['id' => request('id')],
                [
                    'google_ads' => $ads,
                ]
            );
            return back()->with('flash_message', 'Settings are Updated successfully');
        } else {
            $data = Ads::select('id', 'google_ads')->first();
            //dd($data);
            return view('admin.google_ads', compact('data'));
        }
    }
}
