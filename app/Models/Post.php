<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use Traits\SlugTrait;
    //
    protected $fillable = ['title', 'content', 'slug'];

    public static function booted()
    {
        static::saving(function($post){
            if ($post->isDirty('title')){
              $post->slug = $post->createSlug($post->title);
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
