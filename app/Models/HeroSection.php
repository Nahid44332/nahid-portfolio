<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $guarded = [];

      protected $fillable = [
        'title_prefix',
        'name',
        'typed_texts',
        'cv_link',
        'video_link',
        'image',
    ];
}
