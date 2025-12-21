<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view("role.list", compact("roles"));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view("role.create", compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required'
        ]);
        $permissijons = Permission::all();
        try {
            DB::beginTransaction();
            $role = Role::create([
                'name' => $request->name
            ]);
            $role->syncPermissions($request->permissions);

            DB::commit();
            return redirect()->route('role.index')->with('success', 'Role Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }

    }
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('role.show', compact('role'));
    }

    public function edit(Role $role){
        $permissions = Permission::all();
        return view('role.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        // Sync permissions
        $role->syncPermissions($request->permissions);

        return redirect()->route('role.index')->with('success', 'Role updated successfully');
    }


    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role deleted successfully.');

    }


}
