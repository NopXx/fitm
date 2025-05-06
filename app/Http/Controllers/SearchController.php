<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\FitmNews;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Handle the search request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get search query from request
        $query = $request->input('q');

        // Return empty results if no query
        if (empty($query)) {
            return view('search.results', [
                'query' => '',
                'contentResults' => collect(),
                'fitmNewsResults' => collect(),
                'newsResults' => collect(),
                'totalResults' => 0
            ]);
        }

        // Current language
        $lang = app()->getLocale();
        $isThaiLanguage = $lang === 'th';

        // Search in Content model
        $contentResults = Content::where(function($q) use ($query, $isThaiLanguage) {
            if ($isThaiLanguage) {
                $q->where('title_th', 'LIKE', "%{$query}%")
                  ->orWhere('detail_th', 'LIKE', "%{$query}%");
            } else {
                $q->where('title_en', 'LIKE', "%{$query}%")
                  ->orWhere('detail_en', 'LIKE', "%{$query}%");
            }
        })->get();

        // Search in FitmNews model
        $fitmNewsResults = FitmNews::where(function($q) use ($query) {
            $q->where('title_th', 'LIKE', "%{$query}%")
              ->orWhere('title_en', 'LIKE', "%{$query}%")
              ->orWhere('description_th', 'LIKE', "%{$query}%")
              ->orWhere('description_en', 'LIKE', "%{$query}%")
              ->orWhere('issue_name', 'LIKE', "%{$query}%");
        })->get();

        // Search in News model (with language consideration)
        $newsResults = News::where(function($q) use ($query, $isThaiLanguage) {
            if ($isThaiLanguage) {
                $q->where('title_th', 'LIKE', "%{$query}%")
                  ->orWhere('detail_th', 'LIKE', "%{$query}%")
                  ->orWhere('content_th', 'LIKE', "%{$query}%");
            } else {
                $q->where('title_en', 'LIKE', "%{$query}%")
                  ->orWhere('detail_en', 'LIKE', "%{$query}%")
                  ->orWhere('content_en', 'LIKE', "%{$query}%");
            }
        })
        ->where('status', 1) // Assuming status 1 means active/published
        ->orderBy('effective_date', 'desc')
        ->get();

        // Calculate total results
        $totalResults = $contentResults->count() + $fitmNewsResults->count() + $newsResults->count();

        // Pass the results to the view
        return view('search.results', [
            'query' => $query,
            'contentResults' => $contentResults,
            'fitmNewsResults' => $fitmNewsResults,
            'newsResults' => $newsResults,
            'totalResults' => $totalResults
        ]);
    }
}