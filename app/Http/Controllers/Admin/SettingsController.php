<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutSettingsRequest;
use App\Http\Requests\Admin\ContactSettingsRequest;
use App\Http\Requests\Admin\SeoSettingsRequest;
use App\Http\Requests\Admin\SocialSettingsRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Organisation-wide settings (about, mission, contact, SEO, social), each stored as one JSON site setting.
 */
class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings', [
            'settings' => SiteSetting::query()->pluck('value', 'key'),
        ]);
    }

    public function updateAbout(AboutSettingsRequest $request): RedirectResponse
    {
        $this->save('about', $request->validated('about'));
        $this->save('mission', $request->validated('mission'));

        return $this->saved('about');
    }

    public function updateContact(ContactSettingsRequest $request): RedirectResponse
    {
        $this->save('contact', $request->contactSetting());

        return $this->saved('contact');
    }

    public function updateSeo(SeoSettingsRequest $request): RedirectResponse
    {
        $this->save('seo', $request->validated());

        return $this->saved('seo');
    }

    public function updateSocial(SocialSettingsRequest $request): RedirectResponse
    {
        $this->save('social', $request->validated('social', []));

        return $this->saved('social');
    }

    private function save(string $key, mixed $value): void
    {
        SiteSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    private function saved(string $section): RedirectResponse
    {
        return redirect()->to(route('admin.settings.edit').'#'.$section)->with('status', 'Settings saved.');
    }
}
