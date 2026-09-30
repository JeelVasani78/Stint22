<?php
error_reporting(0); 
//ini_set('display_errors', 1);
session_start();
if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_nm']) && !isset($_SESSION['email']) && !isset($_SESSION['category']))
{
    echo "<script> window.location='index.html'; </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stint22 | Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="b_dashboard.css">
    <link rel="shortcut icon" type="x-icon" href="./img/final_logo.jpg">
</head>
<body>
    <div id="preloader"></div>
    <div class="main">
        <!--Sidebar-->
        <div class="left">
            <div class="l1">
                <h1>Stint22</h1>
                <i class="fa-solid fa-bars"></i>
            </div>
            <div class="l2">
                <div class="b1" onclick="addtask()" title="Add Task">
                    <div class="b_child">
                        <i class="fa-solid fa-plus"> &nbsp;<input type="button" value="Add Task"></i><br>
                    </div>
                </div>
                <hr>
                <div class="b2" onclick="yourtask()" title="My Tasks">
                    <div class="b_child">    
                        <i class="fa-solid fa-list-check"> &nbsp;<input type="button" value="My Tasks"></i><br>
                    </div>
                </div>
                <hr>
                <div class="b3" onclick="todaytask()" title="Today's Tasks">
                    <div class="b_child">    
                        <i class="fa-solid fa-calendar-day"> &nbsp;<input type="button" value="Today"></i><br>
                    </div>
                </div>
                <hr>
                <div class="b4" onclick="pasttask()" title="Past Due">
                    <div class="b_child">
                        <i class="fas fa-hourglass-end"> &nbsp;<input type="button" value="Past Due"></i><br>
                    </div>
                </div>
                <hr>
            </div>
            <div class="l3" onclick="toggle_user_profile()">
            <?php
                $server="localhost";
                $username="root";
                $password="";
                $db="stint22";
                
                $con0=mysqli_connect($server,$username,$password,$db);
                if($con0)
                {
                    $user_id=$_SESSION["user_id"];
                    $l3_s1="select user_nm from user_info where user_id=$user_id";
                    $l3_q1=mysqli_query($con0,$l3_s1);
                    $l3_r1=mysqli_fetch_assoc($l3_q1);
                }
            ?>
            <i class="fa-solid fa-user" onclick="toggle_user_profile()"></i>
            <p><?php echo $l3_r1['user_nm']; ?></p>
            </div>
        </div>
        <!--Right Content Tabs-->
        <div class="right">
            <!---Add Tasks--->
            <div class="inputbox">
                <div class="inputbox_child">
                    <div class="a_task">
                        <div class="top">
                            <p>Add Task</p>
                            <i class="fa-solid fa-xmark" id="x-icon" onclick="addtask()"></i>
                        </div>
                        <!--form-->
                        <form name="frm1" action="s_dashboard.php" method="POST">
                        <div class="middle">
                            <input type="text" id="task_title" name="task_title" placeholder="Task Title" class="txt" maxlength="25" autofocus required>
                            <hr>
                            <textarea name="task_desc" id="task_desc1" rows="5" cols="30" placeholder="Description" maxlength="200" required></textarea>
                            <hr>
                            <p id="result"></p>
                        </div>
                        <div class="mid-bottom">
                            <div class="f_time">
                                From:<input type="time" name="f_time" min="00:00" max="23:59" required>
                            </div>
                            <div class="t_time">
                                To:<input type="time" name="t_time" min="00:00" max="23:59" required>
                            </div>
                            <div class="d_date">
                                Date:<input type="date" name="d_date" min="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="bottom">
                            <input type="reset" name="reset" value="Reset">
                            <input type="submit" name="submit0" value="Submit">
                        </div>
                        <?php
                        //error_reporting(0);
                        //session_start();
                        if (!isset($_SESSION["user_id"])) 
                        {
                            header('Location: login.php');
                            exit();
                        }
                        $user_id=$_SESSION["user_id"];
                        if(isset($_POST['submit0']))
                        {
                            $server="localhost";
                            $username="root";
                            $password="";
                            $db="stint22";
                            $con1=mysqli_connect($server,$username,$password,$db);
                            if($con1)
                            {
                                $task_title=$_POST['task_title'];
                                $task_desc=$_POST['task_desc'];
                                $f_time=$_POST['f_time'];
                                $t_time=$_POST['t_time'];
                                $d_date=$_POST['d_date'];

                                $q1="insert into task_master(user_id,date,s_time,e_time,title,task_desc) values('$user_id','$d_date','$f_time','$t_time','$task_title','$task_desc')";
                                $insert=mysqli_query($con1,$q1);
                                if($insert)
                                {
                                    echo "<script>alert('Task Added Successfully');</script>";
                                    header('Location:s_dashboard.php');
                                    exit();
                                }
                                else
                                {
                                    echo "<script>alert('Error Adding Task');</script>";
                                }
                            }
                            else
                            {
                                echo "<script>alert('Error in Connection...');</script>";
                            }

                        }
                        ?>
                        </form>
                    </div> 
                </div>
            </div>
            <!--End Add Tasks-->
            <!--Your Tasks-->
            <div id="your_tasks">
                <div class="up1">
                    <p>My Tasks</p>
                    <i class="fa-solid fa-bars"  onclick="toggle_themes()" title="Themes"></i>
                </div>
                <div class="down1">
                    <?php
                        //error_reporting(0);
                        //session_start();
                        if (!isset($_SESSION["user_id"])) 
                        {
                            header('Location: login.php');
                            exit();
                        }
                        $user_id=$_SESSION["user_id"];
                        $server="localhost";
                        $username="root";
                        $password="";
                        $db="stint22";
                        $con2=mysqli_connect($server,$username,$password,$db);
                        if($con2)
                        {
                            $q2="select * from task_master where date>=CURDATE() and team_id IS NULL and user_id=$user_id order by date,s_time,e_time,task_id";
                            $sel1=mysqli_query($con2,$q2);
                            while ($r1=mysqli_fetch_assoc($sel1))
                            {
                                $taskid=$r1['task_id'];
                                //echo "$taskid";
                    ?>
                    <div class="taskbox">
                        <!--form-->
                        <form name="frm2" action="s_dashboard.php" method="POST">
                            <div class="middle">
                                <input type="text" class="c_task_title" id="c_task_title1_<?php echo $taskid; ?>" name="c_task_title" placeholder="Task Title" maxlength="25" readonly value="<?php echo $r1['title'];?>">
                                <hr>
                                <textarea name="task_desc1" class="c_task_desc" id="c_task_desc_<?php echo $taskid; ?>" rows="5" cols="30" placeholder="Description" maxlength="200" readonly><?php echo $r1['task_desc'];?></textarea>
                                <hr>
                                <?php
                                    $clen=strlen($r1['task_desc']);
                                ?>
                                <p id="c_result"><?php echo $clen;?>/200</p>
                            </div>
                            <div class="mid-bottom">
                                <div class="f_time">
                                    From:<input type="time" id="c_f_time_<?php echo $taskid;?>" value="<?php echo $r1['s_time'];?>" readonly>
                                </div>
                                <div class="t_time">
                                    To:<input type="time" id="c_t_time_<?php echo $taskid;?>" value="<?php echo $r1['e_time'];?>" readonly>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="d_date" title="Due Date">
                                    Date:<input type="date" id="c_d_date_<?php echo $taskid;?>" value="<?php echo $r1['date'];?>" readonly>
                                </div>
                                <input type="button" name="submit1" value="Update" onclick="update(<?php echo $taskid;?>)">
                                <input type="button" name="submit2" value="Delete" onclick="del(<?php echo $taskid;?>)">
                            </div>
                        </form>
                    </div>
                    <?php
                            }
                        }
                        else
                        {
                            echo "<script>alert('Error in Connection...');</script>";
                        } 
                    ?>
                </div>
            </div>
            <!--End Your Tasks-->
            <!--update-->
            <div class="update">
                <div class="update_child">
                    <div class="updatebox">
                        <div class="top">
                            <p>Update Task</p>
                            <i class="fa-solid fa-xmark" id="x-icon" onclick="update()"></i>
                        </div>
                        <!--form-->
                        <form name="u_frm" action="s_dashboard.php" method="POST">
                        <div class="middle">
                            <input type="hidden" name="u_hidden_task_id" id="u_hidden_task_id">
                            <input type="text" id="u_task_title" name="u_task_title" placeholder="Task Title" maxlength="25" autofocus required>
                            <hr>
                            <textarea name="u_task_desc" id="u_task_desc" rows="5" cols="30" placeholder="Description" maxlength="200" required></textarea>
                            <hr>
                            <p id="u_result"></p>
                        </div>
                        <div class="mid-bottom">
                            <div class="f_time">
                                From:<input type="time" class="u_f_time" id="u_f_time" name="u_f_time" min="00:00" max="23:59" required>
                            </div>
                            <div class="t_time">
                                To:<input type="time" class="u_t_time" id="u_t_time" name="u_t_time" min="00:00" max="23:59" required>
                            </div>
                            <div class="d_date">
                                Date:<input type="date" class="u_d_date" id="u_d_date" name="u_d_date" title="Choose a Date"  min="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="bottom">
                            <input type="reset" name="reset" value="Reset">
                            <input type="submit" name="update" value="Update">
                        </div>
                        </form>
                    <?php
                        //error_reporting(0);
                        //session_start();
                        if(isset($_POST['update']))
                        {
                            if (!isset($_SESSION["user_id"])) 
                            {
                                header('Location: login.php');
                                exit();
                            }
                            $user_id=$_SESSION["user_id"];
                            $server="localhost";
                            $username="root";
                            $password="";
                            $db="stint22";
                            $con3=mysqli_connect($server,$username,$password,$db);
                            if($con3)
                            {
                                $u_taskid=$_POST['u_hidden_task_id'];
                                $u_title=$_POST['u_task_title'];
                                $u_desc=$_POST['u_task_desc'];
                                $u_f_time=$_POST['u_f_time'];
                                $u_t_time=$_POST['u_t_time'];
                                $u_d_date=$_POST['u_d_date'];

                                $u_q1="update task_master set title='$u_title', task_desc='$u_desc', s_time='$u_f_time', e_time='$u_t_time', date='$u_d_date' where task_id='$u_taskid' and user_id='$user_id'";                                
                                $update1=mysqli_query($con3,$u_q1);
                                if($update1)
                                {
                                    echo "<script>alert('Task Updated Successfully!');</script>";
                                    header('Location:s_dashboard.php');
                                }
                                else
                                {
                                    echo "<script>alert('Error in Updating Task!');</script>";
                                }
                            }
                        }
                    ?>
                    </div>
                </div>
            </div>
            <!--End Update-->
            <!--delete-->
            <div class="delete">
                <div class="delete_parent">
                    <div class="delete_child">
                        <div class="top">
                            <p>Delete Task</p>
                            <i class="fa-solid fa-xmark" id="x-icon" onclick="del()"></i>
                        </div>
                        <hr>
                        <!--form-->
                        <form name="d_frm" action="s_dashboard.php" method="POST">
                        <div class="middle">
                            <input type="hidden" name="d_hidden_task_id" id="d_hidden_task_id">
                            <p>Are you sure to delete this task?</p>
                        </div>
                        <div class="bottom">
                            <input type="submit" name="d_submit" id="d_submit" value="Yes">
                            <input type="button" name="delete_cancel" value="No" onclick="del()">
                        </div>
                        </form>
                        <?php
                        //error_reporting(0);
                        //session_start();
                        if(isset($_POST['d_submit']))
                        {
                            if (!isset($_SESSION["user_id"])) 
                            {
                                header('Location: login.php');
                                exit();
                            }
                            $user_id=$_SESSION["user_id"];
                            $server="localhost";
                            $username="root";
                            $password="";
                            $db="stint22";
                            $con4=mysqli_connect($server,$username,$password,$db);
                            if($con4)
                            {
                                $d_taskid=$_POST['d_hidden_task_id'];
                                $d_q1="delete from task_master where task_id=$d_taskid";
                                $d1=mysqli_query($con4,$d_q1);
                                if($d1)
                                {
                                    echo "<script>alert('Task deleted successfully!');</script>";
                                    header("Location:s_dashboard.php");
                                }
                                else
                                {
                                    echo "<script>alert('Error in deletion!');</script>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!--End Delete-->
            <!--Today's Tasks--> 
            <div id="today_tasks">
                <div class="up1">
                    <p>Today's Tasks</p>
                    <i class="fa-solid fa-bars"  onclick="toggle_themes()" title="Themes"></i>
                </div>
                <div class="down1">
                    <?php
                        //error_reporting(0);
                        //session_start();
                        if (!isset($_SESSION["user_id"])) 
                        {
                            header('Location: login.php');
                            exit;
                        }
                        $user_id=$_SESSION["user_id"];
                        $server="localhost";
                        $username="root";
                        $password="";
                        $db="stint22";
                        $con5=mysqli_connect($server,$username,$password,$db);
                        if($con5)
                        {
                            $q2="select * from task_master where date=CURDATE() and team_id IS NULL and user_id=$user_id order by date,s_time,e_time,task_id";
                            $sel1=mysqli_query($con5,$q2);
                            while ($r1=mysqli_fetch_assoc($sel1))
                            {
                                $taskid=$r1['task_id'];
                                //echo "$taskid";
                    ?>
                    <div class="taskbox">
                        <!--form-->
                        <form name="frm2" action="s_dashboard.php" method="POST">
                            <div class="middle">
                                <input type="text" class="c_task_title" id="c_task_title1_<?php echo $taskid; ?>" name="c_task_title" placeholder="Task Title" maxlength="25" readonly value="<?php echo $r1['title'];?>">
                                <hr>
                                <textarea name="task_desc1" class="c_task_desc" id="c_task_desc_<?php echo $taskid; ?>" rows="5" cols="30" placeholder="Description" maxlength="200" readonly><?php echo $r1['task_desc'];?></textarea>
                                <hr>
                                <?php
                                    $clen=strlen($r1['task_desc']);
                                ?>
                                <p id="c_result"><?php echo $clen;?>/200</p>
                            </div>
                            <div class="mid-bottom">
                                <div class="f_time">
                                    From:<input type="time" id="c_f_time_<?php echo $taskid;?>" value="<?php echo $r1['s_time'];?>" readonly>
                                </div>
                                <div class="t_time">
                                    To:<input type="time" id="c_t_time_<?php echo $taskid;?>" value="<?php echo $r1['e_time'];?>" readonly>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="d_date" title="Due Date">
                                    Date:<input type="date" id="c_d_date_<?php echo $taskid;?>" value="<?php echo $r1['date'];?>" readonly>
                                </div>
                                <input type="button" name="submit1" value="Update" onclick="update(<?php echo $taskid;?>)">
                                <input type="button" name="submit2" value="Delete" onclick="del(<?php echo $taskid;?>)">
                            </div>
                        </form>
                    </div>
                    <?php
                            }
                        }
                        else
                        {
                            echo "<script>alert('Error in Connection...');</script>";
                        } 
                    ?>
                </div>
            </div>
            <!--End Today's Tasks-->
            <!--Past Tasks-->
            <div id="past_tasks">
                <div class="up1">
                    <p>Past Due</p>
                    <i class="fa-solid fa-bars"  onclick="toggle_themes()" title="Themes"></i>
                </div>
                <div class="down1">
                    <?php
                        //error_reporting(0);
                        //session_start();
                        if (!isset($_SESSION["user_id"])) 
                        {
                            header('Location: login.php');
                            exit();
                        }
                        $user_id=$_SESSION["user_id"];
                        $server="localhost";
                        $username="root";
                        $password="";
                        $db="stint22";
                        $con6=mysqli_connect($server,$username,$password,$db);
                        if($con6)
                        {
                            $q2="select * from task_master where date<CURDATE() and team_id IS NULL and user_id=$user_id order by date,s_time,e_time,task_id";
                            $sel1=mysqli_query($con6,$q2);
                            while ($r1=mysqli_fetch_assoc($sel1))
                            {
                                $taskid=$r1['task_id'];
                                //echo "$taskid";
                    ?>
                    <div class="taskbox">
                        <!--form-->
                        <form name="frm2" action="s_dashboard.php" method="POST">
                            <div class="middle">
                                <input type="text" class="c_task_title" id="c_task_title1_<?php echo $taskid; ?>" name="c_task_title" placeholder="Task Title" maxlength="25" readonly value="<?php echo $r1['title'];?>">
                                <hr>
                                <textarea name="task_desc1" class="c_task_desc" id="c_task_desc_<?php echo $taskid; ?>" rows="5" cols="30" placeholder="Description" maxlength="200" readonly><?php echo $r1['task_desc'];?></textarea>
                                <hr>
                                <?php
                                    $clen=strlen($r1['task_desc']);
                                ?>
                                <p id="c_result"><?php echo $clen;?>/200</p>
                            </div>
                            <div class="mid-bottom">
                                <div class="f_time">
                                    From:<input type="time" id="c_f_time_<?php echo $taskid;?>" value="<?php echo $r1['s_time'];?>" readonly>
                                </div>
                                <div class="t_time">
                                    To:<input type="time" id="c_t_time_<?php echo $taskid;?>" value="<?php echo $r1['e_time'];?>" readonly>
                                </div>
                            </div>
                            <div class="pd_bottom">
                                <div class="d_date" title="Due Date">
                                    Date:<input type="date" id="c_d_date_<?php echo $taskid;?>" value="<?php echo $r1['date'];?>" readonly>
                                </div>
                                <input type="button" name="submit2" value="Delete" onclick="del(<?php echo $taskid;?>)">
                            </div>
                        </form>
                    </div>
                    <?php
                            }
                        }
                        else
                        {
                            echo "<script>alert('Error in Connection...');</script>";
                        } 
                    ?>
                </div>
            </div>
            <!--End Past Tasks-->
            <!--User Profile-->
            <div class="user">
                <div class="user_parent">
                    <div class="user_child">
                        <!--Form-->
                        <form name="user_frm" action="s_dashboard.php" method="POST" enctype="multipart/form-data">
                        <?php 
                        $user_id=$_SESSION["user_id"];
                        $server="localhost";
                        $username="root";
                        $password="";
                        $db="stint22";
                        
                        $con12=mysqli_connect($server,$username,$password,$db);
                        if($con12)
                        {


                            $user_s4="select image,user_nm from user_info where user_id=$user_id";
                            $user_q4=mysqli_query($con12,$user_s4);
                            $user_r4=mysqli_fetch_assoc($user_q4);

                            $folder=$user_r4['image'];
                            if(isset($_FILES["upload_img"]) && $_FILES["upload_img"]["error"]===UPLOAD_ERR_OK && !empty($_FILES["upload_img"]["name"]))
                            {
                                $file_name=basename($_FILES["upload_img"]["name"]);
                                $tmp_name=$_FILES["upload_img"]["tmp_name"];
                                $folder="img/".$file_name;
                                move_uploaded_file($tmp_name,$folder);
                            }
                        ?>
                        <div class="user_top">
                            <p>Your Profile</p>
                            <i class="fa-solid fa-xmark" id="x-icon" onclick="toggle_user_profile()"></i>
                        </div>
                        <hr>
                        <div class="user_middle">
                            <div class="user_middle1">
                                <div class="user_img">
                                    <img src="<?php echo $user_r4['image']; ?>" alter="user">
                                    <input type="file" name="upload_img">
                                </div>
                                <div class="user_name">
                                    <input type="text" id="edit_user_name" name="u_user_nm" maxlength="30" value="<?php echo $user_r4['user_nm']; ?>" readonly>
                                    <i class="fa-solid fa-pen" onclick="change_user_nm()"></i>
                                </div>
                            </div>
                            <div class="user_middle2">

                                <?php

                                    if(isset($_POST['save_user_info']))
                                    {
                                        $updated_user_nm=$_POST['u_user_nm'];
                                        $user_i1="update user_info set image='$folder',user_nm='$updated_user_nm' where user_id=$user_id";
                                        $user_q5=mysqli_query($con12,$user_i1);

                                        // $_SESSION['user_nm']=$user_r4['user_nm'];

                                        echo "<script> window.location='s_dashboard.php'; </script>";
                                    }
                                    $user_s1="select count(task_id) as total_task from task_master where user_id=$user_id and team_id IS NULL";
                                    $user_q1=mysqli_query($con12,$user_s1);
                                    $user_r1=mysqli_fetch_assoc($user_q1);

                                    $user_s2="select count(team_id) as total_team from team_master where user_id=$user_id";
                                    $user_q2=mysqli_query($con12,$user_s2);
                                    $user_r2=mysqli_fetch_assoc($user_q2);

                                    if($user_q1)
                                    {
                                        $total_task=$user_r1['total_task'];
                                    }
                                    else
                                    {
                                        $total_task=0;
                                    }

                                    if($user_q2)
                                    {
                                        $total_team=$user_r2['total_team'];
                                    }
                                    else
                                    {
                                        $total_team=0;
                                    }

                                    $user_s3="select date from user_info where user_id=$user_id";
                                    $user_q3=mysqli_query($con12,$user_s3);
                                    $user_r3=mysqli_fetch_assoc($user_q3);
                                ?>
                                <p>Category: <?php echo $_SESSION["category"]; ?></p>
                                <p>Total Task: <?php echo $total_task; ?></p>
                                <p>Total Team: <?php echo $total_team; ?></p>
                                <p>Created on: <?php echo  $user_r3['date']; ?></p>

                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <hr>
                        <div class="user_bottom">
                                <input type="reset" value="Reset">
                                <input type="submit" value="Save" name="save_user_info">
                                <input type="submit" value="Logout" name="logout">
                        </div>
                        </form>
                        <?php
                            if(isset($_POST["logout"]))
                            {
                                session_start();
                                session_unset();
                                session_destroy();

                                echo "<script> window.location='index.html'; </script>";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!--End User Profile-->
            <!--Themes-->
            <div class="theme">
                <div class="theme_parent">
                    <div class="theme_child">
                        <div class="theme_top">
                            <p>Themes</p>
                            <i class="fa-solid fa-xmark" id="x-icon" onclick="toggle_themes()"></i>
                        </div>
                        <hr>
                        <div class="theme_bottom">
                            <div class="theme_bottom1">
                                <span id="span1" onclick="sp1()" title="Stint22 Official"></span>
                                <span id="span2" onclick="sp2()" title="Coal"></span>
                                <span id="span3" onclick="sp3()" title="Silver"></span>
                                <span id="span4" onclick="sp4()" title="Sage Green"></span>
                                <span id="span5" onclick="sp5()" title="Baby Pink"></span>
                            </div>
                            <div class="theme_bottom2">
                                <span id="span6" onclick="sp6()" title="Midnight Blue"></span>
                                <span id="span7" onclick="sp7()" title="Pale Lavender"></span>
                                <span id="span8" onclick="sp8()" title="Baby Blue"></span>
                                <span id="span9" onclick="sp9()" title="Dark Vanilla"></span>
                                <span id="span10" onclick="sp10()" title="Lemon Chiffon"></span>
                            </div>
                            <div class="theme_bottom3">
                                <span id="span11" onclick="sp11()" title="Mountain with Lake"></span>
                                <span id="span12" onclick="sp12()" title="Mount Fuji"></span>
                                <span id="span13" onclick="sp13()" title="Sunglasses"></span>
                                <span id="span14" onclick="sp14()" title="Golden Fields at Sunset"></span>
                                <span id="span15" onclick="sp15()" title="Mountains"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Themes-->
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
    <script>
        /*Script for loading screen*/
        var loader = document.getElementById("preloader");
        window.addEventListener("load",function(){
            loader.style.display="none";
        });
        /*Script for Restrictions in Input fields*/
        var task_title=document.getElementById("task_title");
        var task_desc=document.getElementById("task_desc1"); 
        var u_task_title=document.getElementById("u_task_title");
        var u_task_desc=document.getElementById("u_task_desc");
        var result1=document.getElementById("result");
        var result2=document.getElementById("u_result");
        var limit1=25;
        var limit2=200;
        result1.textContent="0/"+limit2;
        result2.textContent="0/"+limit2;
        
        task_title.addEventListener("input",function() {
            var textLength1=task_title.value.length;
            if (textLength1===limit1) 
            {
                task_title.style.color="#ff0000";
            } 
            else
            {
                task_title.style.color="#888888";   
            }    
        });
        task_desc.addEventListener("input",function() {
            var textLength2=task_desc.value.length;
            result.textContent=textLength2+"/"+limit2;
            if (textLength2===limit2) 
            {
                task_desc.style.color="#ff0000";
                result1.style.color="#ff0000";
            } 
            else
            {
                task_desc.style.color="#888888";
                result1.style.color="#888888";    
            }    
        });
        u_task_title.addEventListener("input",function() {
            var textLength3=u_task_title.value.length;
            if (textLength3===limit1) 
            {
                u_task_title.style.color="#ff0000";
            } 
            else
            {
                u_task_title.style.color="#888888";   
            }    
        });
        u_task_desc.addEventListener("input",function() {
            var textLength4=u_task_desc.value.length;
            result2.textContent=textLength4+"/"+limit2;
            if (textLength4===limit2) 
            {
                u_task_desc.style.color="#ff0000";
                result2.style.color="#ff0000";
            } 
            else
            {
                u_task_desc.style.color="#888888";
                result2.style.color="#888888";    
            }    
        });

        /*Script for Display and Hide the Add Task Box*/
        var add_task1=document.querySelector(".inputbox");
        var your_task1=document.getElementById("your_tasks");
        var today_task1=document.getElementById("today_tasks");
        var past_task1=document.getElementById("past_tasks");
        var update_task=document.querySelector(".update");
        var delete_task=document.querySelector(".delete");
        var user_profile=document.querySelector(".user");
        var theme=document.querySelector(".theme");
        var b1=document.querySelector(".b1");
        var b2=document.querySelector(".b2");
        var b3=document.querySelector(".b3");
        var b4=document.querySelector(".b4");

        function addtask()
        {
            if(add_task1.style.display=="block")
            {
                add_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="#00000014";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
            }
            else
            {
                add_task1.style.display="block";
                update_task.style.display="none";
                delete_task.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="#00000014";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
            }
        }
        function yourtask()
        {
            if(your_task1.style.display=="none")
            {
                your_task1.style.display="block";
                add_task1.style.display="none";
                today_task1.style.display="none";
                past_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="#00000014";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
            }
            else
            {
                your_task1.style.display="block";
                add_task1.style.display="none";
                today_task1.style.display="none";
                past_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="#00000014";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
            }
        }
        function todaytask()
        {
            if(today_task1.style.display=="block")
            {
                today_task1.style.display="block";
                your_task1.style.display="none";
                add_task1.style.display="none";
                past_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="#00000014";
                b4.style.backgroundColor="transparent";
            }
            else
            {
                today_task1.style.display="block";
                your_task1.style.display="none";
                add_task1.style.display="none";
                past_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="#00000014";
                b4.style.backgroundColor="transparent";
            }
        }
        function pasttask()
        {
            if(past_task1.style.display=="block")
            {
                past_task1.style.display="block";
                your_task1.style.display="none";
                add_task1.style.display="none";
                today_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="#00000014";
            }
            else
            {
                past_task1.style.display="block";
                your_task1.style.display="none";
                add_task1.style.display="none";
                today_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="#00000014";
            }
        }
        function update(taskid)
        {
            if(update_task.style.display=="block")
            {
                update_task.style.display="none";
            }
            else
            {
                update_task.style.display="block";
                /* Script for updating task */
                var task_id=taskid;
                //console.log(task_id);
                var ctitle=document.getElementById("c_task_title1_"+ task_id).value;
                var cdesc=document.getElementById("c_task_desc_"+task_id).value;
                var cftime=document.getElementById("c_f_time_"+task_id).value;
                var cttime=document.getElementById("c_t_time_"+task_id).value;
                var cdate=document.getElementById("c_d_date_"+task_id).value;
                //console.log(ctitle);
                var utaskid=document.getElementById("u_hidden_task_id");
                var utitle=document.getElementById("u_task_title");
                var udesc=document.getElementById( "u_task_desc");
                var uftime=document.getElementById("u_f_time");
                var uttime=document.getElementById("u_t_time");
                var udate=document.getElementById("u_d_date");
                
                utaskid.value=taskid;
                //console.log(utaskid);
                utitle.value=ctitle;
                udesc.value=cdesc;
                uftime.value=cftime;
                uttime.value=cttime;
                udate.value=cdate;
                
                var uresult=document.getElementById("u_result");
                var ulen=udesc.value.length;
                uresult.textContent=ulen+"/200";
                
                /*if(ctitle && utitle)
                {
                    utitle.value=ctitle;
                    console.log("Working");
                }
                else
                {
                    console.log("Not Working");
                }*/
            }
           
        }
        function del(taskid)
        {
            /*console.log("Delete Button Clicked!");*/
            if(delete_task.style.display=="block")
            {
                delete_task.style.display="none";
            }
            else
            {
                delete_task.style.display="block";
                var task_id=taskid;
                /*console.log(taskid);*/
                var dtaskid=document.getElementById("d_hidden_task_id");
                dtaskid.value=task_id;
            }
        }
        
        function team_information()
        {
            if(team_info.style.display=="block")
            {
                team_info.style.display="block";
                past_task1.style.display="none";
                your_task1.style.display="none";
                add_task1.style.display="none";
                today_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
            }
            else
            {
                team_info.style.display="block";
                past_task1.style.display="none";
                your_task1.style.display="none";
                add_task1.style.display="none";
                today_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
            }
        }
        
        function change_user_nm()
        {
            var user_nm=document.querySelector("#edit_user_name");
            if(user_nm.readOnly)
            {
                user_nm.readOnly=false;
                user_nm.focus();
                user_nm.style.backgroundColor="#00000024";
            }
            else
            {
                user_nm.readOnly=true;
                user_nm.style.background="transparent";
            }
        }

        function toggle_user_profile()
        {
            if(user_profile.style.display=="block")
            {
                user_profile.style.display="none";
                b2.style.backgroundColor="#00000014";
                // your_task1.style.display="block";
            }
            else
            {
                user_profile.style.display="block";
                update_task.style.display="none";
                delete_task.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
            }
        }

        function toggle_themes()
        {
            if(theme.style.display=="block")
            {
                theme.style.display="none";
                b2.style.backgroundColor="#00000014";
            }
            else
            {
                theme.style.display="block";
                user_profile.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
            }
        }

        var Stint22_official="#ffffff";
        var coal="#282828";
        var silver="#C0C0C0";
        var sage_green="#A8C0A1";
        var baby_pink="#F7D1D8";
        var mid_blue="#092230";
        var Light_Periwinkle="#d0bdf4";
        var baby_blue="#89CFF0";
        var pale_chestnut="#dcb9a1";
        var color10="#FFFACD";

        var span1=document.querySelector("#span1");
        var span2=document.querySelector("#span2");
        var span3=document.querySelector("#span3");
        var span4=document.querySelector("#span4");
        var span5=document.querySelector("#span5");
        var span6=document.querySelector("#span6");
        var span7=document.querySelector("#span7");
        var span8=document.querySelector("#span8");
        var span9=document.querySelector("#span9");
        var span10=document.querySelector("#span10");
        var span11=document.querySelector("#span11");
        var span12=document.querySelector("#span12");
        var span13=document.querySelector("#span13");
        var span14=document.querySelector("#span14");
        var span15=document.querySelector("#span15");

        var main=document.querySelector(".main");
        var left=document.querySelector(".left");
        var a_task=document.querySelector(".a_task");
        var updatebox=document.querySelector(".updatebox");
        var deletebox=document.querySelector(".delete_child");
        var themes=document.querySelector(".theme_child");
        var user_p=document.querySelector(".user_child");

        function sp1()
        {
            span1.style.boxShadow="0px 0px 5px 5px #00000033";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#888888";});

            main.style.background="#ffffff";
            left.style.background="#ffffff";
            a_task.style.background="#ffffff";
            updatebox.style.background="#ffffff";
            deletebox.style.background="#ffffff";
            themes.style.background="#ffffff";
            user_p.style.background="#ffffff";

            localStorage.setItem('textcolor', '#888888');
            localStorage.setItem('main','#ffffff');
            localStorage.setItem('bgcolor','#ffffff');
        }

        function sp2()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="0px 0px 5px 5px #00000033";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#ffffff";});

            main.style.background="#282828";
            left.style.background="#282828";
            a_task.style.background="#282828";
            updatebox.style.background="#282828";
            deletebox.style.background="#282828";
            themes.style.background="#282828";
            user_p.style.background="#282828";

            localStorage.setItem('textcolor', '#ffffff');
            localStorage.setItem('main','#282828');
            localStorage.setItem('bgcolor','#282828');
        }

        function sp3()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="0px 0px 5px 5px #00000033";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#282828";});

            main.style.background="#C0C0C0";
            left.style.background="#C0C0C0";
            a_task.style.background="#C0C0C0";
            updatebox.style.background="#C0C0C0";
            deletebox.style.background="#C0C0C0";
            themes.style.background="#C0C0C0";
            user_p.style.background="#C0C0C0";

            localStorage.setItem('textcolor', '#282828');
            localStorage.setItem('main','#C0C0C0');
            localStorage.setItem('bgcolor','#C0C0C0');
        }

        function sp4()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="0px 0px 5px 5px #00000033";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#282828";});

            main.style.background="#A8C0A1";
            left.style.background="#A8C0A1";
            a_task.style.background="#A8C0A1";
            updatebox.style.background="#A8C0A1";
            deletebox.style.background="#A8C0A1";
            themes.style.background="#A8C0A1";
            user_p.style.background="#A8C0A1";

            localStorage.setItem('textcolor', '#282828');
            localStorage.setItem('main','#A8C0A1');
            localStorage.setItem('bgcolor','#A8C0A1');
        }

        function sp5()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="0px 0px 5px 5px #00000033";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#282828";});

            main.style.background="#F7D1D8";
            left.style.background="#F7D1D8";
            a_task.style.background="#F7D1D8";
            updatebox.style.background="#F7D1D8";
            deletebox.style.background="#F7D1D8";
            themes.style.background="#F7D1D8";
            user_p.style.background="#F7D1D8";

            localStorage.setItem('textcolor', '#282828');
            localStorage.setItem('main','#F7D1D8');
            localStorage.setItem('bgcolor','#F7D1D8');
        }
        
        function sp6()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="0px 0px 5px 5px #00000033";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#ffffff";});

            main.style.background="#092230";
            left.style.background="#092230";
            a_task.style.background="#092230";
            updatebox.style.background="#092230";
            deletebox.style.background="#092230";
            themes.style.background="#092230";
            user_p.style.background="#092230";

            localStorage.setItem('textcolor', '#ffffff');
            localStorage.setItem('main','#092230');
            localStorage.setItem('bgcolor','#092230');
        }

        function sp7()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="0px 0px 5px 5px #00000033";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#282828";});

            main.style.background="#d0bdf4";
            left.style.background="#d0bdf4";
            a_task.style.background="#d0bdf4";
            updatebox.style.background="#d0bdf4";
            deletebox.style.background="#d0bdf4";
            themes.style.background="#d0bdf4";
            user_p.style.background="#d0bdf4";

            localStorage.setItem('textcolor', '#282828');
            localStorage.setItem('main','#d0bdf4');
            localStorage.setItem('bgcolor','#d0bdf4');
        }

        function sp8()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="0px 0px 5px 5px #00000033";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#282828";});

            main.style.background="#89CFF0";
            left.style.background="#89CFF0";
            a_task.style.background="#89CFF0";
            updatebox.style.background="#89CFF0";
            deletebox.style.background="#89CFF0";
            themes.style.background="#89CFF0";
            user_p.style.background="#89CFF0";

            localStorage.setItem('textcolor', '#282828');
            localStorage.setItem('main','#89CFF0');
            localStorage.setItem('bgcolor','#89CFF0');
        }

        function sp9()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="0px 0px 5px 5px #00000033";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#282828";});

            main.style.background="#dcb9a1";
            left.style.background="#dcb9a1";
            a_task.style.background="#dcb9a1";
            updatebox.style.background="#dcb9a1";
            deletebox.style.background="#dcb9a1";
            themes.style.background="#dcb9a1";
            user_p.style.background="#dcb9a1";

            localStorage.setItem('textcolor', '#282828');
            localStorage.setItem('main','#dcb9a1');
            localStorage.setItem('bgcolor','#dcb9a1');
        }

        function sp10()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="0px 0px 5px 5px #00000033";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#282828";});

            main.style.background="#FFFACD";
            left.style.background="#FFFACD";
            a_task.style.background="#FFFACD";
            updatebox.style.background="#FFFACD";
            deletebox.style.background="#FFFACD";
            themes.style.background="#FFFACD";
            user_p.style.background="#FFFACD";

            localStorage.setItem('textcolor', '#282828');
            localStorage.setItem('main','#FFFACD');
            localStorage.setItem('bgcolor','#FFFACD');
        }

        function sp11()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="0px 0px 5px 5px #00000033";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#ffffff";});

            main.style.background="url(./img/mountain2.jpg) no-repeat center center/100% 100%";
            left.style.background="transparent";
            a_task.style.background="transparent";
            updatebox.style.background="transparent";
            deletebox.style.background="transparent";
            themes.style.background="transparent";
            user_p.style.background="transparent";

            localStorage.setItem('textcolor', '#ffffff');
            localStorage.setItem('main','url(./img/mountain2.jpg) no-repeat center center/100% 100%');
            localStorage.setItem('bgcolor','transparent');
        }

        function sp12()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="0px 0px 5px 5px #00000033";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#ffffff";});

            main.style.background="url(./img/mt_fuji.jpg) no-repeat center center/100%";
            left.style.background="transparent";
            a_task.style.background="transparent";
            updatebox.style.background="transparent";
            deletebox.style.background="transparent";
            themes.style.background="transparent";
            user_p.style.background="transparent";

            localStorage.setItem('textcolor', '#ffffff');
            localStorage.setItem('main','url(./img/mt_fuji.jpg) no-repeat center center/100%');
            localStorage.setItem('bgcolor','transparent');
        }

        function sp13()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="0px 0px 5px 5px #00000033";
            span14.style.boxShadow="none";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#ffffff";});

            main.style.background="url(./img/sunglass.jpg) no-repeat center center/100%";
            left.style.background="transparent";
            a_task.style.background="transparent";
            updatebox.style.background="transparent";
            deletebox.style.background="transparent";
            themes.style.background="transparent";
            user_p.style.background="transparent";

            localStorage.setItem('textcolor', '#ffffff');
            localStorage.setItem('main','url(./img/sunglass.jpg) no-repeat center center/100%');
            localStorage.setItem('bgcolor','transparent');
        }

        function sp14()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="0px 0px 5px 5px #00000033";
            span15.style.boxShadow="none";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#ffffff";});

            main.style.background="url(./img/fields.jpg) no-repeat center center/100%";
            left.style.background="transparent";
            a_task.style.background="transparent";
            updatebox.style.background="transparent";
            deletebox.style.background="transparent";
            themes.style.background="transparent";
            user_p.style.background="transparent";

            localStorage.setItem('textcolor', '#ffffff');
            localStorage.setItem('main','url(./img/fields.jpg) no-repeat center center/100%');
            localStorage.setItem('bgcolor','transparent');
        }

        function sp15()
        {
            span1.style.boxShadow="none";
            span2.style.boxShadow="none";
            span3.style.boxShadow="none";
            span4.style.boxShadow="none";
            span5.style.boxShadow="none";
            span6.style.boxShadow="none";
            span7.style.boxShadow="none";
            span8.style.boxShadow="none";
            span9.style.boxShadow="none";
            span10.style.boxShadow="none";
            span11.style.boxShadow="none";
            span12.style.boxShadow="none";
            span13.style.boxShadow="none";
            span14.style.boxShadow="none";
            span15.style.boxShadow="0px 0px 5px 5px #00000033";

            const allElements = document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color = "#ffffff";});

            main.style.background="url(./img/mountain3.jpg) no-repeat center center/100%";
            left.style.background="transparent";
            a_task.style.background="transparent";
            updatebox.style.background="transparent";
            deletebox.style.background="transparent";
            themes.style.background="transparent";
            user_p.style.background="transparent";

            localStorage.setItem('textcolor', '#ffffff');
            localStorage.setItem('main','url(./img/mountain3.jpg) no-repeat center center/100%');
            localStorage.setItem('bgcolor','transparent');
        }

        function saved_theme()
        {
            const saved_color=localStorage.getItem('textcolor');
            const main_bg=localStorage.getItem('main');
            // const left_bg=localStorage.getItem('left');
            // const a_task_bg=localStorage.getItem('a_task');
            // const task_box_bg=localStorage.getItem('task_box');
            // const updatebox_bg=localStorage.getItem('updatebox');
            // const deletebox_bg=localStorage.getItem('deletebox');
            // const create_team_bg=localStorage.getItem('create_team');
            // const team_member_bg=localStorage.getItem('team_member');
            // const team_task_child_bg=localStorage.getItem('team_task_child');
            // const delete_teams_bg=localStorage.getItem('delete_teams_bg');
            // const themes_bg=localStorage.getItem('themes');
            // const user_p_bg=localStorage.getItem('user_p');
            const back_color=localStorage.getItem('bgcolor');

            const allElements=document.querySelectorAll("*");
                allElements.forEach(element => {element.style.color=saved_color;});

            main.style.background=main_bg;
            left.style.background=back_color;
            a_task.style.background=back_color;
            updatebox.style.background=back_color;
            deletebox.style.background=back_color;
            themes.style.background=back_color;
            user_p.style.background=back_color;

        }
 
        document.addEventListener('DOMContentLoaded', saved_theme);
        window.onload = yourtask();
        
    </script>

</body>
</html>
