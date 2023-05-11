<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleService;
use DataTables;
use App\Http\Requests\RoleAddRequest;
use App\Http\Requests\RoleUpdateRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
  public $roleService;
  public function __construct(RoleService $roleServicee) {
    $this->roleService = $roleServicee;
  }
  /**
  * Display a listing of the resource.
  */
  public function index(Request $request) {
    if ($request->ajax()) {
      $data = $this->roleService->getRoles();
      return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('action', function(Role $role) {
        $btn = '<a href="'.route('role.edit',$role->id).'" class="btn btn-primary role-edit btn-sm">Edit</a>
                <a href="javascript:void(0)" data-role_id="'.$role->id.'" class="btn btn-danger role-delete btn-sm ">Delete</a>';
        return $btn;
      })
      ->rawColumns(['action'])
      ->make(true);
    }
    return view('roles.role-listing');
  }

  /**
  * Show the form for creating a new resource.
  */
  public function create() {
    $permissions = Permission::get();
    return view('roles.role-add',['permissions' => $permissions]);
  }

  /**
  * Store a newly created resource in storage.
  */
  public function store(RoleAddRequest $request) {
    $data = [
      'name' => $request->name,
    ];
     $role = $this->roleService->createRole($data);
     $result =  $role->syncPermissions($request->permissions);
     if($result){
        return redirect()->route('role.index')->withSuccess('Role added
        successfully');
     }  else {
       return redirect()->back()->withError('Something went wrong')->withInput();
     }
  }

  /**
  * Display the specified resource.
  */
  public function show(string $id) {
  }

  /**
  * Show the form for editing the specified resource.
  */
  public function edit(string $id) {
    $role = Role::where('id',$id)->first();
    $role_permissions = $role->permissions->pluck('id')->toArray();
    $permissions = Permission::get();
    return view('roles.role-edit',[
      'permissions' => $permissions,
      'role' => $role,
      'role_permissions' => $role_permissions
      ]);
  }

  /**
  * Update the specified resource in storage.
  */
  public function update(RoleUpdateRequest $request, string $id) {
    $data = [
      'name' => $request->name,
    ];
    
   $role =  $this->roleService->updateRole([
      ['id', $id]
    ], $data);
    $role = Role::where('id',$id)->first();
    $result = $role->syncPermissions($request->permissions);
    
    if($result){
        return redirect()->route('role.index')->withSuccess('Role Edit
        successfully');
     }  else {
       return redirect()->back()->withError('Something went wrong')->withInput();
     }
    
  }

  /**
  * Remove the specified resource from storage.
  */
  public function destroy(string $id) {
    if($id == 1){
      return response()->json(['status' => 101, 'message' => 'Cannot be deleted
      of super admin']);
    }
    $result = $this->roleService->deleteRole($id);
    if ($result) {
      return response()->json(['status' => 200, 'message' => 'Role Delete Successfully']);
    } else {
      return response()->json(['status' => 101, 'message' => 'Something Went Wrong']);
    }
  }
  
   public function roleList(){
     $roles = Role::all();
     return  view('role-show',['roles' => $roles]);
   }
  
}