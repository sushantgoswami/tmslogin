<?php
session_start();
include 'config.php';

if(isset($_POST['passagreesubmit']))
{
$usercid=$_POST['usercid']; // Get username
$agree=$_POST['agree']; // get agreement

$ret=mysqli_query($con,"SELECT * FROM login WHERE userName='$usercid'");
$num=mysqli_fetch_array($ret);

if(empty($num))
{
$_SESSION['msg']="Invalid CID entered";
}
elseif($agree=="agree")
{
$_SESSION['usercid']=$usercid;
$newlink = bin2hex(openssl_random_pseudo_bytes(4));
$_SESSION['newlink']=$newlink;
$extra="resetpage.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['msg']="You have not typed agree";
}
}
?>



<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
<title>User login and tracking in PHP using PHP OOPs Concept</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style2.css">
</head>
<body>

<form name="registration" method="post" >
  <header>Submission Form</header>
  <p style="color:red;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
<p style="padding-left:3%;"><b>New user registration form for IIHS:</b></p>

  <label>Plaese enter your username CID<span>*</span></label>
  <input name="usercid" type="text" value="" required />
  <label>Type agree to password reset below and click submit<span>*</span></label>
  <input name="agree" type="text" value="" required />
  <button type="submit" name="passagreesubmit">Submit</button>
  <p style="padding-left:39%;">Already a member? <a href="index.php">Sign in</a></p>
  <p style="padding-left:15%;"><font color=blue><font size="2">This site is maintained by TCS Platform Linux, for any queries, email to Site Admin <a href="emailtoadmin.php">Click Here</a></font></font></p>
</form>

</body>
</html>

