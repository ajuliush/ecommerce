<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permission', only: ['index']),
            new Middleware('permission:edit permission', only: ['edit']),
            new Middleware('permission:create permission', only: ['create']),
            new Middleware('permission:delete permission', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Permission::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $permissions = $query->paginate(10);
        return view('backend.admin.permission.list', compact('permissions'));
    }

    /**
     * This method will show create permission page.
     */
    public function create()
    {
        return view('backend.admin.permission.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:permissions|min:3'
        ]);
        if ($validator->passes()) {
            Permission::create([
                'name' => $request->name
            ]);
            return redirect()->route('permission.index')->with('success', 'Permissions created successfully');
        } else {
            return redirect()->route('permission.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }
    /**
     * Edit the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.admin.permission.edit', compact('permission'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'  => 'required|min:3|unique:permissions,name,' . $id . 'id'
        ]);
        if ($validator->passes()) {
            $permission->name = $request->name;
            $permission->update();
            return redirect()->route('permission.index')->with('success', 'Permissions update successfully');
        } else {
            return redirect()->route('permission.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $permission = Permission::findOrFail($id);
        if ($permission == null) {
            session()->flash('error', 'Permission not found');
            return response()->json([
                'status' => 'false',
            ]);
        }
        $permission->delete();
        session()->flash('error', 'Permission deleted successfully');
        return response()->json([
            'status' => 'true',
        ]);
    }
}