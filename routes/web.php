<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PortfolioItemController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\UserRegistrationController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SalesController;



/*
|--------------------------------------------------------------------------
| PUBLIC HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

// BOOKING (no login required)
Route::get('/book', [BookingController::class, 'create'])->name('book.create');
Route::post('/book', [BookingController::class, 'store'])->name('book.store');
Route::post('/book/generate-image', [BookingController::class, 'generateImage'])
    ->name('book.generate-image');

// PUBLIC portfolio (client side)
Route::get('/portfolio', [PortfolioItemController::class, 'publicIndex'])
    ->name('portfolio');

// PUBLIC contact page
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// PUBLIC – client reviews page + submit
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| ADMIN + ASSISTANT ROUTES
| (shared access: admin, assistant_admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,assistant_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // BOOKINGS TABLE (VIEW ONLY for assistant; actions are admin-only below)
        Route::get('/bookings', [BookingController::class, 'adminIndex'])
            ->name('bookings.index');

        // PORTFOLIO MANAGER (admin side)
        // Assistant admin can upload & edit, but NOT delete
        Route::get('/portfolio', [PortfolioItemController::class, 'index'])
            ->name('portfolio'); // => admin.portfolio

        Route::post('/portfolio', [PortfolioItemController::class, 'store'])
            ->name('portfolio.store');

        Route::get('/portfolio/{item}/edit', [PortfolioItemController::class, 'edit'])
            ->name('portfolio.edit');

        Route::put('/portfolio/{item}', [PortfolioItemController::class, 'update'])
            ->name('portfolio.update');

            // SALES PAGE (admin + assistant admin)
        Route::get('/sales', [SalesController::class, 'index'])
            ->name('sales.index');

        // CLIENT REVIEW MODERATION (admin + assistant)
        Route::get('/reviews', [ReviewAdminController::class, 'index'])
            ->name('reviews.index'); // => admin.reviews.index

        Route::patch('/reviews/{review}/approve', [ReviewAdminController::class, 'approve'])
            ->name('reviews.approve');

        Route::patch('/reviews/{review}/hide', [ReviewAdminController::class, 'hide'])
            ->name('reviews.hide');

        Route::delete('/reviews/{review}', [ReviewAdminController::class, 'destroy'])
            ->name('reviews.destroy');

            // Sales payments
Route::post('/sales/{booking}/downpayment', [SalesController::class, 'storeDownpayment'])
    ->name('sales.downpayment');

Route::post('/sales/{booking}/final-payment', [SalesController::class, 'storeFinalPayment'])
    ->name('sales.final-payment');


    });

/*
|--------------------------------------------------------------------------
| MAIN ADMIN-ONLY ROUTES
| (ONLY role:admin can hit these)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |-------------------------
        | BOOKINGS – ADMIN ONLY
        |-------------------------
        */
        Route::patch('/bookings/{booking}/approve', [BookingController::class, 'approve'])
            ->name('bookings.approve');

        Route::patch('/bookings/{booking}/reject', [BookingController::class, 'reject'])
            ->name('bookings.reject');

        Route::patch('/bookings/{booking}/complete', [BookingController::class, 'complete'])
            ->name('bookings.complete');

        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])
            ->name('bookings.destroy');

        /*
        |-------------------------
        | PORTFOLIO – ADMIN ONLY DELETE
        |-------------------------
        */
        Route::delete('/portfolio/{item}', [PortfolioItemController::class, 'destroy'])
            ->name('portfolio.destroy');

        /*
        |-------------------------
        | INVENTORY
        |-------------------------
        */
        Route::get('/inventory', [InventoryItemController::class, 'index'])
            ->name('inventory.index');

        Route::get('/inventory/create', [InventoryItemController::class, 'create'])
            ->name('inventory.create');

        Route::post('/inventory', [InventoryItemController::class, 'store'])
            ->name('inventory.store');

        Route::get('/inventory/{item}/edit', [InventoryItemController::class, 'edit'])
            ->name('inventory.edit');

        Route::put('/inventory/{item}', [InventoryItemController::class, 'update'])
            ->name('inventory.update');

        Route::delete('/inventory/{item}', [InventoryItemController::class, 'destroy'])
            ->name('inventory.destroy');

        /*
        |-------------------------
        | ASSISTANT ADMIN REGISTRATIONS
        |-------------------------
        */
        Route::get('/user-registrations', [UserRegistrationController::class, 'index'])
            ->name('user-registrations.index');

        Route::post('/user-registrations/{id}/approve', [UserRegistrationController::class, 'approve'])
            ->name('user-registrations.approve');

        Route::post('/user-registrations/{id}/revoke', [UserRegistrationController::class, 'revoke'])
            ->name('user-registrations.revoke');

        Route::delete('/user-registrations/{id}', [UserRegistrationController::class, 'destroy'])
            ->name('user-registrations.destroy');
    });

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
