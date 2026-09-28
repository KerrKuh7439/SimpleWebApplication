<?php

// Load the Product Model
require_once __DIR__ . '/../model/product_db.php';

// Get all products from the Model
$products = get_products();

// Load the Catalog View
require_once __DIR__ . '/../view/catalog_view.php';