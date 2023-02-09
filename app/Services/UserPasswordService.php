<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserPasswordService {
  public static function getUserByPassword($password): ?User {
    $users = User::all();
    foreach ($users as $user) {
        if (Hash::check($password, $user->password)) {
          return $user;
        }
    }
    return null;
  }
}
?>
