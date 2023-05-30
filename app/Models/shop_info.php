<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shop_info extends Model
{
    use HasFactory;
    protected $fillable = ['owner_id', 'creater_id', 'shop_name', 'status', 'delete_status', 'shop_phone', 'open_at', 'closed_at', 'shop_email', 'home', 'village', 'word', 'union', 'upazila', 'district', 'zip_code', 'division', 'country', 'shop_profile_image', 'profile_image_path', 'shop_cover_image', 'cover_image_path'];
}
