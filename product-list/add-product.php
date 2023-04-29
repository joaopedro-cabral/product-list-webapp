<!DOCTYPE html>
<html lang="en">

    <?php include ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/scandiweb/product-list/template/header.php' ); ?>

        <body class="d-flex flex-column min-vh-100">
            <div class="preloader">
                <div class="loader"></div>
            </div>
            <form id="product_form" method="POST" novalidate>
            <nav class="navbar sticky-top navbar-expand-sm shadow p-4 bg-white rounded-bottom">
                <div class="container">
                    <div class="navbar-brand d-flex flex-row align-items-center">
                        <div class="rectangle"></div>
                        <h3 class="mx-2 my-1">add
                            <small class="text-muted">product</small>
                        </h3>
                    </div>
                    <ul class="navbar-nav">
                        <button type="submit" name="submit" id="save-product" class="nav-item my-1 mx-2 btn text-light rounded-pill">Save</button>
                        <button href="index.php" id="cancel-add" class="nav-item mx-2 my-1 btn rounded-pill">Cancel</button>
                    </ul>
                </div>
            </nav>
            <!--MAIN FORM-->
            <div class="my-5 mx-md-5">
                <div class="bg-white shadow container-fluid w-75 rounded-5 py-2 px-4">
                    <!--PRODUCT SKU-->
                    <div id="sku_group" class="form-group my-3">
                        <label class="col-form-label" for="sku">SKU</label>
                        <div>
                            <input type="text" class="form-control rounded-pill" name="sku" id="sku" value="<?php echo isset($_POST['sku']) ? htmlspecialchars($_POST['sku']) : ''; ?>" placeholder="Product SKU...">
                        </div>
                    </div>
                    <!--PRODUCT NAME-->
                    <div id="name_group" class="form-group my-3">
                        <label class="col-form-label" for="name">Name</label>
                        <div>
                            <input type="text" class="form-control rounded-pill" name="name" id="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" placeholder="Product Name...">
                        </div>
                    </div>
                    <!--PRODUCT PRICE-->
                    <div id="price_group" class="form-group my-3">
                        <label class="col-form-label" for="price">Price ($)</label>
                        <div>
                            <input type="text" class="form-control rounded-pill" name="price" id="price" placeholder="Product price...">
                        </div>
                    </div>
                    <!--PRODUCT TYPE SWITCHER-->
                    <div id="type_group" class="form-group row my-4">
                        <label class="col-sm-2 col-form-label" for="productType">Type Switcher</label>
                        <div class="col-sm-6">
                            <select class="form-select rounded-pill" name="type" id="productType">
                                <option selected disabled>Select your product type...</option>
                                <option value="Book|Weight">Book</option>
                                <option value="Dvd|Size">DVD</option>
                                <option value="Furniture|Measures">Furniture</option>
                            </select>
                        </div>
                    </div>
                    <!--PRODUCT SIZE-->
                    <div class="form-group my-3 d-none" id="productSizeField">
                        <label class="col-form-label" for="size">Size (MB)</label>
                        <div>
                            <input type="text" class="form-control rounded-pill" placeholder="Product size..." name="size" id="size">
                        </div>
                        <!--ATTRIBUTE DESCRIPTION-->
                        <small class="text-muted mt-2">Please, provide size.</small>
                    </div>
                    <!--PRODUCT WEIGHT-->
                    <div class="form-group my-3 d-none" id="productWeightField">
                        <label class="col-form-label" for="weight">Weight (Kg)</label>
                        <div>
                            <input type="text" class="form-control rounded-pill" placeholder="Product weight..." name="weight" id="weight">
                        </div>
                        <!--ATTRIBUTE DESCRIPTION-->
                        <small class="text-muted mt-2">Please, provide weight.</small>
                    </div>
                    <!--PRODUCT MEASURES-->
                    <div class="form-group row my-3 d-none justify-content-around" id="productMeasuresField">
                        <div class="col-auto">
                            <label class="col-form-label" for="height">Height (cm)</label>
                            <div>
                                <input type="text" class="form-control rounded-pill" placeholder="Height..." name="height" id="height">
                            </div>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label" for="width"> Width (cm)</label>
                            <div>
                                <input type="text" class="form-control rounded-pill" placeholder="Width..." name="width" id="width">
                            </div>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label" for="length">Length (cm)</label>
                            <div>
                                <input type="text" class="form-control rounded-pill" placeholder="Length..." name="length" id="length">   
                            </div>
                        </div>
                        <!--ATTRIBUTE DESCRIPTION-->
                        <small class="text-muted mt-2">Please, provide dimensions.</small>
                    </div>
                </div>
            </div>
        </form> 

        <?php include ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/scandiweb/product-list/template/footer.php' ); ?>
</html>