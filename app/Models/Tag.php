<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    // For flexibility
    public function taggables()
    {
        return $this->morphedByMany(Model::class, 'taggable');
    }


}
