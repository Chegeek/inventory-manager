<?php
namespace App\Models;

use \App\System\App;
use \App\Models\Model;

class UsersModel extends Model {

    public function login($username, $password) {
        $user = App::getDb()->prepare('SELECT * FROM users WHERE username = ?', [$username], true);

        if($user) {
            if($user->password === sha1($password)) {
                $_SESSION['auth'] = $user->id;

                return true;
            }
        }

        return false;
    }

    public function logged(){
        return isset($_SESSION['auth']);
    }

}
