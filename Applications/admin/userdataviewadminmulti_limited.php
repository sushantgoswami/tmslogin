<?php
session_start();
include('../config.php');

if($_SESSION['adminusername'] && $_SESSION['limited_data_view']!="All_Team")
{

?>

<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
<title>welcome</title>
</head>
<body bgcolor="#d6c2c2">
<p><a href="index_limited.php">Return to previous page</a> </p>
<table>
<tr>
<th>Sno.</th>
<th>UserIp</th>
<th>UserName</th>
<th>UserFullName</th>
<th>Platform</th>
<th>ShiftStart ShiftEnd</th>
<th>LoginType</th>
<th>LogoutMethod</th>
<th>LoginDate LoginTime</th>
<th>LoginHours</th>
</tr>

<?php
$queryuser=mysqli_query($con,"select * from login where  platform='".$_SESSION['limited_data_view']."'");
$cnta=1;
while($rowuser=mysqli_fetch_array($queryuser))
{
$currentuser=$rowuser['userName'];
?>

<?php 
$query=mysqli_query($con,"select * from userlog where  username='$currentuser'");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>
<tr>
<td><?php echo $cnt;?></td>
<td><?php echo $row['userIp'];?></td>
<td><?php echo $row['username'];?></td>
<td><?php echo $row['UserFullName'];?></td>
<td><?php echo $row['platform'];?></td>
<td><?php echo $row['shifttime'];?></td>
<td><?php echo $row['LoginType'];?></td>
<td><?php echo $row['operation'];?></td>
<td><?php echo $row['loginTime'];?></td>
<td><?php echo $row['workhours'];?></td>
</tr>
<?php $cnt=$cnt+1;
} 
?>
<?php $cnta=$cnta+1;
}
?>
<?php
}
?>
</table>
</body>
</html>

<?php

if(empty($_SESSION['adminusername']))
{
 $_SESSION['msg']="Your session ID is lost, you have either refreshed your page. Please login again";
 $extra="../admin.php";
 $host=$_SERVER['HTTP_HOST'];
 $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
 header("location:http://$host$uri/$extra");
 exit();
}

?>

