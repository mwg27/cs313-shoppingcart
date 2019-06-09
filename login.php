<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        //get the post vars if this is a form submit then validate the user name and password
        $varname = $_POST['name'];
        $varpasswd = $_POST['password'];
        $iserror = false;
        if ( isset($varname)) {
            // then a login verify that it is valid
            $servername = "localhost";
            $username = "mike";
            $password = "!1Goulding0)";
            $dbname = "mike";
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = sprintf("SELECT * FROM users where login_ID='%s'",$varname);
            $result = $conn->query($sql);
            $userid = -1;
            $passwd = "17625dgstaggjjcsddssss";
            if( $result->num_rows > 0 ){
                $row = $result->fetch_assoc();
                $userid = $row["userID"];
                $passwd = $row["password"];
                if($passwd == $varpasswd){
                    $_SESSION["userID"] = $userid;
                    header("Location: shopping.php");
                } else {
                    $iserror = true;
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
        <h1>Mike's Hardware & Stuff</h1><br>
        <h4>Login</h4>
            <?php
                if( $iserror )
                    echo '<div class="errormsg"> Invalid User name or password, Retry...</div>';   
            ?>     
            <div class="loginbox">
                <div class="loginimagediv"><img src="img/LoginRed.jpg" class="loginimage"></div>
                <br>
                <form action="login.php" method="post">
                    <label class="loginlabel">Username:&nbsp;</label><input type="text" id="name" name="name" value="" class="checkoutln"> <br>
                    <label class="loginlabel">Password:&nbsp;</label><input type="password" id="password" name="password" value="" class="checkoutln"><br>
                    <input type="image" src="img/loginbtn.png" alt="Submit" class="loginbtn">
                </form>
            </div>
            <br>
            Create an account click&nbsp;<a href="create.php">here</a>
        </div>
    </body> 
</html>