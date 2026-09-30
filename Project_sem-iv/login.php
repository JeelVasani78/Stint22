<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stint22 | Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="shortcut icon" type="x-icon" href="./img/final_logo.jpg">
</head>
<body>
    <div class="main">
        <div class="left">
            <div class="up">
                <h1>Stint22</h1>
                <h3><a href="index.html">Home</a></h3>  
            </div>
            <div class="down">
                <p>"Small Tasks, Big Impact,Welcome Back To Your Productivity Revolution."</p>
            </div>
        </div>
        <div class="right">
            <div class="up">
                <p>Welcome back:)</p>
            </div>
            <div class="down">
                <form action="login.php" method="POST">
                    <h1>Login</h1>
                    <div class="txt1">
                        <input type="email" placeholder="Email Id" name="email" required>
                    </div>
                    <div class="txt2">
                        <input type="password" placeholder="Password" name="pass" required>
                    </div>
                    <div class="forgot">
                        <a href="forgot.php">Forgot Password?</a>
                    </div>
                    <input type="submit" value="Login" name="submit" class="login">
                    <div class="signup">
                        <p>Don't have an account?<a href="signup.php">Register</a></p>
                    </div>
                </form>
                <?php
                error_reporting(0);
if(isset($_POST['submit'])) 
                {
                    $server="localhost";
                    $user="root";
                    $password="";
                    $database="stint22";
                    $cn=mysqli_connect($server,$user,$password,$database);

                    if($cn)
                    {
                        $email=$_POST['email'];
                        $pass=$_POST['pass'];

                        $q1="select emailid,pass from user_info where emailid='$email' and pass='$pass'";
                        $select1=mysqli_query($cn,$q1);
                        if(mysqli_num_rows($select1)>0)
                        {
                            $q2="select user_id from user_info where emailid='$email' and pass='$pass'";
                            $select2=mysqli_query($cn,$q2);
                            $q3="select category from user_info where emailid='$email' and pass='$pass'";
                            $select3=mysqli_query($cn,$q3);
                            $q4="select user_nm from user_info where emailid='$email' and pass='$pass'";
                            $select4=mysqli_query($cn,$q4);

                            $row1=mysqli_fetch_assoc($select2);
                            $row2=mysqli_fetch_assoc($select3);
                            $row3=mysqli_fetch_assoc($select4);

                            $user_id=$row1['user_id'];
                            $cat=$row2['category'];
                            $user_nm=$row3['user_nm'];
                            if($cat=="Business")
                            {
                                $_SESSION["user_id"]=$user_id;
                                $_SESSION["email"]=$email;
                                $_SESSION["user_nm"]=$user_nm;
                                $_SESSION["category"]=$cat;
                                header("Location:b_dashboard.php");
                                exit;
                            }
                            else if($cat=="Teacher")
                            {
                                $_SESSION["user_id"]=$user_id;
                                $_SESSION["email"]=$email;
                                $_SESSION["user_nm"]=$user_nm;
                                $_SESSION["category"]=$cat;
                                header("Location:t_dashboard.php");
                                exit;
                            }
                            else
                            {
                                $_SESSION["user_id"]=$user_id;
                                $_SESSION["email"]=$email;
                                $_SESSION["user_nm"]=$user_nm;
                                $_SESSION["category"]=$cat;
                                header("Location:s_dashboard.php");
                                exit;
                            }
                        }
                        else
                        {
                            $_SESSION['error_message']="You don't have an account, Please make a new account:)";
                        }
                        header("Location:login.php");
                        exit;
                    }
                    else
                    {
                        $_SESSION['error_message']="Error in connection:(";
                    }
                } 
                
                if(isset($_SESSION['error_message'])) 
                {
                    echo "
                        <div class='l_error'>
                        <p> &#9888; {$_SESSION['error_message']}</p>
                        </div> ";
                    unset($_SESSION['error_message']); 
                }
                ?>
            </div>    
        </div>
    </div>
    <!--Width Restriction-->
    <div class="cover_parent">
        <div class="cover_child">
            <div class="cover_img_holder"></div>
            <div class="cover_instruction">
                <p>Sorry, This site is not available for Mobile Users:(</p>
                <p>Please open this site into Desktop View!</p>
            </div>
        </div>
    </div>
    <!--End Width Restriction-->
</body> 
</html>