<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display Roles & Staff Management Hub.
     */
    public function index(Request $request): View
    {
        $roles = Role::withCount('users')->orderBy('is_system', 'desc')->orderBy('name')->get();

        $staffUsers = User::with('roleModel')
            ->where(function ($q) {
                $q->where('is_staff', true)
                    ->orWhereIn('role', ['super_admin', 'support', 'finance', 'content_manager']);
            })
            ->latest()
            ->paginate(15);

        $activeTab = $request->query('tab', 'staff');
        $modules = Role::MODULES;
        $actions = Role::ACTIONS;

        return view('admin.roles.index', [
            'roles' => $roles,
            'staffUsers' => $staffUsers,
            'activeTab' => $activeTab,
            'modules' => $modules,
            'actions' => $actions,
        ]);
    }

    /**
     * Create a new Staff Member (Sub-Admin).
     */
    public function storeStaff(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $role = Role::findOrFail($request->input('role_id'));

        $staff = User::create([
            'name' => trim((string) $request->input('name')),
            'email' => strtolower(trim((string) $request->input('email'))),
            'phone' => trim((string) $request->input('phone')),
            'password' => Hash::make((string) $request->input('password')),
            'role' => $role->slug,
            'role_id' => $role->id,
            'is_staff' => true,
            'is_blocked' => false,
            'active_package' => 'Advance Package',
            'payment_status' => 'paid',
            'affiliate_id' => 'STAFF-'.rand(1000, 9999),
        ]);

        ActivityLog::record(
            action: 'STAFF_CREATED',
            module: 'roles',
            description: "Created new staff member: {$staff->name} ({$staff->email}) assigned to role '{$role->name}'.",
            properties: [
                'staff_id' => $staff->id,
                'staff_name' => $staff->name,
                'staff_email' => $staff->email,
                'role' => $role->slug,
            ]
        );

        return redirect()->route('admin.roles', ['tab' => 'staff'])
            ->with('success', "Staff member '{$staff->name}' created successfully with role '{$role->name}'!");
    }

    /**
     * Update an existing Staff Member.
     */
    public function updateStaff(Request $request, int $id): RedirectResponse
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:users,email,{$id}"],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'string', 'min:6'],
            'is_blocked' => ['nullable', 'boolean'],
        ]);

        $oldRole = $staff->roleModel?->name ?? $staff->role;
        $newRole = Role::findOrFail($request->input('role_id'));

        $updateData = [
            'name' => trim((string) $request->input('name')),
            'email' => strtolower(trim((string) $request->input('email'))),
            'phone' => trim((string) $request->input('phone')),
            'role_id' => $newRole->id,
            'role' => $newRole->slug,
            'is_staff' => true,
            'is_blocked' => (bool) $request->input('is_blocked', false),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make((string) $request->input('password'));
        }

        $staff->update($updateData);

        ActivityLog::record(
            action: 'STAFF_UPDATED',
            module: 'roles',
            description: "Updated staff member {$staff->name}. Role changed from '{$oldRole}' to '{$newRole->name}'.",
            properties: [
                'staff_id' => $staff->id,
                'old_role' => $oldRole,
                'new_role' => $newRole->name,
                'is_blocked' => $staff->is_blocked,
            ]
        );

        return redirect()->route('admin.roles', ['tab' => 'staff'])
            ->with('success', "Staff member '{$staff->name}' updated successfully!");
    }

    /**
     * Delete a staff user (Prevent self-deletion or super_admin deletion).
     */
    public function deleteStaff(int $id): RedirectResponse
    {
        $staff = User::findOrFail($id);

        if ($staff->id === auth()->id()) {
            return back()->with('error', 'Aap apne khud ke account ko delete nahi kar sakte.');
        }

        if ($staff->isSuperAdmin()) {
            return back()->with('error', 'Super Admin account ko delete nahi kiya ja sakta.');
        }

        $name = $staff->name;
        $email = $staff->email;
        $roleName = $staff->roleModel?->name ?? $staff->role;

        $staff->delete();

        ActivityLog::record(
            action: 'STAFF_DELETED',
            module: 'roles',
            description: "Deleted staff member {$name} ({$email}) with role '{$roleName}'.",
            properties: [
                'deleted_staff_name' => $name,
                'deleted_staff_email' => $email,
            ]
        );

        return redirect()->route('admin.roles', ['tab' => 'staff'])
            ->with('success', "Staff user '{$name}' deleted successfully.");
    }

    /**
     * Create a new custom role.
     */
    public function storeRole(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['nullable', 'array'],
        ]);

        $name = trim((string) $request->input('name'));
        $slug = Str::slug($name, '_');

        if (Role::where('slug', $slug)->exists()) {
            $slug = $slug.'_'.rand(10, 99);
        }

        $role = Role::create([
            'name' => $name,
            'slug' => $slug,
            'description' => trim((string) $request->input('description', '')),
            'is_system' => false,
            'permissions' => $request->input('permissions', []),
        ]);

        ActivityLog::record(
            action: 'ROLE_CREATED',
            module: 'roles',
            description: "Created new custom role '{$role->name}' with customized permissions.",
            properties: [
                'role_id' => $role->id,
                'role_name' => $role->name,
                'permissions' => $role->permissions,
            ]
        );

        return redirect()->route('admin.roles', ['tab' => 'roles'])
            ->with('success', "Role '{$role->name}' created successfully!");
    }

    /**
     * Update permissions matrix for a role.
     */
    public function updateRolePermissions(Request $request, int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['nullable', 'array'],
        ]);

        $oldPermissions = $role->permissions;
        $newPermissions = $request->input('permissions', []);

        $role->update([
            'name' => trim((string) $request->input('name')),
            'description' => trim((string) $request->input('description', '')),
            'permissions' => $newPermissions,
        ]);

        ActivityLog::record(
            action: 'PERMISSIONS_UPDATED',
            module: 'roles',
            description: "Updated permissions matrix for role '{$role->name}'.",
            properties: [
                'role_id' => $role->id,
                'role_name' => $role->name,
                'old_permissions' => $oldPermissions,
                'new_permissions' => $newPermissions,
            ]
        );

        return redirect()->route('admin.roles', ['tab' => 'roles'])
            ->with('success', "Permissions for '{$role->name}' saved successfully!");
    }

    /**
     * Delete a custom role (Cannot delete system roles or roles with assigned users).
     */
    public function deleteRole(int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        if ($role->is_system) {
            return back()->with('error', "System role '{$role->name}' cannot be deleted.");
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', "Is role me {$role->users()->count()} staff members assigned hain. Pehle unka role change karein.");
        }

        $name = $role->name;
        $role->delete();

        ActivityLog::record(
            action: 'ROLE_DELETED',
            module: 'roles',
            description: "Deleted custom role '{$name}'.",
            properties: ['role_name' => $name]
        );

        return redirect()->route('admin.roles', ['tab' => 'roles'])
            ->with('success', "Role '{$name}' deleted successfully.");
    }

    /**
     * Display Activity Log & Audit Trail.
     */
    public function activityLogs(Request $request): View
    {
        $query = ActivityLog::with('user')->latest('id');

        if ($request->filled('module')) {
            $query->where('module', $request->input('module'));
        }

        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(25)->withQueryString();

        $allStaff = User::where('is_staff', true)->orWhereIn('role', ['super_admin', 'support', 'finance', 'content_manager'])->get();
        $modules = Role::MODULES;

        return view('admin.roles.activity-logs', [
            'logs' => $logs,
            'allStaff' => $allStaff,
            'modules' => $modules,
            'currentModule' => $request->input('module'),
            'currentAction' => $request->input('action'),
            'currentUserId' => $request->input('user_id'),
            'search' => $request->input('search'),
        ]);
    }
}

