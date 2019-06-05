<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $varname = $_POST['name'];
        $varpasswd = $_POST['password'];
        $varpasswd2 = $_POST['password2'];
        $iserror = false;
        $isnotsame = false;
        //see if the passwords are the same
        if( isset($varpasswd)){
            if( isset($varpasswd2)){
                if( $varpasswd != $varpasswd2)
                    $isnotsame = true;
            } else {
                $isnotsame = true;
            }
        }
        //see if the name has already been taken
        if( isset($varname)){
            $servername = "localhost";
            $username = "mike";
            $password = "!1Goulding0)";
            $dbname = "mike";
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = sprintf("SELECT * FROM users where login_ID='%s'",$varname);
            $result = $conn->query($sql);
            if( $result->num_rows == 0 ){
                //ifnot then insert it, goto login
                $sql = sprintf("INSERT INTO users (userID, login_ID, password) VALUES('0','%s','%s')",$varname,$varpasswd);
                $result = $conn->query($sql);
                if ($result === TRUE) {
                    header("Location: login.php");
                }
            } else {
                $iserror = true;
            }
            $conn->close();
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
        <h1>Welcom to Mikes Hardware & Stuff</h1><br>
        <h4>Create an account with us</h4>
        <?php
            if($iserror){
                echo '<div class="errormsg"> User name already used, try a different one...</div>';
            }
            if($isnotsame) {
                echo '<div class="errormsg"> Passwords do not natch, retype...</div>';
            }            
        ?>      
            <div class="createbox">
                <div class="loginimagediv"><img src="img/users.jpg" class="loginimage"></div>
                <br>
                <form action="create.php" method="post">
                    <label class="loginlabel">Username:&nbsp;</label><input type="text" id="name" name="name" value="" class="checkoutln"> <br>
                    <label class="loginlabel">Password:&nbsp;</label><input type="password" id="password" name="password" value="" class="checkoutln"><br>
                    <label class="loginlabel">Retype:&nbsp;</label><input type="password" id="password2" name="password2" value="" class="checkoutln"><br>
                    <a href="login.php"><img src="img/cancelbtn.png" class="createbtn"></a>
                    &nbsp;
                    <input type="image" src="img/createbtn.png" alt="Submit" class="createbtn">
                </form>
            </div>
        </div>
    </body> 
</html>