<?php
namespace App\Models;

use \App\System\App;
use \App\Models\Model;

class CategoriesModel extends Model {

    protected $table = "categories";

    public function allotment() {
        $categories = $this->all();
        $categories_value = [];

        foreach($categories as $category) {
            $count = count($this->query("SELECT id FROM products WHERE category = ?", [$category->id]));
            $categories_value[] = [
                "{$category->title}" => "{$count}"
            ];
        }

        return $categories_value;
    }

}
