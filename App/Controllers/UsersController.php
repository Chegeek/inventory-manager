<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\Settings;
use \App\System\FormValidator;
use \App\Controllers\Controller;
use \App\Models\UsersModel;
use \App\System\Mailer;

class UsersController extends Controller {

    public function all() {
        $model = new UsersModel();
        $data  = $model->all();

        $this->render('pages/admin/users.twig', [
            'title'       => 'Users',
            'description' => 'Users - Just a simple inventory management system.',
            'page'        => 'users',
            'users'    => $data
        ]);
    }

    public function add() {
        if(!empty($_POST)) {
            $username              = isset($_POST['username']) ? $_POST['username'] : '';
            $email                 = isset($_POST['email']) ? $_POST['email'] : '';
            $password              = isset($_POST['password']) ? $_POST['password'] : '';
            $password_verification = isset($_POST['password_verification']) ? $_POST['password_verification'] : '';

            $validator = new FormValidator();
            $validator->validUsername('username', $username, "Your username is not valid (no spaces, uppercase, special character)");
            $validator->availableUsername('username', $username, "Your username is not available");
            $validator->validEmail('email', $email, "Your email is not valid");
            $validator->validPassword('password', $password, $password_verification, "You didn't write the same password twice");

            if($validator->isValid()) {
                $model = new UsersModel();
                $model->create([
                    'username' => $username,
                    'email'    => $email,
                    'password' => hash('sha256', Settings::getConfig()['salt'] . $password)
                ]);

                $mailer = new Mailer();
                $mailer->setFrom('gregoire.mielle@gmail.com', 'Mailer');
                $mailer->addAddress('gregoiremielle@gmail.com', 'Joe User');
                $mailer->Subject = 'Here is the subject';
                $mailer->Body    = 'This is the HTML message body <b>in bold!</b>';
                $mailer->send();


                App::redirect('admin/users');
            }

            else {
                $this->render('pages/admin/users_add.twig', [
                    'title'       => 'Add user',
                    'description' => 'Users - Just a simple inventory management system.',
                    'page'        => 'users',
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'username' => $username,
                        'email'    => $email
                    ]
                ]);
            }
        }

        else {
            $this->render('pages/admin/users_add.twig', [
                'title'       => 'Add user',
                'description' => 'Users - Just a simple inventory management system.',
                'page'        => 'users'
            ]);
        }
    }

    public function login() {
        if(!empty($_POST)) {
            $model = new UsersModel();

            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? hash('sha256', Settings::getConfig()['salt'] . $_POST['password']) : '';

            if($model->login($username, $password)) {
                $_SESSION['auth'] = $username;
                App::redirect('admin/dashboard');
            }

            else {
                $errors = [
                    "Your username and your password don't match."
                ];
            }
        }

        $this->render('pages/signin.twig', [
            'title'       => 'Sign in',
            'description' => 'Sign in to the dashboard',
            'errors'      => isset($errors) ? $errors : ''
        ]);
    }

    public function logout() {
        session_destroy();
        App::redirect();
    }

}
