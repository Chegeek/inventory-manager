<?php
namespace App\Controllers;

use \App\System\App;
use \App\Controllers\Controller;
use \App\Models\UsersModel;

class UsersController extends Controller {

    public function login() {
        // $errors = false;
        //
        // if(!empty($_POST)) {
        //     $model = new UsersModel();
        //
        //     if($model->login($_POST['username'], $_POST['password'])) {
        //         App::redirect('admin/');
        //     }
        //
        //     else {
        //         $errors = true;
        //     }
        // }

        $this->render('pages/login.twig', []);
    }

}
