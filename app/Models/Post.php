<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function upvotes()
    {
        return $this->votes()->where('vote', 1);
    }

    public function downvotes()
    {
        return $this->votes()->where('vote', -1);
    }
    
    // Calculate vote score (upvotes - downvotes)
    public function getScoreAttribute()
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }
}
