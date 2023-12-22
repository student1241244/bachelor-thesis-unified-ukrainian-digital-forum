<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comment_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id'); // Reference to comment
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('vote'); // -1 for downvote, 1 for upvote
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Unique constraint
            $table->unique(['user_id', 'comment_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('comment_votes');
    }
};
