<?php
session_start();
include 'config.php';

$errorcode="ERR(0001)";

if(isset($_POST['login']))
{
$username=$_POST['username']; // Get username
$password=$_POST['password']; // get password
$shifttime=$_POST['shifttime']; // Get Shift Timing
//query for match  the user inputs

////
$rowpass=mysqli_query($con,"select * from login where userName='$username'");
$encr_pass=mysqli_fetch_array($rowpass);
$ssl_pass=$encr_pass['password'];
$decr_password = shell_exec("scripts/password_decrypter.sh {$ssl_pass}");
////
$passvalidation = shell_exec("scripts/password_validator.sh {$password} {$decr_password}");
////

$ret=mysqli_query($con,"SELECT * FROM login WHERE userName='$username'");
$num=mysqli_fetch_array($ret);

// if user inputs match if condition will runn
if($passvalidation>0)
{
$_SESSION['login']=$username; // hold the user name in session
$_SESSION['id']=$num['id']; // hold the user id in session
$_SESSION['shifttime']=$shifttime; // hold the shift time

$query=mysqli_query($con,"select * from login where  id='".$_SESSION['id']."'");
$row=mysqli_fetch_array($query);

$userfullname=$row['UserFullName'];
$platform=$row['platform'];
$_SESSION['userfullname']=$userfullname;
$_SESSION['platform']=$platform;
$uip=$_SERVER['REMOTE_ADDR']; // get the user ip
$LoginType="Login"; // Type of Login or Logout
$epochtime1 = shell_exec('date +%s');
$_SESSION['epochtime1']=$epochtime1;
$operation="SELF";

// query for existing Login session
$lastlogin=mysqli_query($con,"select * from userlog where  userId='".$_SESSION['id']."' ORDER BY id DESC LIMIT 1");
$lastloginrow=mysqli_fetch_array($lastlogin);
$existinglogin=$lastloginrow['LoginType'];
$existingloginepoch=$lastloginrow['epochtime'];

if($existinglogin=="Login")
{
$_SESSION['epochtime1']=$existingloginepoch;
$extra="existinglogin.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}

// query for inser user log in to data base
mysqli_query($con,"insert into userlog(userId,username,userIp,LoginType,shifttime,UserFullName,platform,epochtime,operation) values('".$_SESSION['id']."','".$_SESSION['login']."','$uip','$LoginType','$shifttime','$userfullname','$platform','$epochtime1','$operation')");

// code redirect the page after login
$extra="welcome.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
// If the userinput no matched with database else condition will run
else
{
$_SESSION['msg']="Invalid username or password, error code $errorcode";
$extra="index.php";
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
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
<link rel="stylesheet" href="css/style.css">
</head>
<body>    

<form name="login" method="post" >
  <header>Login to Timesheet management system</header>
  <p style="color:red;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
<p style="padding-left:1%;"><b>Please Enter UserID/passwords for IIHS:</b></p>

  <label>Username <span>*</span></label>
  <input name="username" type="text" value="" required />
  <label>Password <span>*</span></label>
  <input name="password" type="password" value="" required />

  <label>Shift Time<span>*</span></label>
  <select id="shifttime" name="shifttime">
  <option value="21:00:00   06:00:00">06:30 to 15:30 HRS India Time</option>
  <option value="21:30:00   06:30:00">07:00 to 16:00 HRS India Time</option>
  <option value="04:00:00   13:00:00">13:30 to 23:00 HRS India Time</option>
  <option value="05:30:00   14:30:00">15:00 to 00:00 (Next Day) HRS India Time</option>
  <option value="12:00:00   21:00:00">21:30 to 07:00 (Next Day) HRS India Time</option>
  <option value="23:30:00   08:30:00">09:00 to 18:00 HRS India Time</option>
  <option value="02:00:00   11:00:00">11:30 to 20:30 HRS India Time</option>
  <option value="03:00:00   12:00:00">12:30 to 21:30 HRS India Time</option>
  <option value="22:30:00   07:30:00">08:00 to 17:00 HRS India Time</option>
  <option value="09:00:00   18:00:00">09:00 to 18:00 HRS Eastern Time (US)</option>
  <option value="08:30:00   17:30:00">08:30 to 17:30 HRS Eastern Time (US)</option>
  <option value="08:00:00   17:00:00">08:00 to 17:00 HRS Eastern Time (US)</option>
  <option value="03:00:00   12:00:00">09:00 to 18:00 HRS Central Europe Time (France, Germany, Italy)</option>
  <option value="02:30:00   11:30:00">08:30 to 17:30 HRS Central Europe Time (France, Germany, Italy)</option>
  <option value="02:00:00   11:00:00">08:00 to 17:00 HRS Central Europe Time (France, Germany, Italy)</option>
  <option value="04:00:00   13:00:00">09:00 to 18:00 HRS British Standard Time (UK)</option>
  <option value="03:30:00   12:30:00">08:30 to 17:30 HRS British Standard Time (UK)</option>
  <option value="03:00:00   12:00:00">08:00 to 17:00 HRS British Standard Time (UK)</option>
  <option value="21:00:00   06:00:00">09:00 to 18:00 HRS Singapore Time (APAC)</option>
  <option value="20:30:00   05:30:00">08:30 to 17:30 HRS Singapore Time (APAC)</option>
  <option value="20:00:00   05:00:00">08:00 to 17:00 HRS Singapore Time (APAC)</option>
  <option value="noshifttime">NO SHIFT TIMING (You have to specify reason on next page)</option>
  </select>
  <button type="submit" name="login">Login</button>
  
  <p style="padding-left:37%;"><b>Join us as a member? </b><a href="register.php">Sign UP</a></p>
  <p style="padding-left:37%;"><b>Login to Admin Panel </b><a href="admin.php">Click Here</a></p>
  <p style="padding-left:37%;"><b>Reset your password </b><a href="passwordreset.php">Click Here</a></p>
  <p style="padding-left:15%;"><font color=blue><font size="2">This site is maintained by TCS Platform Linux, for any queries, email to Site Admin <a href="emailtoadmin.php">Click Here</a></font></font></p>

</form>    
    
    
  </body>
</html>
