<?php

namespace Form\Input;

include_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/class/Form/Input/OptionValidation.php');

use Form\Input\OptionValidation as OptionValidation;

class FurnitureOptionValidation implements OptionValidation
{
    private $errors = [];
    private $empty = [];
    private $measures_map = ['height', 'width', 'length'];

    public function validate($form_data){

        foreach($this->measures_map as $measure) {
            if(empty($form_data[$measure])){
                $this->empty[] = $measure;
            } else {
                if(!preg_match('/^\d*(\.\d+)?$/', $form_data[$measure])){
                    return $this->errors['measures'] = 'Product measures should be numeric!';
                };
            }
        }

        if(count($this->empty) > 0){
            $this->errors['measures'] = 'Please, provide the numeric data of: ' . implode(', ', $this->empty);

            return $this->errors['measures'];
        }
    }
}

?>