<?php

namespace App\Mail;

use App\Models\EmailCampaign;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class YourCampaignMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;

    /**
     * Create a new message instance.
     *
     * @param EmailCampaign $campaign
     */
    public function __construct(EmailCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.campaign') // Define the view for the email
                    ->with([
                        'title' => $this->campaign->title,
                        'subject' => $this->campaign->subject,
                        'body' => $this->campaign->body,
                    ])
                    ->subject($this->campaign->subject);  // Email subject
    }
}
