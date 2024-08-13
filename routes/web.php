<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\{DashboardController, FrontController, SitemapController};

// CMS Controllers
use App\Http\Controllers\Cms\{PageController, AlbumController, FileManagerController, MenuController, ArticleController, ArticleCategoryController, ArticleFrontController, DentistsController};

use App\Http\Controllers\Settings\{UserController, AccountController, WebController, LogsController, RoleController, AccessController, PermissionController};


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Creating Storage Link
    Route::get('/storage_link', function () {
        Artisan::call('storage:link');
        return 'Storage link created successfully.';
});


 // CMS4 Front Pages
    Route::get('/home', function(){
        return redirect(route('home'));
    });

    Route::get('/', [FrontController::class, 'home'])->name('home');
    Route::get('/privacy-policy/', [FrontController::class, 'privacy_policy'])->name('privacy-policy');
    Route::post('/contact-us', [FrontController::class, 'contact_us'])->name('contact-us');
    Route::get('/search', [FrontController::class, 'search'])->name('search');
    Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap');
    Route::post('/search-dentist', [DentistsController::class, 'searchDentist'])->name('search-dentist');
    Route::get('/search-result',[FrontController::class, 'seach_result'])->name('search.result');

    //News Frontend
        Route::get('/news/', [ArticleFrontController::class, 'news_list'])->name('news.front.index');
        Route::get('/news/{slug}', [ArticleFrontController::class, 'news_view'])->name('news.front.show');
        Route::get('/news/{slug}/print', [ArticleFrontController::class, 'news_print'])->name('news.front.print');
        Route::post('/news/{slug}/share', [ArticleFrontController::class, 'news_share'])->name('news.front.share');
        Route::get('/albums/preview', [FrontController::class, 'test'])->name('albums.preview');
    //
//



