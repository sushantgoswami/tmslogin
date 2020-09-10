<?php
session_start();
include '../config.php';

$tempfile = bin2hex(openssl_random_pseudo_bytes(4));
$tempdir = "../tmp/";

if($_SESSION['adminusername'])
{
$_SESSION['msg']="Admin successfully logged in ..!";
$query=mysqli_query($con,"select * from adminlogin where  userName='".$_SESSION['adminusername']."'");
$row=mysqli_fetch_array($query);
}
else
{
$_SESSION['msg']="Please Login to admin to contineu ..!";
$extra="../admin.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}


if(isset($_POST['dataviewemail'])) // Get username
{
$task=$_POST['admintask'];
$names=$_POST['cid_of_user'];
$platform_group=$_POST['newplatform'];
$queryuser=mysqli_query($con,"select * from login where  userName='$names'");
$rowuser=mysqli_fetch_array($queryuser);

if($task=="One_CID")
{
$dataviewuser=$_POST['cid_of_user']; // Get username
$_SESSION['dataviewuser']=$dataviewuser; // hold the user name in session
$extra="userdataviewadmin_limited.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}

if($task=="One_CID_email")
{
$admingroup=$row['admingroup'];
$emailid=$row['email'];
$username=$row['userName'];
$platform=$rowuser['platform'];
shell_exec("../scripts/user_data_fetch_for_single_cid.sh {$admingroup} {$emailid} {$username} {$platform} {$names} {$tempfile}");
$_SESSION['msg']="Email successfully sent for Particular id $names on $emailid";
}

}


if(isset($_POST['dataviewemail_platform']))
{
$task_to_do=$_POST['view_or_email'];
$newplatform=$_POST['newplatform'];
$queryuser=mysqli_query($con,"select * from login where  userName='$names'");
$rowuser=mysqli_fetch_array($queryuser);

if($task_to_do=="email_the_data" && $newplatform!="All_Team")
{
$admingroup=$row['admingroup'];
$emailid=$row['email'];
$username=$row['userName'];
shell_exec("../scripts/user_data_fetch_for_single_platform.sh {$admingroup} {$emailid} {$username} {$newplatform} {$tempfile}");
$_SESSION['msg']="Email successfully sent for Particular $newplatform on $emailid";
}

if($task_to_do=="email_the_data" && $newplatform=="All_Team")
{
$admingroup=$row['admingroup'];
$emailid=$row['email'];
$username=$row['userName'];
$platform=$row['platform'];
shell_exec("../scripts/user_data_fetch_for_all_platform.sh {$admingroup} {$emailid} {$username} {$platform} {$tempfile}");
$_SESSION['msg']="Email successfully sent for ALL Platform on $emailid";
}

if($task_to_do=="view_the_data")
{
$_SESSION['limited_data_view']=$newplatform;
$extra="userdataviewadminmulti_limited.php";
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
<link rel="stylesheet" href="../css/style3.css">
</head>
<body bgcolor="#d6c2c2">

<form name="dataview" method="post" >
  <header><b>User data view for <?php echo $row['userName'];?> || Administrator for platform: <?php echo $row['admingroup'];?></b></header>
  <p style="color:red;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
  <p style="padding-left:1%;"><b>Welcome Mr. <?php echo $row['UserFullName'];?>, you are eligible to see only your platform specific data (<?php echo $row['admingroup'];?>)</b></p>
  
  <label>Please enter the task to perform</label>
  <select id="admintask" name="admintask">
  <option value="One_CID">Enter One CID in below Box and view html</option>
  <option value="One_CID_email">Enter One CID and email the report</option>
  </select>

  <label>CID of User<span>*</span></label>
  <input name="cid_of_user" type="text" value="" /><p>Get List of Users: <a href="getlistofusers.php">Click Here</a></p>

  <button type="submit" name="dataviewemail">Submit</button>

  <p><b> OR </b></p>

  <label>Platform or ALL Team data action</label>
  <select id="newplatform" name="newplatform">
  <option value="<?php echo $row['admingroup'];?>"><?php echo $row['admingroup'];?></option>
  </select>
 
  <label>View Data or Email Data</label>
  <select id="view_or_email" name="view_or_email">
  <option value="view_the_data">View the Data</option>
  <option value="email_the_data">Email the Data</option>
  </select>
 
  <button type="submit" name="dataviewemail_platform">Submit</button>
  
  <footer>
  <a href="admin_logout.php">Logout</a> </p></b>
  </footer>
</form>
</body>
</html>
