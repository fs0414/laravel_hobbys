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
        Schema::drop('line_items');
        Schema::drop('carts');
        Schema::drop('products');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
