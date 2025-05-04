<?php

namespace EmailCampaignManager;

use App\Models\EmailCampaign;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendCampaignEmailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class EmailCampaignManager
{
    /**
     * Create a new email campaign
     *
     * @param array $data
     * @return EmailCampaign
     */
    public function createCampaign(array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign = EmailCampaign::create($data);
        return $campaign;
    }

    /**
     * Filter the audience based on status and plan expiry date
     *
     * @param string|null $status
     * @param int|null $planExpiryDays
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filterAudience($status = null, $planExpiryDays = null)
    {
        Log::info("Filtering customers with status: $status, plan expiry days: $planExpiryDays");

        $customers = Customer::query();

        // Filter by status if provided
        if ($status) {
            $customers->where('status', $status);
        }

        // Filter by plan expiry days if provided
        if ($planExpiryDays) {
            $customers->whereBetween('plan_expiry_date', [
                Carbon::now()->startOfDay(),
                Carbon::now()->addDays($planExpiryDays)->endOfDay()
            ]);
        }

        $result = $customers->get();
        Log::info("Filtered customers count: " . $result->count());

        return $result;
    }

    /**
     * Send email campaign to the filtered customers
     *
     * @param EmailCampaign $campaign
     * @param \Illuminate\Database\Eloquent\Collection $customers
     * @return string
     */
    public function sendCampaign(EmailCampaign $campaign, $customers)
    {
        Log::info("Dispatching job to send campaign: " . $campaign->title);

        foreach ($customers as $customer) {
            Log::info("Dispatching job for customer: " . $customer->email);
            // Dispatch the job to send emails asynchronously using queues
            SendCampaignEmailJob::dispatch($customer, $campaign);
        }

        return "Emails are being sent to the selected audience.";
    }
}
