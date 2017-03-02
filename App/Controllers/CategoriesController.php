<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\FormValidator;
use \App\System\Settings;
use \App\Controllers\Controller;
use \App\Models\CategoriesModel;
use \DateTime;

class CategoriesController extends Controller {

    public function all() {
        $model = new CategoriesModel();
        $data  = $model->all();

        $this->render('pages/admin/categories.twig', [
            'title'       => 'Categories',
            'description' => 'Categories - Just a simple inventory management system.',
            'page'        => 'categories',
            'categories'  => $data
        ]);
    }

    public function add() {
        if(!empty($_POST)) {
            $title       = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';

            $validator = new FormValidator();
            $validator->notEmpty('title', $title, "Your title must not be empty");
            $validator->notEmpty('description', $description, "Your description must not be empty");

            if($validator->isValid()) {
                $model = new CategoriesModel();
                $model->create([
                    'title'       => $title,
                    'description' => $description
                ]);

                App::redirect('admin/categories');
            }

            else {
                $this->render('pages/admin/categories_add.twig', [
                    'title'       => 'Add category',
                    'description' => 'Categories - Just a simple inventory management system.',
                    'page'        => 'categories',
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'title'       => $title,
                        'description' => $description
                    ]
                ]);
            }
        }

        else {
            $this->render('pages/admin/categories_add.twig', [
                'title'       => 'Add category',
                'description' => 'Categories - Just a simple inventory management system.',
                'page'        => 'categories'
            ]);
        }
    }

    public function edit($id) {
        if(!empty($_POST)) {
            $title       = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';

            $validator = new FormValidator();
            $validator->notEmpty('title', $title, "Your title must not be empty");
            $validator->notEmpty('description', $description, "Your description must not be empty");

            if($validator->isValid()) {
                $model = new CategoriesModel();
                $model->update($id, [
                    'title'       => $title,
                    'description' => $description
                ]);

                App::redirect('admin/categories');
            }

            else {
                $this->render('pages/admin/categories_add.twig', [
                    'title'       => 'Add category',
                    'description' => 'Categories - Just a simple inventory management system.',
                    'page'        => 'categories',
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'title'       => $title,
                        'description' => $description
                    ]
                ]);
            }
        }

        else {
            $model = new CategoriesModel();
            $data = $model->find($id);
            $this->render('pages/admin/categories_add.twig', [
                'title'       => 'Add category',
                'description' => 'Categories - Just a simple inventory management system.',
                'page'        => 'categories',
                'data'        => $data
            ]);
        }
    }

    public function delete($id) {
        if(!empty($_POST)) {
            $model = new CategoriesModel();
            $model->delete($id);

            App::redirect('admin/categories');
        }

        else {
            $model = new CategoriesModel();
            $data = $model->find($id);
            $this->render('pages/admin/categories_delete.twig', [
                'title'       => 'Delete category',
                'description' => 'Categories - Just a simple inventory management system.',
                'page'        => 'categories',
                'data'        => $data
            ]);
        }
    }

    public function single($id, $slug) {
        $model = new CategoriesModel();
        $data  = $model->find($id);

        if($data->slug === $slug) {
            $this->render('pages/single.twig', [
                'title'       => 'Single',
                'description' => 'Just a simple inventory management system.',
                'page'        => 'products',
                'post' => $data
            ]);
        }

        else {
            App::error();
        }
    }

}
