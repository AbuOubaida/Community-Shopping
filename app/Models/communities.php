<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class communities extends Model
{
    use HasFactory;
    protected $fillable = ['owner_id', 'creater_id', 'community_name', 'community_type', 'status', 'delete_status', 'community_phone', 'community_email', 'home', 'village', 'word', 'union', 'upazila', 'district', 'zip_code', 'division', 'country', 'community_profile_image', 'profile_image_path', 'community_cover_image', 'cover_image_path'];
}
