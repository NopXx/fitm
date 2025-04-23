<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Departments;
use App\Models\MenuCategory;
use App\Models\MenuDisplaySetting;
use App\Models\MenuTranslation;
use App\Services\MenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class MenuController extends Controller
{

    public function __construct(
        protected MenuService $menuService
    ) {}

    public function changeLocale(string $locale): RedirectResponse
    {
        if (in_array($locale, [config('app.locale'), config('app.fallback_locale')])) {
            App::setLocale($locale);
            session()->put('locale', $locale);
            $this->menuService->clearMenuCache();
        }

        return back();
    }

    public function clearMenuCache(): JsonResponse
    {
        $this->menuService->clearMenuCache();

        return response()->json([
            'message' => 'Menu cache cleared successfully'
        ]);
    }

    public function updateOrder12(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_categories,id',
            'items.*.children' => 'array',
            'items.*.children.*.id' => 'exists:menu_categories,id'
        ]);

        $this->updateOrder12($request->items);

        return response()->json(['message' => 'Menu order updated successfully']);
    }

    public function index()
    {
        // Use menuService to get all menus including inactive ones
        $menu1 = MenuCategory::with(['translations', 'displaySetting', 'children.translations'])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
        $departments = Departments::with('content')->get();

        return view('menus.index', compact('menu1', 'departments'));
    }

    public function syncDepartmentMenus()
    {
        try {
            DB::beginTransaction();

            // Create or find main department menu
            $mainMenu = MenuCategory::firstOrCreate(
                ['system_name' => 'departments'],
                [
                    'parent_id' => null,
                    'sort_order' => 1,
                    'is_active' => true
                ]
            );

            // Create or update main menu translations
            MenuTranslation::updateOrCreate(
                [
                    'category_id' => $mainMenu->id,  // Changed from menu_category_id
                    'language_code' => 'th'
                ],
                [
                    'name' => 'ภาควิชา/หน่วยงาน',
                    'url' => '#'
                ]
            );

            MenuTranslation::updateOrCreate(
                [
                    'category_id' => $mainMenu->id,  // Changed from menu_category_id
                    'language_code' => 'en'
                ],
                [
                    'name' => 'Departments',
                    'url' => '#'
                ]
            );

            // Create or update main menu display settings
            MenuDisplaySetting::updateOrCreate(
                ['category_id' => $mainMenu->id],  // Changed from menu_category_id
                [
                    'is_visible' => true,
                    'show_dropdown' => true
                ]
            );

            // Get all departments
            $departments = Departments::get();

            foreach ($departments as $index => $department) {
                // Create or update department menu
                $menuItem = MenuCategory::updateOrCreate(
                    ['system_name' => 'dept_' . $department->department_code],
                    [
                        'parent_id' => $mainMenu->id,
                        'sort_order' => $index + 1,
                        'is_active' => true
                    ]
                );

                // Create or update translations
                MenuTranslation::updateOrCreate(
                    [
                        'category_id' => $menuItem->id,  // Changed from menu_category_id
                        'language_code' => 'th'
                    ],
                    [
                        'name' => $department->department_name_th,
                        'url' => '/departments/' . $department->department_code
                    ]
                );

                // English translation
                $englishName = $department->department_name_en ?? $department->department_name_th;
                MenuTranslation::updateOrCreate(
                    [
                        'category_id' => $menuItem->id,  // Changed from menu_category_id
                        'language_code' => 'en'
                    ],
                    [
                        'name' => $englishName,
                        'url' => '/departments/' . $department->department_code
                    ]
                );

                // Create or update display settings
                MenuDisplaySetting::updateOrCreate(
                    ['category_id' => $menuItem->id],  // Changed from menu_category_id
                    [
                        'is_visible' => true,
                        'show_dropdown' => false
                    ]
                );
            }

            DB::commit();
            return redirect()->route('menus.index')
                ->with('success', 'Menu synchronized successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Menu sync failed: ' . $e->getMessage());
            return redirect()->route('menus.index')
                ->with('error', 'Failed to sync menus. Error: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $mainMenus = MenuCategory::whereNull('parent_id')
            ->with('translations')
            ->get();

        $contents = Content::all();
        $url = MenuTranslation::select(['url'])->get();
        return view('menus.form', compact('mainMenus', 'contents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_categories,id',
            'show_dropdown' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Calculate the max sort order for the new menu
            $maxOrder = 0;
            if ($request->parent_id) {
                // If this is a submenu, get the max sort_order under the parent
                $maxOrder = MenuCategory::where('parent_id', $request->parent_id)
                    ->max('sort_order') ?? 0;
            } else {
                // If this is a main menu, get the max sort_order for main menus
                $maxOrder = MenuCategory::whereNull('parent_id')
                    ->max('sort_order') ?? 0;
            }

            // สร้างเมนู
            $menu = MenuCategory::create([
                'parent_id' => $request->parent_id,
                'sort_order' => $maxOrder + 1,
                'is_active' => true
            ]);

            // สร้าง translations - Updated for single URL
            $url = $request->url;
            $menu->translations()->createMany([
                [
                    'language_code' => 'th',
                    'name' => $request->name_th,
                    'url' => $url
                ],
                [
                    'language_code' => 'en',
                    'name' => $request->name_en,
                    'url' => $url
                ]
            ]);

            // กำหนด show_dropdown = false ถ้าเป็นเมนูย่อย
            $menu->displaySetting()->create([
                'is_visible' => true,
                'show_dropdown' => !$request->parent_id && $request->has('show_dropdown')
            ]);

            DB::commit();
            $this->menuService->clearMenuCache();
            return redirect()->route('menus.index')
                ->with('success', __('menu.created_successfully'));
        } catch (\Exception $e) {
            Log::debug($e);
            DB::rollBack();
            return back()->with('error', __('menu.creation_failed'));
        }
    }

    public function edit($id)
    {
        $menu = MenuCategory::with(['translations', 'displaySetting'])
            ->findOrFail($id);
        $mainMenus = MenuCategory::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->with('translations')
            ->get();
        $contents = Content::all();
        $url = MenuTranslation::select(['url'])->get();
        return view('menus.form', compact('menu', 'mainMenus', 'contents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_categories,id',
            'show_dropdown' => 'boolean',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $menu = MenuCategory::findOrFail($id);

            // อัพเดทเมนู - Fix for is_active checkbox
            $menu->update([
                'parent_id' => $request->parent_id,
                'is_active' => $request->has('is_active')
            ]);

            // อัพเดท translations - Updated for single URL
            $url = $request->url;
            foreach (['th', 'en'] as $lang) {
                $urlWithPrefix = $lang === 'en' ? $url : $url;

                $menu->translations()
                    ->where('language_code', $lang)
                    ->update([
                        'name' => $request->{"name_$lang"},
                        'url' => $urlWithPrefix
                    ]);
            }

            // กำหนด show_dropdown = false ถ้าเป็นเมนูย่อย
            $menu->displaySetting()->updateOrCreate(
                ['category_id' => $menu->id],
                [
                    'is_visible' => true,
                    'show_dropdown' => !$request->parent_id && $request->has('show_dropdown')
                ]
            );

            DB::commit();
            $this->menuService->clearMenuCache();
            return redirect()->route('menus.index')
                ->with('success', __('menu.updated_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('menu.update_failed'));
        }
    }

    public function destroy($id)
    {
        try {
            $menu = MenuCategory::findOrFail($id);
            $menu->delete();
            $this->menuService->clearMenuCache();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function updateOrder(Request $request)
    {
        $items = $request->input('items', []);
        $parentId = $request->input('parent_id');
        $isMainMenu = $request->input('is_main_menu', false);

        if ($isMainMenu) {
            // Update main menu order
            foreach ($items as $order => $itemId) {
                MenuCategory::where('id', $itemId)->update([
                    'sort_order' => $order
                ]);
            }
        } else {
            // Update submenu order and parent
            foreach ($items as $order => $itemId) {
                MenuCategory::where('id', $itemId)->update([
                    'parent_id' => $parentId ?: null,
                    'sort_order' => $order
                ]);
            }
        }
        $this->menuService->clearMenuCache();

        return response()->json(['success' => true]);
    }
}
