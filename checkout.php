<?php
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
    $sql = sprintf("SELECT cartID FROM shoppingCart where userId='%s'",$userId);
    $result = $conn->query($sql);
    if( $result->num_rows > 0 ){
        $row = $result->fetch_assoc();
        $cartId = $row["cartID"];
        $cnt = 0;
        $sql = sprintf("select count(*) from shopCartItem where cartID='%s'",$cartId);
        $result = $conn->query($sql);
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            $cnt = $row["count(*)"];
        }
        $totalall = 0;                            
        $sql = sprintf("SELECT productID,quantity FROM shopCartItem where cartID='%s'",$cartId);
        $result = $conn->query($sql);
        if( $result->num_rows > 0 ){
            while($row = $result->fetch_assoc()) {
                $productid = $row["productID"];
                $quantity = $row["quantity"];
                $psql = sprintf("SELECT price FROM products WHERE productID='%s'",$productid);
                $res = $conn->query($psql);
                if( $res->num_rows > 0 ){
                    $r = $res->fetch_assoc();
                    $pr = $r["price"];
                    $total = $pr * $quantity;
                    $totalall = $totalall + $total;
                }
            }                               
        }
        $sql = sprintf("select cNumber from creditCard where userId='%s'",$userId);
        $result = $conn->query($sql);
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            $cNum = $row["cNumber"];
            $cCard = sprintf("****-****-****-%s",substr($cNum,strlen($cNum)-4));
        }
        $sql = sprintf("select * from billingAddress where userId='%s'",$userId);
        $result = $conn->query($sql);
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            $bName = $row["name"];
            $bAddress = $row["address"];
            $bCity = $row["city"];
            $bState = $row["state"];
            $bZip = $row["zip"];
        }
    } else {
        header("Location: shopping.php");
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
            <h4>Checkout</h4>
            <div class="checkoutbox">
            <?php
                echo "<div>&nbsp;&nbsp;Items Ordered: $cnt <br> &nbsp;&nbsp;For a Total of $$totalall</div>";
            ?>
            </div>
            <h4>Billing</h4>
            <div class="checkoutbox">
            <?php
                echo "<div>&nbsp;&nbsp;Your Credit Card: $cCard <br>&nbsp;&nbsp;will be used for this order.</div>";
            ?>
            </div>
            <h4>Shipping Information</h4>
            <div class="container">
                <form action="confirm.php" method="post">
                    <div class="checkoutbox">
                    <br>
                    <?PHP  echo "<input type=\"hidden\" id=\"total\" name=\"total\" value=\"$totalall\">";    ?>
                    <label>Ship To Name:&nbsp;</label><input type="text" id="name" name="name" <?php echo "value=\"$bName\"" ?> class="checkoutln p1"> <br>
                    <label>Address:&nbsp;</label><input type="text" id="addr1" name="addr1" <?php echo "value=\"$bAddress\"" ?> class="checkoutln p1"><br>
                    <label>City:&nbsp;</label><input type="text" id="city" name="city" <?php echo "value=\"$bCity\"" ?> class="checkoutln p2"><br>
                    <label>State:&nbsp;</label><input type="text" id="state" name="state" <?php echo "value=\"$bState\"" ?> class="checkoutln p2"><br>
                    <label>Zip:&nbsp;</label><input type="text" id="zip" name="zip" <?php echo "value=\"$bZip\"" ?> class="checkoutln p3"><br><br>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="shopping.php"><img src="img/continue.png" class="btntop"></a> 
                    <input type="image" src="img/pruchase.png" alt="Submit" class="btntop">
                </form> 
            </div>          
        </div>
    </body> 
</html>