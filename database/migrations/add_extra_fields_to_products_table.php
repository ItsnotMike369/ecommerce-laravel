<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('name');
            $table->string('brand')->nullable()->after('sku');
            $table->decimal('sale_price', 10, 2)->nullable()->after('price');
            $table->string('weight')->nullable()->after('sale_price');
            $table->string('dimensions')->nullable()->after('weight');
            $table->string('tags')->nullable()->after('dimensions');
            $table->boolean('is_featured')->default(false)->after('tags');
            $table->boolean('is_hot_offer')->default(false)->after('is_featured');
            $table->boolean('is_new_arrival')->default(false)->after('is_hot_offer');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku', 'brand', 'sale_price', 'weight', 'dimensions', 'tags', 'is_featured', 'is_hot_offer', 'is_new_arrival']);
        });
    }
};
