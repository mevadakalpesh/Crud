<?php
namespace App\RepoInterface;
interface UserRepoInterface {
  public function getUsers($where = []);
  public function getUser($id);
  public function createUser(array $data);
  public function deleteUser($id);
  public function updateUser(array $where = [],array $data = []);
}