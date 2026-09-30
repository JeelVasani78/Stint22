<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="b_dashboard.css">
    <linke rel="shortcut icon" href="C:\wamp\www\Project_sem-iv/logo.png">
</head>
<body>
    <div class="main">
        <!--Sidebar-->
        <div class="left">
            <div class="l1">
                <h1>Stint22</h1>
                <i class="fa-solid fa-bars"></i>
            </div>
            <div class="l2">
                <div class="b1" onclick="addtask()" title="Add Task">
                    <i class="fa-solid fa-plus"> &nbsp;<input type="button" value="Add Task"></i><br>
                </div>
                    <hr>
                <div class="b2" onclick="yourtask()" title="Your Tasks">    
                    <i class="fa-solid fa-list-check"> &nbsp;<input type="button" value="Your Tasks"></i><br>
                </div>
                    <hr>
                <div class="b3" onclick="todaytask()" title="Today's Tasks">    
                    <i class="fa-solid fa-calendar-day"> &nbsp;<input type="button" value="Today"></i><br>
                </div>
                    <hr>
                <div class="b4" title="Make a Team">
                    <i class="fa-solid fa-plus"> &nbsp;<input type="button" value="New Team"></i><br>
                </div>
                    <hr>
            </div>
            <div class="l3">
                <h1>Hello! <?php
                    error_reporting(0);
                    session_start();
                    $user_nm= $_SESSION['user_nm'];
                    echo $user_nm;
                ?>
                </h1>
                <p><?php
                    error_reporting(0);
                    session_start();
                    $email= $_SESSION['email'];
                    echo $email;
                ?>
                </p>
            </div>
        </div>
        <!--Content-->
        <div class="right">
            <!---Add Tasks--->
            <div class="input_task_box1" id="input_task_box">
                <div class="a_task">
                    <div class="top">
                        <p>Add Task</p>
                        <i class="fa-solid fa-xmark" id="x-icon" onclick="addtask()"></i>
                    </div>
                    <!--form-->
                    <form name="frm1" action="extra.php" method="POST">
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
                            Date:<input type="date" name="d_date" required>
                        </div>
                    </div>
                    <div class="bottom">
                        <input type="reset" name="reset" value="Reset">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                    <?php
                    error_reporting(0);
                    session_start();
                    if (!isset($_SESSION["user_id"])) 
                    {
                        header('Location: login.php');
                        exit();
                    }
                    $user_id=$_SESSION["user_id"];
                    if(isset($_POST['submit']))
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
                                header('Location:extra.php');
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
            <!--Your Tasks-->
            <div id="your_tasks">
                <div class="up1">
                    <p>Your Tasks</p>
                </div>
                <div class="down1">
                    <?php
                        error_reporting(0);
                        session_start();
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
                            $q2="select * from task_master where user_id=$user_id";
                            $sel1=mysqli_query($con2,$q2);
                            while ($r1=mysqli_fetch_assoc($sel1))
                            {
                    ?>
                    <div class="taskbox">
                        <!--form-->
                        <form name="frm2" action="extra.php" method="POST">
                            <div class="middle">
                                <input type="text" id="task_title1" name="task_title1" placeholder="Task Title" class="txt" maxlength="25" readonly value="<?php echo $r1['title'];?>">
                                <hr>
                                <textarea name="task_desc1" id="task_desc2" rows="5" cols="30" placeholder="Description" maxlength="200" readonly><?php echo $r1['task_desc'];?></textarea>
                                <hr>
                            </div>
                            <div class="mid-bottom">
                                <div class="f_time">
                                    From:<?php echo $r1['s_time'];?>
                                </div>
                                <div class="t_time">
                                    To:<?php echo $r1['e_time'];?>
                                </div>
                                <div class="d_date">
                                    Date:<?php echo $r1['date'];?>
                                </div>
                            </div>
                            <div class="bottom">
                                <input type="submit" name="submit1" value="Update">
                                <input type="submit" name="submit2" value="Delete">
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
            <!--Today's Tasks--> 
            <div id="today_tasks">
                <div class="up2">
                    <p>Today Tasks</p>
                </div>
                <div class="down2">
                <form name="frm3" action="extra.php" method="POST">
                    <div class="middle">
                        <input type="text" id="task_title2" name="task_title1" placeholder="Task Title" class="txt" maxlength="25" autofocus required>
                        <hr>
                        <textarea name="task_desc2" id="task_desc3" rows="5" cols="30" placeholder="Description" maxlength="200" required></textarea>
                        <hr>
                        <p id="result2"></p>
                    </div>
                    <div class="mid-bottom">
                        <div class="f_time">
                            From:<input type="time" name="f_time1" min="00:00" max="23:59" required>
                        </div>
                        <div class="t_time">
                            To:<input type="time" name="t_time1" min="00:00" max="23:59" required>
                        </div>
                        <div class="d_date">
                            Date:<input type="date" name="d_date1" required>
                        </div>
                    </div>
                    <div class="bottom">
                        <input type="reset" name="reset" value="Reset">
                    <input type="submit" name="submit3" value="Submit">
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        /*Script for Restrictions in Input fields*/
        var task_title=document.getElementById("task_title")
        var task_desc=document.getElementById("task_desc1");
        var result=document.getElementById("result");
        var limit1=25;
        var limit2=200;
        result.textContent="0/"+limit2;
        
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
                result.style.color="#ff0000";
            } 
            else
            {
                task_desc.style.color="#888888";
                result.style.color="#888888";    
            }    
        });
        /*Script for Display and Hide the Add Task Box*/
        var add_task1=document.getElementById("input_task_box");
        var your_task1=document.getElementById("your_tasks");
        var today_task1=document.getElementById("today_tasks");
        function addtask()
        {
            if(add_task1.style.display=="flex")
            {
                add_task1.style.display="none";
                your_task1.style.display="block";
                today_task1.style.display="none";
            }
            else
            {
                add_task1.style.display="flex";
                your_task1.style.display="none";
                today_task1.style.display="none";
            }
        }
        function yourtask()
        {
            var add_task1=document.getElementById("input_task_box");
            var your_task1=document.getElementById("your_tasks");
            var today_task1=document.getElementById("today_tasks");
            if(your_task1.style.display=="none")
            {
                your_task1.style.display="block";
                add_task1.style.display="none";
                today_task1.style.display="none";
            }
        }
        function todaytask()
        {
            if(today_task1.style.display=="block")
            {
                today_task1.style.display="block";
                your_task1.style.display="none";
                add_task1.style.display="none";
            }
            else
            {
                today_task1.style.display="block";
                your_task1.style.display="none";
                add_task1.style.display="none";
            }
        }
        window.onload = yourtask();
    </script>
</body>
</html>




















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