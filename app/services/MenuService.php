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
     * Fetch fresh menu data from database
     */
    protected function fetchMenusFromDatabase(): Collection
    {
        return MenuCategory::query()
            ->with([
                'translations',
                'displaySetting',
                'children' => function ($query) {
                    $query->orderBy('sort_order')
                        ->where('is_active', true);
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
            return MenuCategory::with(['translations', 'displaySetting', 'children.translations', 'children.displaySetting'])
                ->whereNull('parent_id')
                ->orderBy('sort_order')
                ->get();
            // No filtering of children - we want to see all menus in admin
        });
    }
}
