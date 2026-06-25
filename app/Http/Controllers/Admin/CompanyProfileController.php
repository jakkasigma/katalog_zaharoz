<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyProfileRequest;
use App\Http\Requests\Admin\PaymentInfoRequest;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    public function edit(): View
    {
        $companyProfile = CompanyProfile::query()->first();

        if (! $companyProfile) {
            $companyProfile = CompanyProfile::query()->create([
                'name' => 'Eyes of Zaharoz',
                'email' => 'hello@eyesofzaharoz.test',
                'phone' => '080000000000',
            ]);
        }

        return view('admin.company-profile.edit', compact('companyProfile'));
    }

    public function update(CompanyProfileRequest $request): RedirectResponse
    {
        $companyProfile = CompanyProfile::query()->first();

        if (! $companyProfile) {
            $companyProfile = CompanyProfile::query()->create([
                'name' => $request->validated('name'),
                'email' => $request->validated('email'),
                'phone' => $request->validated('phone'),
            ]);
        }

        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            if ($companyProfile->logo_path) {
                Storage::disk('public')->delete($companyProfile->logo_path);
            }

            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        unset($validated['logo']);

        if ($request->hasFile('qris')) {
            if ($companyProfile->qris_path) {
                Storage::disk('public')->delete($companyProfile->qris_path);
            }

            $validated['qris_path'] = $request->file('qris')->store('qris', 'public');
        }

        unset($validated['qris']);

        $companyProfile->update($validated);

        return redirect()->route('admin.company-profile.edit')
            ->with('status', 'Company profile berhasil diperbarui.');
    }

    public function updatePaymentInfo(PaymentInfoRequest $request): RedirectResponse
    {
        $companyProfile = CompanyProfile::query()->first();

        if (! $companyProfile) {
            $companyProfile = CompanyProfile::query()->create([
                'name' => 'Eyes of Zaharoz',
                'email' => 'hello@eyesofzaharoz.test',
                'phone' => '080000000000',
            ]);
        }

        $validated = $request->validated();

        if ($request->hasFile('qris')) {
            if ($companyProfile->qris_path) {
                Storage::disk('public')->delete($companyProfile->qris_path);
            }

            $validated['qris_path'] = $request->file('qris')->store('qris', 'public');
        }

        unset($validated['qris']);

        $companyProfile->update($validated);

        return redirect()->route('admin.company-profile.edit')
            ->with('status', 'Informasi pembayaran berhasil diperbarui.');
    }
}
