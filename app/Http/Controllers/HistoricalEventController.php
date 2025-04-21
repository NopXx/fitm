<?php

namespace App\Http\Controllers;

use App\Models\HistoricalEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class HistoricalEventController extends Controller
{
    public function index()
    {
        // Get events ordered by year descending
        $events = HistoricalEvent::orderBy('year', 'desc')->get();

        return view('historical-events.index', compact('events'));
    }

    public function frontend() {
        $events = HistoricalEvent::orderBy('year', 'desc')->get();
        return view('historical-events.frontend', compact('events'));
    }


    public function data()
    {
        $events = HistoricalEvent::all();
        Log::debug($events);
        return response()->json($events);
    }

    public function create()
    {
        return view('historical-events.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'title_th' => 'required|string|max:255',
            'description_th' => 'required|string',
            'title_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        try {
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('history', 'public');
                $validated['image_path'] = $path;
            }

            HistoricalEvent::create($validated);

            return redirect()
                ->route('historical-events.index')
                ->with('success', __('historical_event.save_success'));
        } catch (\Exception $e) {
            Log::error('Error creating historical event: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('historical_event.save_error'));
        }
    }

    public function edit($id)
    {
        $historicalEvent = HistoricalEvent::find($id);
        return view('historical-events.edit', compact('historicalEvent'));
    }

    public function update(Request $request, $id)
    {
        $historicalEvent = HistoricalEvent::findOrFail($id);

        $validated = $request->validate([
            'year' => 'required|integer',
            'title_th' => 'required|string|max:255',
            'description_th' => 'required|string',
            'title_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);
        Log::debug($request);

        try {
            // Handle image removal
            if ($request->input('remove_image') == '1' && $historicalEvent->image_path) {
                Storage::disk('public')->delete($historicalEvent->image_path);
                $historicalEvent->image_path = null;
            }

            // Handle new image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($historicalEvent->image_path) {
                    Storage::disk('public')->delete($historicalEvent->image_path);
                }
                $path = $request->file('image')->store('history', 'public');
                $validated['image_path'] = $path;
            }

            $historicalEvent->update($validated);

            return redirect()
                ->route('historical-events.index')
                ->with('success', __('historical_event.update_success'));
        } catch (\Exception $e) {
            Log::error('Error updating historical event: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('historical_event.update_error'));
        }
    }

    public function destroy($id)
    {
        try {
            $historicalEvent = HistoricalEvent::findOrFail($id);

            if ($historicalEvent->image_path) {
                Storage::disk('public')->delete($historicalEvent->image_path);
            }

            $historicalEvent->delete();

            return response()->json([
                'success' => true,
                'message' => __('historical_event.delete_success')
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting historical event: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('historical_event.delete_error')
            ], 500);
        }
    }
}