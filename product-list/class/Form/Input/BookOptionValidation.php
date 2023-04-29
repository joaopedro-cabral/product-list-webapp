<?php

namespace Form\Input;

include_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/class/Form/Input/OptionValidation.php');

use Form\Input\OptionValidation as OptionValidation;

class BookOptionValidation implements OptionValidation
{
    private $errors = [];

    public function validate($form_data){

        if(empty($form_data['weight'])){
            return $this->errors['weight'] = 'Please, provide the data of "weight"';
        } else {
            if(!preg_match('/^\d*(\.\d+)?$/', $form_data['weight'])){
                return $this->errors['weight'] = 'Product weight should be numeric.';
            };
        };

    }
}

?>