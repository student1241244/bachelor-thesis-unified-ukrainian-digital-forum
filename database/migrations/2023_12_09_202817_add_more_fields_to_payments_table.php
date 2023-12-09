<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('stripe_session_id')->nullable();
            $table->string('secure_token')->nullable();
            $table->string('status')->default('pending');
            $table->boolean('passcode_displayed')->default(false);
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['stripe_id', 'stripe_session_id', 'secure_token', 'status', 'passcode', 'passcode_displayed']);
        });
    }
};
