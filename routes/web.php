<?php

use App\Http\Controllers\PgController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// -------------------------------------------------------------------
// Home
// -------------------------------------------------------------------
Route::get('/', [PgController::class, 'home'])->name('home');

// -------------------------------------------------------------------
// Boys section: /boys/...
// -------------------------------------------------------------------
Route::prefix('boys')->name('boys.')->group(function () {
    Route::get('/', [PgController::class, 'index'])->defaults('section', 'boys')->name('index');
    Route::get('/search', [PgController::class, 'search'])->defaults('section', 'boys')->name('search');
    Route::get('/area/{area}', [PgController::class, 'area'])->defaults('section', 'boys')->name('area');
    Route::get('/near/{college:slug}', [PgController::class, 'nearCollege'])->defaults('section', 'boys')->name('near-college');
    Route::get('/{pg:slug}', [PgController::class, 'show'])->defaults('section', 'boys')->name('show');
    Route::post('/{pg:slug}/enquiry', [EnquiryController::class, 'store'])->name('enquiry')->middleware('auth');
    Route::post('/{pg:slug}/review', [ReviewController::class, 'store'])->name('review')->middleware('auth');
});

// -------------------------------------------------------------------
// Girls section: /girls/...
// -------------------------------------------------------------------
Route::prefix('girls')->name('girls.')->group(function () {
    Route::get('/', [PgController::class, 'index'])->defaults('section', 'girls')->name('index');
    Route::get('/search', [PgController::class, 'search'])->defaults('section', 'girls')->name('search');
    Route::get('/area/{area}', [PgController::class, 'area'])->defaults('section', 'girls')->name('area');
    Route::get('/near/{college:slug}', [PgController::class, 'nearCollege'])->defaults('section', 'girls')->name('near-college');
    Route::get('/{pg:slug}', [PgController::class, 'show'])->defaults('section', 'girls')->name('show');
    Route::post('/{pg:slug}/enquiry', [EnquiryController::class, 'store'])->name('enquiry')->middleware('auth');
    Route::post('/{pg:slug}/review', [ReviewController::class, 'store'])->name('review')->middleware('auth');
});

// -------------------------------------------------------------------
// Compare (section-agnostic)
// -------------------------------------------------------------------
Route::get('/compare', [PgController::class, 'compare'])->name('compare');

// -------------------------------------------------------------------
// Owner dashboard
// -------------------------------------------------------------------
Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');

    // Wizard
    Route::get('/wizard/step1', [OwnerController::class, 'createStep1'])->name('wizard.step1');
    Route::post('/wizard/step1', [OwnerController::class, 'storeStep1']);
    Route::get('/wizard/{pg}/step2', [OwnerController::class, 'createStep2'])->name('wizard.step2');
    Route::post('/wizard/{pg}/step2', [OwnerController::class, 'storeStep2']);
    Route::get('/wizard/{pg}/step3', [OwnerController::class, 'createStep3'])->name('wizard.step3');
    Route::post('/wizard/{pg}/step3', [OwnerController::class, 'storeStep3']);
    Route::get('/wizard/{pg}/step4', [OwnerController::class, 'createStep4'])->name('wizard.step4');
    Route::post('/wizard/{pg}/step4', [OwnerController::class, 'storeStep4']);
    Route::get('/wizard/{pg}/step5', [OwnerController::class, 'createStep5'])->name('wizard.step5');
    Route::post('/wizard/{pg}/step5', [OwnerController::class, 'storeStep5']);

    // PG management
    Route::get('/{pg}/edit', [OwnerController::class, 'edit'])->name('edit');
    Route::put('/{pg}', [OwnerController::class, 'update'])->name('update');
    Route::post('/{pg}/vacancy', [OwnerController::class, 'updateVacancy'])->name('vacancy');
    Route::post('/{pg}/college-stats', [OwnerController::class, 'updateCollegeStats'])->name('college-stats');
    Route::get('/{pg}/enquiries', [EnquiryController::class, 'ownerIndex'])->name('enquiries');
    Route::get('/{pg}/analytics', [OwnerController::class, 'analytics'])->name('analytics');
});

// -------------------------------------------------------------------
// Admin panel
// -------------------------------------------------------------------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/listings', [AdminController::class, 'listings'])->name('listings');
    Route::post('/listings/{pg}/approve', [AdminController::class, 'approve'])->name('approve');
    Route::post('/listings/{pg}/reject', [AdminController::class, 'reject'])->name('reject');
    Route::post('/listings/{pg}/verify', [AdminController::class, 'verify'])->name('verify');
    Route::post('/listings/{pg}/suspend', [AdminController::class, 'suspend'])->name('suspend');
    Route::post('/reviews/{review}/approve', [AdminController::class, 'approveReview'])->name('review.approve');
    Route::post('/reviews/{review}/verify-resident', [AdminController::class, 'verifyResident'])->name('review.verify');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
});

// -------------------------------------------------------------------
// Breeze profile routes
// -------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
