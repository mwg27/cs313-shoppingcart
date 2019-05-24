<?php
$varadd = $_GET['addwhat'];
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
            <?php
            $p = $_SESSION["product"];
            $pr = $_SESSION["price"];
            $img = $_SESSION["image"];
            echo "<h4>$p[$varadd]</h4><br>";
            echo "<img src=\"img/shop/$img[$varadd]\" class=\"addimage\">";
            echo "&nbsp;";
            echo "$$pr[$varadd]";
            ?>
            <form action="cart.php" method="post">
            <?php
                echo "<input type=\"hidden\" id=\"addwhat\" name=\"addwhat\" value=\"$varadd\">";
            ?>
                <br>
                    Quantity:&nbsp;<input type="text" class="qtyinput" id="quantity" name="quantity" value="1" />
                <br>
                <a href="shopping.php"><img src="img/continue.png" class="btntop"></a>
                &nbsp;
                <input type="image" src="img/addtocart.png" alt="Submit" class="btntop">
            </form>
        </div>
    </body> 
</html>