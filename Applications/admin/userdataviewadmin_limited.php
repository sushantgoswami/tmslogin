<?php
session_start();
include('../config.php');
$query=mysqli_query($con,"select * from login where  userName='".$_SESSION['dataviewuser']."'");
$row=mysqli_fetch_array($query);
echo $row['UserFullName'];
echo " ####### ";
echo $row['platform'];
echo " ####### ";
echo $row['email'];

$username=$row['userName'];
$userfullname=$row['UserFullName'];
$platform=$row['platform'];
$admingroup=$_SESSION['admingroup'];

if($platform!=$admingroup)
{
$_SESSION['msg']="You are not entitled to see $username - Mr. $userfullname details, user belongs to $platform"; 
$extra="index_limited.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}

if($_SESSION['dataviewuser'])
{
?><!DOCTYPE html>
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

<?php $query=mysqli_query($con,"select * from userlog where  username='".$_SESSION['dataviewuser']."'");
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
} ?>
</table>
 </body>
</html>
<?php
} else{
header('location:index_limited.php');
}
?>

