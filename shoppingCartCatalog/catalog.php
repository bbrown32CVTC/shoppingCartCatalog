<?php

// Check if a session is already in progress and if not, start one.
if (!session_id()) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart Catalog - Education Project Only</title>

    <link rel="stylesheet" href="css/minismall.css">
</head>
<body>

    <h2>Product Catalog - Education Project Only</h2>
    <?php

    ini_set('display_errors', 1);
    error_reporting(-1);

    require 'sanitize.php';
    require 'callQuery.php';
    require 'dbConnect.php';

    // If a session variable named 'numItems' has never been set,
    // initialize it to 0
    if (!isset($_SESSION['numItems'])) {
        $_SESSION['numItems'] = 0;
    }
    
    
    ?>
    <p>Your shopping cart contains <?= $_SESSION['numItems'] ?> item(s)</p>

    <a href="cart_bbrown32.php">View your cart</a> |
    <a href="index.html">Back to product categories</a>
    <?php

    // Set up and run query to get product categories and initialize variables
    $query = "SELECT catid FROM categories";
    $errorMsg = "Error fetching category info: ";

    $categoryResult = callQuery($pdo, $query, $errorMsg);

    $catIDs = Array();
    $ctr = 0;

    // Step through the result set and store each category id into
    // our $catIDs array.
    while ($row = $categoryResult->fetch()) {
        
        $catIDs[$ctr] = $row['catid'];
        $ctr += 1;
    }

    //
    // Check if the incoming category the user chose is valid
    //
    $incomingCategory = sanitizeString(INPUT_GET, 'cat');


    // if the incoming category is NOT a valid category, then set 
    // incoming category to 1
    if (!isset($incomingCategory) || !in_array($incomingCategory, $catIDs)) {
        $incomingCategory = 1;
    }

    //echo "<h3>category id = $incomingCategory</h3>";

    // Save our incoming category id in our session (session variable)
    $_SESSION['cat'] = $incomingCategory;

    //
    // Query for all products in the selected category and 
    // display them in a table - one row per product.
    //
    // We will also display some form elements (tags) as well
    //

    $query = "SELECT * FROM products
              WHERE category=$incomingCategory";
    
    $errorMsg = "Error fetching product info: ";

    $itemsResult = callQuery($pdo, $query, $errorMsg);

    // Start our category's product table by generating the 
    // first (header) row.
    ?> 
    <br><br>
    <form action="cart_bbrown32.php" method="post">
        <table>
            <tr class="header">
                <th>Image</th>
                <th>Description</th>
                <th>Price - USD</th>
                <th style="background-color: #fff">&nbsp;</th>
            </tr>

    <?php
    //
    // Step through the result set of products for this category
    // and display each product and its related info in its own table row
    //
    while ($row = $itemsResult->fetch()) {     

        // Convert any special HTML characters to their corresponding
        // HTML entity codes.   Example: & --> &amp;
        //
        // Also, strip off any HTML tags found in the data
        // 
        // Note: could also use sanitization functions to strip out tags
        //
        $imageLocation = htmlspecialchars(strip_tags($row['loc']));
        $description = htmlspecialchars(strip_tags($row['description']));
        $price = htmlspecialchars(strip_tags($row['price']));


        //$price = "$" . number_format($price, 2);
        // Now let's do the above an alternate way
        $price = sprintf("$%.2f", $price);

        $productID = strip_tags($row['prodid']);


        // Set $qty to contain what is in our session cart array variable.
        // If your session cart array element of $_SESSION for this product
        // is empty, set the $qty variable to its default value of 0.
        //
        // If the cart element for this product is NOT empty (implying that 
        // a value already exists in the cart for this product), then grab
        // its quantity (value) for display on this page.
        //
        // Note that $_SESSION['cart'] is an array.
        //
        // Remember that each element of an array is like a variable that 
        // holds a value.  That value can be another array so an array
        // element can hold another array as is the case here with 
        // $_SESSION['cart'].
        //
        // We can now deduce that $_SESSION['cart'] is an associative array
        // whose keys are the product ID's and whose values are the quantity
        // for the product that user wishes to purchase.

        //$_SESSION['cart'][2] = 7;
        //$_SESSION['cart'][10] = 4;

        if (isset($_SESSION['cart'][$productID])) {
            $qty = $_SESSION['cart'][$productID];
        } else {
            $qty = 0;
        }

        //
        // Build and display a table row for this product using a Here Document
        // named TABLEROW
        //
        echo <<<TABLEROW
             <tr>
                <td><img src="$imageLocation" alt="image of $description"</td>
                <td class="desc">$description</td>
                <td class="price">$price</td>
                <td class="qty">
                    <label for="quantityForProduct$productID">Qty</label>
                    <input type="text" name="$productID" id="quantityForProduct$productID" value="$qty" size="1em">
                </td>
             </tr>

TABLEROW;


    }    // end while next product row
    ?>
            <tr>
                <td colspan="4" id="submitCell">
                    <input type="submit" name="addCart" value="Add Items to Cart">
                </td>
            </tr>
        </table>
    </form>
    <br>
    <a href="cart_bbrown32.php">View your cart</a> |
    <a href="index.html">Back to product categories</a>
    
</body>
</html>