<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'name',
        'slug',
        'show_at_popular',
        'show_at_featured',
    ];
}
