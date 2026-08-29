<?php
// ════════════════════════════════════════════════
// database/migrations/2024_01_01_000001_create_users_table.php
// ════════════════════════════════════════════════
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'staff'])->default('staff');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('users'); }
};


// ════════════════════════════════════════════════
// database/migrations/2024_01_01_000002_create_categories_table.php
// ════════════════════════════════════════════════

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('categories'); }
};


// ════════════════════════════════════════════════
// database/migrations/2024_01_01_000003_create_menu_items_table.php
// ════════════════════════════════════════════════

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('menu_items'); }
};


// ════════════════════════════════════════════════
// database/migrations/2024_01_01_000004_create_orders_table.php
// ════════════════════════════════════════════════

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


// ════════════════════════════════════════════════
// database/migrations/2024_01_01_000005_create_order_items_table.php
// ════════════════════════════════════════════════

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_item_id')->constrained()->onDelete('restrict');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
        });
    }
    public function down(): void { Schema::dropIfExists('order_items'); }
};


// ════════════════════════════════════════════════
// database/migrations/2024_01_01_000006_create_bills_table.php
// ════════════════════════════════════════════════

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
