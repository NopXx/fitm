<?php

namespace App\Http\Controllers;

use App\Models\PopupSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PopupSettingController extends Controller
{
    public function edit()
    {
        $popup = PopupSetting::first();

        return view('popup.edit', [
            'popup' => $popup,
        ]);
    }

    public function update(Request $request)
    {
        $request->merge([
            'title' => $request->filled('title') ? $request->input('title') : null,
            'link' => $request->filled('link') ? $request->input('link') : null,
        ]);

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'url'],
            'image' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $popup = PopupSetting::first() ?? new PopupSetting();

        if (array_key_exists('title', $validated)) {
            $popup->title = $validated['title'];
        }

        if (array_key_exists('link', $validated)) {
            $popup->link = $validated['link'];
        }
        $popup->is_active = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($popup->image_path) {
                Storage::disk('public')->delete($popup->image_path);
            }

            $popup->image_path = $request->file('image')->store('popup', 'public');
        }

        $popup->save();

        return redirect()
            ->route('popup-settings.edit')
            ->with('success', __('popup.updated_successfully'));
    }
}
