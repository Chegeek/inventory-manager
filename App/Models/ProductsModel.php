<?php
namespace App\Models;

use \App\System\App;
use \App\Models\Model;

class ProductsModel extends Model {

    protected $table = "products";

    public function all() {
        return $this->query('SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category 
                             FROM products 
                             LEFT JOIN categories 
                             ON products.category = categories.id
                             ORDER BY products.id');
    }

}
