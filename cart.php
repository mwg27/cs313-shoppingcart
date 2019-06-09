<?php
$varadd = $_POST['addwhat'];
$varqty = $_POST['quantity'];
$varremove = $_GET['remove'];
if (session_status() == PHP_SESSION_NONE) {
    session_start();

    $userId = $_SESSION["userID"];
    $servername = "localhost";
    $username = "mike";
    $password = "!1Goulding0)";
    $dbname = "mike";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if(! isset($userId)){
        header("Location: login.php");
    } else {
        //see if there is a cart for this user
        $sql = sprintf("SELECT cartID FROM shoppingCart where userId='%s'",$userId);
        $result = $conn->query($sql);
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            $cartId = $row["cartID"];
        } else {
            $sql = sprintf("INSERT INTO shoppingCart (cartID, userId) VALUES('0','%s')",$userId);
            $result = $conn->query($sql);
            if ($result === TRUE) {
                $sql = sprintf("SELECT cartID FROM shoppingCart where userId='%s'",$userId);
                $result = $conn->query($sql);
                if( $result->num_rows > 0 ){
                    $row = $result->fetch_assoc();
                    $cartId = $row["cartID"];
                } else {
                    header("Location: shopping.php");
                }
            } else {
                header("Location: shopping.php");
            }
        }
        if(isset($varadd) && !isset($varqty)){
            header("Location: shopping.php");
        } else {
            if( isset($varadd)){
                // now add the item to the cart
                $sql = sprintf("INSERT INTO shopCartItem (cartItemID, productID, cartID, quantity) VALUES('0','%s','%s','%s')",$varadd,$cartId,$varqty);
                $result = $conn->query($sql);
                if ($result === FALSE) {
                    header("Location: shopping.php");
                } else {

                }
            } 
            if( isset($varremove)) {
                //then a remove item
                $sql = sprintf("SELECT cartID FROM shoppingCart where userId='%s'",$userId);
                $result = $conn->query($sql);
                if( $result->num_rows > 0 ){
                    $row = $result->fetch_assoc();
                    $cartId = $row["cartID"];
                    $sql = sprintf("DELETE FROM shopCartItem where cartID='%s' and cartItemID='%s'",$cartId,$varremove);
                    $result = $conn->query($sql);
                } else {
                    header("Location: shopping.php");
                }
            }
        }       
    }    
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html lang="en"> 
    <head> 
       <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
       <title>addpage</title> 
       <link href="css/myCSSfile4.css" rel="stylesheet" type="text/css">
       <script src="js/myScript.js"></script>
    </head> 
    <body> 
        <div class="titlediv">
            <h4>Shopping Cart</h4>
            <div class="tablediv cartbox">
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="tblheader">Item</th>
                            <th scope="col" class="tblheader">Description</th>
                            <th scope="col" class="tblheader">Price</th>
                            <th scope="col" class="tblheader">Quantity</th>
                            <th scope="col" class="tblheader">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            $totalall = 0;                            
                            $sql = sprintf("SELECT * FROM shopCartItem where cartID='%s'",$cartId);
                            $result = $conn->query($sql);
                            if( $result->num_rows > 0 ){
                                while($row = $result->fetch_assoc()) {
                                    $productid = $row["productID"];
                                    $quantity = $row["quantity"];
                                    $cartItemId = $row["cartItemID"];
                                    $psql = sprintf("SELECT * FROM products WHERE productID='%s'",$productid);
                                    $res = $conn->query($psql);
                                    if( $res->num_rows > 0 ){
                                        $r = $res->fetch_assoc();
                                        $p = $r["name"];
                                        $pr = $r["price"];
                                        $img = $r["picFileName"];
                                        echo "<tr class=\"tablerow\">";
                                        echo "<td> <img src=\"img/shop/$img\" class=\"tableimage\" ></td>";
                                        echo "<td> $p </td>";
                                        $rnd = number_format((float)$pr, 2, '.', '');
                                        echo "<td> $$rnd </td>";
                                        echo "<td> $quantity </td>";
                                        $total = $pr * $quantity;
                                        $totalall = $totalall + $total;
                                        $rnd = number_format((float)$total, 2, '.', '');
                                        echo "<td> $$rnd </td>";
                                        echo "<td> <a href=\"cart.php?remove=$cartItemId\"><img src=\"img/trashcan.png\" width=\"42\" height=\"42\"></a> </td>";
                                        echo "</tr>";
                                    }
                                }                               
                            }
                            echo "<tr class=\"tablerow\">";
                            echo "<td> <h3>Total:</h3> </td>"; 
                            echo "<td> ---- </td>";
                            echo "<td> ---- </td>";
                            echo "<td> ---- </td>";
                            $rnd = number_format((float)$totalall, 2, '.', '');
                            echo "<td> $$rnd </td>"; 
                            echo "</tr>";

                    ?>
                    </tbody>
                </table>
           </div>
 
            <br>
            <a href="shopping.php"><img src="img/continue.png"  class="btntop"></a>&nbsp; 
            <a href="checkout.php"><img src="img/checkout.png"  class="btntop"></a>                
        </div>
    </body> 
</html>