<?php
session_start();
include('../config.php');

if($_SESSION['adminusername'] && $_SESSION['admingroup']!="all")
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
<th>UserName</th>
<th>UserFullName</th>
<th>Platform</th>
<th>Email</th>
</tr>

<?php 
$query=mysqli_query($con,"select * from login where  platform='".$_SESSION['admingroup']."'");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>
<tr>
<td><?php echo $cnt;?></td>
<td><?php echo $row['userName'];?></td>
<td><?php echo $row['UserFullName'];?></td>
<td><?php echo $row['platform'];?></td>
<td><?php echo $row['email'];?></td>
</tr>
<?php $cnt=$cnt+1;
} 
?>
<?php
}
?>
</table>
</body>
</html>

<?php

if($_SESSION['adminusername'] && $_SESSION['admingroup']=="all")
{
?><!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
<title>welcome</title>
</head>
<body bgcolor="#d6c2c2">
<p><a href="index.php">Return to previous page</a> </p>
<table>
<tr>
<th>Sno.</th>
<th>UserName</th>
<th>UserFullName</th>
<th>Platform</th>
<th>Email</th>
</tr>

<?php $query=mysqli_query($con,"select * from login");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>
<tr>
<td><?php echo $cnt;?></td>
<td><?php echo $row['userName'];?></td>
<td><?php echo $row['UserFullName'];?></td>
<td><?php echo $row['platform'];?></td>
<td><?php echo $row['email'];?></td>
</tr>
<?php $cnt=$cnt+1;
} ?>
</table>
 </body>
</html>
<?php
}
?>

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
