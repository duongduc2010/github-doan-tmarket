<?php
	include('../user/connect.php');
	$id = $_GET['id'];
	$idgv = $_GET['idgv'];
	//Xóa ở bảng ruttien
	$sql_xoa = "DELETE FROM ruttien WHERE id='$id'";
	$stmt_xoa = $conn->prepare($sql_xoa);
	$query_xoa = $stmt_xoa->execute();
	if($query_xoa){
		header("location:giaovien_ruttien.php");
	}
	else{
		echo "Lỗi";
	}
?>