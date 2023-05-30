<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'vendor_id', 'creater_id', 'status', 'c_name', 'c_description'];
}
