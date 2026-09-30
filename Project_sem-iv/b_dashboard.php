<?php
// error_reporting(0); 
// //ini_set('display_errors', 1);
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
    <!-- <div id="preloader"></div> -->
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
                <div class="b5" title="Make a Team" onclick="c_team()">
                    <div class="b_child">
                        <i class="fa-solid fa-user-plus"> &nbsp;<input type="button" value="New Team"></i><br>
                    </div>
                </div>
                <hr>
                <div class="b6" title="My Teams" onclick="team_information()">
                    <div class="b_child">
                        <i class="fa-solid fa-list-ul"> &nbsp;<input type="button" value="My Teams"></i><br>
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
                        <form name="frm1" action="b_dashboard.php" method="POST">
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
                                    echo "<script> window.location='b_dashboard.php'; </script>";
                                    exit();
                                }
                                else
                                {
                                    echo "<script>alert('Error Adding Task');</script>";
                                }
                                /*header('Location:b_dashboard.html');*/
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
                        if(!isset($_SESSION["user_id"])) 
                        {
                            header('Location: login.php');
                            exit();
                        }
                        $user_id=$_SESSION["user_id"];
                        $email= $_SESSION['email'];
                        $user_nm= $_SESSION['user_nm'];
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
                        <form name="frm2" action="b_dashboard.php" method="POST">
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
                        <form name="u_frm" action="b_dashboard.php" method="POST">
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
                                    header('Location:b_dashboard.php');
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
                        <form name="d_frm" action="b_dashboard.php" method="POST">
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
                                    header("Location:b_dashboard.php");
                                }
                                else
                                {
                                    echo "<script>alert('Error in Deletion!');</script>";
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
                        <form name="frm2" action="b_dashboard.php" method="POST">
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
                        <form name="frm2" action="b_dashboard.php" method="POST">
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
            <!--Make Teams-->
            <div class="teams">
                <div class="teams_parent">
                    <div class="teams_child">
                    <div class="top">
                            <p>Create Team</p>
                            <i class="fa-solid fa-xmark" id="x-icon" onclick="c_team()"></i>
                        </div>
                        <hr>
                        <!--form-->
                        <form name="t_frm" action="b_dashboard.php" method="POST">
                        <div class="middle">
                            <input type="text" name="t_name" id="t_name" placeholder="Team Name" maxlength="50" autofocus required>
                        </div>
                        <div class="bottom">
                            <input type="submit" name="t_submit" id="t_submit" value="Create">
                        </div>
                        </form>
                        <?php
                        //error_reporting(0);
                        //session_start();
                        if(isset($_POST['t_submit']))
                        {
                            if (!isset($_SESSION["user_id"])) 
                            {
                                header('Location: login.php');
                                exit();
                            }
                            $user_id=$_SESSION["user_id"];
                            $cat=$_SESSION["category"];
                            $server="localhost";
                            $username="root";
                            $password="";
                            $db="stint22";
                            
                            $con7=mysqli_connect($server,$username,$password,$db);
                            if($con7)
                            {
                                $t_name=$_POST['t_name'];
                                $c_t_date=date("Y-m-d");
                                $l_t_name1=strval(strtolower($t_name));
                                $c_t_s1="select team_name from team_master where team_name='$t_name' and user_id=$user_id";
                                $s1=mysqli_query($con7,$c_t_s1);
                                $r1=mysqli_fetch_assoc($s1);
                                $t_name2=$r1['team_name'];
                                $l_t_name2=strval(strtolower($t_name2));
                                if($l_t_name1!=$l_t_name2)
                                {
                                    $c_t_i1="insert into team_master(user_id,team_name,team_category,date)values('$user_id','$t_name','$cat','$c_t_date')";
                                    $i1=mysqli_query($con7,$c_t_i1);
                                    if($i1)
                                    {   
                                        $_SESSION['message1']="Team created successfully!";
                                        header('Location:b_dashboard.php');
                                        exit;
                                    }
                                    else
                                    {
                                        $_SESSION['message1']="Error in data insertion!";
                                        header('Location:b_dashboard.php');
                                        exit;
                                    }
                                }
                                else
                                {
                                    $_SESSION['message2']="Team already exist! Please try another name.";
                                    header('Location:b_dashboard.php');
                                    exit;
                                }
                            }
                            else
                            {
                                echo "<script>alert('Error in connection!');</script>";
                            }
                        }
                        if(isset($_SESSION['message1'])) 
                        {
                            echo "<script>alert('{$_SESSION['message1']}');</script>";
                            unset($_SESSION['message1']);
                        }
                        if(isset($_SESSION['message2']))
                        {
                            echo "<script>alert('{$_SESSION['message2']}');</script>";
                            unset($_SESSION['message2']);
                        } 
                        ?>
                    </div>
                </div>
            </div>
            <!--End Make Teams-->
            <!--Team Information-->
            <div id="team_info">
                <div class="up1">
                    <p>My Teams</p>
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
                    
                    $con8=mysqli_connect($server,$username,$password,$db);
                    if($con8)
                    {
                        $t_s1="select * from team_master where user_id=$user_id";
                        $s1=mysqli_query($con8,$t_s1);
                        while($row1=mysqli_fetch_assoc($s1))
                        {
                            $team_id=$row1['team_id'];
                            //echo "<script>console.log($team_id);</script>";

                            $t_s2="select * from task_master where user_id=$user_id and team_id=$team_id";
                            $s2=mysqli_query($con8,$t_s2);

                            $t_s3="select * from emp where user_id=$user_id and team_id=$team_id";
                            $s3=mysqli_query($con8,$t_s3);
                            
                    ?>
                    <div class="teambox">
                        <!--form-->
                        <form name="team_info_frm" method="POST" action="b_dashboard.php">
                        <div class="t_block1">
                            <div class="t_top1">
                                <!--<input type="hidden" name="t_hidden_id1" id="t_hidden_id">-->
                                <p>Name:<?php echo $row1['team_name'];?></p>
                    <?php
                                while($row2=mysqli_fetch_assoc($s2))
                                {
                                    
                    ?>
                                <p>Task Title:<?php echo $row2['title'];?></p>
                                <p>Details:<?php echo $row2['task_desc'];?></p>
                                <p>Due:Before&nbsp;<?php echo $row2['date'];?>&nbsp;by&nbsp;<?php echo $row2['e_time'];?></p>
                    <?php
                                }
                    ?>
                            </div>
                            <div class="t_top2">
                                <button type="button" name="del_team" onclick="d_team(<?php echo $team_id;?>)"><i class="fa-solid fa-xmark" id="x-icon"></i></button>
                            </div>
                        </div>
                        <hr>
                        <div class="t_block2">
                    <?php
                               
                                $t_s4="select count(emp_id) as t_emp from emp where user_id=$user_id and team_id=$team_id";
                                $s4=mysqli_query($con8,$t_s4);
                                if($s4)
                                {
                                    $t_f1=mysqli_fetch_assoc($s4);        
                    ?>             
                            <p>Total members:<?php echo $t_f1['t_emp'];?></p>
                    <?php
                                }
                                else
                                {
                    ?>
                            <p>Total members:0</p>
                    <?php
                                }
                                while($row3=mysqli_fetch_assoc($s3))
                                {   
                                    $empno=$row3['emp_no']; 
                    ?>
                            <div class="member_list_parent">
                                <div class="member_list_child">
                                    <div class="m_left">
                                        <p><?php echo $row3['ename'];?></p>
                                    </div>
                                    <div class="m_right">
                                        <button type="submit" name="del_mem" value="<?php echo $empno;?>"><i class="fa-solid fa-xmark"></i></button>
                                    </div>
                    <?php
                                    if(isset($_POST['del_mem']))
                                    {
                                        $e_no= $_POST["del_mem"];
                                        $d_e_q1="delete from emp where user_id=$user_id and emp_no=$e_no";
                                        $d_q1=mysqli_query($con8,$d_e_q1);
                                        if($d_q1)
                                        {
                                            header('Location:b_dashboard.php');
                                        }
                                        else
                                        {
                                            echo "<script>alert('Error while deleting!');</script>";
                                        }
                                    }
                    ?>
                                </div>
                            </div>
                    <?php
                                }
                    ?>
                        </div>
                        <hr>
                        <div class="t_block3">
                            <input type="button" name="a_member" id="a_member" value="Add Member" onclick="toggle_add_member(<?php echo $team_id;?>)">
                            <input type="button" name="edit_task" id="edit_task" value="Edit Task" onclick="toggle_team_task(<?php echo $team_id;?>)">
                        </div>
                        </form>
                    </div>
                    <?php
                            }
                        }
                        else
                        {
                            echo "<script>alert('Error in connection!!');</script>";
                        }
                    ?>    
                </div>
            </div>
            <!--End Team Infromation-->
            <!--Add Member-->
            <div class="add_member">
                <div class="add_member_parent">
                    <div class="add_member_child">
                        <div class="top1">
                            <p>Add Member</p>
                            <i class="fa-solid fa-xmark" onclick="toggle_add_member()"></i>
                        </div>
                        <hr>
                        <!--form-->
                        <form name="a_m_frm" action="b_dashboard.php" method="POST">
                        <div class="middle1">
                            <input type="hidden" name="t_id1_hidden"  id="t_id1_hidden">
                            <input type="number" name="emp_no" id="emp_no1" placeholder="Employee No." min="0" max="99999" autofocus required>
                            <input type="text" name="ename" id="ename1" placeholder="Employee Name" maxlength="25" required>
                            <input type="text" name="deptno" id="deptno1" placeholder="Department No." maxlength="5" required>
                        </div>
                        <hr>
                        <div class="bottom1">
                            <input type="submit" name="add_m" value="Add">
                        </div>
                        </form>

                        <?php
                        //error_reporting(0);
                        //session_start();
                        if(isset($_POST['add_m']))
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
                            
                            $con9=mysqli_connect($server,$username,$password,$db);
                            if($con9)
                            {
                                $add_team_id=$_POST['t_id1_hidden'];
                                $eno=$_POST['emp_no'];
                                $ename=$_POST['ename'];
                                $deptno=$_POST['deptno'];
                                $e_s1="select emp_no from emp where user_id=$user_id";
                                $s1=mysqli_query($con9,$e_s1);
                                $r1=mysqli_fetch_assoc($s1);
                                $old_empno=$r1['emp_no'];
                                if($old_empno!=$eno)
                                {
                                    $e_q1="insert into emp(user_id,team_id,emp_no,ename,deptno) values('$user_id','$add_team_id','$eno','$ename','$deptno')";
                                    $q1=mysqli_query($con9,$e_q1);
                                    if($q1)
                                    {
                                        echo "<script>alert('Member added successfully!');</script>";
                                        header("Location:b_dashboard.php");
                                    }
                                    else
                                    {
                                        echo "<script>alert('Error in insertion');</script>";
                                    }
                                }
                                else
                                {
                                    echo "<script>alert('Employee number already exists!');</script>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!--End Add Member-->
            <!--Team Task-->
            <div class="team_task">
                <div class="team_task_parent">
                    <div class="team_task_child">
                        <div class="top1">
                            <p>Add Team Task</p>
                            <i class="fa-solid fa-xmark" onclick="toggle_team_task()"></i>
                        </div>
                        <hr>
                        <!--form-->
                        <form name="t_t_frm" action="b_dashboard.php" method="POST">
                        <div class="middle1">
                        <input type="hidden" name="t_id2_hidden" id="t_id2_hidden">
                            <input type="text" id="t_t_title" name="t_t_title" placeholder="Task Title" maxlength="50" autofocus required>
                            <textarea name="t_t_desc" id="t_t_desc" rows="5" cols="30" placeholder="Description" maxlength="500" required></textarea>
                        </div>
                        <hr>
                        <div class="t_result">
                            <p id="t_t_result"></p>
                        </div>
                        <div class="mid-bottom1">
                            <p>Due:</p>
                            <input type="time" name="t_d_time" id="t_d_time" require>
                            <input type="date" name="t_d_date" id="t_d_date"  min="<?php echo date('Y-m-d'); ?>" require>
                        </div>
                        <hr>
                        <div class="bottom1">
                            <input type="reset" value="Reset">
                            <input type="submit" value="Submit" name="t_t_submit">
                        </div>
                        </form>
                        <?php
                        //error_reporting(0);
                        //session_start();
                        if(isset($_POST['t_t_submit']))
                        {
                            if(!isset($_SESSION["user_id"])) 
                            {
                                header('Location: login.php');
                                exit();
                            }
                            $user_id=$_SESSION["user_id"];
                            $server="localhost";
                            $username="root";
                            $password="";
                            $db="stint22";
                            
                            $con10=mysqli_connect($server,$username,$password,$db);
                            if($con10)
                            {
                                $add_team_id2=$_POST['t_id2_hidden'];
                                $t_t_title=$_POST['t_t_title'];
                                $t_t_desc=$_POST['t_t_desc'];
                                $t_d_time=$_POST['t_d_time'];
                                $t_d_date=$_POST['t_d_date'];
                                $t_t_q1="insert into task_master(user_id,team_id,title,task_desc,e_time,date) values('$user_id','$add_team_id2','$t_t_title','$t_t_desc','$t_d_time','$t_d_date')";
                                $q1=mysqli_query($con10,$t_t_q1);
                                if($q1)
                                {
                                    echo "<script>alert('Task inserted successfully!');</script>";
                                    header("Location:b_dashboard.php");
                                }
                                else
                                {
                                    echo "<script>alert('Error in insertion!');</script>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!--End Team Task-->
            <!--Delete Team-->
            <div class="delete_team">
                <div class="delete_team_parent">
                    <div class="delete_team_child">
                        <div class="top">
                            <p>Delete Team</p>
                            <i class="fa-solid fa-xmark" id="x-icon" onclick="d_team()"></i>
                        </div>
                        <hr>
                        <!--form-->
                        <form name="d_frm" action="b_dashboard.php" method="POST">
                        <div class="middle">
                            <input type="hidden" name="d_hidden_team_id" id="d_hidden_team_id2">
                            <p>Are you sure to delete this team?</p>
                        </div>
                        <div class="bottom">
                            <input type="submit" name="d_submit2" id="d_submit2" value="Yes">
                            <input type="button" name="delete_cancel2" value="No" onclick="d_team()">
                        </div>
                        </form>
                        <?php
                        //error_reporting(0);
                        //session_start();
                        if(isset($_POST['d_submit2']))
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
                            
                            $con11=mysqli_connect($server,$username,$password,$db);
                            if($con11)
                            {
                                $d_teamid=$_POST['d_hidden_team_id'];
                                $d_q1="delete from team_master where user_id='$user_id' and team_id='$d_teamid'";
                                $d1=mysqli_query($con11,$d_q1);

                                $d_q2="delete from emp where user_id='$user_id' and team_id='$d_teamid'";
                                $d2=mysqli_query($con11,$d_q2);
                                if($d1 && $d2)
                                {
                                    echo "<script>alert('Team deleted successfully!');</script>";
                                    header("Location:b_dashboard.php");
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
            <!--End Delete Team-->
            <!--User Profile-->
            <div class="user">
                <div class="user_parent">
                    <div class="user_child">
                        <!--Form-->
                        <form name="user_frm" action="b_dashboard.php" method="POST" enctype="multipart/form-data">
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

                                        echo "<script> window.location='b_dashboard.php'; </script>";
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
        var c_team_name=document.getElementById("t_name");
        var team_title=document.getElementById("t_t_title");
        var team_desc=document.getElementById("t_t_desc");
        var result1=document.getElementById("result");
        var result2=document.getElementById("u_result");
        var result3=document.getElementById("t_t_result");
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
        c_team_name.addEventListener("input",function() {
            var textLength5=c_team_name.value.length;
            if (textLength5===50) 
            {
                c_team_name.style.color="#ff0000";
            } 
            else
            {
                c_team_name.style.color="#888888";   
            }    
        });
        team_title.addEventListener("input",function() {
            var textLength6=team_title.value.length;
            if (textLength6===50) 
            {
                team_title.style.color="#ff0000";
            } 
            else
            {
                team_title.style.color="#888888";   
            }    
        });
        team_desc.addEventListener("input",function() {
            var textLength7=team_desc.value.length;
            result3.textContent=textLength7+"/"+500;
            if (textLength7===500) 
            {
                team_desc.style.color="#ff0000";
                result3.style.color="#ff0000";
            } 
            else
            {
                team_desc.style.color="#888888";
                result3.style.color="#888888";    
            }    
        });


        /*Script for Display and Hide the Add Task Box*/
        var add_task1=document.querySelector(".inputbox");
        var your_task1=document.getElementById("your_tasks");
        var today_task1=document.getElementById("today_tasks");
        var past_task1=document.getElementById("past_tasks");
        var update_task=document.querySelector(".update");
        var delete_task=document.querySelector(".delete");
        var c_teams=document.querySelector(".teams");
        var team_info=document.getElementById("team_info");
        var add_member=document.querySelector(".add_member");
        var team_task=document.querySelector(".team_task");
        var del_team=document.querySelector(".delete_team");
        var user_profile=document.querySelector(".user");
        var theme=document.querySelector(".theme");
        var b1=document.querySelector(".b1");
        var b2=document.querySelector(".b2");
        var b3=document.querySelector(".b3");
        var b4=document.querySelector(".b4");
        var b5=document.querySelector(".b5");
        var b6=document.querySelector(".b6");

        function addtask()
        {
            if(add_task1.style.display=="block")
            {
                add_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                c_teams.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="#00000014";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="transparent";
            }
            else
            {
                add_task1.style.display="block";
                update_task.style.display="none";
                delete_task.style.display="none";
                c_teams.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="#00000014";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="transparent";
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
                c_teams.style.display="none";
                team_info.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="#00000014";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="transparent";
            }
            else
            {
                your_task1.style.display="block";
                add_task1.style.display="none";
                today_task1.style.display="none";
                past_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                c_teams.style.display="none";
                team_info.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="#00000014";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="transparent";
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
                c_teams.style.display="none";
                team_info.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="#00000014";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="transparent";
            }
            else
            {
                today_task1.style.display="block";
                your_task1.style.display="none";
                add_task1.style.display="none";
                past_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                c_teams.style.display="none";
                team_info.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="#00000014";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="transparent";
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
                c_teams.style.display="none";
                team_info.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="#00000014";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="transparent";
            }
            else
            {
                past_task1.style.display="block";
                your_task1.style.display="none";
                add_task1.style.display="none";
                today_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                c_teams.style.display="none";
                team_info.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="#00000014";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="transparent";
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
        function c_team()
        {
            if(c_teams.style.display=="block")
            {
                c_teams.style.display="none";
                add_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="#00000014";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
            }
            else
            {
                c_teams.style.display="block";
                add_task1.style.display="none";
                update_task.style.display="none";
                delete_task.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="#00000014";
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
                c_teams.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="#00000014";
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
                c_teams.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                user_profile.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="#00000014";
            }
        }
        
        
        function toggle_add_member(teamid)
        {
            if(add_member.style.display=="block")
            {
                add_member.style.display="none";
            }
            else
            {
                add_member.style.display="block";
                var team_id1=teamid;
                //console.log(team_id1);
                var hidden_txt1=document.getElementById("t_id1_hidden");
                hidden_txt1.value=team_id1;
                
            }
        }
        function toggle_team_task(teamid)
        {
            if(team_task.style.display=="block")
            {
                team_task.style.display="none";
            }
            else
            {
                team_task.style.display="block";
                var team_id2=teamid;
                var hidden_txt2=document.getElementById("t_id2_hidden");
                hidden_txt2.value=team_id2;
            }
        } 
        function d_team(teamid)
        {
            if(del_team.style.display=="block")
            {
                del_team.style.display="none";
            }
            else
            {
                del_team.style.display="block";
                var d_tid=teamid;
                var d_hidden_id2=document.getElementById("d_hidden_team_id2");
                d_hidden_id2.value=d_tid;
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
                c_teams.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                theme.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="transparent";
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
                c_teams.style.display="none";
                add_member.style.display="none";
                team_task.style.display="none";
                del_team.style.display="none";
                b1.style.backgroundColor="transparent";
                b2.style.backgroundColor="transparent";
                b3.style.backgroundColor="transparent";
                b4.style.backgroundColor="transparent";
                b5.style.backgroundColor="transparent";
                b6.style.backgroundColor="transparent";
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
        var create_team=document.querySelector(".teams_child");
        var team_member=document.querySelector(".add_member_child");
        var team_task_child=document.querySelector(".team_task_child");
        var delete_teams=document.querySelector(".delete_team_child");
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
            create_team.style.background="#ffffff";
            team_member.style.background="#ffffff";
            team_task_child.style.background="#ffffff";
            delete_teams.style.background="#ffffff";
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
            create_team.style.background="#282828";
            team_member.style.background="#282828";
            team_task_child.style.background="#282828";
            delete_teams.style.background="#282828";
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
            create_team.style.background="#C0C0C0";
            team_member.style.background="#C0C0C0";
            team_task_child.style.background="#C0C0C0";
            delete_teams.style.background="#C0C0C0";
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
            create_team.style.background="#A8C0A1";
            team_member.style.background="#A8C0A1";
            team_task_child.style.background="#A8C0A1";
            delete_teams.style.background="#A8C0A1";
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
            create_team.style.background="#F7D1D88";
            team_member.style.background="#F7D1D8";
            team_task_child.style.background="#F7D1D8";
            delete_teams.style.background="#F7D1D88";
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
            create_team.style.background="#092230";
            team_member.style.background="#092230";
            team_task_child.style.background="#092230";
            delete_teams.style.background="#092230";
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
            create_team.style.background="#d0bdf4";
            team_member.style.background="#d0bdf4";
            team_task_child.style.background="#d0bdf4";
            delete_teams.style.background="#d0bdf4";
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
            create_team.style.background="#89CFF0";
            team_member.style.background="#89CFF0";
            team_task_child.style.background="#89CFF0";
            delete_teams.style.background="#89CFF0";
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
            create_team.style.background="#dcb9a1";
            team_member.style.background="#dcb9a1";
            team_task_child.style.background="#dcb9a1";
            delete_teams.style.background="#dcb9a1";
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
            create_team.style.background="#FFFACD";
            team_member.style.background="#FFFACD";
            team_task_child.style.background="#FFFACD";
            delete_teams.style.background="#FFFACD";
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
            create_team.style.background="transparent";
            team_member.style.background="transparent";
            team_task_child.style.background="transparent";
            delete_teams.style.background="transparent";
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
            create_team.style.background="transparent";
            team_member.style.background="transparent";
            team_task_child.style.background="transparent";
            delete_teams.style.background="transparent";
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
            create_team.style.background="transparent";
            team_member.style.background="transparent";
            team_task_child.style.background="transparent";
            delete_teams.style.background="transparent";
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
            create_team.style.background="transparent";
            team_member.style.background="transparent";
            team_task_child.style.background="transparent";
            delete_teams.style.background="transparent";
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
            create_team.style.background="transparent";
            team_member.style.background="transparent";
            team_task_child.style.background="transparent";
            delete_teams.style.background="transparent";
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
            create_team.style.background=back_color;
            team_member.style.background=back_color;
            team_task_child.style.background=back_color;
            delete_teams.style.background=back_color;
            themes.style.background=back_color;
            user_p.style.background=back_color;

        }
 
        document.addEventListener('DOMContentLoaded', saved_theme);
        window.onload = yourtask();
        
    </script>

</body>
</html>
