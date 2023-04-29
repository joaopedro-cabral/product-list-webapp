<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/class/Products/Types/Book.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/class/Products/Types/Dvd.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/class/Products/Types/Furniture.php');

//polymorph classes for product type attribute
require_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/class/Form/Input/BookOptionValidation.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/class/Form/Input/DvdOptionValidation.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/class/Form/Input/FurnitureOptionValidation.php');

//form validation
require_once ($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/product-list/class/Form/Input/FormValidation.php');

?>