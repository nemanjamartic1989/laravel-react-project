<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'user_id',
        'post_id',
    ];

    /**
     * Autor which comment belong
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Post which comment belong
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
