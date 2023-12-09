<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMediaAddExtraFields extends Migration
{
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('source_link')->nullable();
            $table->tinyInteger('license')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_link')->nullable();
        });
    }
}
