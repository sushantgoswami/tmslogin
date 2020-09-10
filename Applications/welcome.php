<?php
session_start();
include 'config.php';
$query=mysqli_query($con,"select * from login where  id='".$_SESSION['id']."'");
$row=mysqli_fetch_array($query);
$lastlogin=mysqli_query($con,"select * from userlog where  userId='".$_SESSION['id']."' ORDER BY id DESC LIMIT 1");
$lastloginrow=mysqli_fetch_array($lastlogin);

if(isset($_POST['refresh']))
{
$epochtime1 = $_SESSION['epochtime1'];
$epochtime2 = shell_exec('date +%s');
$workingtime = ($epochtime2 - $epochtime1) / 3600;
$workinghours = number_format($workingtime, 2, '.', '');
}

if($_SESSION['login'])
{
?>

<!DOCTYPE html>
<html >
<link rel="stylesheet" href="css/style3.css">
<form name="refresh" method="post">
<head>
<meta charset="UTF-8">
<title>welcome</title>
</head>
<body bgcolor="#d6c2c2">  
<header>Session Login Page</header>
<b><p>Welcome : <?php echo $_SESSION['login'];?> | <a href="logout.php">Logout</a> </p></b>
<b><?php echo $row['UserFullName']; ?> | <?php echo $row['platform']; ?> | <?php echo $row['email']; ?> | Login Time: <?php echo $lastloginrow['loginTime']; ?></b>
<p><a href="userlog.php">User Access log</a></p>

<label><b>Login Hours (Note: Relogin will not reduce login hours)</b></label>
<input name="username" type="text" value="<?php echo $workinghours; ?>"/>
<button type="submit" name="refresh">Refresh Login Hours</button>

</body>
</form>
</html>

<?php
} 
else
{
header('location:logout.php');
}
?>
