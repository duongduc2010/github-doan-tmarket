<?php
	session_start();
	if(isset($_SESSION['taikhoan']) && $_SESSION['taikhoan'] != NULL){
		unset($_SESSION['taikhoan']);
		header("location:../user/index.php");
	}
?>