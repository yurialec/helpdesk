<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\LogoController;
use App\Http\Controllers\Site\MainTextController;
use App\Http\Controllers\Site\SiteAboutController;
use App\Http\Controllers\Site\SiteCarouselController;
use App\Http\Controllers\Site\SocialMediaController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [SiteController::class, 'index'])->name('site.home');
Route::get('/sobre', [SiteController::class, 'about'])->name('site.about');
Route::get('/contato', [SiteController::class, 'contact'])->name('site.contact');
Route::get('/enviar-link', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin/')->group(function () {
        //dont need acl
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::get('sidebar', [MenuController::class, 'sidebar'])->name('sidebar');
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/profile-view', [UserController::class, 'profileView'])->name('profile.view');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');

        Route::middleware('acl:keep-config')->group(function () {
            Route::post('/download-backup', [ConfigController::class, 'downloadBackup'])->name('downloadBackup');
        });

        Route::middleware('acl:keep-users')->group(function () {
            Route::prefix('users')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('users.index');
                Route::get('/list', [UserController::class, 'list'])->name('users.list');
                Route::get('/create', [UserController::class, 'create'])->name('users.create');
                Route::post('/store', [UserController::class, 'store'])->name('users.store');
                Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
                Route::get('/find/{id}', [UserController::class, 'find'])->name('users.find');
                Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
                Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
            });
        });

        Route::middleware('acl:keep-roles')->group(function () {
            Route::prefix('roles')->group(function () {
                Route::get('/', [RoleController::class, 'index'])->name('roles.index');
                Route::get('/list', [RoleController::class, 'list'])->name('roles.list');
                Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
                Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
                Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
                Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
                Route::get('/find/{id}', [RoleController::class, 'find'])->name('roles.find');
                Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('roles.delete');
                Route::get('/list-permissions', action: [RoleController::class, 'listPermissions'])->name('roles.list.permissions');
            });
        });

        Route::middleware('acl:keep-permissions')->group(function () {
            Route::prefix('permissions')->group(function () {
                Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
                Route::get('/list', [PermissionController::class, 'list'])->name('permissions.list');
                Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
                Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
                Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
                Route::get('/find/{id}', [PermissionController::class, 'find'])->name('permissions.find');
                Route::post('/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
                Route::delete('/delete/{id}', [PermissionController::class, 'delete'])->name('permissions.delete');
            });
        });

        Route::middleware('acl:keep-menu')->group(function () {
            Route::prefix('menu')->group(function () {
                Route::get('/', [MenuController::class, 'index'])->name('menu.index');
                Route::get('/list', [MenuController::class, 'list'])->name('menu.list');
                Route::get('/create', [MenuController::class, 'create'])->name('menu.create');
                Route::post('/store', [MenuController::class, 'store'])->name('menu.store');
                Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
                Route::post('/update/{id}', [MenuController::class, 'update'])->name('menu.update');
                Route::get('/find/{id}', [MenuController::class, 'find'])->name('menu.find');
                Route::delete('/delete/{id}', [MenuController::class, 'delete'])->name('menu.delete');
                Route::post('/change-order-menu/{id}', [MenuController::class, 'changeOrderMenu'])->name('menu.changeOrderMenu');
            });
        });
    });

    Route::get('/cep/{cep}', function ($cep) {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
        return $response->json();
    });
});
// === [AUTO] Admin / Feedback ===
Route::middleware(['auth', 'acl:keep-feedback'])->prefix('admin/feedback')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/list', [App\Http\Controllers\Admin\FeedbackController::class, 'list'])->name('feedback.list');
    Route::get('/create', [App\Http\Controllers\Admin\FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/store', [App\Http\Controllers\Admin\FeedbackController::class, 'store'])->name('feedback.store');
    Route::put('/update-status-feedback/{feedback}', [App\Http\Controllers\Admin\FeedbackController::class, 'updateStatusFeedback'])->name('feedback.update.status');
    Route::get('/evidence/{id}/download', [App\Http\Controllers\Admin\FeedbackController::class, 'downloadEvidence'])->name('feedback.update.downloadEvidence');
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\FeedbackController::class, 'edit'])->name('feedback.edit');
    Route::get('/find/{id}', [App\Http\Controllers\Admin\FeedbackController::class, 'find'])->name('feedback.find');
    Route::post('/update/{id}', [App\Http\Controllers\Admin\FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/delete/{id}', [App\Http\Controllers\Admin\FeedbackController::class, 'delete'])->name('feedback.delete');
});
// === [/AUTO] Admin / Feedback ===

