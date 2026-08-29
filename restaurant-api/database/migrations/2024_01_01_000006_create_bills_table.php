<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->onDelete('cascade');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax',      10, 2)->default(0);
            $table->decimal('total',    10, 2);
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('bills'); }
};
