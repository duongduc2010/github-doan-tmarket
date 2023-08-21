<?php
	include("../user/connect.php");
	$id_pdgv = $_GET['idpdgv'];

	
	$id_kh = "DELETE FROM khoahocgiaovien WHERE giaovienid = '$id_pdgv'";
	$stmt_kh = $conn->prepare($sql_kh);
	$query_kh = $stmt_kh->execute();


	$sql_xoa = "DELETE FROM giaovien WHERE id = '$id_pdgv'";
	$stmt_xoa = $conn->prepare($sql_xoa);
	$query_xoa = $stmt_xoa->execute();


	// Update phân quyền thành tài khoản thường
	$taikhoan = $_GET['taikhoan'];
	$sql_update = "UPDATE taikhoan SET phanquyen = '3' WHERE id = '$taikhoan'";
	$stmt_update = $conn->prepare($sql_update);
	$query_update = $stmt_update->execute();

	if($query_update && $query_xoa){
		header("location:giaovien.php");
	}
	else{
		echo "Xóa thất bại";
	}
?>