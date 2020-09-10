<?php
session_start();
include 'config.php';
if(isset($_POST['newsubmit']))
{
$newusername=$_POST['newusername']; // Get username
$newfullusername=$_POST['newfullusername']; // Get username full
$newemail=$_POST['newemail']; // Get email
$newplatform=$_POST['newplatform']; // Get platform
// $newpassword="Lilly123"; // Default password
$newpassword = bin2hex(openssl_random_pseudo_bytes(4));

$ret=mysqli_query($con,"SELECT * FROM login WHERE userName='$newusername'");
$num=mysqli_fetch_array($ret);
$usernamelenght=strlen($newusername);
$emaildomain="lilly.com";

if(preg_match("/$emaildomain/i", $newemail))
{
$domainnamecorrection=1;
}

if($num>0)
{
$_SESSION['msg']="User already exists or Invalid username or password";
}
else if($usernamelenght<7)
{
$_SESSION['msg']="User ID incorrect or mistyped";
}
else if($domainnamecorrection<1)
{
$_SESSION['msg']="Email ID does not belongs to Lilly Domain";
}
else
{
$encr_password = shell_exec("scripts/password_encrypter.sh {$newpassword}");
mysqli_query($con,"insert into login(userName,password,UserFullName,platform,email) values('$newusername','$encr_password','$newfullusername','$newplatform','$newemail')");
$_SESSION['msg']="User successfully registered, password is sent to your email address";

$to = "$newemail";
$subject = "New credentails for Login and Timesheet Managemant system";
$txt = "Your password for User $newusername is $newpassword";
$headers = "From: Login-management-system@lists.lilly.com";
mail($to,$subject,$txt,$headers);
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

<form name="registration" method="post" >
  <header>Submission Form</header>
  <p style="color:red;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
<p style="padding-left:3%;"><b>New user registration form for IIHS:</b></p>

  <label>CID<span>*</span></label>
  <input name="newusername" type="text" value="" required />
  <label>Full Name<span>*</span></label>
  <input name="newfullusername" type="text" value="" required />
  <label>Email ID<span>*</span></label>
  <input name="newemail" type="text" value="" required />
  <label>Platform<span>*</span></label>
  <select id="newplatform" name="newplatform">
  <option value="Linux_Operation">Linux_Operation</option>
  <option value="Linux_Openshift">Linux_Openshift</option>
  <option value="Linux_SAP">Linux_SAP</option>
  <option value="Linux_VRM">Linux_VRM</option>
  <option value="VMWare">VMWare</option>
  <option value="Windows">Windows</option>
  <option value="Storage">Storage</option>
  <option value="Citrix">Citrix</option>
  <option value="LillyNET">LillyNET</option>
  <option value="General_VRM">General_VRM</option>
  <option value="Load_Balancer">Load_Balancer</option>
  <option value="Service_Management">Service_Management</option>
  <option value="Ignio">Ignio</option>
  <option value="DWS_Team">DWS_Team</option>
  <option value="HPC">HPC - High Performance Computing</option>
  <option value="Project_Team">Project_Team</option>
  <option value="Project_Team_Lead">Project_Team_Lead</option>
  <option value="WHO">WHO_web_Hosting</option>
  <option value="Cloud_OPS">Cloud_OPS</option>
  <option value="Command_Center">Command_Center</option>
  <option value="DC_OPS">DC_OPS</option>
  <option value="DCN_NSX">DCN_NSX</option>
  <option value="Oracle_DBA">Oracle_DBA</option>
  <option value="BUIT_Apps">BUIT_Apps</option>
  <option value="MQ_Team">MQ_Team</option>
  <option value="TMSadmin_portal_administrator">TMSadmin_portal_administrator (Take CID as Userid as admin only. Confirmation will be generated after approval)</option>
  </select>
  <button type="submit" name="newsubmit">Submit</button>
  <p style="padding-left:39%;">Already a member? <a href="index.php">Sign in</a></p>
  <p style="padding-left:15%;"><font color=blue><font size="2">This site is maintained by TCS Platform Linux, for any queries, email to Site Admin <a href="emailtoadmin.php">Click Here</a></font></font></p>
</form>

</body>
</html>

