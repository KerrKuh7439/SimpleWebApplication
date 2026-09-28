<?php

session_start();

require_once __DIR__ . '/../model/product_db.php';

// Create cart if it does not exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// -----------------------------------------
// PROCESS CART ACTIONS
// -----------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id = isset($_POST['product_id'])
        ? (int)$_POST['product_id']
        : 0;

    $action = $_POST['action'] ?? '';

    // Add product
    if ($action === 'add' && $product_id > 0) {

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
    }

    // Increase quantity
    elseif ($action === 'increase' && $product_id > 0) {

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        }
    }

    // Decrease quantity
    elseif ($action === 'decrease' && $product_id > 0) {

        if (isset($_SESSION['cart'][$product_id])) {

            $_SESSION['cart'][$product_id]--;

            if ($_SESSION['cart'][$product_id] <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }

    // Remove product
    elseif ($action === 'remove' && $product_id > 0) {

        unset($_SESSION['cart'][$product_id]);
    }

    // AJAX requests do not redirect.
    if (
        isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
    ) {
        echo 'success';
        exit;
    }

    // Normal form submission redirects to cart
    header('Location: cart_controller.php');
    exit;
}


// -----------------------------------------
// BUILD CART FOR VIEW
// -----------------------------------------

$cart_items = [];
$cart_total = 0;

foreach ($_SESSION['cart'] as $product_id => $quantity) {

    $product = get_product($product_id);

    if ($product) {

        $item_total =
            (float)$product['product_cost'] * $quantity;

        $cart_items[] = [
            'product_id'   => $product['product_id'],
            'product_name' => $product['product_name'],
            'product_cost' => $product['product_cost'],
            'quantity'     => $quantity,
            'item_total'   => $item_total
        ];

        $cart_total += $item_total;
    }
}


// -----------------------------------------
// LOAD VIEW
// -----------------------------------------

require_once __DIR__ . '/../view/cart_view.php';