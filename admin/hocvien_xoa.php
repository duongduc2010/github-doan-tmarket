<?php
	include("../user/connect.php");
	$id = $_GET['id'];
	$sql = "UPDATE taikhoan SET phanquyen = '3' WHERE id ='$id'";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();

	$sql_hv = "DELETE FROM khoahochocvien WHERE idhocvien ='$id'";
	$stmt_hv = $conn->prepare($sql_hv);
	$query_hv = $stmt_hv->execute();

	$sql_hv1 = "DELETE FROM hocvien WHERE taikhoan ='$id'";
	$stmt_hv1 = $conn->prepare($sql_hv1);
	$query_hv1 = $stmt_hv1->execute();

	$sql_hv2 = "DELETE FROM ketqualambaitap WHERE idhocvien ='$id'";
	$stmt_hv2 = $conn->prepare($sql_hv2);
	$query_hv2 = $stmt_hv2->execute();

	if($query && $query_hv && $query_hv1 && $query_hv2){
		header("location:hocvien.php");
	}

?>