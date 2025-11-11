<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('old_stock')->nullable();
            $table->integer('new_stock')->nullable();
            $table->integer('delta')->nullable(); // new - old
            $table->string('reason')->default('manual'); // manual|purchase
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('stock_changes');
    }
};