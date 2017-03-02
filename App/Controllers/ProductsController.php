<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\Settings;
use \App\Controllers\Controller;
use \App\Models\ProductsModel;

class ProductsController extends Controller {

    public function blank() {
        $this->render('pages/index.twig', [
            'description' => 'Just a simple inventory management system.'
        ]);
    }

    public function index() {
        $model = new ProductsModel();
        $data  = $model->all();

        $this->render('pages/admin/dashboard.twig', [
            'title'       => 'Dashboard',
            'description' => 'Dashboard - Just a simple inventory management system.',
            'page'        => 'dashboard',
            'products'    => $data
        ]);
    }

    public function all() {
        $model = new ProductsModel();
        $data  = $model->all();

        $this->render('pages/admin/products.twig', [
            'title'       => 'Products',
            'description' => 'Products - Just a simple inventory management system.',
            'page'        => 'products',
            'products'    => $data
        ]);
    }

    public function single($id, $slug) {
        $model = new ProductsModel();
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
