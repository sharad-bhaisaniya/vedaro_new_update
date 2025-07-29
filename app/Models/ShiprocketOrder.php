<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiprocketOrder extends Model
{
    use HasFactory;

   protected $fillable = [
    'order_id',
    'channel_order_id',
    'shipment_id',
    'awb_code',
    'courier_name',
    'destination',
    'origin',
    'pincode',
    'packages',
    'pod',
    'pod_status',
    'status',
    'tracking_url',
    'weight',
    'size',
];

}
