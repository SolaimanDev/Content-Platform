<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'image',
        'body',
        'user_id',
        'category_id',
        'status'
    ];

    protected static function booted()
    {
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
             if (empty($post->user_id)) {
                $post->user_id = Auth::id();
            }
        });

        static::updating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function scopeUnreviewed($query)
    {
        return $query->where('status', 0)
            ->where('created_at', '<=', now()->subDays(3));
    }
}