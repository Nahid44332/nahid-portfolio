<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $guarded = [];

     protected $fillable = [
        'years',
        'title',
        'description',
        'features',
        'happy_clients',
        'projects_completed',
        'image_one',
        'image_two',
    ];

    protected $casts = [
        'features' => 'array',
    ];
}