// === [AUTO] Admin / Companies ===
Route::middleware(['auth', 'acl:keep-companies'])->prefix('admin/companies')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\CompaniesController::class, 'index'])->name('companies.index');
    Route::get('/list', [App\Http\Controllers\Admin\CompaniesController::class, 'list'])->name('companies.list');
    Route::get('/create', [App\Http\Controllers\Admin\CompaniesController::class, 'create'])->name('companies.create');
    Route::post('/store', [App\Http\Controllers\Admin\CompaniesController::class, 'store'])->name('companies.store');
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\CompaniesController::class, 'edit'])->name('companies.edit');
    Route::get('/find/{id}', [App\Http\Controllers\Admin\CompaniesController::class, 'find'])->name('companies.find');
    Route::put('/update/{id}', [App\Http\Controllers\Admin\CompaniesController::class, 'update'])->name('companies.update');
    Route::delete('/delete/{id}', [App\Http\Controllers\Admin\CompaniesController::class, 'delete'])->name('companies.delete');
    Route::post('/disable/{id}', [App\Http\Controllers\Admin\CompaniesController::class, 'disable'])->name('companies.disable');
    Route::get('/list-system-categories', [App\Http\Controllers\Admin\CompaniesController::class, 'listSystemCategories'])->name('companies.listSystemCategories');
});
// === [/AUTO] Admin / Companies ===

// === [AUTO] Admin / SystemCategory ===
Route::middleware(['auth', 'acl:keep-system-category'])->prefix('admin/system-category')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\SystemCategoryController::class, 'index'])->name('system-category.index');
    Route::get('/list', [App\Http\Controllers\Admin\SystemCategoryController::class, 'list'])->name('system-category.list');
    Route::get('/create', [App\Http\Controllers\Admin\SystemCategoryController::class, 'create'])->name('system-category.create');
    Route::post('/store', [App\Http\Controllers\Admin\SystemCategoryController::class, 'store'])->name('system-category.store');
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\SystemCategoryController::class, 'edit'])->name('system-category.edit');
    Route::get('/find/{id}', [App\Http\Controllers\Admin\SystemCategoryController::class, 'find'])->name('system-category.find');
    Route::put('/update/{id}', [App\Http\Controllers\Admin\SystemCategoryController::class, 'update'])->name('system-category.update');
    Route::delete('/delete/{id}', [App\Http\Controllers\Admin\SystemCategoryController::class, 'delete'])->name('system-category.delete');
    Route::post('/disable/{id}', [App\Http\Controllers\Admin\SystemCategoryController::class, 'disable'])->name('system-category.disable');
});
// === [/AUTO] Admin / SystemCategory ===

// === [AUTO] Admin / Tickets ===
Route::middleware(['auth','acl:keep-tickets'])->prefix('admin/tickets')->group(function () {
    Route::get('/',                 [App\Http\Controllers\Admin\TicketsController::class, 'index'])->name('tickets.index');
    Route::get('/list',             [App\Http\Controllers\Admin\TicketsController::class, 'list'])->name('tickets.list');
    Route::get('/create',           [App\Http\Controllers\Admin\TicketsController::class, 'create'])->name('tickets.create');
    Route::post('/store',           [App\Http\Controllers\Admin\TicketsController::class, 'store'])->name('tickets.store');
    Route::get('/edit/{id}',        [App\Http\Controllers\Admin\TicketsController::class, 'edit'])->name('tickets.edit');
    Route::get('/find/{id}',        [App\Http\Controllers\Admin\TicketsController::class, 'find'])->name('tickets.find');
    Route::get('/list-priorities',        [App\Http\Controllers\Admin\TicketsController::class, 'listPriorities'])->name('tickets.listPriorities');
    Route::get('/list-status',        [App\Http\Controllers\Admin\TicketsController::class, 'listStatus'])->name('tickets.listStatus');
    Route::get('/list-agents',        [App\Http\Controllers\Admin\TicketsController::class, 'listAgents'])->name('tickets.listAgents');
    Route::get('/list-companies',        [App\Http\Controllers\Admin\TicketsController::class, 'listCompanies'])->name('tickets.listCompanies');
    Route::get('/list-systems/{id}',        [App\Http\Controllers\Admin\TicketsController::class, 'listSystems'])->name('tickets.listSystems');
    Route::get('/list-sla',        [App\Http\Controllers\Admin\TicketsController::class, 'listSla'])->name('tickets.listSla');
    Route::get('/list-category',        [App\Http\Controllers\Admin\TicketsController::class, 'listCategory'])->name('tickets.listCategory');
    Route::get('/list-groups',        [App\Http\Controllers\Admin\TicketsController::class, 'listGroups'])->name('tickets.listGroups');
    Route::put('/update/{id}',     [App\Http\Controllers\Admin\TicketsController::class, 'update'])->name('tickets.update');
    Route::delete('/delete/{id}',   [App\Http\Controllers\Admin\TicketsController::class, 'delete'])->name('tickets.delete');
});
// === [/AUTO] Admin / Tickets ===
