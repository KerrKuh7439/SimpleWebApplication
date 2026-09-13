<?php
session_start();

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

$products = [
    1 => [
        "name" => "Apprentice Wand",
        "description" => "A polished wooden wand for beginner witches and wizards.",
        "cost" => 29.99,
        "image" => "images/apprentice-wand.jpg"
    ],

    2 => [
        "name" => "Cauldron Starter Kit",
        "description" => "A small black cauldron with basic potion-making supplies.",
        "cost" => 34.99,
        "image" => "images/cauldron-kit.jpg"
    ],

    3 => [
        "name" => "Spellbook Journal",
        "description" => "A leather-style journal for recording spells, notes, and magical discoveries.",
        "cost" => 18.99,
        "image" => "images/spellbook-journal.jpg"
    ],

    4 => [
        "name" => "House Color Scarf",
        "description" => "A warm striped scarf available in several magical house-inspired colors.",
        "cost" => 22.99,
        "image" => "images/house-scarf.jpg"
    ],

    5 => [
        "name" => "Owl Post Messenger Bag",
        "description" => "A canvas messenger bag inspired by magical mail delivery.",
        "cost" => 27.99,
        "image" => "images/owl-messenger-bag.jpg"
    ]
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $productId =
        (int) $_POST["product_id"];

    if (isset($_POST["increase"])) {

        if (!isset(
            $_SESSION["cart"][$productId]
        )) {
            $_SESSION["cart"][$productId] = 0;
        }

        $_SESSION["cart"][$productId]++;
    }

    if (isset($_POST["decrease"])) {

        if (
            isset($_SESSION["cart"][$productId]) &&
            $_SESSION["cart"][$productId] > 0
        ) {
            $_SESSION["cart"][$productId]--;
        }

        if (
            isset($_SESSION["cart"][$productId]) &&
            $_SESSION["cart"][$productId] <= 0
        ) {
            unset(
                $_SESSION["cart"][$productId]
            );
        }
    }

    if (isset($_POST["remove"])) {

        unset(
            $_SESSION["cart"][$productId]
        );
    }
}

$subtotal = 0;
$totalItems = 0;

foreach (
    $_SESSION["cart"]
    as $productId => $quantity
) {

    if (
        isset($products[$productId]) &&
        $quantity > 0
    ) {

        $subtotal +=
            $products[$productId]["cost"]
            * $quantity;

        $totalItems += $quantity;
    }
}

$tax =
    $subtotal * 0.05;

$shipping =
    $subtotal * 0.10;

$orderTotal =
    $subtotal +
    $tax +
    $shipping;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Shopping Cart |
        The Enchanted Cauldron
    </title>

    <link
        rel="stylesheet"
        href="css/styles.css"
    >

</head>

<body>

<header>

    <h1>
        The Enchanted Cauldron
    </h1>

    <nav>
        <a href="index.php">
            Home
        </a>

        <a href="catalog.php">
            Shop
        </a>

        <a href="cart.php">
            Shopping Cart
        </a>
    </nav>

</header>

