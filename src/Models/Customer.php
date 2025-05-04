<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_number', 'status', 'plan_expiry_date',
    ];

    public $timestamps = false; // only if you don't have created_at / updated_at columns
}
