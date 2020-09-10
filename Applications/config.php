<?php
define('DB_SERVER','localhost');
define('DB_USER','logintracking');
define('DB_PASS' ,'Lilly@2012');
define('DB_NAME', 'logintracking');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
