<?php
session_start();
include 'config.php';

if(isset($_POST['passwordsubmit']))
{
$newpassword1=$_POST['newpassword1']; // Get password full
$newpassword2=$_POST['newpassword2']; // Get password full
if($newpassword1==$newpassword2)
{
$newpasswordcaptcha = bin2hex(openssl_random_pseudo_bytes(4));
$_SESSION['newpasswordcaptcha']=$newpasswordcaptcha; // export captcha
$_SESSION['newpassword1']=$newpassword1; // export new password
$query=mysqli_query($con,"select * from login where  userName='".$_SESSION['usercid']."'");
$row=mysqli_fetch_array($query);
$email=$row['email'];
$userfullname=$row['UserFullName'];

$to = "$email";
$subject = "Captcha Validation";
$txt = "Dear $userfullname, Your captcha for password reset is $newpasswordcaptcha";
$headers = "From: Login-management-system@lists.lilly.com";
mail($to,$subject,$txt,$headers);

$_SESSION['msg']="Captcha successfully sent to email, please check your email and validate";

$extra="captchavalidation.php";
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
<link rel="stylesheet" href="css/style2.css">
</head>
<body>

<form name="password reset" method="post" >
  <header>Password reset Submission Form</header>
  <p style="color:red;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
  <p style="padding-left:3%;"><b>Password reset submission</b></p>

  <label>Please enter new password<span>*</span></label>
  <input name="newpassword1" type="text" value="" required />
  <label>Please re enter new password<span>*</span></label>
  <input name="newpassword2" type="password" value="" required />
  <button type="submit" name="passwordsubmit">Submit</button>
  
  <p style="padding-left:39%;">Already a member? <a href="index.php">Sign in</a></p>
  <p style="padding-left:15%;"><font color=blue><font size="2">This site is maintained by TCS Platform Linux, for any queries, email to Site Admin <a href="emailtoadmin.php">Click Here</a></font></font></p>
</form>

</body>
</html>

