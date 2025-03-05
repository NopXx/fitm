<?php

namespace App\Http\Controllers;

use App\Models\OnlineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OnlineServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('online-services.index');
    }

    /**
     * Show JSON listing of services for DataTables.
     */
    public function getServices()
    {
        $services = OnlineService::orderBy('order')->get();
        return response()->json($services);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('online-services.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_th' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'active' => 'boolean',
            'order' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $data['image'] = $imagePath;
        }

        $service = OnlineService::create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'service' => $service,
                'message' => __('online_services.create_success')
            ]);
        }

        return redirect()->route('online-services.index')
            ->with('success', __('online_services.create_success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OnlineService $onlineService)
    {
        return view('online-services.edit', ['service' => $onlineService]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OnlineService $onlineService)
    {
        $validator = Validator::make($request->all(), [
            'title_th' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'active' => 'boolean',
            'order' => 'integer',
            'remove_image' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        $data = $request->except(['image', 'remove_image']);

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            // Delete the old image if it exists
            if ($onlineService->image && Storage::disk('public')->exists($onlineService->image)) {
                Storage::disk('public')->delete($onlineService->image);
            }
            $data['image'] = null;
        }
        // Handle image upload
        else if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($onlineService->image && Storage::disk('public')->exists($onlineService->image)) {
                Storage::disk('public')->delete($onlineService->image);
            }

            $imagePath = $request->file('image')->store('services', 'public');
            $data['image'] = $imagePath;
        }

        $onlineService->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'service' => $onlineService,
                'message' => __('online_services.update_success')
            ]);
        }

        return redirect()->route('online-services.index')
            ->with('success', __('online_services.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = OnlineService::findOrFail($id);

        // Delete the image if it exists
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => __('online_services.deleted_success')
        ]);
    }
}
