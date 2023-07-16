<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class community_order_from_shop extends Model
{
    use HasFactory;
    protected $fillable = [ 'order_id', 'shop_id', 'community_id', 'status', 'seen_status', 'request_time', 'response_time'];
}
