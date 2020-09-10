<?php
session_start();
if(isset($_POST['newemailsubmit']))
{
$emailfullusername=$_POST['emailfullusername']; // Get Fullname
$emailidfullusername=$_POST['emailidfullusername']; // Get Email
$contactno=$_POST['contactno']; // Get telephone
$emailsubject=$_POST['emailsubject']; // Get Subject
$message=$_POST['message']; // Get Message
$emaildomain="lilly.com";
$adminemail="goswami_sushant@network.lilly.com";
$nameandsubject="$emailfullusername - $contactno - $emailsubject";

if(preg_match("/$emaildomain/i", $emailidfullusername))
{
$to = "$adminemail";
$subject = "$nameandsubject";
$txt = "$message";
$headers = "From: Login-management-system < $emailidfullusername >\n";
mail($to,$subject,$txt,$headers);
session_unset();
$_SESSION['msg']="Email successfully sent, we will get back to you in 4 hours.";
$extra="index.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['msg']="Reply Email ID is not correct or outside organization domain.";
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

<form name="emailtoadmin" method="post" >
  <header>Email to admin Submission Form</header>
  <p style="color:red;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
<p style="padding-left:3%;"><b>Submission of email on any issue or feedback:</b></p>

  <label>First Name and Last Name<span>*</span></label>
  <input name="emailfullusername" type="text" maxlength="50" value="" required />
  <label>Email Address<span>*</span></label>
  <input name="emailidfullusername" type="text" maxlength="50" value="" required />
  <label>Contact Number<span>*</span></label>
  <input name="contactno" type="text" maxlength="50" value="" required />
  <label>Subject<span>*</span></label>
  <select id="emailsubject" name="emailsubject">
  <option value="reset_password">I am not able to Reset my Password</option>
  <option value="captcha_email">Captcha email for password reset</option>
  <option value="Login_issue">I am unable to Login</option>
  <option value="Registration_issue">I am not able to register</option>
  <option value="Password_email">I am not getting password email</option>
  <option value="Admin_login">I am not able login as Admin</option>
  <option value="Any_other">I am having any other issue</option>
  </select>
  <label>Message<span>*</span></label>
  <textarea  name="message" maxlength="400" cols="65" rows="6"></textarea>
  <button type="submit" name="newemailsubmit">Submit</button>
  <p style="padding-left:39%;">Already a member? <a href="index.php">Sign in</a></p>
</form>

</body>
</html>

