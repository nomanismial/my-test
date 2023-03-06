<?php

use App\Models\Admin;
use \Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\CmsController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\AdminAjaxController;
use App\Http\Controllers\GeneralsettingController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Http\Controllers\HomeContoller;

ini_set("session.cookie_secure", 1);

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

//Admin Routes
    if (Schema::hasTable('blogs')) {
        $admin   = Admin::first();
        $admin   = (isset($admin->slug)) ? _decrypt($admin->slug) : "";
    } else {
        $admin   = "";
    }
    $desktop = Agent::isDesktop();
    $num = 1;
    if (!defined('admin')) define('admin', $admin);
    if (!defined('desktop')) define('desktop', $desktop);
    if (!defined('num')) define('num', $num);

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::match(["get","post"],'/'. admin , [AdminController::class , 'index'])->name('admin')->middleware('guest:admin');
Route::get('logs', [LogViewerController::class, 'index']);

Route::group(['prefix' => admin , 'middleware' => ['auth:admin']], function () {

    Route::match(["get","post"],    '/general-setting',   [GeneralsettingController::class])->name("general-setting");
    Route::patch('/general-setting',                      [GeneralsettingController::class,  'store']);
    Route::match(["get","post"],    '/menu',              [GeneralsettingController::class,  'menu'])->name("menu");
    Route::match(["get","post"],    '/theme-setting',     [GeneralsettingController::class,  'theme'])->name("theme-setting");
    Route::match(["get","post"],    '/homepage',          [HomeContoller::class, 'homemeta']);
    Route::match(["get","post"],    '/footer',            [HomeContoller::class, 'footer']);
    Route::match(["get","post"],    '/edit-emails',       [AdminController::class,  'edit_emails']);
    Route::match(["get","post"],    '/login-info',        [AdminController::class,  'logininfo'])->name("login-info");
    Route::match(["get","post"],    '/sorting',           [AdminController::class,  '_sorting']);
    Route::match(["get","post"],    '/internal-links',    [AdminController::class,  'internal_links']);
    Route::match(["get","post"],    '/sidebar-settings',  [AdminController::class,  'sidebar_settings']);
    Route::match(["get","post"],    '/blogs',             [BlogsController::class,  'addBlogsSave'])->name('save-blog');
    Route::match(["get","post"],    '/blogs/meta',        [BlogsController::class,  'meta']);
    Route::match(["get","post"],    '/blogs/category',    [BlogsController::class,  'blogCategory']);
    Route::match(["get","post"],    '/blogs/cats-store',  [BlogsController::class,  'catsStore']);
    Route::match(["get","post"],    '/add-author',        [AuthorsController::class,  'addAuthor'])->name('add-author');
    Route::get('/authors-list',                           [AuthorsController::class,  'authorsList'])->name('authors-list');
    Route::post('/category/order',                        [BlogsController::class,  'catsorder'])->name('category-order');
    Route::get('/logout',                                 [AdminController::class,  'logout']);
    Route::post('/multiEmail',                            [AdminController::class,  'multiEmails']);
    Route::get('/send-email',                             [AdminController::class,  'send_email']);
    Route::get('/emails',                                 [AdminController::class,  'emails']);
    Route::get('/log-book',                               [AdminController::class,  'logBook']);
    Route::get('/dashboard',                              [AdminController::class,  'dashboard'])->name("dashboard");
    Route::get('/blogs/list-data',                        [BlogsController::class,  'blogsListData'])->name('list-data');
    Route::get('/blogs/list',                             [BlogsController::class,  'blogsList'])->name('blogsList');

    // CMS ROUTES

    Route::match(["get","post"],  '/privacy-policy', [CmsController::class,  'privacy'])->name('privacy');
    Route::match(["get","post"],  '/about',          [CmsController::class,  'about'])->name('about');
    Route::match(["get","post"],  '/write-us',       [CmsController::class,  'writeUs'])->name('write-us');
    Route::match(["get","post"],  '/terms-condition',[CmsController::class,  'faqs'])->name('admin-faqs"');
    Route::match(["get","post"],  '/faqs',           [CmsController::class,  'privacy'])->name('privacy');
    Route::match(["get","post"],  '/faqs',           [CmsController::class,  'privacy'])->name('privacy');
    Route::match(["get","post"],  '/contactus',      [CmsController::class,  'ContactUs'])->name("contactus");
    Route::match(["get","post"],  '/ads',            [AdsController::class])->name("ads");
    Route::match(["get","post"],  '/ga-ads',         [AdsController::class, '_gaAdv'])->name("ga-adv");
    Route::get('/faqs-list',                         [CmsController::class,  'allfaqs']);
    Route::post('/faqs/store',                       [CmsController::class,  'faqsstore']);
    Route::post('/faqs/order',                       [CmsController::class,  'faqsorder']);
    Route::post('/get_views',                        [AdminAjaxController::class,  'get_views']);
    Route::post('/get-internal-links',               [AdminAjaxController::class,  'get_internalLinks']);
    Route::get('/image-crop',                        [AdminAjaxController::class,  'Croppie'])->name("cropie");

});


    // Clear route cache
    Route::get('/route-cache', function () {
        $exitCode = Artisan::call('route:cache');
        return 'Routes cache cleared successfully';
    });

    // Clear config cache
    Route::get('/config-cache', function () {
        $exitCode = Artisan::call('config:cache');
        return 'Config cache cleared successfully';
    });

    // Clear application cache
    Route::get('/clear-cache', function () {
        $exitCode = Artisan::call('cache:clear');
        return 'Application cache cleared successfully';
    });

    // Clear view cache
    Route::get('/view-clear', function () {
        $exitCode = Artisan::call('view:clear');
        return 'View cache cleared successfully';
    });
    // Clear all cache with a single function
    Route::get('/optimize-clear', function () {
        $exitCode = Artisan::call('optimize:clear');
        return 'Application cache cleared successfully';
    });

//Front Routes
Route::group(["namespace" => "\App\Http\Controllers"], function () {
    Route::get('/', 'MainController@index')->name("HomeUrl");
    Route::get('/contact-us', 'MainController@_contact')->name('contact-us');
    Route::get('/privacy-policy', 'MainController@privacy')->name("privacy-policy");
    Route::get('/about', 'MainController@about')->name("about-us");
    Route::get('/write-for-us', 'MainController@WriteForUs')->name("write-for-us");
    Route::get('/terms-conditions', 'MainController@terms')->name("terms-conditions");
    Route::post('/contactform', 'AjaxController@contactform');
    Route::get('/faqs', 'MainController@_faqs')->name("faqs");
    Route::post('/subscriber', 'AjaxController@subscriber');
    Route::get('/search', 'MainController@search')->name("search");
    Route::get('/404', 'MainController@notFound');
    Route::get('sitemap.xml', 'SitemapController@_show');
    Route::get('images/sitemap.xml', 'SitemapController@_showimages');
    Route::post('/more-post', 'MainController@more_post')->name('more-post');
    Route::match(["get", "post"], '/email-get', 'AjaxController@_emailGet');

    Route::get('/{url}', function ($url) {
        $last_id = get_postid("last_id");
        $page_id = get_postid("page_id");
        $full    = get_postid("full");
        $seg     = request()->segment(1);
        if (is_numeric($last_id) and $seg != "404") {
            if ($page_id == 1 or $page_id == 2) {
                return (new \App\Http\Controllers\MainController())->single();
            } else {
                return redirect("/404", 301);
            }
        } else {
            return redirect("/404", 301);
        }
    });
});
