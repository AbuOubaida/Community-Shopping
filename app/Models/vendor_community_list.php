<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_community_list extends Model
{
    use HasFactory;
    protected $fillable = ['vendor_id','community_id','remarks'];
}
