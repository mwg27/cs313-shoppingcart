<?php
$varadd = $_POST['addwhat'];
$varqty = $_POST['quantity'];
$varremove = $_GET['remove'];
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if( isset($varadd)){
    $cart = $_SESSION["cart"];
    $cart[] = $varadd;
    $_SESSION["cart"] = $cart;  
    $qty = $_SESSION["qtyarray"];
    $qty[] = $varqty;
    $_SESSION["qtyarray"] = $qty;
}
if( isset($varremove)){
    $orgcart = $_SESSION["cart"];
    $orgqty = $_SESSION["qtyarray"];
    $cart = array();
    $qty = array();
    for($i=0; $i<count($orgcart); $i++){
        if( $i != $varremove){
            $cart[] = $orgcart[$i];
            $qty[] = $orgqty[$i];
        }
    }
    $_SESSION["cart"] = $cart; 
    $_SESSION["qtyarray"] = $qty; 
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
            <div class="tablediv">
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
                            $index = 0;
                            $p = $_SESSION["product"];
                            $pr = $_SESSION["price"];
                            $img = $_SESSION["image"];
                            $qty = $_SESSION["qtyarray"];
                            $crt = $_SESSION["cart"];
                            $totalall = 0;
                            for($i=0; $i<count($crt); $i++){
                                $j = $crt[$i];
                                echo "<tr class=\"tablerow\">";
                                echo "<td> <img src=\"img/shop/$img[$j]\" class=\"tableimage\" ></td>";
                                echo "<td> $p[$j] </td>";
                                $rnd = number_format((float)$pr[$j], 2, '.', '');
                                echo "<td> $$rnd </td>";
                                echo "<td> $qty[$i] </td>";
                                $total = $pr[$j] * $qty[$i];
                                $totalall = $totalall + $total;
                                $rnd = number_format((float)$total, 2, '.', '');
                                echo "<td> $$rnd </td>";
                                echo "<td> <a href=\"cart.php?remove=$i\"><img src=\"img/trashcan.png\" width=\"42\" height=\"42\"></a> </td>";
                                echo "</tr>";
                                $index++;
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