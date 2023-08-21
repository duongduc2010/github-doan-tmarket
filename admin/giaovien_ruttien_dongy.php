<?php
	include('../user/connect.php');;
	$id = $_GET['id'];
	$idgv = $_GET['idgv'];
	$sql_sotien = "SELECT sotien FROM ruttien WHERE id = '$id'";
	$stmt_sotien = $conn->prepare($sql_sotien);
	$query_sotien = $stmt_sotien->execute();
	$result_sotien = array();
	while($row_sotien = $stmt_sotien->fetch(PDO::FETCH_ASSOC)){
		$result_sotien[] = $row_sotien;
	}
	foreach ($result_sotien as $items) {
		$sotien = $items['sotien'];
	}

	//Trừ tiền trong ví giáo viên
	$sql_trutien = "UPDATE giaovien SET vitien = vitien - '$sotien' WHERE id = '$idgv'";
	$stmt_trutien = $conn->prepare($sql_trutien);
	$query_trutien = $stmt_trutien->execute();


	// Lấy giá trị Ví tiền sau khi trừ
	$sql_vitien = "SELECT vitien FROM giaovien WHERE id = '$idgv'";
	$stmt_vitien = $conn->prepare($sql_vitien);
	$query_vitien = $stmt_vitien->execute();
	$result_vitien = array();
	while($row_vitien = $stmt_vitien->fetch(PDO::FETCH_ASSOC)){
		$result_vitien[] = $row_vitien;
	}
	foreach ($result_vitien as $items) {
		$vitien = $items['vitien'];
	}

	//Thêm vào lịch sử giao dịch

	$sql_lsgd = "INSERT INTO lichsugiaodich (idgiaovien,mota,biendong,tongtienconlai) VALUES('$idgv','Rút tiền','$sotien','$vitien')";;
	$stmt_lsgd = $conn->prepare($sql_lsgd);
	$query_lsgd = $stmt_lsgd->execute();

	//Xóa ở bảng ruttien
	$sql_xoa = "DELETE FROM ruttien WHERE id='$id'";
	$stmt_xoa = $conn->prepare($sql_xoa);
	$query_xoa = $stmt_xoa->execute();


	if($query_trutien && $query_lsgd && $query_xoa){
		header("location:giaovien_ruttien.php");
	}
	else{
		echo "Lỗi";
	}
?>