<!--Team Information-->
<div class="team_info">
    <div class="team_info_parent">
        <div class="team_info_child">
            <form name="team_info_frm" method="POST" action="dashboard.php">
            <div class="t_top">
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
                $con9=mysqli_connect($server,$username,$password,$db);
                if($con9)
                {
            ?>
                <div class="t_top1">
                    <input type="hidden" name="t_hidden_id1" id="t_hidden_id">
            <?php
                    $t_i_q1="select team_name from team_master where team_id=";
                    //$q1=mysqli_query($con9,$t_i_q1);
            ?>
                    <p>Name:</p>
                    <p>Task Title:</p>
                    <p>Details:</p>
                    <p>Due:Before... </p>
                </div>
                <div class="t_top2">
                    <i class="fa-solid fa-xmark" id="x-icon" onclick="team_information()"></i>
                </div>
            </div>
            <hr>
            <div class="t_middle">
                <p>Total members:</p>
                <div class="member_list_parent">
                    <div class="member_list_child">
                        <div class="m_left">
                            <p>Member1</p>
                        </div>
                        <div class="m_right">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="t_bottom">
                <input type="button" name="a_member" id="a_member" value="Add Member" onclick="toggle_add_member()">
                <input type="button" name="edit_task" id="edit_task" value="Edit Task" onclick="toggle_team_task()">
            </div>
            <?php
                }
                else
                {
                    echo "<script>alert('Error in connection');</script>";
                }
            ?>
            </form>    
        </div>
    </div>
</div>
<!--End Team Infromation-->

<script>
function team_information(teamid)
        {
            
            /*var req = new XMLHttpRequest();
            req.open("POST", "http://localhost/Project_sem-iv/b_dashboard.php?team_id=" + team_id, true);
            req.onload = function() {
                if (req.status == 200) {
                    document.querySelector("#t_hidden_id").innerHTML = req.responseText;
                }
            };
            req.send();*/
            if(team_info.style.display=="block")
            {
                team_info.style.display="none";
            }
            else
            {
                team_info.style.display="block";
                var team_id=teamid;
                console.log(team_id);
                var hidden_tid=document.getElementById('t_hidden_id');
                hidden_tid.value=team_id;
            }
        }
        /*function unrefreshed(event)
        {
            event.preventDefault();
            console.log("Prevented");
        }
        function hiddenform()
        {
            var h_form=document.getElementById('frm10');
            if(h_form)
            {
                console.log("Form is Visible");
                h_form.submit();
            }
            else{
                console.log("form is not visible");
            }
        }*/
</script>
