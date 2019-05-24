<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $products = array("Dremel set w/ heads","Electric Hand sander","Band Saw","Table Saw","Airbrush w/ compressor","Heat Gun","Soldering Iron","Shop Vac","Laser cutter","3D Printer");
    $prices = array(44.99,54.99,374.99,427.00,87.99,37.99,67.25,99.00,6997.00,248.99);
    $images = array("dremel_set.jpeg","sander.jpg","band_saw.jpg","tablesaw.jpg","airbrush_compressor.jpg","heatgun.jpg","solderingiron.png","shopvac.jpg","lasercutter.jpg","3d_printer.jpg");


    $_SESSION["product"] = $products;
    $_SESSION["price"] = $prices;
    $_SESSION["image"] = $images;
    if ( ! isset($_SESSION['cart'])) 
        $_SESSION['cart'] = array();
    if ( ! isset($_SESSION['qtyarray'])) 
        $_SESSION['qtyarray'] = array();
    if( count($_SESSION['cart']) != count($_SESSION['qtyarray'])){
        unset($_SESSION['cart']);
        unset($_SESSION['qtyarray']);
        $_SESSION['cart'] = array();
        $_SESSION['qtyarray'] = array();
    }
}



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html lang="en"> 
    <head> 
       <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
       <title>Shoppingpage</title> 
       <link href="css/myCSSfile4.css" rel="stylesheet" type="text/css">
       <script src="js/myScript.js"></script>
    </head> 
    <body> 
        <div class="titlediv">
            <h1>Mikes Hardware & Stuff</h1>
           <div class="cartpos">
                <a href="cart.php"><img src="img/cart.jpg" width="64" height="64"></a>
                <?php
                        $c = $_SESSION["cart"];
                        $cnt = count($c);
                    echo "Items in Cart: $cnt<br>";
                ?>
           </div >
           <div class="tablediv">
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="tblheader">Item</th>
                            <th scope="col" class="tblheader">Description</th>
                            <th scope="col" class="tblheader">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            $index = 0;
                            $p = $_SESSION["product"];
                            $pr = $_SESSION["price"];
                            $img = $_SESSION["image"];
                            for($i=0; $i<count($p); $i++){
                                echo "<tr class=\"tablerow\">";
                                echo "<td> <img src=\"img/shop/$img[$i]\" class=\"tableimage\" ></td>";
                                echo "<td> $p[$i] </td>";
                                $rnd = number_format((float)$pr[$i], 2, '.', '');
                                echo "<td> $$rnd </td>";
                                echo "<td> <a href=\"addtocart.php?addwhat=$i\"><img src=\"img/details.png\" width=\"188\" height=\"50\"></a> </td>";
                                echo "</tr>";
                                $index++;
                            }                
                    ?>
                    </tbody>
                </table>
           </div>
        </div>
    </body> 
</html>