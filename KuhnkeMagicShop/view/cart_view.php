<?php

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

    <title>
        The Enchanted Cauldron - Shopping Cart
    </title>

    <link rel="stylesheet"
          href="../css/styles.css">

    <!-- Cart-specific styling -->
    <style>

        .cart-item {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 25px;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
        }

        .cart-item img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .cart-item-info {
            flex: 1;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .quantity-controls form {
            margin: 0;
        }

        .quantity-controls button {
            cursor: pointer;
        }

        .quantity-number {
            min-width: 25px;
            text-align: center;
            font-weight: bold;
        }

        .cart-summary {
            margin-top: 30px;
        }

        .cart-summary a {
            display: inline-block;
            margin-right: 15px;
        }

    </style>

</head>


<body>

<header>

    <h1>
        The Enchanted Cauldron
    </h1>

    <nav>

        <a href="../index.php">
            Home
        </a>

        <a href="catalog_controller.php">
            Catalog
        </a>

        <a href="cart_controller.php">
            Shopping Cart
        </a>

    </nav>

</header>


<main class="container">

    <h2>
        Shopping Cart
    </h2>


    <div id="cart-content">

        <?php if (empty($cart_items)): ?>

            <p>
                Your shopping cart is empty.
            </p>

            <a href="catalog_controller.php">
                Continue Shopping
            </a>


        <?php else: ?>


            <div class="cart-items">

                <?php foreach ($cart_items as $item): ?>

                    <?php

                    $product_id =
                        $item['product_id'];

                    $image =
                        $product_images[$product_id] ?? '';

                    ?>

                    <div
                        class="cart-item"
                        id="item-<?php echo $product_id; ?>"
                    >

                        <?php if ($image): ?>

                            <img
                                src="../images/<?php echo htmlspecialchars($image); ?>"
                                alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                            >

                        <?php endif; ?>


                        <div class="cart-item-info">

                            <h3>
                                <?php
                                echo htmlspecialchars(
                                    $item['product_name']
                                );
                                ?>
                            </h3>


                            <p>

                                Price:

                                $<?php
                                echo number_format(
                                    $item['product_cost'],
                                    2
                                );
                                ?>

                            </p>


                            <p>

                                Item Total:

                                $<span
                                    id="item-total-<?php echo $product_id; ?>"
                                >
                                    <?php
                                    echo number_format(
                                        $item['item_total'],
                                        2
                                    );
                                    ?>
                                </span>

                            </p>


                            <div class="quantity-controls">


                                <button
                                    type="button"
                                    onclick="updateCart(
                                        <?php echo $product_id; ?>,
                                        'decrease'
                                    )"
                                >
                                    −
                                </button>


                                <span
                                    class="quantity-number"
                                    id="quantity-<?php echo $product_id; ?>"
                                >
                                    <?php
                                    echo $item['quantity'];
                                    ?>
                                </span>


                                <button
                                    type="button"
                                    onclick="updateCart(
                                        <?php echo $product_id; ?>,
                                        'increase'
                                    )"
                                >
                                    +
                                </button>


                                <button
                                    type="button"
                                    onclick="updateCart(
                                        <?php echo $product_id; ?>,
                                        'remove'
                                    )"
                                >
                                    Remove
                                </button>


                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>


            <div class="cart-summary">

                <h3>

                    Cart Total:

                    $<span id="cart-total">
                        <?php
                        echo number_format(
                            $cart_total,
                            2
                        );
                        ?>
                    </span>

                </h3>


                <a href="catalog_controller.php">
                    Continue Shopping
                </a>


                <a href="../checkout.php">
                    Checkout
                </a>

            </div>


        <?php endif; ?>

    </div>

</main>


<script>

function updateCart(productId, action) {

    const formData = new FormData();

    formData.append(
        'product_id',
        productId
    );

    formData.append(
        'action',
        action
    );


    fetch('cart_controller.php', {

        method: 'POST',

        headers: {
            'X-Requested-With':
                'XMLHttpRequest'
        },

        body: formData

    })

    .then(response => response.text())

    .then(() => {

        /*
         * Reload only the cart information
         * instead of navigating the whole page.
         */

        fetch('cart_controller.php')

        .then(response => response.text())

        .then(html => {

            const parser =
                new DOMParser();

            const documentData =
                parser.parseFromString(
                    html,
                    'text/html'
                );

            const newCart =
                documentData.querySelector(
                    '#cart-content'
                );

            const currentCart =
                document.querySelector(
                    '#cart-content'
                );

            if (newCart && currentCart) {

                currentCart.innerHTML =
                    newCart.innerHTML;

            }

        });

    });

}

</script>


</body>

</html>