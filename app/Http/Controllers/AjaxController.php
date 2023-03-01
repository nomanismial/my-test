<?php
namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\ContactUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{

    public function contactform()
    {
        $data = array(
            "name"    => request("name"),
            "subject" => request("subject"),
            "email"   => request("email"),
            "message" => request("message"),
        );
        $valid = Validator::make($data, [
            'name'    => ['required', 'min:3', 'max:50', 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ ]+$/'],
            'subject' => ['required', 'min:3', 'max:50', 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ ]+$/'],
            'email'   => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);
        if ($valid->fails()) {
            $message  = $valid->getMessageBag()->toArray();
            $messages = array();
            foreach ($message as $k => $v) {
                if (is_array($v)) {
                    $messages[$k] = $v[0];
                } else {
                    $messages[$k] = $v;
                }
            }
            return array("resp" => "error", "msg" => $messages);
        } else {
            $from   = request('email');
            $data   = ContactUs::select("r_email")->first();
            $emails = explode(",", $data['r_email']);

            $subject      = get("website_title") . " - Contact Email";
            $mail_message = 'name :' . request('name') . PHP_EOL . 'email: ' . request('email') . PHP_EOL . request('message');

            foreach ($emails as $k => $v) {
                $data = array(
                    "name"    => request("name"),
                    "subject" => request("subject"),
                    "email"   => $from,
                    "content" => request('message'),
                    "subject" => $subject,
                    "from"    => array("email" => "info@bintefarooq.com", "label" => request("name")),
                    "to"      => array("email" => trim($v), "label" => get("website_title")),
                );
                $Mail = new Mail;
                sendEmail($Mail, "email-template.contact", $data);
            }
            return array("resp" => "success", "msg" => "Your Email has been sent Successfully.");
        }
    }
    //Get Email For Distplay
    public function _emailGet()
    {
        $rec = ContactUs::select("email")->first();
        echo $rec['email'];
    }
    public function subscriber()
    {
        //dd("ok");
        $data = array(
            "email" => request("email"),
        );
        $valid = Validator::make($data, [
            'email' => 'required|email|unique:contactusers,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
        ], [
            "email.required" => "Please Enter Your Valid Email ID",
            "email.unique"   => "You Have Already Subscribed With This Email ID",
            "email.regex"    => "Please Enter Your Valid Email ID.",
            "email.email"    => "Please Enter Your Valid Email ID.",
        ]);

        if ($valid->fails()) {
            $message  = $valid->getMessageBag()->toArray();
            $messages = array();
            foreach ($message as $k => $v) {
                if (is_array($v)) {
                    $messages[$k] = $v[0];
                } else {
                    $messages[$k] = $v;
                }
            }
            return array("resp" => "error", "msg" => $messages);
        } else {
            $data = ContactUser::create([
                'email' => request('email'),
                'type'  => "Subscriber",
            ]);
            return array("resp" => "success", "msg" => "Your Email has been sent Successfully.");
        }

    }
}
