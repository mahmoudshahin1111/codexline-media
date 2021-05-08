<?php

namespace App\Http\Controllers;

use App\Events\NewVideoUploaded;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\VideoController\CreateOneRequest;
use App\Http\Requests\VideoController\RemoveOneRequest;
use App\Models\UserVideoLike;
use App\Models\Video;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function videosPage(Request $request)
    {
        $videos = Video::where('status', Video::getStatusAsProcessed())->paginate(15);
        return view('videos', ['videos' =>  $videos]);
    }

    public function createPage(Request $request)
    {
        return view('uploadVideo');
    }
    public function createOne(CreateOneRequest $request)
    {
        $file = $request->file('video');
        $folderName = 'media';
        $fileBaseName = Str::random(10);
        Storage::disk('public')
            ->putFileAs(
                "{$folderName}/{$fileBaseName}",
                $file,
                $fileBaseName
            );
        $video = new Video([
            'user_id' => auth()->id(),
            'name' => $request->get('name'),
            'path' => $fileBaseName,
            'status' => Video::getStatusAsProcessing()
        ]);
        $video->save();
        NewVideoUploaded::dispatch($video);
        return Redirect::route('dashboard');
    }


    public function showOne(Request $request, Video $video)
    {
        $data = [
            'video' => $video,
            'likes' => $video->userVideoLikes()
            ->where('like_status', UserVideoLike::getLikeStatusAsLike())
            ->count(),
            'dislikes' => $video->userVideoLikes()
            ->where('like_status', UserVideoLike::getLikeStatusAsDislike())
            ->count()
        ];
        $likeStatus = UserVideoLike::where('video_id', $video->id)
            ->where('user_id', auth()->id())
            ->first();
        if ($likeStatus) {
            $data['likeStatus'] = $likeStatus->like_status;
        }
        return view('showVideo', $data);
    }
    public function like(Request $request, Video $video)
    {
        $userVideoLike = UserVideoLike::where('video_id', $video->id)
            ->where('user_id', auth()->id())
            ->first();
        if ($userVideoLike) {
            if ($userVideoLike->like_status === UserVideoLike::getLikeStatusAsLike()) {
                $userVideoLike->like_status = UserVideoLike::getLikeStatusAsIgnore();
            } else {
                $userVideoLike->like_status = UserVideoLike::getLikeStatusAsLike();
            }
            $userVideoLike->save();
        } else {
            UserVideoLike::create([
                'video_id' => $video->id,
                'user_id' => auth()->id(),
                'like_status' => UserVideoLike::getLikeStatusAsLike()
            ]);
        }
        return Redirect::back();
    }
    public function dislike(Request $request, Video $video)
    {
        $userVideoLike = UserVideoLike::where('video_id', $video->id)
            ->where('user_id', auth()->id())
            ->first();
        if ($userVideoLike) {
            if ($userVideoLike->like_status === UserVideoLike::getLikeStatusAsDislike()) {
                $userVideoLike->like_status = UserVideoLike::getLikeStatusAsIgnore();
            } else {
                $userVideoLike->like_status = UserVideoLike::getLikeStatusAsDislike();
            }

            $userVideoLike->save();
        } else {
            UserVideoLike::create([
                'video_id' => $video->id,
                'user_id' => auth()->id(),
                'like_status' => UserVideoLike::getLikeStatusAsDislike()
            ]);
        }
        return Redirect::back();
    }

    public function removeOne(RemoveOneRequest $request, Video $video)
    {

        Storage::disk('public')
        ->deleteDirectory("media/{$video->path}");

        $video->userVideoLikes()->delete();

        $video->delete();

        return Redirect::route('video.videosPage');

    }
}
