<?php

session_start();

// Clear all items from the shopping cart
$_SESSION["cart"] = [];

// Return the user to the MVC catalog page
header("Location: controller/catalog_controller.php");
exit;

?>