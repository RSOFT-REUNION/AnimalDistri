<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $table = 'content_carousel';
    protected $fillable = ['name', 'image', 'description', 'title_url', 'url'];
}
