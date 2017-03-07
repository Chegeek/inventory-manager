<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\ImageUpload;
use \App\System\Settings;
use \App\Controllers\Controller;
use \App\Models\RevisionsModel;
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

    public function edit($id) {
        if(!empty($_POST)) {
            $title       = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $category    = isset($_POST['category']) ? $_POST['category'] : '';
            $price       = isset($_POST['price']) ? (int) $_POST['price'] : '';
            $quantity    = isset($_POST['quantity']) ? (int) $_POST['quantity'] : '';

            $validator = new FormValidator();
            $validator->notEmpty('title', $title, "Your title must not be empty");
            $validator->notEmpty('description', $description, "Your description must not be empty");
            $validator->validCategory('category', $category, "Your category must be valid");
            $validator->isNumeric('price', $price, "Your price must be a number");
            $validator->isInteger('quantity', $quantity, "Your quantity must be a number");

            if($validator->isValid()) {
                $model = new ProductsModel();
                $model->update($id, [
                    'title'       => $title,
                    'description' => $description,
                    'category'    => $category,
                    'price'       => $price,
                    'quantity'    => $quantity
                ]);

                $revisions = new RevisionsModel();
                $revisions->create([
                    'type'    => 'products',
                    'type_id' => $id,
                    'user'    => $_SESSION['auth']
                ]);

                App::redirect('admin/products');
            }

            else {
                $model = new CategoriesModel();
                $categories  = $model->all();

                $model2 = new RevisionsModel();
                $revisions = $model2->revisions($id, 'products');

                $this->render('pages/admin/products_add.twig', [
                    'title'       => 'Edit product',
                    'description' => 'Products - Just a simple inventory management system.',
                    'page'        => 'products',
                    'errors'      => $validator->getErrors(),
                    'revisions'   => $revisions,
                    'categories'  => $categories,
                    'data'        => [
                        'title'       => $title,
                        'description' => $description,
                        'price'       => $price,
                        'quantity'    => $quantity,
                        'category'    => $category
                    ]
                ]);
            }
        }

        else {
            $model = new CategoriesModel();
            $categories  = $model->all();

            $model2 = new ProductsModel();
            $data   = $model2->find($id);

            $model3 = new RevisionsModel();
            $revisions = $model3->revisions($id, 'products');

            $this->render('pages/admin/products_edit.twig', [
                'title'       => 'Edit product',
                'description' => 'Products - Just a simple inventory management system.',
                'page'        => 'products',
                'revisions'   => $revisions,
                'data'        => $data,
                'categories'  => $categories
            ]);
        }
    }

    public function delete($id) {
        if(!empty($_POST)) {
            $model = new ProductsModel();
            $file  = $model->find($id)->media;
            unlink(__DIR__ . '/../../public/uploads/' . $file);
            $model->delete($id);

            App::redirect('admin/products');
        }

        else {
            $model = new ProductsModel();
            $data  = $model->find($id);
            $this->render('pages/admin/products_delete.twig', [
                'title'       => 'Delete product',
                'description' => 'Products - Just a simple inventory management system.',
                'page'        => 'products',
                'data'        => $data
            ]);
        }
    }

    public function search($get) {
        $query = isset($get['query']) ? $get['query'] : '';
        $order = isset($get['order']) ? $get['order'] : '';

        $model = new ProductsModel();
        $data  = $model->search($order, $query);

        echo json_encode($data);
    }

    public function api($id = null) {
        if($id) {
            $model = new ProductsModel();
            $data  = $model->find($id);

            $data->media = Settings::getConfig()['url'] . 'uploads/' . $data->media;;

            echo json_encode($data);
        }

        else {
            $model = new ProductsModel();
            $data  = $model->all();

            foreach($data as $key => $element) {
                $data[$key]->media = Settings::getConfig()['url'] . 'uploads/' . $data[$key]->media;
            }

            echo json_encode($data);
        }
    }

    public function stats() {
        $model = new ProductsModel();
        $value = $model->value();
        $count = $model->count();
        $average_quantity = $model->average('quantity');
        $average_price    = $model->average('price');
        $lows_products    = $model->low(1);

        $model2 = new CategoriesModel();
        $categories_value = $model2->allotment();

        $stats = [
            'value' => $value,
            'count' => $count,
            'average_quantity' => $average_quantity,
            'average_price'    => $average_price,
            'categories'       => $categories_value,
            'lows_products'    => $lows_products
        ];

        echo json_encode($stats);
    }

}
