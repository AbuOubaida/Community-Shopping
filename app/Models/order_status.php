<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_status extends Model
{
    use HasFactory;

    protected $fillable = ['status_name', 'status_value', 'badge','title'];
}
