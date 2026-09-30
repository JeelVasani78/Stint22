<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stint22 | Reset Password</title>
    <link rel="stylesheet" href="change_pass.css">
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
                <p>"Task by Task, Password by Password-Resetting for a More Organized Tomorrow."</p>
            </div>
        </div>
        <div class="right">
            <div class="up">
                <p>Welcome:)</p>
            </div>
            <div class="down">
                <form action="change_pass.php" method="POST">
                    <h1>Reset Password</h1>
                    <div class="txt1">
                        <input type="email" placeholder="Email Id" name="email" required>
                    </div>
                    <div class="txt2">
                        <input type="password" placeholder="New Password" name="n_pass" required>
                    </div>
                    <div class="txt3">
                        <input type="password" placeholder="Confirm Password" name="n_c_pass" required>
                    </div>
                    <input type="submit" value="Submit" name="submit" class="login" id="submit">
                    <div class="signup">
                        <p>Don't have an account?<a href="signup.php">SignUp</a></p>
                    </div>
                    <?php
                    error_reporting(0);
                    if(isset($_POST['submit']))
                    {
                        $server="localhost";
                        $username="root";
                        $password="";
                        $db="stint22";
                        $con1=mysqli_connect($server,$username,$password,$db);
                        if($con1)
                        {
                            $email=$_POST['email'];
                            $n_pass=$_POST['n_pass'];
                            $n_c_pass= $_POST['n_c_pass'];
                            if($n_pass==$n_c_pass)
                            {
                                $s1="select * from user_info where emailid='$email'";
                                $sel1=mysqli_query($con1,$s1);
                                if(mysqli_num_rows($sel1)>0)
                                {
                                    $row=mysqli_fetch_assoc($sel1);
                                    $old_pass=$row['pass'];
                                    if($old_pass!=$n_c_pass)
                                    {
                                        $u1="update user_info set pass='$n_c_pass' where emailid='$email'";
                                        $update=mysqli_query($con1,$u1);
                                        if($update)
                                        {
                                            echo "<script>alert('Password Reset Successfully');</script>";
                                            header("Location:login.php");
                                        }
                                        else
                                        {
                                            echo "<script>alert('Somthing goes wrong!');</script>";
                                        }
                                    }
                                    else
                                    {
                                        echo "<script>alert('You entered old password!');</script>";
                                    }
                                }
                                else
                                {
                                    echo "<script>alert('Email not found!');</script>";
                                }
                            }
                        }
                    }
                    ?>
                </form>
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