<?php

namespace App\Http\Controllers;

use App\Models\FitmNews;
use App\Models\News;
use App\Models\NewType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsFrontendController extends Controller
{
    /**
     * Display a listing of the news.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get current locale
        $lang = app()->getLocale();

        // Get the structure of both tables to ensure we're only selecting columns that exist
        $fitmNewsColumns = $this->getTableColumns('fitm_news');
        $newsColumns = $this->getTableColumns('news');

        // Build queries based on existing columns
        $fitmNewsQuery = $this->buildFitmNewsQuery($fitmNewsColumns, $lang);
        $regularNewsQuery = $this->buildRegularNewsQuery($newsColumns, $lang);

        // Get important news for the hero carousel
        $importantNewsQuery = clone $regularNewsQuery;
        $importantNews = [];

        // Check if is_important column exists in the news table
        if (in_array('is_important', $newsColumns)) {
            $importantNews = $importantNewsQuery->where('is_important', true)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Paginate each news type separately
        $fitmNews = $fitmNewsQuery->paginate(8, ['*'], 'fitm_page');
        $regularNews = $regularNewsQuery->paginate(8, ['*'], 'regular_page');

        // Get the news type and issue data for filters
        $newsTypes = NewType::all();
        $issues = FitmNews::distinct()->pluck('issue_name')->filter()->values();

        // Get featured news (most recent fitm news by issue_name)
        $featuredNews = FitmNews::orderBy('issue_name', 'DESC')->first();

        // Add source information to featured news if needed
        if ($featuredNews) {
            $featuredNews->source = 'fitm';
        }

        return view('news.frontend', compact(
            'fitmNews',
            'regularNews',
            'newsTypes',
            'issues',
            'featuredNews',
            'importantNews',
            'lang'
        ));
    }

    /**
     * Display the specified news.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        // Get current locale
        $lang = app()->getLocale();

        // Only for regular news, as FITM news will open URL directly
        $news = News::with('new_type')->find($id);

        if (!$news) {
            abort(404);
        }

        $source = 'regular';

        // Get related news (same type)
        $relatedNews = News::where('id', '!=', $id)
            ->where('new_type', $news->new_type)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('news.detail', compact('news', 'source', 'relatedNews', 'lang'));
    }

    /**
     * Get all column names for a table
     *
     * @param string $table
     * @return array
     */
    private function getTableColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }

    /**
     * Build query for FitmNews with only existing columns
     *
     * @param array $columns
     * @param string $lang Current locale (en/th)
     * @return \Illuminate\Database\Query\Builder
     */
    private function buildFitmNewsQuery($columns, $lang = 'th')
    {
        $query = FitmNews::query();

        // Filter out news items that don't have content in current language
        if (in_array('title_' . $lang, $columns)) {
            $query->whereNotNull('title_' . $lang);
            $query->where('title_' . $lang, '!=', '');
        }

        // Select ID
        $query->addSelect('id');

        // Select the appropriate title based on locale
        if (in_array('title_' . $lang, $columns)) {
            $query->addSelect('title_' . $lang . ' as title');
        } elseif (in_array('title', $columns)) {
            // Only use generic title if it exists
            $query->addSelect('title');
        } else {
            // No fallback to other language, just set NULL
            $query->addSelect(DB::raw('NULL as title'));
        }

        // Handle published date
        if (in_array('published_date', $columns)) {
            // We'll select it as a string to avoid DateTime conversion issues
            $query->addSelect(DB::raw('DATE_FORMAT(published_date, "%Y-%m-%d") as published_date'));
        } else {
            if (in_array('effective_date', $columns)) {
                $query->addSelect(DB::raw('DATE_FORMAT(effective_date, "%Y-%m-%d") as published_date'));
            } else {
                $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as published_date'));
            }
        }

        // Handle cover image
        if (in_array('cover_image', $columns)) {
            $query->addSelect('cover_image');
        } else {
            $query->addSelect(DB::raw('NULL as cover_image'));
        }

        // Handle description based on locale
        if (in_array('description_' . $lang, $columns)) {
            $query->addSelect('description_' . $lang . ' as description');
        } elseif (in_array('detail_' . $lang, $columns)) {
            $query->addSelect('detail_' . $lang . ' as description');
        } elseif (in_array('description', $columns)) {
            // Only use generic description if it exists
            $query->addSelect('description');
        } elseif (in_array('detail', $columns)) {
            // Only use generic detail if it exists
            $query->addSelect('detail as description');
        } else {
            // No fallback to other language, just set NULL
            $query->addSelect(DB::raw('NULL as description'));
        }

        // Handle issue name
        if (in_array('issue_name', $columns)) {
            $query->addSelect('issue_name');
        } else {
            $query->addSelect(DB::raw('NULL as issue_name'));
        }

        // Handle URL
        if (in_array('url', $columns)) {
            $query->addSelect('url');
        } else {
            $query->addSelect(DB::raw('NULL as url'));
        }

        // Add is_featured if it exists
        if (in_array('is_featured', $columns)) {
            $query->addSelect('is_featured');
        } else {
            $query->addSelect(DB::raw('false as is_featured'));
        }

        $query->addSelect(DB::raw('NULL as new_type'));
        $query->addSelect(DB::raw("'fitm' as source"));

        return $query->orderBy('issue_name', 'DESC');
    }

    /**
     * Build query for News with only existing columns
     *
     * @param array $columns
     * @param string $lang Current locale (en/th)
     * @return \Illuminate\Database\Query\Builder
     */
    private function buildRegularNewsQuery($columns, $lang = 'th')
    {
        $query = News::query();

        // Filter out news items that don't have content in current language
        if (in_array('title_' . $lang, $columns)) {
            $query->whereNotNull('title_' . $lang);
            $query->where('title_' . $lang, '!=', '');
        }

        // Select ID
        $query->addSelect('id');

        // Select the appropriate title based on locale
        if (in_array('title_' . $lang, $columns)) {
            $query->addSelect('title_' . $lang . ' as title');
        } elseif (in_array('title', $columns)) {
            // Only use generic title if it exists
            $query->addSelect('title');
        } else {
            // No fallback to other language, just set NULL
            $query->addSelect(DB::raw('NULL as title'));
        }

        // Handle published date
        $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as published_date'));

        // Handle cover image
        if (in_array('cover', $columns)) {
            $query->addSelect('cover as cover_image');
        } else {
            $query->addSelect(DB::raw('NULL as cover_image'));
        }

        // Handle description based on locale
        if (in_array('detail_' . $lang, $columns)) {
            $query->addSelect('detail_' . $lang . ' as description');
        } elseif (in_array('description_' . $lang, $columns)) {
            $query->addSelect('description_' . $lang . ' as description');
        } elseif (in_array('detail', $columns)) {
            // Only use generic detail if it exists
            $query->addSelect('detail as description');
        } elseif (in_array('description', $columns)) {
            // Only use generic description if it exists
            $query->addSelect('description');
        } else {
            // No fallback to other language, just set NULL
            $query->addSelect(DB::raw('NULL as description'));
        }

        // Handle news type
        if (in_array('new_type', $columns)) {
            $query->addSelect('new_type');
        } else {
            $query->addSelect(DB::raw('NULL as new_type'));
        }

        // Handle content based on locale
        if (in_array('content_' . $lang, $columns)) {
            $query->addSelect('content_' . $lang . ' as content');
        } elseif (in_array('content', $columns)) {
            // Only use generic content if it exists
            $query->addSelect('content');
        } else {
            // No fallback to other language, just set NULL
            $query->addSelect(DB::raw('NULL as content'));
        }

        // Handle URL field
        if (in_array('url', $columns)) {
            $query->addSelect('url');
        } elseif (in_array('link', $columns)) {
            $query->addSelect('link as url');
        } else {
            $query->addSelect(DB::raw('NULL as url'));
        }

        // Add is_important field if it exists
        if (in_array('is_important', $columns)) {
            $query->addSelect('is_important');
        } else {
            $query->addSelect(DB::raw('false as is_important'));
        }

        $query->addSelect(DB::raw('NULL as issue_name'));
        $query->addSelect(DB::raw("'regular' as source"));

        // Filter by display_type if it exists
        if (in_array('display_type', $columns)) {
            $query->where('display_type', 1);
        }

        return $query->orderBy('created_at', 'desc');
    }
}