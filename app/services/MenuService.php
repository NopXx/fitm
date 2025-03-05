<?php

namespace App\Services;

use App\Models\MenuCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class MenuService
{
    /**
     * Get menus from cache or database
     */
    public function getMenus(): Collection
    {
        $locale = App::getLocale();

        return Cache::remember(
            key: "menu_data_{$locale}",
            ttl: now()->addMinutes(5),
            callback: fn() => $this->fetchMenusFromDatabase()
        );
    }

    /**
     * Fetch fresh menu data from database - fixed to avoid duplicate ORDER BY
     */
    protected function fetchMenusFromDatabase(): Collection
    {
        return MenuCategory::query()
            ->with([
                'translations',
                'displaySetting',
                // Explicit loading of children without chaining methods that might add duplicate ordering
                'children' => function ($query) {
                    $query->where('is_active', true)
                          ->select('*')  // Explicit select to avoid inheriting previous ordering
                          ->orderByRaw('sort_order ASC'); // Use orderByRaw for more control
                },
                'children.translations',
                'children.displaySetting'
            ])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Update menu order
     */
    public function updateOrder(array $items): void
    {
        foreach ($items as $index => $item) {
            MenuCategory::where('id', $item['id'])->update([
                'sort_order' => $index + 1
            ]);

            if (!empty($item['children'])) {
                foreach ($item['children'] as $childIndex => $child) {
                    MenuCategory::where('id', $child['id'])->update([
                        'parent_id' => $item['id'],
                        'sort_order' => $childIndex + 1
                    ]);
                }
            }
        }

        $this->clearMenuCache();
    }

    /**
     * Clear menu cache for configured locales
     */
    public function clearMenuCache(): void
    {
        collect([
            config('app.locale', 'th'),
            config('app.fallback_locale', 'en')
        ])->each(
            fn($locale) => Cache::delete("menu_data_{$locale}")
        );
    }

    public function getAdminMenu()
    {
        return Cache::remember('admin_menu', 86400, function () {
            // Use a different query approach to avoid duplicate ordering
            $query = MenuCategory::query()
                ->with([
                    'translations',
                    'displaySetting',
                    // No ordering in relationship definitions
                    'children',
                    'children.translations',
                    'children.displaySetting'
                ])
                ->whereNull('parent_id');

            // Add explicit ordering only once
            return $query->orderBy('sort_order')->get();
        });
    }
}
