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
        Schema::create('books', function (Blueprint $table) {
            $table->id();           
            $table->string('title');
            $table->string('publisher');
            $table->year('published_year');
            $table->string('ISBN', 17)->nullable()->unique();
            $table->text('description');
            $table->unsignedSmallInteger('pages');     
            $table->string('cover_image')->nullable();
            $table->timestamps();
            // author foreign key and pivot table
            // category foreign key and pivot table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
