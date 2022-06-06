<?php
// 1) ***Start a session if one is not already in progress...

if (!session_id()) {
    session_start();
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Shopping Cart - Education Project only</title>
        
        <link href="css/minisMall.css" rel="stylesheet">
    </head>
    <body>
        
        <h2>Minis Mall Shopping Cart - Education Project only</h2>
        
        <?php
        
        // Display any errors that occur to the web page rather than
        // placing them into a log file
        ini_set('display_errors', 1);
        error_reporting(-1);   // level of -1 says display all
        
        require 'sanitize.php';
        require 'callQuery.php';
        
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
        }
        else {  // $_SESSION['cart'] doesn't exist
            $cart = Array();
        }
        
		// No sanitization required for this part - use as is with no changes!
        if (isset($_POST['remove'])) {
			$remove = $_POST['remove'];
        }
        else {
            $remove = Array();
        }
        
        
        
        $totalPrice = 0;
        $prodIDStr = "";
        $_SESSION['numItems'] = 0;   // reset to 0
        
        
        // loop through $_POST to update our shopping cart array ($cart)
		//
		// Note: This foreach statement should NOT be changed...  You 
		// will be filling in the code inside of it.
        foreach ($_POST as $productID => $productQty) {
            
            // 2) ***In a single if statement condition,
			// check if quantity value is numeric, and if it is, 
			// truncate it to be an Integer value.  In the same 
			// condition, check if the quantity is > 0 and that the 
			// checkbox for removing this product has NOT been checked.
			//
			// If the condition evaluates to true, update the shopping
			// cart array's element for this product with this 
			// product's quantity
			//
			// In an else if condition unset the cart element for this
			// product if the quantity is 0 OR its remove checkbox
			// has been checked.
            
            
			if (is_numeric($productQty)) {
                $productQty = round($productQty);

                if ($productQty > 0 && !isset($remove[$productID])) {
                    $cart[$productID] = $productQty;
                } else {
                    unset($cart[$productID]);
                }
            }
            
        }  // end foreach form field item in $_POST
        
        
        //
        // OK, display products currently in the shopping cart array
        //
        
        require 'dbConnect.php';
        
		// 3) ***Use a foreach loop to step through the $cart 
		// associative array and generate a comma-delimited string 
		// containing the product ID's of all the products in our 
		// shopping cart array ($cart).
		// 
		// Use $prodIDStr as the variable that will contain this string.
		// This variable was initialized to the empty string ("") above.
		// Note that you will end up with a comma at the end of this 
		// string.  You will take care of this shortly.
		//
		// Also, add each cart element's value (quantity of that 
		// type of product) to the Session numItems variable so that 
		// when done with the loop it contains the total number of 
		// items in our cart.
        
        foreach ($cart as $productID => $productQty) {
            $prodIDStr .= $productID . ',';
            $_SESSION['numItems'] += $productQty;
        }
		
		
		
        
        
        if (!$_SESSION['numItems']) {   // cart is empty
            print "<h3>Your shopping cart is empty</h3>\n\n";
        }
        else {   // cart contains at least one product selection
		
			// Note that this else's ending curly brace is quite a ways
			// down the page and should NOT need to be changed.

            // 4) ***Get rid of trailing comma from our $prodIDStr
            // your code here for task 4)

            $prodIDStr = rtrim($prodIDStr, ',');
			
			
			// 5) ***Set up and run a query to select all fields
			// from the products table selecting only rows where
			// the prodid field is found in the product ID string
			// you built above when looping through your $cart array.
			//
			// Make sure the result set will be ordered by category 
			// product ID.
			//
			// Store the resulting PDOStatement object (result set) in
			// a variable named $itemsResult.
			
			$query = "SELECT * FROM products
              WHERE prodid IN ($prodIDStr)
              ORDER BY category";
    
            $errorMsg = "Error fetching product info: ";

            $itemsResult = callQuery($pdo, $query, $errorMsg);
			

            //
            // Begin displaying table of products in our cart
            //

            ?>

        <br><br>
        <form action="cart_bbrown32.php" method="post">

            <table>

                <tr class="header">
                    <th>Remove</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Quantity</th>
                </tr>

        

        <?php

            // 6) ***Fetch each row of the previous query's result set
            // displaying product info for this row's product in a 
			// table row.  Store the fetched row in $row.
			
            while ($row = $itemsResult->fetch()) {

                // get data ready to display in table row
				
				// 7) ***Retrieve quantity for this product
				// storing it in a variable called $qty.
                
				$qty = $cart[$row['prodid']];
                $price = $row['price'];
				
				// The following two lines should NOT be changed...
                $subTotal = $qty * $row['price'];
                $totalPrice += $subTotal;

				// 8) ***Convert price and subtotal values
				// to strings that show currency format using
				// sprintf() with floating point conversion codes (%f).  
				// 
				// The value should be preceded with a $ and display
				// exactly two decimal places.  Store the results
				// back into $price and $subTotal respectively.
                
				$price = sprintf("$%.2f", $price);
                $subTotal = sprintf("$%.2f", $subTotal);


				// The following Here Document should NOT be changed...
                print <<<CARTSTUFF

                <tr>
                    <td>
                        <input type="checkbox" name="remove[$row[prodid]]" value="1">
                    </td>

                    <td>
                        <img src="$row[loc]" alt="image for $row[description]">
                    </td>

                    <td class="desc">
                        $row[description]
                    </td>

                    <td class="price">
                        $price
                    </td>

                    <td class="price">
                        $subTotal
                    </td>

                    <td>
                        <input type="text" name="$row[prodid]" value="$qty" size="2">
                    </td>
                </tr>

CARTSTUFF;

            }  // end while not at end of result set

            // Now that we are done fetching rows from the result set
            // format and display running total
			
			
			// 9) ***Convert total price value
			// to a string that shows currency format using
			// sprintf() with a conversion code (%f).  
			//  
			// The value should be preceded with a $ and display
			// exactly two decimal places.  Store the result
			// back into $totalPrice.
			
			$totalPrice = sprintf("$%.2f", $totalPrice);
            

			
			// The following Here Document should NOT be changed...
            print <<<ENDTABLE


            <tr>
                <td colspan="5" style="text-align:right">
                    Total: $totalPrice
                </td>

                <td>
                    $_SESSION[numItems]
                </td>
            </tr>

            <tr>
                <td colspan="6" style="text-align:right">
                    <br>
                    <input type="submit" name="checkOut" value="Check Out">
                    <input type="submit" name="updateCart" value="Update Cart">
                </td>
            </tr>

ENDTABLE;

        }  // end else cart contained at least one product

        // 10) ***remember to "save" $cart as a session variable
		// before leaving this page
		
		$_SESSION['cart'] = $cart ;
        
        ?>
            </table>
        </form>

        <div style="text-align:center">
            <a href="index.html">Continue shopping</a>
        </div>
        
    </body>
</html>
