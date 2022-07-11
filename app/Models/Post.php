<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    use HasFactory;

    protected $guarded = [];

    protected $with = [ 'author'];

//    public function category() {
//        return $this->belongsTo(Category::class);
//    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }



    public function scopeFilter($query, array $filers) {

        $query->when($filers['search'] ?? false, function ($query, $search) {
            $query->where(fn($query) =>
                $query->where('title',  'Like' , '%'. $search.'%')
                      ->orWhere('body',  'Like' , '%'. $search.'%')
            );

        });

        $query->when($filers['category'] ?? false, fn($query, $category) =>
            $query
                ->whereHas('category', fn ($query) =>
                  $query->where('slug', $category))
        );

        $query->when($filers['author'] ?? false, fn($query, $author) =>
        $query
            ->whereHas('author', fn ($query) =>
            $query->where('username', $author))
        );




    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
