<?php
session_start();
include 'config.php';

if(isset($_POST['captchasubmit']))
{
$captchavalidation=$_POST['captchavalidation']; // Get captcha
$sessioncaptcha=$_SESSION['newpasswordcaptcha']; // session captcha
$sessionpassword=$_SESSION['newpassword1'];
if($sessioncaptcha==$captchavalidation)
{
$encr_sessionpassword = shell_exec("scripts/password_encrypter.sh {$sessionpassword}");
mysqli_query($con,"update login set password='$encr_sessionpassword' where userName='".$_SESSION['usercid']."'");
session_unset();
$_SESSION['msg']="Password successfully reset";
$extra="index.php";
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['msg']="Captcha Validation failed";
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

<form name="password reset" method="post" >
  <header>Captcha validation Submission Form</header>
  <p style="color:red;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
  <p style="padding-left:3%;"><b>Captcha validation on email</b></p>

  <label>Please enter the captcha, which is sent to your email<span>*</span></label>
  <input name="captchavalidation" type="text" value="" required />
  <button type="submit" name="captchasubmit">Submit</button>

  <p style="padding-left:39%;">Already a member? <a href="index.php">Sign in</a></p>
  <p style="padding-left:15%;"><font color=blue><font size="2">This site is maintained by TCS Platform Linux, for any queries, email to Site Admin <a href="emailtoadmin.php">Click Here</a></font></font></p>
</form>

</body>
</html>

