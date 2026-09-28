<?php

// Start session so the catalog can display
// the current quantities in the shopping cart.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Match product IDs with image files.
$product_images = [
    1 => 'apprentice-wand.jpg',
    2 => 'cauldron-kit.jpg',
    3 => 'spellbook-journal.jpg',
    4 => 'house-scarf.jpg',
    5 => 'owl-messenger-bag.jpg'
];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>The Enchanted Cauldron - Catalog</title>

    <link rel="stylesheet"
          href="../css/styles.css">

    <style>

        .product-card img {
            width: 100%;
            max-width: 220px;
            height: 220px;
            object-fit: cover;
            display: block;
            margin: 0 auto 15px;
            border-radius: 8px;
        }

        .cart-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin-top: 15px;
        }

        .cart-controls button {
            cursor: pointer;
            min-width: 40px;
        }

        .cart-controls span {
            min-width: 30px;
            text-align: center;
            font-weight: bold;
        }

        .add-cart-button {
            display: block;
            margin: 15px auto 5px;
            cursor: pointer;
        }

        .cart-message {
            min-height: 20px;
            margin-top: 8px;
            text-align: center;
            font-weight: bold;
        }

    </style>

</head>


<body>


<header>

    <h1>The Enchanted Cauldron</h1>

    <nav>

        <a href="../index.php">
            Home
        </a>

        <a href="../controller/catalog_controller.php">
            Shop
        </a>

        <a href="../controller/cart_controller.php">
            Shopping Cart
        </a>

    </nav>

</header>


<main class="container">

    <h2>Magical Catalog</h2>


    <div class="product-grid">


        <?php foreach ($products as $product): ?>


            <?php

            $product_id =
                (int)$product['product_id'];

            $image =
                $product_images[$product_id] ?? '';

            // Get actual quantity currently in cart.
            $cart_quantity =
                $_SESSION['cart'][$product_id] ?? 0;

            ?>


            <div class="product-card">


                <?php if ($image): ?>

                    <img
                        src="../images/<?php echo htmlspecialchars($image); ?>"
                        alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                    >

                <?php endif; ?>


                <h3>

                    <?php
                    echo htmlspecialchars(
                        $product['product_name']
                    );
                    ?>

                </h3>


                <p>

                    <?php
                    echo htmlspecialchars(
                        $product['product_description']
                    );
                    ?>

                </p>


                <p class="price">

                    $<?php
                    echo number_format(
                        $product['product_cost'],
                        2
                    );
                    ?>

                </p>


                <!-- Add first item -->

                <button
                    type="button"
                    class="add-cart-button"
                    id="add-button-<?php echo $product_id; ?>"
                    onclick="addToCart(
                        <?php echo $product_id; ?>
                    )"
                >
                    Add to Cart
                </button>


                <!-- Quantity controls -->

                <div class="cart-controls">

                    <button
                        type="button"
                        onclick="changeCartQuantity(
                            <?php echo $product_id; ?>,
                            'decrease'
                        )"
                    >
                        −
                    </button>


                    <span
                        id="quantity-<?php echo $product_id; ?>"
                    >
                        <?php echo $cart_quantity; ?>
                    </span>


                    <button
                        type="button"
                        onclick="changeCartQuantity(
                            <?php echo $product_id; ?>,
                            'increase'
                        )"
                    >
                        +
                    </button>

                </div>


                <div
                    class="cart-message"
                    id="message-<?php echo $product_id; ?>"
                ></div>


            </div>


        <?php endforeach; ?>


    </div>

</main>


<script>


/*
 * Send an action to the Cart Controller.
 */
function sendCartAction(productId, action) {

    const formData =
        new FormData();

    formData.append(
        'product_id',
        productId
    );

    formData.append(
        'action',
        action
    );


    return fetch(
        '../controller/cart_controller.php',
        {

            method: 'POST',

            headers: {

                'X-Requested-With':
                    'XMLHttpRequest'

            },

            body: formData

        }
    );

}


/*
 * Add To Cart adds ONE item.
 */
function addToCart(productId) {

    const quantityElement =
        document.getElementById(
            'quantity-' + productId
        );


    sendCartAction(
        productId,
        'add'
    )

    .then(response => response.text())

    .then(() => {

        let quantity =
            parseInt(
                quantityElement.textContent
            );

        quantity++;

        quantityElement.textContent =
            quantity;


        showMessage(
            productId,
            'Added to cart!'
        );

    })

    .catch(error => {

        console.error(
            'Error adding product:',
            error
        );

    });

}


/*
 * Plus and minus change the ACTUAL
 * quantity in the shopping cart.
 */
function changeCartQuantity(
    productId,
    action
) {

    const quantityElement =
        document.getElementById(
            'quantity-' + productId
        );


    let quantity =
        parseInt(
            quantityElement.textContent
        );


    /*
     * Don't allow quantity below zero.
     */
    if (
        action === 'decrease' &&
        quantity === 0
    ) {

        return;

    }


    /*
     * If + is clicked when quantity is zero,
     * use "add" so the item is created.
     */
    let controllerAction =
        action;

    if (
        action === 'increase' &&
        quantity === 0
    ) {

        controllerAction =
            'add';

    }


    sendCartAction(
        productId,
        controllerAction
    )

    .then(response => response.text())

    .then(() => {


        if (action === 'increase') {

            quantity++;

        }


        if (
            action === 'decrease' &&
            quantity > 0
        ) {

            quantity--;

        }


        quantityElement.textContent =
            quantity;


        showMessage(
            productId,
            'Cart updated!'
        );

    })

    .catch(error => {

        console.error(
            'Error updating cart:',
            error
        );

    });

}


/*
 * Brief confirmation message.
 */
function showMessage(
    productId,
    text
) {

    const message =
        document.getElementById(
            'message-' + productId
        );


    message.textContent =
        text;


    setTimeout(() => {

        message.textContent =
            '';

    }, 1200);

}


</script>


</body>

</html>