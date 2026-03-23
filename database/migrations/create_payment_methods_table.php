<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['card', 'ewallet', 'bank']);
            $table->string('label');
            $table->string('sub_label')->nullable();
            $table->string('icon_class')->default('card');
            $table->string('icon_text')->default('');
            $table->string('last_four')->nullable();
            $table->string('expiry')->nullable();
            $table->boolean('is_default')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
