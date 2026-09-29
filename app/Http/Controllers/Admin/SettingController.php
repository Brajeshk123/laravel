<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateSettingsRequest;
use App\Models\Setting;
use App\Services\SettingService;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Setting::class);

        $settings = $this->settingService->grouped();
        $timezones = timezone_identifiers_list();

        return view('admin.settings.index', compact('settings', 'timezones'));
    }

    public function update(UpdateSettingsRequest $request)
    {
        $this->authorize('viewAny', Setting::class);

        $this->settingService->updateSettings($request->validated());

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
