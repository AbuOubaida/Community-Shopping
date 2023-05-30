<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipping_charges extends Model
{
    use HasFactory;
    protected $fillable = ['location_type','location_name', 'amount','create_by','update_by'];
}
