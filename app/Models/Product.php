<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['p_status', 'offer_status', 'vendor_id', 'creater_id', 'updater_id', 'category_id', 'p_name', 'p_price', 'p_details', 'p_quantity', 'p_image', 'p_slider_image', 'offer_percentage', 'offer_quantity', 'offer_start_time', 'offer_end_time', ];
}
