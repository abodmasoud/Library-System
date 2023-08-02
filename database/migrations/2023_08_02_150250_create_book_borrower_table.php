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
        Schema::create('book_borrower', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            $table->foreignId('borrower_id')->constrained('borrowers')->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['book_id','borrower_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_borrower');
    }
};