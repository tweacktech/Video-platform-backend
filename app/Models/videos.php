<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class videos extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'file_path',
        'thumbnail_path',
        'status',
        'duration',
        'is_featured',
        'views',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
