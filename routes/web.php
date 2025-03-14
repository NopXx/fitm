<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentContentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentViewController;
use App\Http\Controllers\HistoricalEventController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\NewsFrontendController;
use App\Http\Controllers\OnlineServiceController;
use App\Http\Controllers\PersonnelAdminController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\SymbolController;
use App\Http\Controllers\VisitorController;
use App\Models\FitmNews;
use App\Models\FitmVideo;
use App\Models\News;
use App\Models\OnlineService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('lang/{locale}', [LangController::class, 'change'])->name('changeLang');

Route::get('locale/{locale}', [MenuController::class, 'changeLocale'])
    ->name('locale.change')
    ->whereIn('locale', ['en', 'th']);


Route::group(['middleware' => 'auth'], function () {
    Route::prefix('admin')->group(function () {
        // News
        Route::resource('new', NewController::class);
        Route::get('news', [NewController::class, 'getNews'])->name('new.getNews');
        Route::get('new/add', [NewController::class, 'show'])->name('new.add');
        Route::post('new/store', [NewController::class, 'store'])->name('news.store');
        Route::post('new/upload', [NewController::class, 'upload'])->name('new.upload');
        Route::delete('new/revert', [NewController::class, 'destroy'])->name('new.revert');
        // edit news
        Route::get('/new/edit/{new}', [NewController::class, 'edit'])->name('new.edit');
        Route::put('/new/update/{new}', [NewController::class, 'update'])->name('new.update');
        Route::delete('/new/delete/{new}', [NewController::class, 'delete'])->name('new.delete');


        // department
        Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
        Route::get('/department/create', [DepartmentController::class, 'createDepartment'])->name('departments.create');
        Route::post('/department/store', [DepartmentController::class, 'store'])->name('departments.store');
        Route::get('/department/edit/{id}', [DepartmentController::class, 'editDepartment'])->name('departments.edit');
        Route::put('/department/update/{id}', [DepartmentController::class, 'updateDepartment'])->name('departments.update');
        Route::delete('/department/delete/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        Route::get('/departments', [DepartmentController::class, 'getDepartments']);

        // Department Content routes
        Route::get('department/{department}/content', [DepartmentContentController::class, 'edit'])
            ->name('departments.content.edit');
        Route::put('department/{department}/content', [DepartmentContentController::class, 'update'])
            ->name('departments.content.update');
        Route::get('department/{department}/content/preview', [DepartmentContentController::class, 'preview'])
            ->name('departments.content.preview');
        // Media routes
        Route::post('media/upload', [MediaController::class, 'upload'])
            ->name('media.upload');
        Route::delete('media/{media}', [MediaController::class, 'destroy'])
            ->name('media.destroy');
        Route::get('media/browse', [MediaController::class, 'browse'])
            ->name('media.browse');

        // Historical Events
        Route::resource('historical-events', HistoricalEventController::class);
        Route::get('/historical-events-data', [HistoricalEventController::class, 'data'])->name('historical-events.data');

        Route::resource('symbols', SymbolController::class);

        Route::resource('menus', MenuController::class);
        Route::post('/menus/update-order', [MenuController::class, 'updateOrder'])->name('admin.menus.updateOrder');
        Route::post('/menus/sync-departments', [MenuController::class, 'syncDepartmentMenus'])
            ->name('admin.menus.sync-departments');

        Route::resource('contents', ContentController::class);
        Route::get('/contents/get-contents', [ContentController::class, 'show']);

        Route::get('online-services', [OnlineServiceController::class, 'index'])->name('online-services.index');
        Route::get('online-services/get-services', [OnlineServiceController::class, 'getServices'])->name('online-services.get-services');
        Route::get('online-services/create', [OnlineServiceController::class, 'create'])->name('online-services.create');
        Route::post('online-services', [OnlineServiceController::class, 'store'])->name('online-services.store');
        Route::get('online-services/{onlineService}/edit', [OnlineServiceController::class, 'edit'])->name('online-services.edit');
        Route::put('online-services/{onlineService}', [OnlineServiceController::class, 'update'])->name('online-services.update');
        Route::delete('online-services/delete/{id}', [OnlineServiceController::class, 'destroy'])->name('online-services.delete');

        // List all news (DataTable AJAX endpoint)
        Route::get('/fitmnews', [App\Http\Controllers\FitmNewsController::class, 'index'])->name('fitmnews.index');
        // Add new form
        Route::get('/fitmnews/add', [App\Http\Controllers\FitmNewsController::class, 'add'])->name('fitmnews.add');
        // Store new record
        Route::post('/fitmnews/store', [App\Http\Controllers\FitmNewsController::class, 'store'])->name('fitmnews.store');
        // Edit form
        Route::get('/fitmnews/edit/{id}', [App\Http\Controllers\FitmNewsController::class, 'edit'])->name('fitmnews.edit');
        // Update record
        Route::put('/fitmnews/update/{id}', [App\Http\Controllers\FitmNewsController::class, 'update'])->name('fitmnews.update');
        // Delete record
        Route::delete('/fitmnews/delete/{id}', [App\Http\Controllers\FitmNewsController::class, 'destroy'])->name('fitmnews.destroy');

        Route::get('/fitmvideos', [App\Http\Controllers\FitmVideosController::class, 'index'])->name('fitmvideos.index');
        Route::get('/fitmvideos/add', [App\Http\Controllers\FitmVideosController::class, 'create'])->name('fitmvideos.add');
        Route::post('/fitmvideos/store', [App\Http\Controllers\FitmVideosController::class, 'store'])->name('fitmvideos.store');
        Route::get('/fitmvideos/edit/{id}', [App\Http\Controllers\FitmVideosController::class, 'edit'])->name('fitmvideos.edit');
        Route::put('/fitmvideos/update/{id}', [App\Http\Controllers\FitmVideosController::class, 'update'])->name('fitmvideos.update');
        Route::delete('/fitmvideos/destroy/{id}', [App\Http\Controllers\FitmVideosController::class, 'destroy'])->name('fitmvideos.destroy');

        // User Management Routes
        Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('users/add', [App\Http\Controllers\UserController::class, 'add'])->name('users.add');
        Route::post('users/store', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('users/edit/{user}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('users/update/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('users/destroy/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/', [VisitorController::class, 'dashboard'])->name('dashboard.index');
        Route::get('/api/visitors/stats', [VisitorController::class, 'apiStats']);
        Route::get('/api/visitors/daily-stats', [VisitorController::class, 'apiDailyStats']);

        Route::get('/boards', [BoardController::class, 'index'])->name('boards.index');
        Route::get('/boards/add', [BoardController::class, 'add'])->name('boards.add');
        Route::post('/boards/store', [BoardController::class, 'store'])->name('boards.store');
        Route::get('/boards/edit/{id}', [BoardController::class, 'edit'])->name('boards.edit');
        Route::put('/boards/update/{id}', [BoardController::class, 'update'])->name('boards.update');
        Route::delete('/boards/destroy/{id}', [BoardController::class, 'destroy'])->name('boards.destroy');

        Route::get('/personnel', [PersonnelAdminController::class, 'index'])->name('personnel.admin.index');
        Route::get('/personnel/add', [PersonnelAdminController::class, 'add'])->name('personnel.admin.add');
        Route::post('/personnel/store', [PersonnelAdminController::class, 'store'])->name('personnel.admin.store');
        Route::get('/personnel/edit/{id}', [PersonnelAdminController::class, 'edit'])->name('personnel.admin.edit');
        Route::put('/personnel/update/{id}', [PersonnelAdminController::class, 'update'])->name('personnel.admin.update');
        Route::delete('/personnel/destroy/{id}', [PersonnelAdminController::class, 'destroy'])->name('personnel.admin.destroy');
    });
});

Route::get('/', function () {
    $news_show = News::where('display_type', 2)->where('status', 1)->get();

    // Get all news types that have at least one active news item
    $newsTypes = News::where('display_type', 1)
        ->where('status', 1)
        ->distinct()
        ->pluck('new_type');

    $news = collect();

    // For each news type, get news items prioritizing important ones
    foreach ($newsTypes as $type) {
        // First get all important news for this type
        $importantNews = News::where('display_type', 1)
            ->where('status', 1)
            ->where('new_type', $type)
            ->where('is_important', true)
            ->orderBy('effective_date', 'desc')
            ->get();

        // If we have more than 8 important news, use all of them
        if ($importantNews->count() > 8) {
            $typeNews = $importantNews;
        } else {
            // Otherwise, get important news + regular news up to 8 total
            $regularNewsCount = 8 - $importantNews->count();

            if ($regularNewsCount > 0) {
                $regularNews = News::where('display_type', 1)
                    ->where('status', 1)
                    ->where('new_type', $type)
                    ->where('is_important', false)
                    ->orderBy('effective_date', 'desc')
                    ->limit($regularNewsCount)
                    ->get();

                $typeNews = $importantNews->concat($regularNews);
            } else {
                $typeNews = $importantNews;
            }
        }

        $news = $news->concat($typeNews);
    }

    $services = OnlineService::where('active', true)
        ->orderBy('order')
        ->get();
    $fitmnews = FitmNews::orderBy('issue_name', 'desc')->get();

    $videos = FitmVideo::orderBy('created_at', 'desc')->get();

    return view('index', compact('news_show', 'news', 'services', 'fitmnews', 'videos'));
});

Route::get('/news/fitmnews', [App\Http\Controllers\FitmNewsController::class, 'index']);

Route::get('departments/{id}', [DepartmentViewController::class, 'index']);

Route::get('history', [HistoricalEventController::class, 'frontend']);

Route::get('symbol', [SymbolController::class, 'frontend']);

Route::get('/contents/{code}', [ContentController::class, 'frontend'])->name('content.show');

Route::post('admin/clear-menu-cache', [MenuController::class, 'clearMenuCache'])
    ->name('admin.clear-menu-cache');

// News routes
Route::get('/news', [NewsFrontendController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsFrontendController::class, 'show'])->name('news.show');

Route::get('/personnel', [PersonnelController::class, 'index'])->name('personnel.index');
Route::get('/personnel/board/{board_id}', [PersonnelController::class, 'showByBoard'])->name('personnel.board');
Route::get('/personnel/{id}', [PersonnelController::class, 'show'])->name('personnel.show');

Route::prefix('template')->group(function () {
    Route::view('index', 'template.index')->name('index');
    Route::view('project_dashboard', 'template.project_dashboard')->name('project_dashboard');
    Route::view('crypto_dashboard', 'template.crypto_dashboard')->name('crypto_dashboard');
    Route::view('education_dashboard', 'template.education_dashboard')->name('education_dashboard');

    Route::view('accordions', 'template.accordions')->name('accordions');
    Route::view('add_blog', 'template.add_blog')->name('add_blog');
    Route::view('add_product', 'template.add_product')->name('add_product');
    Route::view('advance_table', 'template.advance_table')->name('advance_table');
    Route::view('alert', 'template.alert')->name('alert');
    Route::view('alignment', 'template.alignment')->name('alignment');
    Route::view('animated_icon', 'template.animated_icon')->name('animated_icon');
    Route::view('animation', 'template.animation')->name('animation');
    Route::view('api', 'template.api')->name('api');
    Route::view('area_chart', 'template.area_chart')->name('area_chart');
    Route::view('avatar', 'template.avatar')->name('avatar');

    Route::view('background', 'template.background')->name('background');
    Route::view('badges', 'template.badges')->name('badges');
    Route::view('bar_chart', 'template.bar_chart')->name('bar_chart');
    Route::view('base_inputs', 'template.base_inputs')->name('base_inputs');
    Route::view('basic_table', 'template.basic_table')->name('basic_table');
    Route::view('blank', 'template.blank')->name('blank');
    Route::view('block_ui', 'template.block_ui')->name('block_ui');
    Route::view('blog', 'template.blog')->name('blog');
    Route::view('blog_details', 'template.blog_details')->name('blog_details');
    Route::view('bookmark', 'template.bookmark')->name('bookmark');
    Route::view('bootstrap_slider', 'template.bootstrap_slider')->name('bootstrap_slider');
    Route::view('boxplot_chart', 'template.boxplot_chart')->name('boxplot_chart');
    Route::view('bubble_chart', 'template.bubble_chart')->name('bubble_chart');
    Route::view('bullet', 'template.bullet')->name('bullet');
    Route::view('buttons', 'template.buttons')->name('buttons');

    Route::view('calendar', 'template.calendar')->name('calendar');
    Route::view('candlestick_chart', 'template.candlestick_chart')->name('candlestick_chart');
    Route::view('cards', 'template.cards')->name('cards');
    Route::view('cart', 'template.cart')->name('cart');
    Route::view('chart_js', 'template.chart_js')->name('chart_js');
    Route::view('chat', 'template.chat')->name('chat');
    Route::view('cheatsheet', 'template.cheatsheet')->name('cheatsheet');
    Route::view('checkbox_radio', 'template.checkbox_radio')->name('checkbox_radio');
    Route::view('checkout', 'template.checkout')->name('checkout');
    Route::view('clipboard', 'template.clipboard')->name('clipboard');
    Route::view('collapse', 'template.collapse')->name('collapse');
    Route::view('column_chart', 'template.column_chart')->name('column_chart');
    Route::view('coming_soon', 'template.coming_soon')->name('coming_soon');
    Route::view('count_down', 'template.count_down')->name('count_down');
    Route::view('count_up', 'template.count_up')->name('count_up');

    Route::view('data_table', 'template.data_table')->name('data_table');
    Route::view('date_picker', 'template.date_picker')->name('date_picker');
    Route::view('default_forms', 'template.default_forms')->name('default_forms');
    Route::view('divider', 'template.divider')->name('divider');
    Route::view('draggable', 'template.draggable')->name('draggable');
    Route::view('dropdown', 'template.dropdown')->name('dropdown');
    Route::view('dual_list_boxes', 'template.dual_list_boxes')->name('dual_list_boxes');

    Route::view('editor', 'template.editor')->name('editor');
    Route::view('email', 'template.email')->name('email');
    Route::view('error_400', 'template.error_400')->name('error_400');
    Route::view('error_403', 'template.error_403')->name('error_403');
    Route::view('error_404', 'template.error_404')->name('error_404');
    Route::view('error_500', 'template.error_500')->name('error_500');
    Route::view('error_503', 'template.error_503')->name('error_503');

    Route::view('faq', 'template.faq')->name('faq');
    Route::view('file_manager', 'template.file_manager')->name('file_manager');
    Route::view('file_upload', 'template.file_upload')->name('file_upload');
    Route::view('flag_icons', 'template.flag_icons')->name('flag_icons');
    Route::view('floating_labels', 'template.floating_labels')->name('floating_labels');
    Route::view('fontawesome', 'template.fontawesome')->name('fontawesome');
    Route::view('footer_page', 'template.footer_page')->name('footer_page');
    Route::view('form_validation', 'template.form_validation')->name('form_validation');
    Route::view('form_wizard_1', 'template.form_wizard_1')->name('form_wizard_1');
    Route::view('form_wizard_2', 'template.form_wizard_2')->name('form_wizard_2');
    Route::view('form_wizards', 'template.form_wizards')->name('form_wizards');

    Route::view('gallery', 'template.gallery')->name('gallery');
    Route::view('google_map', 'template.google_map')->name('google_map');
    Route::view('grid', 'template.grid')->name('grid');

    Route::view('heatmap', 'template.heatmap')->name('heatmap');
    Route::view('helper_classes', 'template.helper_classes')->name('helper_classes');

    Route::view('iconoir_icon', 'template.iconoir_icon')->name('iconoir_icon');
    Route::view('input_groups', 'template.input_groups')->name('input_groups');
    Route::view('input_masks', 'template.input_masks')->name('input_masks');
    Route::view('invoice', 'template.invoice')->name('invoice');

    Route::view('kanban_board', 'template.kanban_board')->name('kanban_board');

    Route::view('landing', 'template.landing')->name('landing');
    Route::view('leaflet_map', 'template.leaflet_map')->name('leaflet_map');
    Route::view('line_chart', 'template.line_chart')->name('line_chart');
    Route::view('list', 'template.list')->name('list');
    Route::view('list_table', 'template.list_table')->name('list_table');
    Route::view('lock_screen', 'template.lock_screen')->name('lock_screen');
    Route::view('lock_screen_1', 'template.lock_screen_1')->name('lock_screen_1');


    Route::view('maintenance', 'template.maintenance')->name('maintenance');
    Route::view('misc', 'template.misc')->name('misc');
    Route::view('mixed_chart', 'template.mixed_chart')->name('mixed_chart');
    Route::view('modals', 'template.modals')->name('modals');
    Route::view('notifications', 'template.notifications')->name('notifications');

    Route::view('offcanvas', 'template.offcanvas')->name('offcanvas');
    Route::view('orders', 'template.orders')->name('orders');
    Route::view('order_details', 'template.order_details')->name('order_details');
    Route::view('order_list', 'template.order_list')->name('order_list');

    Route::view('password_create_1', 'template.password_create_1')->name('password_create_1');
    Route::view('password_reset_1', 'template.password_reset_1')->name('password_reset_1');
    Route::view('phosphor', 'template.phosphor')->name('phosphor');
    Route::view('pie_charts', 'template.pie_charts')->name('pie_charts');
    Route::view('placeholder', 'template.placeholder')->name('placeholder');
    Route::view('pricing', 'template.pricing')->name('pricing');
    Route::view('prismjs', 'template.prismjs')->name('prismjs');
    Route::view('privacy_policy', 'template.privacy_policy')->name('privacy_policy');
    Route::view('product', 'template.product')->name('product');
    Route::view('product_details', 'template.product_details')->name('product_details');
    Route::view('product_list', 'template.product_list')->name('product_list');
    Route::view('profile', 'template.profile')->name('profile');
    Route::view('progress', 'template.progress')->name('progress');
    Route::view('project_app', 'template.project_app')->name('project_app');
    Route::view('project_details', 'template.project_details')->name('project_details');
    Route::view('password_create', 'template.password_create')->name('password_create');
    Route::view('password_reset', 'template.password_reset')->name('password_reset');

    Route::view('radar_chart', 'template.radar_chart')->name('radar_chart');
    Route::view('radial_bar_chart', 'template.radial_bar_chart')->name('radial_bar_chart');
    Route::view('range_slider', 'template.range_slider')->name('range_slider');
    Route::view('ratings', 'template.ratings')->name('ratings');
    Route::view('read_email', 'template.read_email')->name('read_email');
    Route::view('ready_to_use_form', 'template.ready_to_use_form')->name('ready_to_use_form');
    Route::view('ready_to_use_table', 'template.ready_to_use_table')->name('ready_to_use_table');
    Route::view('ribbons', 'template.ribbons')->name('ribbons');

    Route::view('scatter_chart', 'template.scatter_chart')->name('scatter_chart');
    Route::view('scrollbar', 'template.scrollbar')->name('scrollbar');
    Route::view('scrollpy', 'template.scrollpy')->name('scrollpy');
    Route::view('select', 'template.select')->name('select');
    Route::view('setting', 'template.setting')->name('setting');
    Route::view('shadow', 'template.shadow')->name('shadow');
    Route::view('sign_in', 'template.sign_in')->name('sign_in');
    Route::view('sign_in_1', 'template.sign_in_1')->name('sign_in_1');
    Route::view('sign_up', 'template.sign_up')->name('sign_up');
    Route::view('sign_up_1', 'template.sign_up_1')->name('sign_up_1');
    Route::view('sitemap', 'template.sitemap')->name('sitemap');
    Route::view('slick_slider', 'template.slick_slider')->name('slick_slider');
    Route::view('spinners', 'template.spinners')->name('spinners');
    Route::view('sweetalert', 'template.sweetalert')->name('sweetalert');
    Route::view('switch', 'template.switch')->name('switch');

    Route::view('tabler_icons', 'template.tabler_icons')->name('tabler_icons');
    Route::view('tabs', 'template.tabs')->name('tabs');
    Route::view('team', 'template.team')->name('team');
    Route::view('terms_condition', 'template.terms_condition')->name('terms_condition');
    Route::view('textarea', 'template.textarea')->name('textarea');
    Route::view('ticket', 'template.ticket')->name('ticket');
    Route::view('ticket_details', 'template.ticket_details')->name('ticket_details');
    Route::view('timeline', 'template.timeline')->name('timeline');
    Route::view('timeline_range_charts', 'template.timeline_range_charts')->name('timeline_range_charts');
    Route::view('to_do', 'template.to_do')->name('to_do');
    Route::view('tooltips_popovers', 'template.tooltips_popovers')->name('tooltips_popovers');
    Route::view('touch_spin', 'template.touch_spin')->name('touch_spin');
    Route::view('tour', 'template.tour')->name('tour');
    Route::view('tree-view', 'template.tree-view')->name('tree-view');
    Route::view('treemap_chart', 'template.treemap_chart')->name('treemap_chart');
    Route::view('two_step_verification', 'template.two_step_verification')->name('two_step_verification');
    Route::view('two_step_verification_1', 'template.two_step_verification_1')->name('two_step_verification_1');
    Route::view('typeahead', 'template.typeahead')->name('typeahead');

    Route::view('vector_map', 'template.vector_map')->name('vector_map');
    Route::view('video_embed', 'template.video_embed')->name('video_embed');
    Route::view('weather_icon', 'template.weather_icon')->name('weather_icon');
    Route::view('widget', 'template.widget')->name('widget');
    Route::view('wishlist', 'template.wishlist')->name('wishlist');
    Route::view('wrapper', 'template.wrapper')->name('wrapper');
});
