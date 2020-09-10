<?php
session_start();
include 'config.php';
$uip=$_SERVER['REMOTE_ADDR']; // get the user ip
$LoginType="Logout"; // Type of Login and Logout
$sessionid=$_SESSION['id'];
$robotlogout=$_SESSION['robotlogout'];
$epochtime1=$_SESSION['epochtime1'];

if($robotlogout=="robotlogout")
{
$epochtime2 = $epochtime1 + 32400;
$operation="ROBOT";
}
else
{
$epochtime2 = shell_exec('date +%s');
$operation="SELF";
}

if($sessionid>0)
{
$workingtime = ($epochtime2 - $epochtime1) / 3600;
$workingseconds = $epochtime2 - $epochtime1;
$workinghours = number_format($workingtime, 2, '.', '');

mysqli_query($con,"insert into userlog(userId,username,userIp,LoginType,shifttime,UserFullName,platform,epochtime,worktime,operation,workhours) values('".$_SESSION['id']."','".$_SESSION['login']."','$uip','$LoginType','".$_SESSION['shifttime']."','".$_SESSION['userfullname']."','".$_SESSION['platform']."','$epochtime2','$workingseconds','$operation','$workinghours')");
session_unset();
$_SESSION['msg']="You have logged out successfully..!, Total Working hours is $workinghours";
}
else
{
session_unset();
$_SESSION['msg']="Your session id is lost, either you have refreshed your logout page, please login again and logout";
}
?>
<script language="javascript">
document.location="index.php";
</script>
