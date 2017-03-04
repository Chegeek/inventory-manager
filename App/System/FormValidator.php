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

    public function validImage($element, $value, $message) {
        if(empty($value)) {
            $this->errors[$element] = $message;
        }

        else {
            if(empty($value['type'])) {
                $this->errors[$element] = $message;
                return;
            }

            if(!exif_imagetype($value['tmp_name'])) {
                $this->errors[$element] = $message;
                return;
            }

            if(getimagesize($value["tmp_name"])[0] != getimagesize($value["tmp_name"])[1]) {
                $this->errors[$element] = "Your media must have the same width and height";
                return;
            }

            if($value['size'] > 1000000) {
                $this->errors[$element] = "Your media is too big (> 1Mo)";
                return;
            }
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
