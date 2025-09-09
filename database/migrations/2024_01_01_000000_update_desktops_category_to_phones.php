<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all products with 'desktops' category to 'phones'
        DB::table('products')
            ->where('category', 'desktops')
            ->update(['category' => 'phones']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert all products with 'phones' category back to 'desktops'
        // Only if they were originally 'desktops' (this is a best effort reversal)
        DB::table('products')
            ->where('category', 'phones')
            ->update(['category' => 'desktops']);
    }
};
