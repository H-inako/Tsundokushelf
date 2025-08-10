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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('author')->nullable();
            $table->enum('format', ['紙', '電子'])->default('紙');
            $table->enum('status', ['未読', '読書中', '読了'])->default('未読');
            $table->string('isbn')->nullable();
            $table->text('notes')->nullable(); // 感想・メモ
            $table->date('registered_at')->nullable(); // 登録日
            $table->date('finished_at')->nullable();   // 読了日
            $table->timestamps();
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
