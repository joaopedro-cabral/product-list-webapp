<?php

namespace Form\Input;

use Products\Types\Book;
use Products\Types\Dvd;
use Products\Types\Furniture;
use Form\Input\BookOptionValidation as BookOptionValidation;
use Form\Input\DvdOptionValidation as DvdOptionValidation;
use Form\Input\FurnitureOptionValidation as FurnitureOptionValidation;

class FormValidation
{
    private $conn;
    private $optionValidation;
    private $form_data;
    private $errors = [];
    private $types_attribute_map = [
        'Book' => 'Weight',
        'Dvd' => 'Size',
        'Furniture' => 'Measures',
    ];

    private $product_type_class_map = [
        'Book' => 'createBook',
        'Dvd' => 'createDvd',
        'Furniture' => 'createFurniture'
    ];

    public function __construct($post_data, $conn, OptionValidation $optionValidation = null){
        $this->form_data = $post_data['data'];
        $this->conn = $conn;

        if (isset($optionValidation)){
            $this->optionValidation = $optionValidation;
        }
    }

    public function validateForm(){
    
        foreach($this->form_data as $key => $value) {
            
                if (empty($this->form_data[$key]) && isset($this->form_data[$key])) {
                    $this->errors[$key] = 'Please, provide the data of "' . $key . '"';
                } else {
                    $validate_func = $key . 'Validation';
    
                    if (method_exists($this, $validate_func)){
                        $this->$validate_func($value);
                    }
                };

            if ($key == 'type') break;
        };

        return $this->errors;

    }

    private function skuValidation($input_val){

        $book_item = new Book ( $this->conn );
        $dvd_item = new Dvd ( $this->conn );
        $furniture_item = new Furniture ( $this->conn );

        if ($book_item->getProduct( $input_val ) || $dvd_item->getProduct( $input_val ) || $furniture_item->getProduct( $input_val)) {
            return $this->errors['sku'] = 'Product SKU already registered in database!';
        }
    }

    private function nameValidation($input_val){

        if(!preg_match("/^(?!\s)(?!.*\s$)(?=.*[a-zA-Z0-9])[a-zA-Z0-9 -_.'~?!]{2,}$/", $input_val)){
            $this->errors['name'] = "Product Name doensn't support the submitted values (special letters, space at the start or...)!";
        };

    }

    private function priceValidation($input_val){

        if(!preg_match('/^\d*(\.\d+)?$/', $input_val)){
            $this->errors['price'] = "Product price must be numeric!";
        };

    }

    private function typeValidation($input_val){

        if(!empty($input_val)){
            $selected_val = explode('|', $input_val);

            $attr_val = $selected_val[1];

            foreach ($this->types_attribute_map as $attr) {
                if ($attr == $attr_val){
                    $attr_error = $this->optionValidation->validate($this->form_data);

                    if (!empty($attr_error)){
                        $this->errors[strtolower($attr_val)] = $attr_error;    
                    }

                    $attr_validate_helper = strtolower($attr_val) . 'Validation';

                    if (method_exists($this, $attr_validate_helper)) {
                        $this->$attr_validate_helper();
                    }
                }
            };
        } 
    }

    private function measuresValidation(){

        $this->heightMeasureValidation($this->form_data['height']);
        $this->widthMeasureValidation($this->form_data['width']);
        $this->lengthMeasureValidation($this->form_data['length']);

    }

    private function heightMeasureValidation($input_val){

        if(empty($input_val)){
            $this->errors['height'] = "Empty field!";
        } else {
            if(!preg_match('/^\d*(\.\d+)?$/', $input_val)){
                $this->errors['height'] = "Must be numeric!";
            };
        }

    }

    private function widthMeasureValidation($input_val){

        if(empty($input_val)){
            $this->errors['width'] = "Empty field!";
        } else {
            if(!preg_match('/^\d*(\.\d+)?$/', $input_val)){
                $this->errors['width'] = "Must be numeric!";
            };
        }
        
    }

    private function lengthMeasureValidation($input_val){

        if(empty($input_val)){
            $this->errors['length'] = "Empty field!";
        } else {
            if(!preg_match('/^\d*(\.\d+)?$/', $input_val)){
                $this->errors['length'] = "Must be numeric!";
            };
        }

    }
}

?>