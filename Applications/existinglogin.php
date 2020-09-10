<?php
session_start();
include 'config.php';

$resumeoption=$_POST['resumeoption'];
$reason=$_POST['reason'];
$epochtime1=$_SESSION['epochtime1'];
$epochtime2 = shell_exec('date +%s');
$sessiontime = $epochtime2 - $epochtime1;

if($sessiontime>32400)
{
$_SESSION['msg']="it is detected that 9 Hours is already passed, you can Logout or extend the shift..!";
$extra="existingsessionlogout.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}

if(isset($_POST['resumelogin']))
{

if($resumeoption=="Resume")
{
$extra="welcome.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}

if($resumeoption=="Logout")
{
$extra="logout.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}

}
?>



<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
<title>User login and tracking in PHP using PHP OOPs Concept</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style1.css">
</head>
<body>

<form name="login" method="post" >
  <header>Login to Timesheet management system</header>
  <p style="color:red;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
<p style="padding-left:1%;"><b>Previous Login Detected in the System:</b></p>

  <label>Select Option<span>*</span></label>
  <select id="resumeoption" name="resumeoption">
  <option value="Resume">Resume and continue to Old Session</option>
  <option value="Logout">Logout and create a new Session</option>
  </select>

  <label>Select Reason<span>*</span></label>
  <select id="reason" name="reason">
  <option value="computer_restart">My Computer restarts</option>
  <option value="forgot_to_logout">I Forgot to Logout</option>
  <option value="unknown_reason">I remeber I logged out, but somehow it is not reflecting</option>
  </select>

  <button type="submit" name="resumelogin">Submit</button>

  <p style="padding-left:37%;"><b>Join us as a member? </b><a href="register.php">Sign UP</a></p>
  <p style="padding-left:37%;"><b>Login to Admin Panel </b><a href="admin.php">Click Here</a></p>
  <p style="padding-left:37%;"><b>Reset your password </b><a href="passwordreset.php">Click Here</a></p>
  <p style="padding-left:15%;"><font color=blue><font size="2">This site is maintained by TCS Platform Linux, for any queries, email to Site Admin <a href="emailtoadmin.php">Click Here</a></font></font></p>

</form>


  </body>
</html>

