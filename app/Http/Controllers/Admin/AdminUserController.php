<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin as AdminModel;
use App\Http\Requests\Admin\StoreAdminRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $admins = AdminModel::orderBy('created_at', 'desc')->get();
        $currentAdminId = Auth::guard('admin')->id();

        return view('admin.admins.index', compact('admins', 'currentAdminId'));
    }

    public function store(StoreAdminRequest $request): RedirectResponse
    {
        AdminModel::create([
            ...$request->validated(),
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Admin added successfully.');
    }

    public function destroy(AdminModel $admin): RedirectResponse
    {
        if ($admin->id === Auth::guard('admin')->id()) {
            return back()->with('error', 'You cannot remove your own admin account.');
        }

        $admin->delete();

        return back()->with('success', 'Admin removed.');
    }
}
