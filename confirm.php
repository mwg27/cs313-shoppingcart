<?php
$varname = $_POST['name'];
$varaddr = $_POST['addr1'];
$varcity = $_POST['city'];
$varstate = $_POST['state'];
$varzip = $_POST['zip'];
$vartot = $_POST['total'];
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$cart = array();
$qty = array();
$_SESSION["cart"] = $cart; 
$_SESSION["qtyarray"] = $qty; 
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
            <h4>Thank You For Ordering From Mikes Hardware & Stuff</h4>
            <br>
            <p>
                Your Account Has been charged a total of 
                <?php 
                    echo "$$vartot <br>";
                    echo "Your Order will be Shipped to:<br>";
                    echo "$varname<br>";
                    echo "$varaddr<br>";
                    echo "$varcity, $varstate $varzip<br>"; 
                ?>
            </p>
            <a href="shopping.php"><img src="img/continue.png" class="btntop"></a> 
               
        </div>
    </body> 
</html>