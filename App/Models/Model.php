<?php
namespace App\Models;

use \App\System\App;

class Model {
    
    protected $table;

    public function all() {
        return $this->query('SELECT * FROM ' . $this->table);
    }

    public function find($id) {
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }

    public function update($id, $fields) {
        $sql_parts  = [];
        $attributes = [];

        foreach($fields as $k => $v) {
            $sql_parts[]  = "$k = ?";
            $attributes[] = $v;
        }

        $attributes[] = $id;
        $sql_part = implode(', ', $sql_parts);

        return $this->query("UPDATE {$this->table} SET $sql_part WHERE id = ?", $attributes, true);
    }

    public function delete($id){
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id], true);
    }

    public function create($fields) {
        $sql_parts  = [];
        $attributes = [];

        foreach($fields as $k => $v) {
            $sql_parts[]  = "$k = ?";
            $attributes[] = $v;
        }

        $sql_part = implode(', ', $sql_parts);

        return $this->query("INSERT INTO {$this->table} SET $sql_part", $attributes, true);
    }

    public function query($statement, $attributes = null, $one = false) {
        if($attributes){
            return App::getDb()->prepare(
                $statement,
                $attributes,
                $one
            );
        }

        else {
            return App::getDb()->query(
                $statement,
                $one
            );
        }
    }

}
