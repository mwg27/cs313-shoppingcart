<?php
// Start the session
$varlogout = $_GET['logout'];
if (session_status() == PHP_SESSION_NONE) {
    session_start();

    $userId = $_SESSION["userID"];
    if(isset($varlogout)){
        unset( $_SESSION["userID"]);
        unset( $userId);
    }
    if(! isset($userId)){
        header("Location: login.php");
    } else {
        $products = array();
        $prices = array();
        $images = array();
        $itemid = array();
    
        $servername = "localhost";
        $username = "mike";
        $password = "!1Goulding0)";
        $dbname = "mike";
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $products[] = $row["name"];
            $prices[] = $row["price"];
            $images[] = $row["picFileName"];
            $itemid[] = $row["productID"];
        }
        $cnt = 0;
        $sql = sprintf("SELECT cartID FROM shoppingCart where userId='%s'",$userId);
        $result = $conn->query($sql);
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            $cartId = $row["cartID"];
            $sql = sprintf("select count(*) from shopCartItem where cartID='%s'",$cartId);
            $result = $conn->query($sql);
            if( $result->num_rows > 0 ){
                $row = $result->fetch_assoc();
                $cnt = $row["count(*)"];
            }
        }
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
            <h1>Mike's Hardware & Stuff</h1>
           <div class="cartpos">
                <a href="profile.php"><img src="img/profile.jpg" class="cartBtn"></a>
                <a href="cart.php"><img src="img/cart.jpg" class="cartBtn"></a>
                <?php
                    echo "Items: $cnt";
                ?>
                <a href="shopping.php?logout=1"><img src="img/logout.jpg" class="cartBtn"></a>
           </div >
           <div class="tablediv shoppingbox">
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
                            $p = $products;
                            $pr = $prices;
                            $img = $images;
                            $id = $itemid;
                            for($i=0; $i<count($p); $i++){
                                echo "<tr class=\"tablerow\">";
                                echo "<td> <img src=\"img/shop/$img[$i]\" class=\"tableimage\" ></td>";
                                echo "<td> $p[$i] </td>";
                                $rnd = number_format((float)$pr[$i], 2, '.', '');
                                echo "<td> $$rnd </td>";
                                echo "<td> <a href=\"addtocart.php?addwhat=$id[$i]\"><img src=\"img/details.jpg\" class=\"detailBtn\"></a> </td>";
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