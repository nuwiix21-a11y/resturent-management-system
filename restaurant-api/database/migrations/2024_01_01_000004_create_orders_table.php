<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->integer('table_number')->nullable();
            $table->enum('type', ['dine_in', 'takeaway'])->default('dine_in');
            $table->enum('status', ['pending', 'preparing', 'ready', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};
