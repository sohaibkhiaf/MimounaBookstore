<?php

use App\Models\Region;
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
        Schema::table('users', function (Blueprint $table){
            $table->string('phone');
            $table->string('address');
            $table->integer('age')->default(18);
            $table->integer('gender')->default(1);
            $table->unsignedInteger('role')->default(0);
            $table->boolean('banned')->default(false);
            $table->foreignIdFor(Region::class)->nullable()->constrained()
                ->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('age')->default(18);
            $table->dropColumn('gender')->default(1);
            $table->dropColumn('role');
            $table->dropColumn('banned')->default(false);
            $table->dropForeignIdFor(Region::class)->nullable()
                ->constrained()->noActionOnDelete()->noActionOnUpdate();
        });
    }
};
