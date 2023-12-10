<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_votes', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentable'); // Polymorphic relation (can belong to question or answer)
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('vote'); // -1 for downvote, 1 for upvote
            $table->timestamps();
        
            $table->unique(['user_id', 'commentable_id', 'commentable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comment_votes', function (Blueprint $table) {
            //
        });
    }
};
