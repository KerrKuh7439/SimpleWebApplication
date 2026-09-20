<?php
session_start();

// Connect to the database
require_once "db.php";

// Create cart if it does not already exist
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Product images
$productImages = [
    1 => "images/apprentice-wand.jpg",
    2 => "images/cauldron-kit.jpg",
    3 => "images/spellbook-journal.jpg",
    4 => "images/house-scarf.jpg",
    5 => "images/owl-messenger-bag.jpg"
];

// Get products from the database
$products = [];

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {

    $productId = $row["product_id"];

    $products[$productId] = [
        "name" => $row["product_name"],
        "description" => $row["product_description"],
        "cost" => $row["product_cost"],
        "image" => $productImages[$productId] ?? ""
    ];
}


// Process quantity changes
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $productId = (int) $_POST["product_id"];

    // Add/increase product
    if (isset($_POST["add"])) {

        if (!isset($_SESSION["cart"][$productId])) {
            $_SESSION["cart"][$productId] = 0;
        }

        $_SESSION["cart"][$productId]++;
    }

    // Decrease product
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