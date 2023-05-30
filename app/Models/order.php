<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['id', 'order_id', 'customer_id', 'products_id', 'vendor_id', 'delivery_person_id', 'delivery_address', 'c_phone', 'c_email', 'order_status', 'order_complete_status', 'order_quantity', 'price','payment_method', 'created_at', 'updated_at'];
}
