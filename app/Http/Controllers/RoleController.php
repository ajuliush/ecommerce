<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view role', only: ['index']),
            new Middleware('permission:edit role', only: ['edit']),
            new Middleware('permission:create role', only: ['create']),
            new Middleware('permission:delete role', only: ['destroy']),
        ];
    }
    // This method will show roles page
    public function index(Request $request)
    {
        $query = Role::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $roles = $query->paginate(10);
        return view('backend.admin.role.list', compact('roles'));
    }
    // This method will  create roles page
    public function create(Request $request)
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('backend.admin.role.create', compact('permissions'));
    }
    // This method will insert a role into the database
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:roles|min:3'
        ]);

        if ($validator->passes()) {
            $role = Role::create([
                'name' => $request->name
            ]);
            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('role.index')->with('success', 'Role created successfully');
        } else {
            return redirect()->route('role.create')->withInput()->withErrors($validator);
        }
    }
    // This method will show roles edit page
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('backend.admin.role.edit', compact('role', 'hasPermissions', 'permissions'));
    }
    // This method will update a role in the database
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:roles,name,' . $id . ',id'
        ]);

        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();
            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('role.index')->with('success', 'Role created successfully');
        } else {
            return redirect()->route('role.edit', $id)->withInput()->withErrors($validator);
        }
    }
    // This method will show roles page
    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::findOrFail($id);
        if ($role == null) {
            session()->flash('error', 'Role not found');
            return response()->json([
                'status' => 'false',
            ]);
        }
        $role->delete();
        session()->flash('error', 'Role deleted successfully');
        return response()->json([
            'status' => 'true',
        ]);
    }
}