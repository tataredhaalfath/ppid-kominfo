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
        Schema::create('public_information_files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("title");
            $table->longText("description")->nullable();
            $table->string("file")->nullable();
            $table->unsignedBigInteger("public_information_news_id");
            $table->foreign("public_information_news_id")
                ->references("id")
                ->on("public_information_news")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_information_files');
    }
};
