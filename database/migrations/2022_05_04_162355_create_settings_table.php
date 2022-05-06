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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name')->nullable();
            $table->string('website_logo')->nullable();
            $table->string('website_icon')->nullable();
            $table->string('website_cover')->nullable();
            $table->text('address')->nullable();
            $table->text('website_bio')->nullable();
            //website_contact
            $table->text('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp_phone')->nullable();
            //website_social
            $table->text('facebook_link')->nullable();
            $table->text('twitter_link')->nullable();
            $table->text('instagram_link')->nullable();
            $table->text('youtube_link')->nullable();
            $table->text('telegram_link')->nullable();
            $table->text('whatsapp_link')->nullable();
            $table->text('tiktok_link')->nullable();
            $table->text('linkedin_link')->nullable();
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
        Schema::dropIfExists('settings');
    }
};
