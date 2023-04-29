<?php

namespace Products\Types;

abstract class Products
{
    // defines product type
    protected $product_type;

    // File connection
    protected $conn;

    // MySQL Table
    protected $db_table = 'products';

    // Table columns
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $attribute;

    // set connection
    public function __construct( $db ) { 
        $this->conn = $db;
    }

    abstract protected function getType();
    abstract protected function getAttribute( $data );
    abstract protected function getProduct( $id );
    abstract protected function getProducts();
    abstract protected function setProduct( $data );
    abstract protected function deleteProduct( $id );
    
}

?>