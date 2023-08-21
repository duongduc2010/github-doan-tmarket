<?php
	include("../user/connect.php");
	$id = $_GET['id'];
	$sql = "DELETE FROM naptien WHERE id ='$id'";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();
	if(!$query){
		echo "Xóa không thành công";
	}
	else{
		header("location:naptien.php");
	}
?>