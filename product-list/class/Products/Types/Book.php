<?php

namespace Products\Types;

// include abstract class "product" and its methods
include_once ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/scandiweb/product-list/class/Products/Types/Products.php' );

use Products\Types\Products as Products;

class Book extends Products
{

    public $sku;
    public $name;
    public $price;
    public $type;
    public $attribute;

    public function __construct( $db )
    {
        $this->conn = $db;   
    }

    public function getType() {
        return 'Book';
    }

    public function getAttribute( $product_data ) {
        return $product_data['weight'] . ' kg';
    }

    public function getProduct( $sku ){
        $sql_query = 'SELECT sku FROM ' . $this->db_table . ' WHERE sku = :sku AND type = :type';
        $stmt = $this->conn->prepare( $sql_query );

        $stmt->bindValue( ':type', 'Book' );
        $stmt->bindValue( ':sku', $sku );

        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    public function getProducts() {
        $sql_query = 'SELECT sku, name, price, type, attribute FROM ' . $this->db_table . ' WHERE type = :type';
        $stmt = $this->conn->prepare( $sql_query );

        $stmt->bindValue( ':type', 'Book' );

        $stmt->execute();

        return $stmt;
    }

    public function setProduct( $product_data ){
        $sql_query = 'INSERT INTO ' . $this->db_table . 
                    ' SET sku = :sku, name = :name, price = :price, type = :type, attribute = :attribute';
        $stmt = $this->conn->prepare( $sql_query );

        //sanitize post data
        $this->sku=htmlspecialchars(strip_tags( $product_data[ 'sku' ] ));
        $this->name=htmlspecialchars(strip_tags( $product_data[ 'name' ] ));
        $this->price=htmlspecialchars(strip_tags( $product_data[ 'price' ] ));
        $this->type=htmlspecialchars(strip_tags( $product_data[ 'type' ] ));
        $this->attribute=htmlspecialchars(strip_tags( $product_data[ 'attribute' ] ));

        //bind post data
        $stmt->bindValue( ':sku', $this->sku );
        $stmt->bindValue( ':name', $this->name );
        $stmt->bindValue( ':price', $this->price );
        $stmt->bindValue( ':type', $this->type );
        $stmt->bindValue( ':attribute', $this->attribute );
        $stmt->execute();

        return $stmt; 
    }

    public function deleteProduct( $sku ){
        //$sql_query = 'DELETE FROM ' . $this->db_table . ' WHERE sku = :sku';
        $sql_query = 'DELETE FROM ' . $this->db_table . ' WHERE sku = :sku AND type = :type';
        $stmt = $this->conn->prepare( $sql_query );

        $stmt->bindValue( ':sku', $sku );
        $stmt->bindValue( ':type', 'Book' );

        $stmt->execute();

        return $stmt;
    }
}

?>