<div class="container">

    <h2 class="page-title">
        Your Magical Shopping Cart
    </h2>

    <?php if ($totalItems == 0): ?>

        <div class="empty-cart">

            <h3>
                Your cart is empty
            </h3>

            <p>
                It looks like you haven't
                selected any magical goods yet.
            </p>

            <a
                href="catalog.php"
                class="link-button"
            >
                Browse the Shop
            </a>

        </div>

    <?php else: ?>

        <div class="cart-grid">

            <div class="cart-items">

                <?php foreach (
                    $_SESSION["cart"]
                    as $productId => $quantity
                ): ?>

                    <?php if (
                        $quantity > 0 &&
                        isset($products[$productId])
                    ): ?>

                        <?php

                        $product =
                            $products[$productId];

                        $productTotal =
                            $product["cost"]
                            * $quantity;

                        ?>

                        <div class="cart-card">

                            <div
                                class="cart-product-image"
                            >

                                <img
                                    src="<?php echo
                                        $product["image"];
                                    ?>"
                                    alt="<?php echo
                                        $product["name"];
                                    ?>"
                                >

                            </div>

                            <div
                                class="cart-product-info"
                            >

                                <h3>
                                    <?php echo
                                        $product["name"];
                                    ?>
                                </h3>

                                <p class="product-id">

                                    Product ID:
                                    <?php echo
                                        $productId;
                                    ?>

                                </p>

                                <p>
                                    <?php echo
                                        $product[
                                            "description"
                                        ];
                                    ?>
                                </p>

                                <p class="price">

                                    $<?php echo
                                        number_format(
                                            $product["cost"],
                                            2
                                        );
                                    ?>

                                </p>

                            </div>

                            <div
                                class="quantity-area"
                            >

                                <p
                                    class="quantity-label"
                                >
                                    Quantity
                                </p>

                                <form
                                    method="post"
                                    class="quantity-form"
                                >

                                    <input
                                        type="hidden"
                                        name="product_id"
                                        value="<?php echo
                                            $productId;
                                        ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="decrease"
                                        class="quantity-button"
                                    >
                                        −
                                    </button>

                                    <span
                                        class="quantity-number"
                                    >
                                        <?php echo
                                            $quantity;
                                        ?>
                                    </span>

                                    <button
                                        type="submit"
                                        name="increase"
                                        class="quantity-button"
                                    >
                                        +
                                    </button>

                                </form>

                                <p
                                    class="product-total"
                                >

                                    Total:
                                    $<?php echo
                                        number_format(
                                            $productTotal,
                                            2
                                        );
                                    ?>

                                </p>

                            </div>

                            <div
                                class="remove-area"
                            >

                                <form method="post">

                                    <input
                                        type="hidden"
                                        name="product_id"
                                        value="<?php echo
                                            $productId;
                                        ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="remove"
                                        class="remove-button"
                                    >
                                        Remove
                                    </button>

                                </form>

                            </div>

                        </div>

                    <?php endif; ?>

                <?php endforeach; ?>

            </div>

            <div class="cart-summary">

                <h3>
                    Order Summary
                </h3>

                <div class="summary-row">

                    <span>
                        Total Items
                    </span>

                    <span>
                        <?php echo
                            $totalItems;
                        ?>
                    </span>

                </div>

                <div class="summary-row">

                    <span>
                        Pre-Tax Total
                    </span>

                    <span>
                        $<?php echo
                            number_format(
                                $subtotal,
                                2
                            );
                        ?>
                    </span>

                </div>

                <div class="summary-row">

                    <span>
                        Tax (5%)
                    </span>

                    <span>
                        $<?php echo
                            number_format(
                                $tax,
                                2
                            );
                        ?>
                    </span>

                </div>

                <div class="summary-row">

                    <span>
                        Shipping & Handling (10%)
                    </span>

                    <span>
                        $<?php echo
                            number_format(
                                $shipping,
                                2
                            );
                        ?>
                    </span>

                </div>

                <hr>

                <div
                    class="summary-row order-total"
                >

                    <span>
                        Order Total
                    </span>

                    <span>
                        $<?php echo
                            number_format(
                                $orderTotal,
                                2
                            );
                        ?>
                    </span>

                </div>

                <a
                    href="checkout.php"
                    class="checkout-button"
                >
                    Check Out
                </a>

                <a
                    href="catalog.php"
                    class="continue-link"
                >
                    Continue Shopping
                </a>

            </div>

        </div>

    <?php endif; ?>

</div>

<footer>
    The Enchanted Cauldron |
    Magical Goods for Every Witch and Wizard
</footer>

<script>
document.addEventListener(
    "DOMContentLoaded",
    function () {

        const savedPosition =
            sessionStorage.getItem(
                "cartScrollPosition"
            );

        if (savedPosition !== null) {

            window.scrollTo(
                0,
                parseInt(savedPosition)
            );

            sessionStorage.removeItem(
                "cartScrollPosition"
            );
        }

        const forms =
            document.querySelectorAll("form");

        forms.forEach(function (form) {

            form.addEventListener(
                "submit",
                function () {

                    sessionStorage.setItem(
                        "cartScrollPosition",
                        window.scrollY
                    );
                }
            );

        });
    }
);
</script>

</body>

</html>