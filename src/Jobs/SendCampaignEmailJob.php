<?php

namespace App\Jobs;

use App\Models\EmailCampaign;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\YourCampaignMailable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;  // Corrected import

class SendCampaignEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $customer;
    protected $campaign;

    public function __construct(Customer $customer, EmailCampaign $campaign)
    {
        $this->customer = $customer;
        $this->campaign = $campaign;
    }

    public function handle()
    {
        Log::info("Processing job for customer: " . $this->customer->email . " with campaign: " . $this->campaign->title);

        try {
            // Send email to customer for the campaign
            Mail::to($this->customer->email)->send(new YourCampaignMailable($this->campaign));

            // Log success
            Log::info('Email sent successfully to customer: ' . $this->customer->email . ' for campaign: ' . $this->campaign->title);
        } catch (\Exception $e) {
            // Log failure
            Log::error('Failed to send email to customer: ' . $this->customer->email . ' for campaign: ' . $this->campaign->title . '. Error: ' . $e->getMessage());
        }
    }
}
