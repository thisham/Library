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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_copy_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->date('loan_date');
            $table->date('return_date')->nullable();
            // Status: 0 => Pending; 1 => Approved and Loaned; 2 => Exceed Limit Day; 3 => Rejected; 4 => Returned
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
