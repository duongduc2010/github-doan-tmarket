<?php
	include("../user/connect.php");
	$id_teacher = $_GET['id'];
	$idgv = $_GET['idgv'];
	$idkh = $_GET['idkh'];
	$idbkt = $_GET['idbkt'];
	$idcauhoi = $_GET['idcauhoi'];
	$sql_xoa = "DELETE FROM chitietbaikiemtra WHERE STT = '$idcauhoi'";
	$stmt_xoa = $conn->prepare($sql_xoa);
	$query_xoa = $stmt_xoa->execute();
	if($query_xoa){
		header("location:bkt_chitiet.php?id=$id_teacher&&idgv=$idgv&&idkh=$idkh&&idbkt=$idbkt");
	}
	else{
		echo "Xóa thất bại";
	}
?>