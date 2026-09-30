<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stint22 | SignUp</title>
    <link rel="stylesheet" href="signup.css">
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
                <p>"Task Management: Because Your Dreams Deserve a Plan."</p>
            </div>
        </div>
        <div class="right">
            <div class="up">
                <p>Welcome:)</p>
            </div>
            <div class="down">
                <form name="frm1" action="signup.php" method="POST">
                    <h1>SignUp</h1>
                    <div class="txt1">
                        <input type="text" placeholder="User Name" name="user_nm" required>
                    </div>
                    <div class="txt2">
                        <input type="email" placeholder="Email Id" name="email" required>
                    </div>
                    <div class="txt3">
                        <input type="password" placeholder="Password" name="pass" required>
                    </div>
                    <div class="txt4">
                        <input type="password" placeholder="Confirm Password" name="c_pass" required>
                    </div>
                    <div class="select">
                        <select name="select1">
                            <option disabled selected> Category </option>
                            <option value="Business">Business</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Student">Student</option>
                        </select>
                    </div>
                    <input type="submit" value="SignUp" name="submit" class="signup">
                    <div class="login">
                        <p>Already have an account?<a href="login.php">Login</a></p>
                    </div>
                </form>
                <?php
                error_reporting(0);
if(isset($_POST['submit'])) 
                {
                    $server = "localhost";
                    $user = "root";
                    $password = "";
                    $database = "stint22";
                    $cn = mysqli_connect($server, $user, $password, $database);

                    if($cn)
                    {
                        $email=$_POST['email'];
                        $user_nm=$_POST['user_nm'];
                        $pass=$_POST['pass'];
                        $c_pass=$_POST['c_pass'];
                        $cat=$_POST['select1'];
                        $s1="select * from  user_info where emailid='$email'";
                        $s=mysqli_query($cn,$s1);
                        
                        if (mysqli_num_rows($s)==0)
                        { 
                            if($pass!=$c_pass) 
                            {
                                $_SESSION['error_message']="Password does not match.";
                            } 
                            elseif($cat=="Category" || empty($cat)) 
                            {
                                $_SESSION['error_message']="Please select a valid Category.";
                            } 
                            else 
                            {
                                $date=date('Y-m-d');
                                $q1="insert into user_info(user_nm,emailid,pass,category,date) values('$user_nm','$email','$pass','$cat','$date')";
                                $insert=mysqli_query($cn,$q1);
                                if($insert) 
                                {
                                    /*$last_id=mysqli_insert_id($cn);
                                    $q2 = "insert into task_master(user_id) values('$last_id')";
                                    $insert=mysqli_query($cn,$q2);*/
                                
                                    header("Location:login.php");
                                    exit();
                                } 
                                else 
                                {
                                    $_SESSION['error_message']="Error in inserting data: ";
                                }
                            }
                        } 
                        else 
                        {
                            $_SESSION['error_message']="Account already exists.";
                        }

                        header("Location:signup.php");
                        exit();
                    } 
                    else
                    {
                        echo "Error in connection.";
                    }
                }

                if(isset($_SESSION['error_message'])) 
                {
                    echo "
                        <div class='p_error'>
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
