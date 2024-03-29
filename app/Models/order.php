<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['id','invoice_id', 'order_id', 'customer_id', 'products_id', 'vendor_id', 'delivery_person_id', 'delivery_address','district','division','country','c_name', 'c_phone', 'c_email', 'order_status', 'order_complete_status', 'order_quantity','product_count', 'price','shipping_charge','payment_method', 'created_at', 'updated_at'];
}
