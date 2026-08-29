<?php
// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;

// ── Public routes ──────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

// ── Protected routes (Sanctum) ─────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user',    [AuthController::class, 'me']);

    // Tables
    Route::get('/tables', [TableController::class, 'index']);

    // Categories
    Route::apiResource('categories', CategoryController::class);

    // Menu Items
    Route::apiResource('menu-items', MenuItemController::class);

    // Orders
    Route::get   ('orders',                [OrderController::class, 'index']);
    Route::post  ('orders',                [OrderController::class, 'store']);
    Route::get   ('orders/{order}',        [OrderController::class, 'show']);
    Route::put   ('orders/{order}/status', [OrderController::class, 'updateStatus']);
    Route::delete('orders/{order}',        [OrderController::class, 'destroy']);

    // Bills
    Route::get ('bills',          [BillController::class, 'index']);
    Route::post('bills',          [BillController::class, 'store']);
    Route::get ('bills/{bill}',   [BillController::class, 'show']);
    Route::put ('bills/{bill}/pay', [BillController::class, 'markPaid']);

    // Reports (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('reports/summary',   [ReportController::class, 'summary']);
        Route::get('reports/top-items', [ReportController::class, 'topItems']);

        // Users
        Route::apiResource('users', UserController::class);
    });
});
