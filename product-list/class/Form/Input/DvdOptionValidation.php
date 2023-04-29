<?php

namespace Form\Input;

include_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/class/Form/Input/OptionValidation.php');

use Form\Input\OptionValidation as OptionValidation;

class DvdOptionValidation implements OptionValidation 
{
    private $errors = [];

    public function validate($form_data){

        if(empty($form_data['size'])){
            return $this->errors['size'] = 'Please, provide the data of "size"';
        } else {
            if(!preg_match('/^\d*(\.\d+)?$/', $form_data['size'])){
                return $this->errors['size'] = 'Product size should be numeric.';
            };
        };
    }
}

?>