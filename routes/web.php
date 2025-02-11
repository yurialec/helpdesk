<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Chat\AttendantsController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\ClientChatController;
use App\Http\Controllers\Chat\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\LogoController;
use App\Http\Controllers\Site\SiteAboutController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\GeneralConfig\CompanyController;
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

Route::get('/', [LoginController::class, 'showLoginForm'])->name('index.site');
Route::get('/sobre', [SiteController::class, 'about'])->name('about');
Route::get('/contato', [SiteController::class, 'contact'])->name('contact');

Route::get('/chat-widget', [ClientChatController::class, 'showWidget']);

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin/')->group(function () {
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::get('menus', [MenuController::class, 'menus'])->name('menus');
        Route::get('/users/profile-view', [UserController::class, 'profileView'])->name('profile.view');
        Route::get('/users/profile', [UserController::class, 'profile'])->name('profile');
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');

        Route::middleware(['acl:manter-usuarios'])->group(function () {
            Route::prefix('users')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('users.index');
                Route::get('/list', [UserController::class, 'list'])->name('users.list');
                Route::get('/create', [UserController::class, 'create'])->name('users.create');
                Route::post('/store', [UserController::class, 'store'])->name('users.store');
                Route::get('/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
                Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
                Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
            });
        });

        Route::middleware(['acl:manter-perfis'])->group(callback: function () {
            Route::prefix('roles')->group(function () {
                Route::get('/', [RoleController::class, 'index'])->name('roles.index');
                Route::get('/list', [RoleController::class, 'list'])->name('roles.list');
                Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
                Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
                Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
                Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
                Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('roles.delete');
                Route::get('/list-permissions', [RoleController::class, 'listPermissions'])->name('roles.list.permissions');
            });
        });

        Route::middleware(['acl:manter-permissoes'])->group(callback: function () {
            Route::prefix('permissions')->group(function () {
                Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
                Route::get('/list', [PermissionController::class, 'list'])->name('permissions.list');
                Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
                Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
                Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
                Route::post('/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
                Route::delete('/delete/{id}', [PermissionController::class, 'delete'])->name('permissions.delete');
            });
        });

        Route::middleware(['acl:manter-menus'])->group(callback: function () {
            Route::prefix('menu')->group(function () {
                Route::get('/', [MenuController::class, 'index'])->name('menu.index');
                Route::get('/list', [MenuController::class, 'list'])->name('menu.list');
                Route::get('/create', [MenuController::class, 'create'])->name('menu.create');
                Route::post('/store', [MenuController::class, 'store'])->name('menu.store');
                Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
                Route::post('/update/{id}', [MenuController::class, 'update'])->name('menu.update');
                Route::delete('/delete/{id}', [MenuController::class, 'delete'])->name('menu.delete');
                Route::post('/change-order-menu/{id}', [MenuController::class, 'changeOrderMenu'])->name('menu.changeOrderMenu');
            });
        });

        Route::prefix('site/')->group(function () {
            Route::middleware(['acl:manter-logo'])->group(callback: function () {
                Route::prefix('logo')->group(function () {
                    Route::get('/', [LogoController::class, 'index'])->name('site.logo.index');
                    Route::get('/list', [LogoController::class, 'list'])->name('site.logo.list');
                    Route::get('/create', [LogoController::class, 'create'])->name('site.logo.create');
                    Route::post('/store', [LogoController::class, 'store'])->name('site.logo.store');
                    Route::get('/edit/{id}', [LogoController::class, 'edit'])->name('site.logo.edit');
                    Route::post('/update/{id}', [LogoController::class, 'update'])->name('site.logo.update');
                    Route::delete('/delete/{id}', [LogoController::class, 'delete'])->name('site.logo.delete');
                });
            });

            Route::middleware(['acl:manter-sobre'])->group(callback: function () {
                Route::prefix('site-about')->group(function () {
                    Route::get('/', [SiteAboutController::class, 'index'])->name('site.about.index');
                    Route::get('/list', [SiteAboutController::class, 'list'])->name('site.about.list');
                    Route::get('/create', [SiteAboutController::class, 'create'])->name('site.about.create');
                    Route::post('/store', [SiteAboutController::class, 'store'])->name('site.about.store');
                    Route::get('/edit/{id}', [SiteAboutController::class, 'edit'])->name('site.about.edit');
                    Route::post('/update/{id}', [SiteAboutController::class, 'update'])->name('site.about.update');
                    Route::delete('/delete/{id}', [SiteAboutController::class, 'delete'])->name('site.about.delete');
                });
            });

            Route::middleware(['acl:manter-contato'])->group(callback: function () {
                Route::prefix('contact')->group(function () {
                    Route::get('/', [ContactController::class, 'index'])->name('site.contact.index');
                    Route::get('/list', [ContactController::class, 'list'])->name('site.contact.list');
                    Route::get('/create', [ContactController::class, 'create'])->name('site.contact.create');
                    Route::post('/store', [ContactController::class, 'store'])->name('site.contact.store');
                    Route::get('/edit/{id}', [ContactController::class, 'edit'])->name('site.contact.edit');
                    Route::post('/update/{id}', [ContactController::class, 'update'])->name('site.contact.update');
                    Route::delete('/delete/{id}', [ContactController::class, 'delete'])->name('site.contact.delete');
                });
            });
        });

        Route::middleware(['acl:manter-chat'])->group(callback: function () {
            Route::prefix('chat')->group(function () {
                Route::get('/', [ChatController::class, 'index'])->name('chat.index');
                Route::get('/list', [ChatController::class, 'list'])->name('chat.list');
                Route::post('transfer/{chat}/{user}', [ChatController::class, 'transfer'])->name('chat.transfer');
                Route::prefix('attendants')->group(function () {
                    Route::get('/', [AttendantsController::class, 'index'])->name('attendants.index');
                    Route::get('/list', [AttendantsController::class, 'list'])->name('attendants.list');
                });

                Route::prefix('clients')->group(function () {
                    Route::get('/', [ClientController::class, 'index'])->name('clients.index');
                    Route::get('/list', [ClientController::class, 'list'])->name('clients.list');
                });
            });
        });

        Route::middleware(['acl:manter-ticket'])->group(callback: function () {
            Route::prefix('tickets')->group(function () {
                
            });
        });

        Route::middleware(['acl:manter-config-gerais'])->group(callback: function () {
            Route::prefix('general-configs')->group(function () {
                Route::prefix('companies')->group(function () {
                    Route::get('/', [CompanyController::class, 'index'])->name('company.index');
                    Route::get('/list', [CompanyController::class, 'list'])->name('company.list');
                    Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
                    Route::post('/store', [CompanyController::class, 'store'])->name('company.store');
                    Route::get('/edit/{id}', [CompanyController::class, 'edit'])->name('company.edit');
                    Route::get('/find/{id}', [CompanyController::class, 'find'])->name('company.find');
                    Route::put('/update/{id}', [CompanyController::class, 'update'])->name('company.update');
                    Route::delete('/delete/{id}', [CompanyController::class, 'delete'])->name('company.delete');
                });
            });
        });

        Route::get('/chat/my-chats', [AttendantsController::class, 'myChats'])->name('attendants.my.chats');
        Route::get('/list-my-chats', [AttendantsController::class, 'listMyChats'])->name('attendants.list.my.chats');
        Route::get('/chat/view/{id}', [ChatController::class, 'view'])->name('chat.view');
        Route::get('/chat/get-chat-by-id/{id}', [ChatController::class, 'getChatById'])->name('get.chat.by.id');
        Route::post('/chat/end/{id}', [ChatController::class, 'end'])->name('chat.end');
        Route::post('/chat/send-message/{protocol}', [AttendantsController::class, 'sendMessage'])->name('attendants.send.message');

        //CONSULTA CEP
        Route::get('/cep/{cep}', function ($cep) {
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
            return $response->json();
        });
    });
});