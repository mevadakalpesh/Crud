<?php
namespace App\Services;
use Spatie\Permission\Models\Role;

class RoleService {
  public $role;
  public function __construct(Role $role) {
    $this->role = $role;
  }

  public function getRoles($where = []) {
    return $this->role->where($where)->orderBy('created_at', 'desc')->get();
  }

  public function createRole($data) {
    return $this->role->create($data);
  }

  public function deleteRole($id) {
    return $this->role->findOrFail($id)->delete();
  }

  public function getRole($id) {
    return $this->role->findOrFail($id);
  }

  public function updateRole($where = [], $data = []) {
    return $this->role->where($where)->update($data);
  }

}