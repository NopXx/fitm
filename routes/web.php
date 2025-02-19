<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentContentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HistoricalEventController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\SymbolController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('template.index');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('lang/{locale}', [LangController::class, 'change'])->name('changeLang');


Route::group(['middleware' => 'auth'], function () {
    Route::prefix('admin')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

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

        // department
        Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
        Route::get('/department/create', [DepartmentController::class, 'createDepartment'])->name('departments.create');
        Route::post('/department/store', [DepartmentController::class, 'store'])->name('departments.store');
        Route::get('/department/edit/{id}', [DepartmentController::class, 'editDepartment'])->name('departments.edit');
        Route::put('/department/update/{id}', [DepartmentController::class, 'updateDepartment'])->name('departments.update');
        Route::delete('/department/delete/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        Route::get('/departments', [DepartmentController::class, 'getDepartments']);

        // Department Content routes
        Route::get('{department}/content', [DepartmentContentController::class, 'edit'])
            ->name('departments.content.edit');
        Route::put('{department}/content', [DepartmentContentController::class, 'update'])
            ->name('departments.content.update');
        Route::get('{department}/content/preview', [DepartmentContentController::class, 'preview'])
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
    });
});

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
