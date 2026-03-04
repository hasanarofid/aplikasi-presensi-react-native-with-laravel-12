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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('employee'); // admin, employee
            $table->string('position')->nullable();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->onDelete('set null');
            $table->string('photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['shift_id']);
            $table->dropColumn(['role', 'position', 'shift_id', 'photo']);
        });
    }
};
