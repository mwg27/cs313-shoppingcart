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
$userId = $_SESSION["userID"];
if(! isset($userId)){
    header("Location: login.php");
} else {
    $servername = "localhost";
    $username = "mike";
    $password = "!1Goulding0)";
    $dbname = "mike";
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = sprintf("select cNumber from creditCard where userId='%s'",$userId);
    $result = $conn->query($sql);
    if( $result->num_rows > 0 ){
         $row = $result->fetch_assoc();
        $cNum = $row["cNumber"];
        $cCard = sprintf("****-****-****-%s",substr($cNum,strlen($cNum)-4));
    }
    //get the cart id
    $sql = sprintf("SELECT cartID FROM shoppingCart where userId='%s'",$userId);
    $result = $conn->query($sql);
    if( $result->num_rows > 0 ){
        $row = $result->fetch_assoc();
        $cartId = $row["cartID"];
        // now remove the items from the cart
        $sql = sprintf("DELETE FROM shopCartItem where cartID='%s'",$cartId);
        $result = $conn->query($sql);
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
            <h4>Thank You For Ordering From Mike's Hardware & Stuff</h4>
            <br>
            <p>                
                <?php 
                    echo "Your Credit Card $cCard Has been charged a total of ";
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