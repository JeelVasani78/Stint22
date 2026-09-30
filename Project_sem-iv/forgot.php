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
                <form action="forgot.php" method="POST">
                    <h1>Reset Password</h1>
                    <div class="txt1">
                        <input type="email" placeholder="Email Id" name="email" required>
                    </div>
                    <input type="submit" value="Send link" name="submit" class="login" id="submit">
                    <div class="signup">
                        <p>Don't have an account?<a href="signup.php">SignUp</a></p>
                    </div>
                </form>
                <?php
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
                        $s1="select emailid from user_info where emailid='$email'";
                        $sel1=mysqli_query($con1,$s1);
                        if(mysqli_num_rows($sel1)>0)
                        {
                            $to = $email;
                            $subject = 'Password Reset Request for Your Stint22 Account';
                            $message = 'Hello,<br><br>';
                            $message .= 'You have requested to reset your password for your Stint22 account. ';
                            $message .= 'Click the link below to reset your password:<br><br>';
                            $message .= '<a href="http://localhost/Project_sem-iv/change_pass.php">Reset Password</a><br><br>';
                            $message .= 'If you did not request this, please ignore this email.';
                        
                            $headers = "From: Stint22 <noreply@Stint22.com>\r\n";
                            $headers .= "Reply-To: noreply@Stint22.com\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                        
                            if (mail($to, $subject, $message, $headers)) 
                            {
                                $_SESSION['message'] = "Email Sent!";
                                header("Location:forgot.php");
                                exit;
                            } 
                            else 
                            {
                                echo "Email could not be sent.";
                            }
                        }
                        else
                        {
                            echo "<script>alert('Email not found!');</script>";
                        }
                    }
                }
                if(isset($_SESSION['message'])) {
                    echo "<script>alert('{$_SESSION['message']}');</script>";
                    unset($_SESSION['message']);
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