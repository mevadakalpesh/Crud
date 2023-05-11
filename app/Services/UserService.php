<?php
namespace App\Services;
use App\Models\User;
use App\RepoInterface\UserRepoInterface;
class UserService implements UserRepoInterface {
  public $user;
  public function __construct(User $user) {
    $this->user = $user;
  }

  public function getUsers($where = []) {
    return $this->user->where($where)->orderBy('created_at', 'desc')->get();
  }

  public function createUser($data) {
    return $this->user->create($data);
  }

  public function deleteUser($id) {
    return $this->user->findOrFail($id)->delete();
  }

  public function getUser($id) {
    return $this->user->findOrFail($id);
  }

  public function updateUser($where = [], $data = []) {
    return $this->user->where($where)->update($data);
  }

}