<?php

//web-app main config
require_once ( $_SERVER['DOCUMENT_ROOT' ] . '/scandiweb/product-list/config/db_connection.php' );
include_once ( $_SERVER['DOCUMENT_ROOT' ] . '/scandiweb/product-list/config/classes.php' );
include_once ( $_SERVER['DOCUMENT_ROOT' ] . '/scandiweb/product-list/config/functions.php' );
include_once ( $_SERVER['DOCUMENT_ROOT' ] . '/scandiweb/product-list/config/variables.php' );

if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    switch( $_POST[ 'action' ] )
    {
        case 'delete':
            //deletes product
            massDelete( $conn, $_POST, $product_types, $product_type_class_map );
            break;
        case 'insert':
            //add product
            addProduct( $conn, $_POST, $form_input_class_map, $product_type_class_map );
            break;
    }
} 

if( $_SERVER[ 'REQUEST_METHOD' ] == 'GET' ) {
    $ajax_request = true;
    //gets product-list
    getProducts( $conn, $product_types, $product_type_class_map, $ajax_request );
}

?>