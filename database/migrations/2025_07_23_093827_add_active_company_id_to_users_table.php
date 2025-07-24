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
      if (!Schema::hasColumn('users', 'active_company_id')) {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('active_company_id')->nullable()->constrained('companies')->nullOnDelete();
        });
    }


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['active_company_id']);

            // Only drop the column if you want — optional
            // If you did NOT create the column here, you should not drop it here.
            // $table->dropColumn('active_company_id');
        });
    }
};
