<?php
	include("../user/connect.php");
	$id = $_GET['id'];
	$sql = "SELECT naptien.*,taikhoan.vitien FROM naptien,taikhoan WHERE naptien.id ='$id' and naptien.idtaikhoan = taikhoan.id";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();
	$result = array();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$result[] = $row;
	}
	foreach ($result as $items) {
		$idtk = $items['idtaikhoan'];
		$sotien = $items['sotien'];
		$vitien = $items['vitien'];
	}
	$tongtienconlai = $sotien + $vitien;
	// Lịch sử giao dịch
	$sql_lsgd = "INSERT INTO lsgiaodich(idtaikhoan,mota,biendong,tienconlai) VALUES('$idtk','Nạp tiền','$sotien','$tongtienconlai')";
	$stmt_lsgd = $conn->prepare($sql_lsgd);
	$query_lsgd = $stmt_lsgd->execute();
	// Cập nhật vào ví tiền
	$sql_vi = "UPDATE taikhoan SET vitien = '$tongtienconlai' WHERE id = '$idtk'";
	$stmt_vi = $conn->prepare($sql_vi);
	$query_vi = $stmt_vi->execute();
	// Xóa

	$sql_xoa = "DELETE FROM naptien WHERE id ='$id'";
	$stmt_xoa = $conn->prepare($sql_xoa);
	$query_xoa = $stmt_xoa->execute();
	if($query_lsgd && $query_vi && $query_xoa){
		header("location:naptien.php");
	}
?>