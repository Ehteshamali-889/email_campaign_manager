<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailCampaignController;

Route::post('/campaigns', [EmailCampaignController::class, 'store']);
Route::post('/campaigns/{id}/send', [EmailCampaignController::class, 'send']);
Route::get('/customers/filter', [EmailCampaignController::class, 'filterCustomers']);