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
        $varname = $_POST['name'];
        $varaddress = $_POST['addr1'];
        $varstate = $_POST['state'];
        $varcity = $_POST['city'];
        $varzip = $_POST['zip'];
        $servername = "localhost";
        $username = "mike";
        $password = "!1Goulding0)";
        $dbname = "mike";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if(isset($varname)){
            // see if this is an update or an insert
            $sql = sprintf("select count(*) from billingAddress where userId='%s'",$userId);
            $result = $conn->query($sql);
            $cnt = 0;
            if( $result->num_rows > 0 ){
                $row = $result->fetch_assoc();
                $cnt = $row["count(*)"];              
            }
            if( $cnt != 0 ){
                //then an update
                $sqla = sprintf("UPDATE billingAddress SET name = '%s', address = '%s', city = '%s', state = '%s', zip = '%s' WHERE userId='%s'",$varname,$varaddress,$varcity,$varstate,$varzip,$userId);
            } else {
                //then an insert
                $sqla = sprintf("INSERT INTO billingAddress (bAddress, userId, name, address, city, state, zip) VALUES('0','%s','%s','%s','%s','%s','%s')",$userId,$varname,$varaddress,$varcity,$varstate,$varzip);
            }
            $result = $conn->query($sqla);
            //now do the same for the shopping cart
        }
        $varcname = $_POST['namecard'];
        $varcnum = $_POST['cardnum'];
        $varcdate = $_POST['carddate'];
        $varcvc = $_POST['cvc'];
        if(isset($varcnum)){
           // see if this is an update or an insert
           $sql = sprintf("select count(*) from creditCard where userId='%s'",$userId);
           $result = $conn->query($sql);
           $cnt = 0;
           if( $result->num_rows > 0 ){
               $row = $result->fetch_assoc();
               $cnt = $row["count(*)"];              
           }
           if( $cnt != 0 ){
                //then an update
                //check to see if the card has been updated otherwase do not update
                $find = '*';
                $pos = strpos($varcnum,$find);
                if( $pos === false){
                    $sqla = sprintf("UPDATE creditCard SET cName = '%s', cNumber = '%s', eDate = '%s', cvcCode = '%s' WHERE userId='%s'",$varcname,$varcnum,$varcdate,$varcvc,$userId);
                    $result = $conn->query($sqla); 
                }
            } else {
                //then an insert
                $sqla = sprintf("INSERT INTO creditCard (cardID, userId, cName, cNumber, eDate, cvcCode) VALUES('0','%s','%s','%s','%s','%s')",$userId,$varcname,$varcnum,$varcdate,$varcvc);
                $result = $conn->query($sqla); 
            }
        }
        //now read in the infor and set the values
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
        $sql = sprintf("select * from creditCard where userId='%s'",$userId);
        $result = $conn->query($sql);
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            $cName = $row["cName"];
            $cNum = $row["cNumber"];
            $cDate = $row["eDate"];
            $cCvC = $row["cvcCode"];
            $cNum = sprintf("****-****-****-%s",substr($cNum,strlen($cNum)-4));
        }
    }
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html lang="en"> 
    <head> 
       <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
       <title>ProfilePage</title> 
       <link href="css/myCSSfile4.css" rel="stylesheet" type="text/css">
       <script src="js/myScript.js"></script>
    </head> 
    <body> 
        <div class="titlediv">
            <h1>Mikes Hardware & Stuff</h1>
           <div class="profilepos">
                <a href="profile.php?logout=1"><img src="img/logout.jpg" class="cartBtn"></a>
           </div >
           <div class="tablediv profilebox">
               <form action="profile.php" method="post">
                    Billing Address<br>
                    <?PHP  echo "<input type=\"hidden\" id=\"total\" name=\"total\" value=\"$totalall\">";    ?>
                    <label>Name:&nbsp;</label><input type="text" id="name" name="name" <?php echo "value=\"$bName\"" ?> class="checkoutln p1"> <br>
                    <label>Address:&nbsp;</label><input type="text" id="addr1" name="addr1" <?php echo "value=\"$bAddress\"" ?> class="checkoutln  p1"><br>
                    <label>City:&nbsp;</label><input type="text" id="city" name="city" <?php echo "value=\"$bCity\"" ?> class="checkoutln p2"><br>
                    <label>State:&nbsp;</label><input type="text" id="state" name="state" <?php echo "value=\"$bState\"" ?> class="checkoutln p2"><br>
                    <label>Zip:&nbsp;</label><input type="text" id="zip" name="zip" <?php echo "value=\"$bZip\"" ?> class="checkoutln p3"><br><br>
                    Credit Card Information<br>
                    <label>Name on Card:&nbsp;</label><input type="text" id="namecard" name="namecard" <?php echo "value=\"$cName\"" ?> class="checkoutln p1"> <br>
                    <label>CardNumber:&nbsp;</label><input type="text" id="cardnum" name="cardnum" <?php echo "value=\"$cNum\"" ?> class="checkoutln p1"><br>
                    <label>Expiration Date:&nbsp;</label><input type="text" id="carddate" name="carddate" <?php echo "value=\"$cDate\"" ?> class="checkoutln p4"><br>
                    <label>CVC:&nbsp;</label><input type="text" id="cvc" name="cvc" <?php echo "value=\"$cCvC\"" ?> class="checkoutln p5"><br><br>
                    &nbsp; &nbsp;<a href="shopping.php"><img src="img/continue.png" class="btntop"></a> &nbsp;
                    <input type="image" src="img/saveprofile.png" alt="Submit" class="btntop">
                </form>               
           </div>
        </div>
    </body> 
</html>