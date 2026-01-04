<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    /**
     * Constructor to set up middleware for permissions
     */
    public function __construct()
    {
        $this->middleware('permission:show roles', ['only' => ['index']]);
        $this->middleware('permission:add roles', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit roles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete roles', ['only' => ['destroy']]);
        $this->middleware('permission:view roles', ['only' => ['show']]);
    }

/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
$roles = Role::orderBy('id','DESC')->paginate(5);
return view('roles.index',compact('roles'))
->with('i', ($request->input('page', 1) - 1) * 5);
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
$permission = Permission::get();
return view('roles.create',compact('permission'));
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
// public function store(Request $request)
// {
// $this->validate($request, [
// 'name' => 'required|unique:roles,name',
// 'permission' => 'required',
// ]);
// $role = Role::create(['name' => $request->input('name')]);
// $role->syncPermissions($request->input('permission'));
// return redirect()->route('roles.index')
// ->with('success','Role created successfully');
// }
public function store(Request $request)
{
    try {
        $this->validate($request, [
            'name' => 'required|unique:roles,name|string|max:255',
            'permission' => 'required|array',
        ]);

        $role = Role::create(['name' => $request->input('name')]);

        $permissionIds = $request->input('permission');
        $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')
            ->with('Add', 'Permission has been added successfully');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'An error occurred: ' . $e->getMessage())
            ->withInput();
    }
}

/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
$role = Role::find($id);
$rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
->where("role_has_permissions.role_id",$id)
->get();
return view('roles.show',compact('role','rolePermissions'));
}
/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
$role = Role::find($id);
$permission = Permission::get();
$rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
->all();
return view('roles.edit',compact('role','permission','rolePermissions'));
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
// public function update(Request $request, $id)
// {
// $this->validate($request, [
// 'name' => 'required',
// 'permission' => 'required',
// ]);
// $role = Role::find($id);
// $role->name = $request->input('name');
// $role->save();
// $role->syncPermissions($request->input('permission'));
// return redirect()->route('roles.index')
// ->with('success','Role updated successfully');
// }
public function update(Request $request, $id)
{
    try {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'permission' => 'required|array',
        ]);

        $role = Role::find($id);

        if(!$role) {
            return redirect()->route('roles.index')
                ->with('error', 'Permission not found');
        }

        $role->name = $request->input('name');
        $role->save();

        $permissionIds = $request->input('permission');
        $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')
            ->with('edit', 'Permission has been updated successfully');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'An error occurred: ' . $e->getMessage())
            ->withInput();
    }
}

/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
    $role = Role::find($id);

    if(!$role) {
        return redirect()->route('roles.index')
            ->with('error', 'Permission not found');
    }

    // Check if role is assigned to any user
    if($role->users()->count() > 0) {
        return redirect()->route('roles.index')
            ->with('error', 'Cannot delete permission that is assigned to users');
    }

    $role->delete();

    return redirect()->route('roles.index')
        ->with('delete', 'Permission has been deleted successfully');
}
}
