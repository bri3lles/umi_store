<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    // Kunci role/status yang valid (label ditampilkan lewat lang/en|id/users.php
    // supaya otomatis mengikuti bahasa yang sedang aktif — lihat method lookups()).
    private const ROLE_KEYS = ['owner', 'admin', 'customer'];
    private const STATUS_KEYS = ['active', 'inactive'];

    /**
     * Daftar user, dengan pencarian nama/email dan filter role/status.
     */
    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->q;
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('role'), fn ($query) => $query->where('role', $request->role))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.users.index', $this->lookups() + compact('users'));
    }

    /**
     * Detail satu user.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', $this->lookups() + compact('user'));
    }

    /**
     * Ubah role user (dipanggil dari modal "Ubah Role").
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => 'required|in:' . implode(',', self::ROLE_KEYS),
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', __('users.role_modal.success'));
    }

    /**
     * Hapus user (dipanggil dari modal konfirmasi hapus).
     */
    public function destroy(User $user): RedirectResponse
    {
        // Admin tidak boleh menghapus akunnya sendiri.
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('users.delete_modal.success'));
    }

    /**
     * Label Role & Status diambil dari file bahasa aktif (en/id).
     */
    private function lookups(): array
    {
        return [
            'roles' => collect(self::ROLE_KEYS)->mapWithKeys(
                fn ($key) => [$key => __("users.roles.$key")]
            )->all(),
            'statuses' => collect(self::STATUS_KEYS)->mapWithKeys(
                fn ($key) => [$key => __("users.statuses.$key")]
            )->all(),
        ];
    }
}