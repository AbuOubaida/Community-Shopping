<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class slider_images extends Model
{
    use HasFactory;
    protected $fillable = ['created_id', 'title', 'title_show','status','deleteStatus', 'quotation', 'quotation_show', 'heading1', 'heading1_show', 'heading2', 'heading2_show', 'paragraph', 'paragraph_show', 'button_title', 'button_link', 'button_show', 'image_name', 'source_url'];
}
