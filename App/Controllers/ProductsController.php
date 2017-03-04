<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\ImageUpload;
use \App\System\Settings;
use \App\Controllers\Controller;
use \App\Models\CategoriesModel;
use \App\Models\ProductsModel;
use \App\System\FormValidator;

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
        $count = count($data);

        $this->render('pages/admin/products.twig', [
            'title'       => 'Products',
            'description' => 'Products - Just a simple inventory management system.',
            'page'        => 'products',
            'products'    => $data,
            'count'       => $count
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

    public function add() {
        if(!empty($_POST)) {
            $title       = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $category    = isset($_POST['category']) ? $_POST['category'] : '';
            $price       = isset($_POST['price']) ? (int) $_POST['price'] : '';
            $quantity    = isset($_POST['quantity']) ? (int) $_POST['quantity'] : '';
            $media       = isset($_FILES['media']) ? $_FILES['media'] : '';

            $validator = new FormValidator();
            $validator->notEmpty('title', $title, "Your title must not be empty");
            $validator->notEmpty('description', $description, "Your description must not be empty");
            $validator->validCategory('category', $category, "Your category must be valid");
            $validator->isNumeric('price', $price, "Your price must be a number");
            $validator->isInteger('quantity', $quantity, "Your quantity must be a number");
            $validator->validImage('media', $media, "You didn't provided a media or it is invalid");

            if($validator->isValid()) {
                $upload    = new ImageUpload();
                $media_url = $upload->add($media);

                $model = new ProductsModel();
                $model->create([
                    'title'       => $title,
                    'description' => $description,
                    'category'    => $category,
                    'price'       => $price,
                    'quantity'    => $quantity,
                    'media'       => $media_url
                ]);

                App::redirect('admin/products');
            }

            else {
                $model = new CategoriesModel();
                $categories  = $model->all();
                $this->render('pages/admin/products_add.twig', [
                    'title'       => 'Add product',
                    'description' => 'Products - Just a simple inventory management system.',
                    'page'        => 'products',
                    'errors'      => $validator->getErrors(),
                    'categories'  => $categories,
                    'data'        => [
                        'title'       => $title,
                        'description' => $description,
                        'price'       => $price,
                        'quantity'    => $quantity
                    ]
                ]);
            }
        }

        else {
            $model = new CategoriesModel();
            $categories  = $model->all();
            $this->render('pages/admin/products_add.twig', [
                'title'       => 'Add product',
                'description' => 'Products - Just a simple inventory management system.',
                'page'        => 'products',
                'categories'  => $categories
            ]);
        }
    }

}
