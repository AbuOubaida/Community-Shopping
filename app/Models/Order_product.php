<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_product extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'order_id', 'product_id', 'customer_id', 'vendor_id', 'order_status', 'order_quantity', 'delivery_quantity','unite_price', 'total_price','tax_amount', 'payment_status', 'created_by', 'updated_by', 'number_of_updated', 'created_at', 'updated_at'];
}
