<?php
	include("../user/connect.php");
	$idtaikhoan = $_GET['id'];
	$idkhgv = $_GET['idkh'];

	$sql_xoa1 = "DELETE FROM khoahochocvien WHERE idkhoahoc = '$idkhgv'";
	$stmt_xoa1 = $conn->prepare($sql_xoa1);
	$query_xoa1 = $stmt_xoa1->execute();

	$sql_xoa = "DELETE FROM khoahocgiaovien WHERE id = '$idkhgv'";
	$stmt_xoa = $conn->prepare($sql_xoa);
	$query_xoa = $stmt_xoa->execute();
	if($query_xoa1 && $query_xoa){
		header("location:thongtincanhan.php?id=$idtaikhoan");
	}
	else{
		echo "Xóa thất bại";
	}

?>