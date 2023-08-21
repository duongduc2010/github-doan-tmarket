<?php
	include("../user/connect.php");
	$id= $_GET['id'];
	$sql = "DELETE FROM khoahochocvien WHERE idkhoahoc ='$id'";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();
	
	$sql = "DELETE FROM khoahocgiaovien WHERE id = '$id'";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();
	if($query){
		header("location:khoahoc_giaovien.php");
	}
?>