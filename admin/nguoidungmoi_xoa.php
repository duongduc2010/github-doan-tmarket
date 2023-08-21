<?php
	include("../user/connect.php");
	$id_nguoidungmoi = $_GET['id'];
	$sql_nguoidungmoi = "DELETE FROM taikhoan WHERE id = '$id_nguoidungmoi'";
	$stmt_nguoidungmoi = $conn->prepare($sql_nguoidungmoi);
	$query_nguoidungmoi = $stmt_nguoidungmoi->execute();
	$row_nguoidungmoi = $stmt_nguoidungmoi->fetch(PDO::FETCH_ASSOC);
	if(!$query_nguoidungmoi){
		echo "Xóa không thành công";
	}
	else{
		header("location:nguoidungmoi.php");
	}
?>