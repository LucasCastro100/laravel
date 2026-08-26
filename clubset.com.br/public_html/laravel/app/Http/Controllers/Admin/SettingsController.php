<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/settings', [
            'settings' => [
                'listings' => Setting::group('listings'),
                'services' => Setting::group('services'),
                'platform' => Setting::group('platform'),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.listings' => ['nullable', 'array'],
            'settings.listings.max_images' => ['nullable', 'integer', 'min:1', 'max:20'],
            'settings.listings.max_description_length' => ['nullable', 'integer', 'min:100', 'max:10000'],
            'settings.listings.require_moderation' => ['nullable', 'string', 'in:true,false'],
            'settings.services' => ['nullable', 'array'],
            'settings.services.require_moderation' => ['nullable', 'string', 'in:true,false'],
            'settings.platform' => ['nullable', 'array'],
            'settings.platform.name' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validated['settings'] as $group => $items) {
            if (! is_array($items)) {
                continue;
            }
            foreach ($items as $key => $value) {
                Setting::set($key, (string) $value, $group);
            }
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Configuracoes salvas com sucesso.',
        ]);

        return back();
    }
}
