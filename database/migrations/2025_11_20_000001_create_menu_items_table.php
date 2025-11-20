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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', [
                'paket',
                'gyutan',
                'dori',
                'salmon',
                'nasi_goreng',
                'mie_bihun',
                'snack',
                'minuman'
            ]);
            $table->decimal('price', 12, 2);
            $table->text('notes')->nullable(); // For topping options or variations
            $table->boolean('is_available')->default(true);
            $table->integer('stock')->default(-1); // -1 means unlimited
            $table->string('image')->nullable(); // Path to menu item image
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
