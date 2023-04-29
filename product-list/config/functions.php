<?php

// product classes
use Products\Types\Book;
use Products\Types\Dvd;
use Products\Types\Furniture;

// form classes
use Form\Input\FormValidation;
use Form\Input\BookOptionValidation;
use Form\Input\DvdOptionValidation;
use Form\Input\FurnitureOptionValidation;


function createBook( $conn ){
    return new Book( $conn );
}

function createDvd( $conn ){
    return new Dvd( $conn );
}

function createFurniture( $conn ){
    return new Furniture( $conn );
}

function createBookOptionValidation()
{
    return new BookOptionValidation();
}

function createDvdOptionValidation()
{
    return new DvdOptionValidation();
}

function createFurnitureOptionValidation()
{
    return new FurnitureOptionValidation();
}

function getProducts( $conn, $product_types, $product_type_class_map, $ajax_request = null )
{
    // set product list
    $products = array();
    $products[ 'body' ] = array();
    $products[ 'itemCount' ] = 0;

    foreach ( $product_types as $product_type ){

        if (!isset($product_type_class_map[$product_type])) {
            throw new Exception('Invalid Product Type!');
        } else {
            $product_classname = $product_type_class_map[$product_type];
            $items = $product_classname( $conn );
            $stmt = $items->getProducts();
            $item_count = $stmt->rowcount();
            
            // insert items in array
            if( $item_count > 0 ) {
                    
                $products[ 'itemCount' ] += $item_count;
                while ( $row = $stmt->fetch( PDO::FETCH_ASSOC )) {
                    extract( $row );
                    $e = array(
                        "sku" => $sku,
                        "name" => $name,
                        "price" => $price,
                        "type" => $type,
                        "attribute" => $attribute,
                    );
                    // populate product list with the item brought from db
                    array_push( $products[ 'body' ], $e );
                } 
            }
        }
    };
    
    // sort the product list by sku value
    $sku_values = array_column( $products[ 'body' ], 'sku' );
    array_multisort( $sku_values, SORT_ASC, $products[ 'body' ] );
    
    if( $_SERVER[ 'REQUEST_METHOD' ] == 'GET' && isset( $ajax_request ) ) {
        //gets product-list
        echo json_encode( $products[ 'body' ] );
    } else {
        return $products['body'];
    }
}

function addProduct( $conn, $post_data, $form_input_class_map, $product_type_class_map )
{
    $errors = [];
    $data = [];

    // instanciates attribute polyphormed class
    if ( !empty( $post_data[ 'data' ][ 'type' ] ) ){
        $selected_val = explode( '|' , $post_data[ 'data' ][ 'type' ] );
        $type_val = $selected_val[ 0 ];

        if ( !isset($form_input_class_map[ $type_val ] ) ) {
            throw new Exception( 'Product type not found!' );
        } else {
            $option_class = $form_input_class_map[ $type_val ];
            $option_validate =  $option_class();
            $form_validation = new FormValidation( $post_data , $conn , $option_validate );
        }
    } else {
        $form_validation = new FormValidation( $post_data , $conn );
    }

    $errors = $form_validation->validateForm();

    if ( !empty( $errors ) ) {
        $data[ 'success' ] = false;
        $data[ 'errors' ] = $errors;
    } else {
        // instanciate product
        if ( !isset( $product_type_class_map [ $type_val ] ) ) {
            throw new Exception( 'Invalid Product Type!' );
        } else {
            $product_classname = $product_type_class_map[ $type_val ];
            $product = $product_classname( $conn );

            // gets product type
            $post_data[ 'data' ][ 'type' ] = $product->getType();

            // gets product attribute
            $post_data[ 'data' ][ 'attribute' ] = $product->getAttribute( $post_data[ 'data' ] );

            // adds product
            if ($product->setProduct( $post_data[ 'data' ] )){
                $data[ 'success' ] = true;
                $data[ 'message' ] = 'Product Added!';
            } else {
                $data[ 'success' ] = false;
                $data[ 'message' ] = 'Error while adding product. Try again!';
            }
        }
    }

    echo json_encode( $data );
}

function massDelete( $conn, $post_data, $product_types, $product_type_class_map )
{
    $sku_list = $post_data['data'];
    
    foreach($sku_list as $sku) 
    {
        foreach ($product_types as $type) 
        {
            if (!isset($product_type_class_map[$type])) {
                throw new Exception($type . ' class not instanciated!');
            } else {
                $product_classname = $product_type_class_map[$type];

                $product = $product_classname( $conn );

                if($product->deleteProduct( $sku ))
                {
                    $data[ 'success' ] = true;
                    $data[ 'message' ] = 'Product(s) Deleted!';
                }
            }
        }    
    }
                    
    echo json_encode($data);
}

?>