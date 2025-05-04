<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignEmailLog extends Model
{
    protected $fillable = [
        'campaign_id',
        'customer_id',
        'status',
        'sent_at',
    ];
}