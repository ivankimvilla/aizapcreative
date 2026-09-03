<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('quotes', 'price')) {
            Schema::table('quotes', function (Blueprint $table) {
                $table->string('price')->nullable()->after('service');
            });
        }
    }

    public function down(): void
    {
        // This migration is redundant because the original quotes table already includes the
        // price column, so rollback should not remove it.
    }
};
