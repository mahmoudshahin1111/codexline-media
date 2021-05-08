<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVideoLike extends Model
{
    use HasFactory;
    protected $fillable = [
        'video_id',
        'user_id',
        'like_status'
    ];

    public static function getLikeStatusAsLike()
    {
        return 'like';
    }
    public static function getLikeStatusAsDislike()
    {
        return 'dislike';
    }
    public static function getLikeStatusAsIgnore()
    {
        return 'ignore';
    }

}
