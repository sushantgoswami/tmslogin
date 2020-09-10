<?php
session_start();
include 'config.php';

session_unset();
$_SESSION['msg']="You have successfully Logout";

?>

<script language="javascript">
document.location="../admin.php";
</script>
