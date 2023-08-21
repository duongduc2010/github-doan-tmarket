<?php
	include('../user/connect.php');
	$id = $_GET['id'];
	$sql_xoa = "DELETE FROM khoahochocvien WHERE id ='$id'";
	$stmt_xoa = $conn->prepare($sql_xoa);
	$query_xoa = $stmt_xoa->execute();
	if($query_xoa){
		header("location:hocvien_pheduyet.php");
	}
	else{
		echo "Xóa thất bại";
	}
?>