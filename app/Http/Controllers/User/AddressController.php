<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreAddressRequest;
use App\Http\Requests\User\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(): View
    {
        $addresses = auth()->user()->addresses()->latest()->get();

        return view('user.addresses.index', compact('addresses'));
    }

    public function create(): View
    {
        return view('user.addresses.create');
    }

    public function store(StoreAddressRequest $request): RedirectResponse
    {
        $request->user()->addresses()->create($request->validated());

        return redirect()->route('addresses.index')->with('status', 'Alamat berhasil ditambahkan.');
    }

    public function edit(Address $address): View
    {
        $this->authorizeAddress($address);

        return view('user.addresses.edit', compact('address'));
    }

    public function update(UpdateAddressRequest $request, Address $address): RedirectResponse
    {
        $this->authorizeAddress($address);

        $address->update($request->validated());

        return redirect()->route('addresses.index')->with('status', 'Alamat berhasil diperbarui.');
    }

    public function destroy(Address $address): RedirectResponse
    {
        $this->authorizeAddress($address);

        $address->delete();

        return redirect()->route('addresses.index')->with('status', 'Alamat berhasil dihapus.');
    }

    private function authorizeAddress(Address $address): void
    {
        abort_unless($address->user_id === auth()->id(), 403);
    }
}
