<?php
	include("../user/connect.php");
	$id = $_GET['id'];;
	$idgv = $_GET['idgv'];
	$idkh = $_GET['idkh'];
	$idbkt = $_GET['idbkt'];
	$sql1 = "DELETE FROM chitietbaikiemtra WHERE idbkt = '$idbkt'";
	$stmt1 = $conn->prepare($sql1);
	$query1 = $stmt1->execute();
	
	$sql = "DELETE FROM baikiemtra WHERE id = '$idbkt'";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();

	
	if($query && $query1){
		header("location:danhsachbkt.php?id=$id&&idgv=$idgv&&idkh=$idkh");
	}
?>