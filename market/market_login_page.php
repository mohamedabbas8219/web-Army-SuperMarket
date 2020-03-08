
<?php
session_start();
require 'connection.php';
require 'classes.php';
//require 'showdata.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>نادي ض ق م براس البر </title>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <div class="title"><br /><center><h1>نادي ضباط القوات المسلحة برأس البر</h1></center></div>
        <?php
        if(isset($_SESSION['curr_page'])){
         $redirectURL = $_SESSION['curr_page'];
         header("Location:" . $redirectURL);
          }
        $msg = '';
        try {
            if (isset($_POST['submit'])) {
                $user = $_POST['username'];
                $pass = $_POST['password'];
                if (check_user($conn, $user, $pass)) {
                    echo 'well done';
                    $msg = '<b style="color:green;">You are logged in successfuly .</b>';

                                        
                    $_SESSION['curr_page'] = 'selling.php';
                    $_SESSION['username'] = $user;
                    $_SESSION['password'] = $pass;

                    $redirectURL = "selling.php";
                    header("Location:" . $redirectURL);
                } else {
                    $msg = '<b style="color:brown;background-color: silver; ">Sorry,username or password is wrong.</b>';
                }
            }
        } catch (Exception $ex) {
            echo 'Sorry , Something go wrong in Your prcess';
        }
        ?>
        <div class="b">
            <img src="images/logo1.jpg">
            <form method="post" action="" enctype="multipart/form-data" >
                <div class="i">
                    <input type="text" name="username" required="" value="">
                    <label>username</label>
                </div>
                <div class="i">
                    <input type="password" name="password" required="">
                    <label>password</label>	
                </div>
                <center><input type="submit" name="submit" value="login"></center>
                <br>
                <?php echo $msg; ?>
            </form>

        </div>
    </body>
</html>


