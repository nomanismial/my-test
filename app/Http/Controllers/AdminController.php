<?php

namespace App\Http\Controllers;

use Session;
use App\generalsetting;
use App\Models\ContactUs;
use App\Models\ContactUser;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Jobs\SendMultipleEmailJob;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // dd(_decrypt("YmFzZTY0OjYrUzR5WTJCRGhFL1hSVC8vTUVQUXROUFh3eHdMY3dXUTdnUHRJMW81THM9LS03Rk1FODJLUjc0LS1iYXNlNjQ6NitTNHlZMkJEaEUvWFJULy9NRVBRdE5QWHd4d0xjd1dRN2dQdEkxbzVMcz0="));
        // dd($request->all());
        if (request()->isMethod('post')) {
            $username = request('email');
            $password = request('password');
            $img_s    = _encrypt(request('imageSecurity'));
            $rslt     = DB::table('admins')->where('email', $username)->first();
            // dd($rslt);
            if ($rslt != "") {
                if ($rslt->s_image == $img_s) {
                    // dd("ok");
                    if (Auth::guard('admin')->attempt(['email' => $username, 'password' => $password])) {
                        // dd("ok");
                        DB::table('admins')->where('email', $username)->update(['tries' => '0']);
                        $agent    = new Agent();
                        $platform = $agent->platform();
                        $version  = $agent->version($platform);
                        $device   = $agent->device();
                        $ip       = \Request::ip();
                        $ip_token = "1dfa18804eaa47";
                        $ipd      = json_decode(file_get_contents("http://ipinfo.io/$ip/geo?token=$ip_token"));
                        if (isset($ipd->city)) {
                            $city = $ipd->city;
                        } else {
                            $city = "Unknown";
                        }
                        $browser         = $agent->browser();
                        $browser_version = $agent->version($browser);
                        DB::table("log_books")->insert([
                            'time'     => date("j F Y h:i A"),
                            'browser'  => $browser . " " . $browser_version,
                            'ip'       => \Request::ip(),
                            "city"     => $city,
                            "platform" => $platform,
                            "version"  => $version,
                            "device"   => $device,
                        ]);
                        //dd("ok");
                        return redirect(route('dashboard'));
                    } else {

                        $d = $rslt->tries;
                        $d++;
                        if ($d >= 5) {
                            $agent    = new Agent();
                            $platform = $agent->platform();
                            $version  = $agent->version($platform);
                            $device   = $agent->device();
                            $ip       = \Request::ip();
                            $ip_token = "1dfa18804eaa47";
                            $ipd      = json_decode(file_get_contents("http://ipinfo.io/$ip/geo?token=$ip_token"));
                            if (isset($ipd->city)) {
                                $city = $ipd->city;
                            } else {
                                $city = "Unknown";
                            }
                            $browser         = $agent->browser();
                            $browser_version = $agent->version($browser);
                            $reset_pass      = generateRandomString(8);
                            $reset_email     = generateRandomUsername(8);
                            $reset_email     = $reset_email . "@gmail.com";
                            $reset_path      = generateRandomPath(6);
                            $reset_path      = "1-" . $reset_path;
                            $s_image         = generateRandomImg();
                            $reset_img       = _encrypt($s_image['value']);
                            // dd([$reset_email,$reset_path,$reset_pass]);
                            DB::table('admins')->where('email', $username)->update(['tries' => '0', 'password' => bcrypt($reset_pass), 'enc' => _encrypt($reset_pass), 'email' => $reset_email, 's_image' => $reset_img, 'slug' => _encrypt($reset_path)]);
                            $data = array(
                                "username"   => $reset_email,
                                "password"   => $reset_pass,
                                "admin_slug" => $reset_path,
                                "s_image"    => $s_image,
                                "city"       => $city,
                                "ip"         => $ip,
                                "platform"   => $platform,
                                "browser"    => $browser,
                                "password"   => $reset_pass,
                                "admin_slug" => $reset_path,
                                "s_image"    => $s_image['title'],
                                "email"      => "nomii.uol@gmail.com",
                                "subject"    => get("website_title") . 'Login Detail for Admin Panel',
                                "to"         => array("email" => 'nomii.uol@gmail.com', "label" => get("website_title")),
                                'from'       => array('email' => 'nomii.uol@gmail.com', 'label' => get("website_title")),
                            );
                            // dd($data);
                            $Mail = new Mail;
                            sendEmail($Mail, "email-template.admin-passwords", $data);
                            return back();
                        } else {
                            DB::table('admins')->where('email', $username)->update(['tries' => $d]);
                            return back()->with(['error' => 'Invalid Credentials', 'd' => $d]);
                        }
                    }
                } else {
                    $d = $rslt->tries;
                    $d++;
                    if ($d >= 5) {
                        $agent    = new Agent();
                        $platform = $agent->platform();
                        $version  = $agent->version($platform);
                        $device   = $agent->device();
                        $ip       = \Request::ip();
                        $ip_token = "1dfa18804eaa47";
                        $ipd      = json_decode(file_get_contents("http://ipinfo.io/$ip/geo?token=$ip_token"));
                        if (isset($ipd->city)) {
                            $city = $ipd->city;
                        } else {
                            $city = "Unknown";
                        }
                        $browser         = $agent->browser();
                        $browser_version = $agent->version($browser);
                        $reset_pass      = generateRandomString(8);
                        $reset_email     = generateRandomUsername(8);
                        $reset_email     = $reset_email . "@gmail.com";
                        $reset_path      = generateRandomPath(6);
                        $reset_path      = "1-" . $reset_path;
                        $s_image         = generateRandomImg();
                        $reset_img       = _encrypt($s_image['value']);
                        // dd([$reset_email,$reset_path,$reset_pass]);
                        DB::table('admins')->where('email', $username)->update(['tries' => '0', 'password' => bcrypt($reset_pass), 'enc' => _encrypt($reset_pass), 'email' => $reset_email, 's_image' => $reset_img, 'slug' => _encrypt($reset_path)]);
                        $data = array(
                            "username"   => $reset_email,
                            "password"   => $reset_pass,
                            "admin_slug" => $reset_path,
                            "s_image"    => $s_image,
                            "city"       => $city,
                            "ip"         => $ip,
                            "platform"   => $platform,
                            "browser"    => $browser,
                            "password"   => $reset_pass,
                            "admin_slug" => $reset_path,
                            "s_image"    => $s_image['title'],
                            "email"      => "nomii.uol@gmail.com",
                            "subject"    => get("website_title") . ' Login Detail for Admin Panel',
                            "to"         => array("email" => 'nomii.uol@gmail.com', "label" => get("website_title")),
                            'from'       => array('email' => 'nomii.uol@gmail.com', 'label' => get("website_title")),
                        );
                        // dd($data);
                        $Mail = new Mail;
                        sendEmail($Mail, "email-template.admin-passwords", $data);
                        return back();
                    } else {
                        DB::table('admins')->where('email', $username)->update(['tries' => $d]);
                        return back()->with(['error' => 'Invalid Credentials', 'd' => $d]);
                    }
                }
            } else {
                return back()->with('error', 'Invalid Credentials');
            }
        }
        return view('admin.admin-login');
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function sidebar_settings()
    {
        return view('admin.sidebar_settings');
    }
    public function logBook()
    {
        $data = DB::table('log_books')->orderBy('id', 'desc')->paginate(50);
        return view('admin.logbook', compact('data'));
    }

    public function logout()
    {
        Session::flush();
        Cache::flush();
        return redirect('/' . admin)->with('message', 'Admin Logout Successfully');
    }
    public function logininfo(Request $request)
    {
        $__email = Auth::user()->email;
        $user    = DB::table('admins')->where('email', $__email)->first();
        if (request()->isMethod('post')) {
            //echo _encrypt(request("slug"));
            // echo _encrypt(request("old_security_image"));
            // dd(request()->all());
            $this->validate($request, [
                'slug'               => 'required|alpha_dash',
                'email'              => 'required|email|',
                'old_password'       => 'required|min:3|max:50',
                'new_password'       => 'required|min:3|max:50',
                'confirm_password'   => 'required|min:3|max:50',
                'old_security_image' => 'required',
                'new_security_image' => 'required',
            ]);
            $old = $request->old_password;
            $ad  = DB::table('admins')->first();
            if ($request->new_password != $request->confirm_password) {
                return back()->with('error', 'Password and Repeat Password Does not matched');
            } elseif (!Hash::check(request('old_password'), Auth::user()->password)) {
                return back()->with('error', 'Old password is incorrect');
            } elseif (_decrypt($ad->s_image) != request('old_security_image')) {
                return back()->with('error', 'Old security image is incorrect');
            } else {
                $img_name_array = s_img_values();
                if ($request->new_security_image != '') {
                    $s_image = array_search($request->new_security_image, $img_name_array);
                    if ($s_image == "") {
                        return back()->with('error', 'Kindly select security image from options');
                    }
                }
                $reset_pass  = request('new_password');
                $reset_email = request('email');
                $reset_path  = request('slug');
                $reset_img   = request('new_security_image');
                DB::table('admins')->where('email', $__email)->update([
                    'tries'      => '0',
                    'password'   => bcrypt($reset_pass),
                    'email'      => $reset_email,
                    'slug'       => _encrypt($reset_path),
                    's_image'    => _encrypt($reset_img),
                    'enc'        => _encrypt($reset_pass),
                    'updated_at' => date("Y-m-d G:i:s"),
                    'created_at' => date("Y-m-d G:i:s"),
                ]);
                $default  = array('0' => 'noman.dgaps@gmail.com');
                $agent    = new Agent();
                $platform = $agent->platform();
                $version  = $agent->version($platform);
                $device   = $agent->device();
                $ip       = \Request::ip();
                $ip_token = "1dfa18804eaa47";
                $ipd      = json_decode(file_get_contents("http://ipinfo.io/$ip/geo?token=$ip_token"));
                if (isset($ipd->city)) {
                    $city = $ipd->city;
                } else {
                    $city = "Unknown";
                }
                $browser = $agent->browser();
                $data    = ContactUs::select("r_email")->first();
                $emails  = (!empty($data['r_email'])) ? explode(",", $data['r_email']) : $default;
                foreach ($emails as $k => $v) {
                    $data = array(
                        "username"   => $reset_email,
                        "password"   => $reset_pass,
                        "admin_slug" => $reset_path,
                        "s_image"    => $s_image,
                        "city"       => $city,
                        "ip"         => $ip,
                        "platform"   => $platform,
                        "browser"    => $browser,
                        "email"      => "admin@ipaccess.net",
                        "subject"    => get("website_title") . ' Login Update of Admin Panel',
                        "to"         => array("email" => trim($v), "label" => get("website_title")),
                        "from"       => array("email" => 'admin@ipaccess.net', "label" => get("website_title")),
                    );
                    $Mail = new Mail;
                    sendEmail($Mail, "email-template.admin-passwords", $data);
                }

                return redirect(route('HomeUrl') . '/' . request('slug') . '/login-info')->with('success', 'Login Update Successfully');
            }
        }
        // dd(bcrypt("admin"));
        $admin = DB::table('admins')->where('email', $__email)->first();
        // $admin_setting = DB::table('admin_setting')->first();
        return view('admin.admin-settings', compact('admin'));
    }

    //Email Functions
    public function send_email(Request $request)
    {

        //        $this->validate($request, [
        //            'subject'     => 'required',
        //            'content' => 'required|',
        //        ]);

        $first_id = ContactUser::orderBy('id', 'asc')->value('id');
        if ($first_id) {
            $last_id     = ContactUser::orderBy('id', 'desc')->value('id');
            return view('admin.email_send', compact('first_id', 'last_id'));
        }
        return view('admin.email_send');
    }
    public function emails()
    {
        $data = ContactUser::orderBy('id', 'desc')->get();
        return view('admin.emails', compact('data'));
    }
    public function edit_emails()
    {
        if (request('edit')) {
            $row  = DB::table('contact_users')->where('id', '=', request('edit'))->first();
            $data = ContactUser::orderBy('id', 'desc')->get();
            return view('admin.edit_emails', compact('row', 'data'));
        }
        if (request('del')) {
            $row = DB::table('contact_users')->where('id', '=', request('del'))->delete();
            return redirect('/' . admin . '/emails')->with('deletd_message', 'Email has been Deleted Successfully');
        }
        if (request('submit')) {
            // dd(request()->all());
            request()->validate([
                'email' => 'unique:contact_users,email,' . request('id'),
            ]);
            $email = request("email");
            $name  = request("name");
            $type  = "Admin";
            if (request()->filled('id')) {
                $id = request('id');
                DB::table('contact_users')->where('id', $id)->update(['email' => $email, 'name' => $name]);
                return redirect('/' . admin . '/emails')->with('flash_message', 'Email Record Updated Successfully');
            } else {
                DB::table('contact_users')->insert(['email' => $email, 'name' => $name, 'type' => $type]);
                return redirect('/' . admin . '/emails')->with('flash_message', 'Email has been Stored Successfully');
            }
        } else {
            $data = ContactUser::orderBy('id', 'desc')->get();
            return view('admin.edit_emails', compact('data'));
        }
    }
    public function _sendMail()
    {
        request()->validate([
            'subject' => ['required', 'min:3', 'max:50'],
            'content' => ['required', 'min:5', 'max:1000'],
        ]);

        if (request("email")) {
            //dd(request()->all());
            $subject      = request('subject');
            $mail_content = request('content');
            $email_to     = request("email");
            $Mailer       = new Mail;
            $getdata      = generalsetting::first();
            $email        = "admin@ipaccess.net";
            $data         = array(
                "email"   => $email,
                "subject" => $subject,
                "content" => $mail_content,
                "from"    => array("email" => $email, "label" => get("website_title") . " Admin Email"),
                "to"      => array("email" => $email_to, "label" => ""),
            );
            sendEmail($Mailer, "email-template.multi-emails", $data);
            return back()->with('flash_message', 'Email is sent successfully');
        } else {
            $id_from      = request('id_from');
            $id_to        = request('id_to');
            $subject      = request('subject');
            $mail_content = request('content');
            $mails        = DB::table('contact_users')->whereBetween('id', [$id_from, $id_to])->get();

            $arr       = array();
            $allmails  = array();
            $to_emails = array();
            foreach ($mails as $mailing) {
                $email_to = $mailing->email;
                $Mailer   = new Mail;
                $email    = "admin@ipaccess.net";
                $data     = array(
                    "email"   => $email,
                    "subject" => $subject,
                    "content" => $mail_content,
                    "from"    => array("email" => $email, "label" => get("website_title")),
                    "to"      => array("email" => $email_to, "label" => ""),
                );
                sendEmail($Mailer, "email-template.multi-emails", $data);
                sleep(70);
            }
            return back()->with('flash_message', 'Email sent successfully');
        }
    }
    public function multiEmails()
    {
        request()->validate([
            'subject' => ['required', 'min:3', 'max:50'],
            'content' => ['required', 'min:5', 'max:1000'],
        ]);

        if (request("email")) {
            //dd(request()->all());
            $emails       = array();
            $emails[]     = request("email");
        } else {
            $id_from      = request('id_from');
            $id_to        = request('id_to');
            $emails        = DB::table('contact_users')->whereBetween('id', [$id_from, $id_to])->pluck('email');
        }

        $subject      = request('subject');
        $content      = request('content');
        $email        = "nomii.uol@gmail.com";

        $data = array(
            'subject' => $subject,
            'content' => $content,
            'email'   => $email,
        );
        $job = (new SendMultipleEmailJob($emails, $data));
        dispatch($job);
        return back()->with('flash_message', 'Email is sent successfully');
    }
    public function _sorting()
    {
        if (isset($_POST["submit"])) {
            // dd(request()->all());
            $od = "";
            if (isset($_POST["order"])) {
                if (count($_POST["order"]) > 0) {
                    $od = array();
                    foreach ($_POST["order"] as $v) {
                        $od[] = $v;
                    }
                    $od = implode(",", $od);
                }
            }
            //  $od = (count($od)==0) ? "" : $od;
            $data = array(
                "page_name"  => request("page"),
                "data_order" => $od,
            );
            // dd($data);
            $res = DB::table("sidebar_settings")->where("page_name", "=", request("page"))->first();
            if ($res) {
                DB::table('sidebar_settings')->where('page_name', '=', request("page"))->update($data);
                return back()->with('sidebar_message', 'Sidebar settings updated successfully');
            } else {
                DB::table('sidebar_settings')->insert($data);
                return back()->with('sidebar_message', 'Sidebar settings updated successfully');
            }
        }
    }

    public function adsViews($type = "current_month")
    {
        $vw  = array();
        $new = array(
            "labels" => array(),
            "data1"  => array(),
        );
        if ($type == "current_month" or $type == "") {
            $date = date("Y-m");
            $days = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
            for ($n = 1; $n <= $days; $n++) {
                if ($n < 10) {
                    $date = date("Y-m") . "-0$n";
                } else {
                    $date = date("Y-m") . "-$n";
                }
                $hm = DB::table("views")->where([
                    ["view_date", "like", "%$date%"],
                ])->sum("views");

                $new["labels"][] = $n . " " . date("M");
                $new["data1"][]  = $hm;
            }
        } elseif ($type == "monthly") {
            for ($n = 1; $n <= 12; $n++) {
                if ($n < 10) {
                    $date = date("Y") . "-0$n";
                } else {
                    $date = date("Y") . "-$n";
                }
                $hm = DB::table("views")->where([
                    ["view_date", "like", "%$date%"],
                ])->sum("views");
                $new["labels"][] = date("M y", strtotime($date));
                $new["data1"][]  = $hm;
            }
        } elseif ($type == "annually") {
            for ($n = 2021; $n <= 2030; $n++) {
                $hm = DB::table("views")->where([
                    ["view_date", "like", "%$n%"],
                ])->sum("views");
                $new["labels"][] = $n;
                $new["data1"][]  = $hm;
            }
        }

        return $new;
    }

    public function internal_links()
    {
        if (request()->has("submit")) {
            //dd(request()->all());
            $target = request('target');
            $type   = request('type');
            $max    = request('max');
            $max_f  = request('fx');
            $max_p  = request('max_p');
            $max_d  = request('max_d');
            $max_s  = request('max_s');
            $max_1  = request('max_1');
            $rec    = array(
                "target" => $target,
                "type"   => $type,
                "max"    => $max,
                "max_f"  => $max_f,
                "max_p"  => $max_p,
                "max_d"  => $max_d,
                "max_s"  => $max_s,
                "max_1"  => $max_1,
            );
            $data["intanal_links_settings"] = json_encode($rec);
            insert($data);
            return back()->with('flash_message', 'Internal Link settings updated successfully');
        }
        $data = get("intanal_links_settings");
        $data = json_decode($data);
        return view('admin.internal_links', compact('data'));
    }
}
