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
        Schema::create('streaming_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("movie_id")->constrained()->cascadeOnDelete();
            $table->integer("netflix")->default(0);
            $table->integer("disney")->default(0);
            $table->integer("hbo")->default(0);
            $table->integer("apple")->default(0);
            $table->integer("amazon")->default(0);
            $table->string("verified_platform")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streaming_votes');
    }
};
