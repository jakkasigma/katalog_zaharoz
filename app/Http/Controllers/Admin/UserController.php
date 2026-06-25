<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->where('is_admin', false)
            ->withCount('orders')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search');

                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->load(['addresses', 'orders.payment', 'orders.items']);

        return view('admin.users.show', compact('user'));
    }

    public function toggleActive(User $user): RedirectResponse
    {
        abort_if($user->id === auth()->id(), 403, 'Tidak bisa menonaktifkan diri sendiri.');

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('status', 'Status user berhasil diperbarui.');
    }
}
