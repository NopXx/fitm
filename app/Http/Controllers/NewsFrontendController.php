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
        // Get the structure of both tables to ensure we're only selecting columns that exist
        $fitmNewsColumns = $this->getTableColumns('fitm_news');
        $newsColumns = $this->getTableColumns('news');

        // Build queries based on existing columns
        $fitmNewsQuery = $this->buildFitmNewsQuery($fitmNewsColumns);
        $regularNewsQuery = $this->buildRegularNewsQuery($newsColumns);

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
            'importantNews'
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

        return view('news.detail', compact('news', 'source', 'relatedNews'));
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
     * @return \Illuminate\Database\Query\Builder
     */
    private function buildFitmNewsQuery($columns)
    {
        $query = FitmNews::select('id', 'title');

        // Add optional columns if they exist
        if (in_array('published_date', $columns)) {
            // We'll select it as a string to avoid DateTime conversion issues
            $query->addSelect(DB::raw('DATE_FORMAT(published_date, "%Y-%m-%d") as published_date'));
        } else {
            if (in_array('effective_date', $columns)) {
                // We'll select it as a string to avoid DateTime conversion issues
                $query->addSelect(DB::raw('DATE_FORMAT(effective_date, "%Y-%m-%d") as published_date'));
            } else {
                $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as published_date'));
            }
        }

        if (in_array('cover_image', $columns)) {
            $query->addSelect('cover_image');
        } else {
            $query->addSelect(DB::raw('NULL as cover_image'));
        }

        if (in_array('description', $columns)) {
            $query->addSelect('description');
        } else if (in_array('detail', $columns)) {
            $query->addSelect('detail as description');
        } else {
            $query->addSelect(DB::raw('NULL as description'));
        }

        if (in_array('issue_name', $columns)) {
            $query->addSelect('issue_name');
        } else {
            $query->addSelect(DB::raw('NULL as issue_name'));
        }

        if (in_array('url', $columns)) {
            $query->addSelect('url as url');
        } else {
            $query->addSelect(DB::raw('NULL as url'));
        }

        $query->addSelect(DB::raw('NULL as new_type'));
        $query->addSelect(DB::raw("'fitm' as source"));

        return $query->orderBy('issue_name', 'DESC');
    }

    /**
     * Build query for News with only existing columns
     *
     * @param array $columns
     * @return \Illuminate\Database\Query\Builder
     */
    private function buildRegularNewsQuery($columns)
    {
        $query = News::select('id', 'title_th');

        // Add optional columns if they exist
        $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as published_date'));

        if (in_array('cover', $columns)) {
            $query->addSelect('cover as cover_image');
        } else {
            $query->addSelect(DB::raw('NULL as cover_image'));
        }

        // Add optional columns if they exist
        if (in_array('detail', $columns)) {
            $query->addSelect('detail as description');
        } else if (in_array('description', $columns)) {
            $query->addSelect('description');
        } else {
            $query->addSelect(DB::raw('NULL as description'));
        }

        if (in_array('new_type', $columns)) {
            $query->addSelect('new_type');
        } else {
            $query->addSelect(DB::raw('NULL as new_type'));
        }

        if (in_array('content', $columns)) {
            $query->addSelect('content');
        } else {
            $query->addSelect(DB::raw('NULL as content'));
        }

        // Add URL field if it exists
        if (in_array('url', $columns)) {
            $query->addSelect('url');
        } else if (in_array('link', $columns)) {
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

        $query->where('display_type', 1);

        return $query->orderBy('created_at', 'desc');
    }
}
