<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Constructor to set up middleware for permissions
     */
    public function __construct()
    {
        $this->middleware('permission:show users', ['only' => ['index']]);
        $this->middleware('permission:add users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
        $this->middleware('permission:view users', ['only' => ['show']]);
    }

/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
$data = User::orderBy('id','DESC')->paginate(5);
return view('users.show_users',compact('data'))
->with('i', ($request->input('page', 1) - 1) * 5);
}


/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
$roles = Role::pluck('name','name')->all();

return view('users.Add_user',compact('roles'));

}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
    try {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:confirm-password',
            'roles_name' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles_name'));

        return redirect()->route('users.index')
            ->with('success', 'User has been added successfully');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput($request->except(['password', 'confirm-password']));
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'An error occurred: ' . $e->getMessage())
            ->withInput($request->except(['password', 'confirm-password']));
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
$user = User::find($id);
return view('users.show',compact('user'));
}
/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
$user = User::find($id);
$roles = Role::pluck('name','name')->all();
$userRole = $user->roles->pluck('name','name')->all();
return view('users.edit',compact('user','roles','userRole'));
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
    try {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();

        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        $user = User::find($id);

        if(!$user) {
            return redirect()->route('users.index')
                ->with('error', 'User not found');
        }

        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('edit', 'User information has been successfully updated');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput($request->except(['password', 'confirm-password']));
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'An error occurred: ' . $e->getMessage())
            ->withInput($request->except(['password', 'confirm-password']));
    }
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy(Request $request)
{
    $user = User::find($request->user_id);

    if($user) {
        $user->delete();
        return redirect()->route('users.index')
            ->with('delete', 'User has been deleted successfully');
    }

    return redirect()->route('users.index')
        ->with('error', 'User not found');
}
}
