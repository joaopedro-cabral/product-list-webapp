<?php

//web-app main config
require_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/config/db_connection.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/config/classes.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/config/functions.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/config/variables.php');

//gets product-list
$product_list = getProducts($conn, $product_types, $product_type_class_map);

?>

<!DOCTYPE html>
<html lang="en">
        
    <?php include ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/scandiweb/product-list/template/header.php' ); ?>

        <body class="d-flex flex-column min-vh-100">
            <div class="preloader">
                <div class="loader"></div>
            </div>
            <nav class="navbar sticky-top navbar-expand-sm shadow p-4 bg-white rounded-bottom">
                <div class="container d-flex justify-content-center justify-content-md-between">
                    <div class="navbar-brand">
                        <h3>product list</h3>
                    </div>
                    <ul class="navbar-nav d-flex flex-row">
                        <button href="add-product.php" id="add-page" class="nav-item mx-2 btn text-light rounded-pill">ADD</button>
                        <button id="delete-product-btn" data-toggle="tooltip" title="" class="nav-item mx-2 btn btn-dark text-light rounded-pill">MASS DELETE</button>
                    </ul>
                </div>
            </nav>
            <!--PRODUCT GRID-->
            <div class="container my-5">
                <div id="product-list" class="row">

                <?php foreach( $product_list as $product ): // render product list array in html ?>

                    <div id="item_<?php echo $product[ 'sku' ] ?>" class="col-md-3 my-4">
                        <div id="product-item" class="card shadow-sm border-0 h-100" >
                            <div class="card-header d-flex flex-row align-items-center">
                                <div class="form-check">
                                    <input class="delete-checkbox form-check-input" type="checkbox" value="<?php echo $product[ 'sku' ] ?>" id="flexCheckDefault">
                                </div>
                                <h6><?php echo htmlspecialchars( $product[ 'sku' ] ); ?></h6>
                            </div>
                            <div class="card-body d-flex flex-column align-items-start">
                                <h5 class="card-title"><?php echo htmlspecialchars( $product[ 'name' ] ); ?></h5>
                                <p><?php echo htmlspecialchars( $product[ 'attribute' ] ); ?></p>
                            </div>
                            <div class="card-body d-flex align-items-end">
                                <p class="text-success h5"><?php echo htmlspecialchars( $product[ 'price' ] ); ?> $</p>
                            </div>  
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        
    <?php include ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/scandiweb/product-list/template/footer.php' ); ?>

</html>