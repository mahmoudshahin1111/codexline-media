<?php

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVideoLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_video_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Video::class);
            $table->foreignIdFor(User::class);
            $table->char('like_status',100); // like-dislike-ignored
            $table->index(['like_status']);
            $table->unique(['video_id','user_id']); // 2 columns as 1 column should be unique
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_video_likes');
    }
}
