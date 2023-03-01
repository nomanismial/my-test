<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMultipleEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $emails;
    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($emails , $data)
    {
        $this->emails = $emails;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->emails as $key => $value) {
            $email_to   = $value;
            $Mail       = new Mail;
            $view       = "email-template.multi-emails";

            $data     = array(
                "email"   => $this->data['email'],
                "subject" => $this->data['subject'],
                "content" => $this->data['content'],
                "from"    => array("email" => $this->data['email'], "label" => get("website_title")),
                "to"      => array("email" => $email_to, "label" => ""),
            );

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
    }
}
