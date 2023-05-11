<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepoInterface\UserRepoInterface;
use App\Models\User;
use DataTables;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserUpdateRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public $userRepoInterface;
  public function __construct(UserRepoInterface $userRepoInterfacee) {
    $this->userRepoInterface = $userRepoInterfacee;
  }
  /**
  * Display a listing of the resource.
  */
  public function index(Request $request) {
    if ($request->ajax()) {

      $data = $this->userRepoInterface->getUsers();

      return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('action', function(User $user) {
        $btn = '<a href="javascript:void(0)" data-user_id="'.$user->id.'"  class="btn btn-primary user-edit btn-sm">Edit</a>
                <a href="javascript:void(0)" data-user_id="'.$user->id.'" class="btn btn-danger user-delete btn-sm ">Delete</a>';
        return $btn;
      })
      ->editColumn('roles', function($user) {
        $userRoles = $user->roles->pluck('name');
        $roleHtml = '';
        if(!blank($userRoles)){
          foreach ($userRoles as $role){
            $roleHtml .= '<span class="basdge">'.$role.'</span>';
          }
        }
        return $roleHtml;
      })
      ->rawColumns(['roles','action'])
      ->make(true);
    }
    $roles = Role::all();
    return view('users.user-listing',['roles' => $roles]);
  }

  /**
  * Show the form for creating a new resource.
  */
  public function create() {}

  /**
  * Store a newly created resource in storage.
  */
  public function store(UserAddRequest $request) {
    $data = [
      'name' => $request->name,
      'email' => $request->amount,
      'password' => Hash::make($request->password),
    ];
    $this->userRepoInterface->createUser($data);
    return response()->json(['status' => 200, 'message' => 'User Add Successfully']);
  }

  /**
  * Display the specified resource.
  */
  public function show(string $id) {}

  /**
  * Show the form for editing the specified resource.
  */
  public function edit(string $id) {
    $result = $this->userRepoInterface->getUser($id);
    if ($result) {
      return response()->json(['status' => 200, 'message' => 'User Get Successfully', 'result' => $result]);
    } else {
      return response()->json(['status' => 101, 'message' => 'Something Went Wrong']);
    }
  }

  /**
  * Update the specified resource in storage.
  */
  public function update(UserUpdateRequest $request, string $id) {
    $data = [
      'name' => $request->name,
      'amount' => $request->amount,
      'status' => $request->status,
      'description' => $request->description ?? null,
    ];
    if ($request->has('image') && !blank($request->image)) {
      $data['image'] = storeFile(User::$filePath, $request->image, 'user');
    }
    $this->userRepoInterface->updateUser([
      ['id', $id]
    ], $data);
    return response()->json(['status' => 200, 'message' => 'User Edit Successfully']);
  }

  /**
  * Remove the specified resource from storage.
  */
  public function destroy(string $id) {
    $result = $this->userRepoInterface->deleteUser($id);
    if ($result) {
      return response()->json(['status' => 200, 'message' => 'User Delete Successfully']);
    } else {
      return response()->json(['status' => 101, 'message' => 'Something Went Wrong']);
    }
  }


}