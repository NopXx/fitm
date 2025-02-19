<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\MenuCategory;
use App\Models\MenuDisplaySetting;
use App\Models\MenuTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index()
    {
        $menus = MenuCategory::with(['translations', 'displaySetting', 'children.translations'])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $departments = Departments::with('content')->get();
        // Log::debug($departments);

        return view('menus.index', compact('menus', 'departments'));
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
            $departments = Departments::with('content')->get();

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
                $englishName = $department->content->department_name_en ?? $department->department_name_th;
                MenuTranslation::updateOrCreate(
                    [
                        'category_id' => $menuItem->id,  // Changed from menu_category_id
                        'language_code' => 'en'
                    ],
                    [
                        'name' => $englishName,
                        'url' => '/en/departments/' . $department->department_code
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
        return view('menus.form', compact('mainMenus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'url_th' => 'required|string|max:255',
            'url_en' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_categories,id'
        ]);

        try {
            DB::beginTransaction();

            $maxOrder = MenuCategory::where('parent_id', $request->parent_id)
                ->max('sort_order') ?? 0;

            $menu = MenuCategory::create([
                'parent_id' => $request->parent_id,
                'sort_order' => $maxOrder + 1,
                'is_active' => true
            ]);

            // Create translations
            $menu->translations()->createMany([
                [
                    'language_code' => 'th',
                    'name' => $request->name_th,
                    'url' => $request->url_th
                ],
                [
                    'language_code' => 'en',
                    'name' => $request->name_en,
                    'url' => $request->url_en
                ]
            ]);

            // Create display settings
            $menu->displaySetting()->create([
                'is_visible' => true,
                'show_dropdown' => false
            ]);

            DB::commit();
            return redirect()->route('admin.menus.index')
                ->with('success', __('menu.created_successfully'));
        } catch (\Exception $e) {
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
        return view('menus.form', compact('menu', 'mainMenus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'url_th' => 'required|string|max:255',
            'url_en' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_categories,id'
        ]);

        try {
            DB::beginTransaction();

            $menu = MenuCategory::findOrFail($id);

            // Update menu category
            $menu->update([
                'parent_id' => $request->parent_id,
                'is_active' => $request->boolean('is_active', true)
            ]);

            // Update translations
            foreach (['th', 'en'] as $lang) {
                $menu->translations()
                    ->where('language_code', $lang)
                    ->update([
                        'name' => $request->{"name_$lang"},
                        'url' => $request->{"url_$lang"}
                    ]);
            }

            DB::commit();
            return redirect()->route('admin.menus.index')
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

        return response()->json(['success' => true]);
    }
}
