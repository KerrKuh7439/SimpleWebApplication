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

    $productId = (int) $_POST["product_id"];

    if (isset($_POST["add"])) {

        if (!isset($_SESSION["cart"][$productId])) {
            $_SESSION["cart"][$productId] = 0;
        }

        $_SESSION["cart"][$productId]++;
    }

    if (isset($_POST["remove"])) {

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
            unset($_SESSION["cart"][$productId]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Shop | The Enchanted Cauldron</title>

    <link
        rel="stylesheet"
        href="css/styles.css"
    >
</head>

<body>

<header>

    <h1>The Enchanted Cauldron</h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="catalog.php">Shop</a>
        <a href="cart.php">Shopping Cart</a>
    </nav>

</header>

<div class="container">

    <h2 class="page-title">
        Magical Goods
    </h2>

    <div class="product-grid">

        <?php foreach ($products as $productId => $product): ?>

            <?php
            $quantity =
                $_SESSION["cart"][$productId] ?? 0;
            ?>

            <div class="product-card">

                <img
                    class="catalog-image"
                    src="<?php echo $product["image"]; ?>"
                    alt="<?php echo $product["name"]; ?>"
                >

                <h3>
                    <?php echo $product["name"]; ?>
                </h3>

                <p class="product-id">
                    Product ID:
                    <?php echo $productId; ?>
                </p>

                <p>
                    <?php echo $product["description"]; ?>
                </p>

                <p class="price">
                    $<?php echo number_format(
                        $product["cost"],
                        2
                    ); ?>
                </p>

                <p class="quantity">
                    Quantity in Cart:
                    <?php echo $quantity; ?>
                </p>

                <form
                    method="post"
                    class="catalog-quantity-form"
                >

                    <input
                        type="hidden"
                        name="product_id"
                        value="<?php echo $productId; ?>"
                    >

                    <button
                        type="submit"
                        name="remove"
                        class="quantity-button"
                    >
                        −
                    </button>

                    <span class="quantity-number">
                        <?php echo $quantity; ?>
                    </span>

                    <button
                        type="submit"
                        name="add"
                        class="quantity-button"
                    >
                        +
                    </button>

                </form>

            </div>

        <?php endforeach; ?>

    </div>

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
                "catalogScrollPosition"
            );

        if (savedPosition !== null) {

            window.scrollTo(
                0,
                parseInt(savedPosition)
            );

            sessionStorage.removeItem(
                "catalogScrollPosition"
            );
        }

        const forms =
            document.querySelectorAll("form");

        forms.forEach(function (form) {

            form.addEventListener(
                "submit",
                function () {

                    sessionStorage.setItem(
                        "catalogScrollPosition",
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