<?php

namespace App\Http\Controllers;

use App\Models\FitmNews;
use App\Models\News;
use App\Models\NewType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsFrontendController extends Controller
{
    /**
     * Display a listing of the news.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
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

        // Apply news type filter if provided
        $newTypeFilter = $request->get('new_type');
        if ($newTypeFilter) {
            $regularNewsQuery = $regularNewsQuery->where('new_type', $newTypeFilter);
        }

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

        // Paginate each news type separately with proper query string preservation
        $fitmNews = $fitmNewsQuery->paginate(8, ['*'], 'fitm_page');

        // For regular news, preserve all query parameters in pagination
        $regularNews = $regularNewsQuery->paginate(8, ['*'], 'regular_page');

        // Preserve query parameters for pagination links
        $fitmNews->appends($request->except('fitm_page'));
        $regularNews->appends($request->except('regular_page'));

        $debugQuery = clone $regularNewsQuery;
        $debugResults = $debugQuery->limit(5)->get();
        Log::debug('Regular News Debug:', $debugResults->toArray());

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'regularNews' => $this->formatNewsForJson($regularNews->items(), $lang),
                'pagination' => $regularNews->links()->render(),
                'totalItems' => $regularNews->total(),
                'currentPage' => $regularNews->currentPage(),
                'lastPage' => $regularNews->lastPage(),
                'queryParams' => $request->except(['regular_page', 'fitm_page']) // Send current filters to frontend
            ]);
        }

        // Get the news type and issue data for filters
        $newsTypes = NewType::all();
        $issues = $fitmNewsQuery->pluck('issue_name')->filter()->values();

        // Get featured news (most recent fitm news by issue_name)
        $featuredNews = $fitmNewsQuery->first();

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
     * Format news data for JSON response
     *
     * @param array $newsItems
     * @param string $lang
     * @return array
     */
    private function formatNewsForJson($newsItems, $lang = 'th')
    {
        return collect($newsItems)->map(function ($item) use ($lang) {
            // Handle title based on language with multiple fallbacks
            $title = '';

            // First try the language-specific column
            if (isset($item->{'title_' . $lang}) && !empty($item->{'title_' . $lang})) {
                $title = $item->{'title_' . $lang};
            }
            // Then try the opposite language as fallback
            elseif ($lang === 'th' && isset($item->title_en) && !empty($item->title_en)) {
                $title = $item->title_en;
            } elseif ($lang === 'en' && isset($item->title_th) && !empty($item->title_th)) {
                $title = $item->title_th;
            }
            // Finally try the generic title column
            elseif (isset($item->title) && !empty($item->title)) {
                $title = $item->title;
            }

            // Handle description based on language with multiple fallbacks
            $description = '';

            // First try the language-specific description column
            if (isset($item->{'description_' . $lang}) && !empty($item->{'description_' . $lang})) {
                $description = $item->{'description_' . $lang};
            }
            // Then try the language-specific detail column
            elseif (isset($item->{'detail_' . $lang}) && !empty($item->{'detail_' . $lang})) {
                $description = $item->{'detail_' . $lang};
            }
            // Try opposite language description as fallback
            elseif ($lang === 'th' && isset($item->description_en) && !empty($item->description_en)) {
                $description = $item->description_en;
            } elseif ($lang === 'en' && isset($item->description_th) && !empty($item->description_th)) {
                $description = $item->description_th;
            }
            // Try opposite language detail as fallback
            elseif ($lang === 'th' && isset($item->detail_en) && !empty($item->detail_en)) {
                $description = $item->detail_en;
            } elseif ($lang === 'en' && isset($item->detail_th) && !empty($item->detail_th)) {
                $description = $item->detail_th;
            }
            // Finally try generic columns
            elseif (isset($item->description) && !empty($item->description)) {
                $description = $item->description;
            } elseif (isset($item->detail) && !empty($item->detail)) {
                $description = $item->detail;
            }

            // Handle cover image
            $coverImage = '';
            if (isset($item->cover_image) && !empty($item->cover_image)) {
                $coverImage = $item->cover_image;
            } elseif (isset($item->cover) && !empty($item->cover)) {
                $coverImage = $item->cover;
            }

            // Handle new type
            $newType = null;
            if (isset($item->new_type)) {
                if (is_object($item->new_type)) {
                    $newType = [
                        'id' => $item->new_type->id,
                        'name' => $item->new_type->name ?? ''
                    ];
                } else {
                    $newType = $item->new_type;
                }
            }

            return [
                'id' => $item->id,
                'title' => $title,
                'title_th' => $item->title_th ?? null,
                'title_en' => $item->title_en ?? null,
                'description' => $description ? Str::limit($description, 120) : '',
                'cover_image' => $coverImage,
                'cover' => $coverImage, // For backward compatibility
                'new_type' => $newType,
                'published_date' => $item->published_date ?? $item->created_at->format('Y-m-d'),
                'url' => $item->url ?? null,
                'source' => $item->source ?? 'regular'
            ];
        })->toArray();
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
        }

        // Select ID
        $query->addSelect('id');

        // Select the appropriate title based on locale
        if (in_array('title_' . $lang, $columns)) {
            $query->addSelect('title_' . $lang);
        }

        // Handle published date
        if (in_array('published_date', $columns)) {
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
            $query->addSelect('description_' . $lang);
        } else {
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

        // Select ID first
        $query->addSelect('id');

        // Select both title columns if they exist
        if (in_array('title_th', $columns)) {
            $query->addSelect('title_th');
        } else {
            $query->addSelect(DB::raw('NULL as title_th'));
        }

        if (in_array('title_en', $columns)) {
            $query->addSelect('title_en');
        } else {
            $query->addSelect(DB::raw('NULL as title_en'));
        }

        // Also add the dynamic title based on current locale for compatibility
        if (in_array('title_' . $lang, $columns)) {
            $query->addSelect('title_' . $lang . ' as title');
            // Filter out news items that don't have content in current language
            $query->whereNotNull('title_' . $lang);
            $query->where('title_' . $lang, '!=', '');
        } elseif (in_array('title', $columns)) {
            // Fallback to generic title if it exists
            $query->addSelect('title');
            $query->whereNotNull('title');
            $query->where('title', '!=', '');
        } else {
            // If no title column exists, set NULL but still include the record
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
            $query->addSelect('detail as description');
        } elseif (in_array('description', $columns)) {
            $query->addSelect('description');
        } else {
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
            $query->addSelect('content');
        } else {
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
