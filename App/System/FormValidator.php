<?php
namespace App\System;

use \App\Models\CategoriesModel;

class FormValidator {

    private $errors = [];

    public function notEmpty($element, $value, $message) {
        if(empty($value)) {
            $this->errors[$element] = $message;
        }
    }

    public function validCategory($element, $value, $message) {
        $model    = new CategoriesModel();
        $category = $model->find($value);

        if(!$category) {
            $this->errors[$element] = $message;
        }
    }

    public function isNumeric($element, $value, $message) {
        if(!is_numeric($value)) {
            $this->errors[$element] = $message;
        }
    }

    public function isInteger($element, $value, $message) {
        if(!is_int(intval($value))) {
            $this->errors[$element] = $message;
        }
    }

    public function isValid() {
        if(empty($this->errors)) return true;
        else return false;
    }

    public function getErrors() {
        return $this->errors;
    }

}
