<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$cart = $_SESSION["cart"];

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
            <h4>Checkout</h4>
            <?php
                $pr = $_SESSION["price"];
                $qty = $_SESSION["qtyarray"];
                $crt = $_SESSION["cart"];
                $totalall = 0;
                $totalitems = count($crt);
                for($i=0; $i<count($crt); $i++){
                   $itm =  $crt[$i];
                   $q = $qty[$i];
                   $p =  $pr[$itm];
                   $total = $p * $q;
                   $totalall = $totalall + $total;
                }
                echo "<div>Items Ordered: $totalitems <br> For a Total of $$totalall</div>";
            ?>
            <h4>Shipping Information</h4>
            <div class="container">
                <form action="confirm.php" method="post">
                    <?PHP  echo "<input type=\"hidden\" id=\"total\" name=\"total\" value=\"$totalall\">";    ?>
                    <label>Ship To Name:&nbsp;</label><input type="text" id="name" name="name" value="" class="checkoutln"> <br>
                    <label>Address:&nbsp;</label><input type="text" id="addr1" name="addr1" value="" class="checkoutln"><br>
                    <label>City:&nbsp;</label><input type="text" id="city" name="city" value="" class="checkoutln"><br>
                    <label>State:&nbsp;</label><input type="text" id="state" name="state" value="" class="checkoutln"><br>
                    <label>Zip:&nbsp;</label><input type="text" id="zip" name="zip" value="" class="checkoutln"><br>
                    
                    <a href="shopping.php"><img src="img/continue.png" class="btntop"></a> 
                    <input type="image" src="img/pruchase.png" alt="Submit" class="btntop">
                </form> 
            </div>          
        </div>
    </body> 
</html>