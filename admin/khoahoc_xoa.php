<?php
	include("../user/connect.php");
	$id_xoa = $_GET['id'];
	$sql_xoa = "DELETE FROM theloaikhoahoc WHERE id = '$id_xoa'";
	$stmt_xoa = $conn->prepare($sql_xoa);
	$query_xoa = $stmt_xoa->execute();
	$row_xoa = $stmt_xoa->fetch(PDO::FETCH_ASSOC);
	if(!$query_xoa){
		echo "Xóa không thành công";
	}
	else{
		header("location:khoahoc.php");
	}
?>