Route::group(['prefix' => 'admin-panel'], function (){
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('panel.login');

    Auth::routes();

    Route::group(['middleware' => 'admin'], function (){
        // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Users
            Route::resource('users', UserController::class);
            Route::post('users/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
            Route::post('users/delete', [UserController::class, 'delete'])->name('users.delete');
            Route::post('users/activate', [UserController::class, 'activate'])->name('users.activate');
            Route::get('user-search/', [UserController::class, 'search'])->name('user.search');
            Route::get('profile-log-search/', [UserController::class, 'filter'])->name('user.activity.search');
        //

        // Account
            Route::get('account/edit', [AccountController::class, 'edit'])->name('account.edit');
            Route::put('account/update', [AccountController::class, 'update'])->name('account.update');
            Route::put('account/update_email', [AccountController::class, 'update_email'])->name('account.update-email');
            Route::put('account/update_password', [AccountController::class, 'update_password'])->name('account.update-password');
        //

        // Website
            Route::get('website-settings/edit', [WebController::class, 'edit'])->name('website-settings.edit');
            Route::put('website-settings/update', [WebController::class, 'update'])->name('website-settings.update');
            Route::post('website-settings/update_contacts', [WebController::class, 'update_contacts'])->name('website-settings.update-contacts');
            Route::post('website-settings/update-ecommerce', [WebController::class, 'update_ecommerce'])->name('website-settings.update-ecommerce');
            Route::post('website-settings/update-paynamics', [WebController::class, 'update_paynamics'])->name('website-settings.update-paynamics');
            Route::post('website-settings/update_media_accounts', [WebController::class, 'update_media_accounts'])->name('website-settings.update-media-accounts');
            Route::post('website-settings/update_data_privacy', [WebController::class, 'update_data_privacy'])->name('website-settings.update-data-privacy');
            Route::post('website-settings/update_modal_content', [WebController::class, 'update_modal_content'])->name('website-settings.update-modal-content');
            Route::post('website-settings/remove_logo', [WebController::class, 'remove_logo'])->name('website-settings.remove-logo');
            Route::post('website-settings/remove_icon', [WebController::class, 'remove_icon'])->name('website-settings.remove-icon');
            Route::post('website-settings/remove_media', [WebController::class, 'remove_media'])->name('website-settings.remove-media');
        //

        // Audit
            Route::get('audit-logs', [LogsController::class, 'index'])->name('audit-logs.index');
        //

        // Roles
            Route::resource('role', RoleController::class);
            Route::post('role/delete',[RoleController::class, 'destroy'])->name('role.delete');
            Route::get('role/restore/{id}',[RoleController::class, 'restore'])->name('role.restore');
        //

        // Access
            Route::resource('access', AccessController::class);
            Route::post('roles_and_permissions/update', [AccessController::class, 'update_roles_and_permissions'])->name('role-permission.update');

            if (env('APP_DEBUG') == "true") {
                // Permission Routes
                Route::resource('permission', PermissionController::class);
                Route::post('permission/delete', [PermissionController::class, 'delete'])->name('permission.delete');
                Route::get('permission/restore/{id}', [PermissionController::class, 'restore'])->name('permission.restore');
            }
        //

        // Pages
            Route::resource('pages', PageController::class);
            Route::get('pages-advance-search', [PageController::class, 'advance_index'])->name('pages.index.advance-search');
            Route::post('pages/get-slug', [PageController::class, 'get_slug'])->name('pages.get_slug');
            Route::put('pages/{page}/default', [PageController::class, 'update_default'])->name('pages.update-default');
            Route::put('pages/{page}/customize', [PageController::class, 'update_customize'])->name('pages.update-customize');
            Route::put('pages/{page}/contact-us', [PageController::class, 'update_contact_us'])->name('pages.update-contact-us');
            Route::post('pages-change-status', [PageController::class, 'change_status'])->name('pages.change.status');
            Route::post('pages-delete', [PageController::class, 'delete'])->name('pages.delete');
            Route::get('page-restore/{page}', [PageController::class, 'restore'])->name('pages.restore');
        //

        // Albums
            Route::resource('albums', AlbumController::class);
            Route::post('albums/upload', [AlbumController::class, 'upload'])->name('albums.upload');
            Route::delete('many/album', [AlbumController::class, 'destroy_many'])->name('albums.destroy_many');
            Route::put('albums/quick/{album}', [AlbumController::class, 'quick_update'])->name('albums.quick_update');
            Route::post('albums/{album}/restore', [AlbumController::class, 'restore'])->name('albums.restore');
            Route::post('albums/banners/{album}', [AlbumController::class, 'get_album_details'])->name('albums.banners');
        //

        // News
            Route::resource('news', ArticleController::class)->except(['show', 'destroy']);
            Route::get('news-advance-search', [ArticleController::class, 'advance_index'])->name('news.index.advance-search');
            Route::post('news-get-slug', [ArticleController::class, 'get_slug'])->name('news.get-slug');
            Route::post('news-change-status', [ArticleController::class, 'change_status'])->name('news.change.status');
            Route::post('news-delete', [ArticleController::class, 'delete'])->name('news.delete');
            Route::get('news-restore/{news}', [ArticleController::class, 'restore'])->name('news.restore');

            // News Category
            Route::resource('news-categories', ArticleCategoryController::class)->except(['show']);;
            Route::post('news-categories/get-slug', [ArticleCategoryController::class, 'get_slug'])->name('news-categories.get-slug');
            Route::post('news-categories/delete', [ArticleCategoryController::class, 'delete'])->name('news-categories.delete');
            Route::get('news-categories/restore/{id}', [ArticleCategoryController::class, 'restore'])->name('news-categories.restore');
        //

        // File Manager
            Route::get('laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show')->name('file-manager.show');
            Route::post('laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload')->name('unisharp.lfm.upload');
            Route::get('file-manager', [FileManagerController::class, 'index'])->name('file-manager.index');
        //

        // Menu
            Route::resource('menus', MenuController::class);
            Route::delete('many/menu', [MenuController::class, 'destroy_many'])->name('menus.destroy_many');
            Route::put('menus/quick1/{menu}', [MenuController::class, 'quick_update'])->name('menus.quick_update');
            Route::get('menu-restore/{menu}', [MenuController::class, 'restore'])->name('menus.restore');
        //

        // Dentist
            Route::resource('dentists', DentistsController::class);
            Route::post('/dentists/import-dentists', [DentistsController::class, 'import_dentists'])->name('dentists.import');
            Route::post('dentists-delete', [DentistsController::class, 'delete'])->name('dentists.delete');
        //
    });
});


// Pages Frontend
Route::get('/{any}', [FrontController::class, 'page'])->where('any', '.*');