<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'path',
        'status'
    ];
    public static function getStatusAsProcessed(){
        return 'processed';
    }
    public static function getStatusAsProcessing(){
        return 'processing';
    }
    public function userVideoLikes()
    {
        return $this->hasMany(UserVideoLike::class);
    }


    public function getSampleUrlAttribute()
    {
        $path = $this->getAttribute('path');
        return Storage::disk('public')
            ->url("media/{$path}/{$path}_100.mp4");
    }
    public function getFullUrlAttribute()
    {
        $path = $this->getAttribute('path');
        return Storage::disk('public')
            ->url("media/{$path}/{$path}_processed.mp4");
    }
    public function getThumbnailUrlAttribute()
    {
        $path = $this->getAttribute('path');
        return Storage::disk('public')
            ->url("media/{$path}/{$path}.png");
    }
    public function getIsOwnerAttribute()
    {
        $userId = $this->getAttribute('user_id');
        if (Auth::check()) {
            return $userId === Auth::id();
        }
        return false;
    }
}
