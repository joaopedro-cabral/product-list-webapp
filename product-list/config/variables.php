<?php

// connect to database
$db = new DatabaseConn();
$conn = $db->getConnection();

// sets product types array
$product_types = [];

$book_type = createBook( $conn );
array_push($product_types, $book_type->getType());

$dvd_type = createDvd( $conn );
array_push($product_types, $dvd_type->getType());

$furniture_type = createFurniture( $conn );
array_push($product_types, $furniture_type->getType());

// sets product type class map
$product_type_class_map = [
    'Book' => 'createBook',
    'Dvd' => 'createDvd',
    'Furniture' => 'createFurniture'
];

// sets form input type class map
$form_input_class_map = [
    'Book' => 'createBookOptionValidation',
    'Dvd' => 'createDvdOptionValidation',
    'Furniture' => 'createFurnitureOptionValidation'
];

?>