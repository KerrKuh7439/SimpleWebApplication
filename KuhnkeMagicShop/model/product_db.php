<?php

// Connect to the database
require_once __DIR__ . '/../db.php';

/*
 * Get all products from the products table.
 */
function get_products() {
    global $conn;

    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);

    $products = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    return $products;
}

/*
 * Get one product using its product ID.
 */
function get_product($product_id) {
    global $conn;

    // Make sure the product ID is treated as a number.
    $product_id = (int)$product_id;

    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_assoc($result);
}

?>