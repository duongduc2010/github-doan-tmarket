<?php
	include("../user/connect.php");
	$id_pdgv = $_GET['idpdgv'];
	$sql_xoa = "DELETE FROM pheduyetgiaovien WHERE id = '$id_pdgv'";
	$stmt_xoa = $conn->prepare($sql_xoa);
	$query_xoa = $stmt_xoa->execute();
	if($query_xoa){
		header("location:pheduyetgiaovien.php");
	}
	else{
		echo "Xóa thất bại";
	}
?>