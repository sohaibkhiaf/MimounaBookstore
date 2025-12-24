<?php

use App\Models\OrderStatus;
use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('shipping');
            $table->unsignedInteger('total');
            $table->text('shipping_region');
            $table->text('shipping_address');
            $table->text('shipping_type');
            $table->text('shipping_name');
            $table->text('shipping_phone');
            $table->foreignIdFor(User::class)->nullable()->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(OrderStatus::class)->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
