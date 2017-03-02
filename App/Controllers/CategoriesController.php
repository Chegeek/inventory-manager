<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\Settings;
use \App\Controllers\Controller;
use \App\Models\CategoriesModel;

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
