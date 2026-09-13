<?php
session_start();

// Clear all items from the shopping cart
$_SESSION["cart"] = [];

// Return the user to the catalog page
header("Location: catalog.php");
exit;
?>