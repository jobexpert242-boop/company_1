<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('about_image')->nullable();
            $table->string('team_image')->nullable();
            $table->string('service_image')->nullable();
            $table->string('portfolio_image')->nullable();
            $table->string('contact_image')->nullable();
            $table->string('portfoliodetailes_image')->nullable();
            $table->string('project_image')->nullable();
            $table->string('booking_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
