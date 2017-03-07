<?php
namespace App\Models;

use \App\System\App;
use \App\Models\Model;

class ProductsModel extends Model {

    protected $table = "products";

    public function all() {
        return $this->query("SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category 
                             FROM {$this->table}
                             LEFT JOIN categories 
                             ON products.category = categories.id
                             ORDER BY products.id");
    }

    public function search($order, $query) {
        if(!empty($query)) {
            return $this->query("SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category 
                                 FROM {$this->table} 
                                 LEFT JOIN categories 
                                 ON products.category = categories.id
                                 WHERE products.title LIKE ? 
                                 ORDER BY ?", [
                "%$query%",
                $order
            ]);
        }

        else {
            return $this->query("SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category 
                                 FROM {$this->table} 
                                 LEFT JOIN categories 
                                 ON products.category = categories.id
                                 ORDER BY ?", [
                $order
            ]);
        }
    }

    public function value() {
        $elements = $this->query("SELECT * FROM {$this->table}");
        return count($elements);
    }

    public function count() {
        $count = 0;

        foreach($this->query("SELECT quantity FROM {$this->table}") as $item) {
            $count+= $item->quantity;
        }

        return $count;
    }

    public function average($column) {
        $count = $this->value();
        $column_total = 0;

        foreach($this->query("SELECT $column FROM {$this->table}") as $item) {
            $column_total+= $item->$column;
        }

        return $column_total / $count;
    }

    public function low($count) {
        return $this->query("SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category 
                             FROM {$this->table}
                             LEFT JOIN categories 
                             ON products.category = categories.id
                             ORDER BY products.quantity ASC
                             LIMIT $count");
    }

}
