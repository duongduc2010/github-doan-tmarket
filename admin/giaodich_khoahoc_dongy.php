<?php
	include("../user/connect.php");
	$idkh = $_GET['idkh'];
	$idgv = $_GET['idgv'];
	//Nạp tiền vào ví giáo viên
	$sql_slhv = "SELECT count(khoahochocvien.idhocvien) as dem
					FROM khoahochocvien
					WHERE khoahochocvien.idkhoahoc = '$idkh'
					and khoahochocvien.hinhthucthanhtoan = '2'";
	$stmt_slhv = $conn->prepare($sql_slhv);
	$query_slhv = $stmt_slhv->execute();
	$result_slhv = array();
	while($row_slhv = $stmt_slhv->fetch(PDO::FETCH_ASSOC)){
		$result_slhv[] = $row_slhv;
	}
	foreach ($result_slhv as $items ) {
		$slhv = $items['dem'];
	}

	$sql_hocphi = "SELECT hocphi FROM khoahocgiaovien WHERE id = '$idkh'";
	$stmt_hocphi = $conn->prepare($sql_hocphi);
	$query_hocphi = $stmt_hocphi->execute();
	$result_hocphi = array();
	while($row_hocphi = $stmt_hocphi->fetch(PDO::FETCH_ASSOC)){
		$result_hocphi[] = $row_hocphi;
	}
	foreach ($result_hocphi as $items ) {
		$hocphi1= $items['hocphi'];
	}

	$hocphi =  $hocphi1 * 0.7;
	$doanhthu = $hocphi1 * 0.3;
	//Nạp tiền
	$sql_naptien = "UPDATE giaovien SET vitien=vitien + '$slhv' * '$hocphi' WHERE id='$idgv'";
	$stmt_naptien = $conn->prepare($sql_naptien);
	$query_naptien = $stmt_naptien->execute();



	// Lưu vào bảng doanh thu

	$sql_doanhthu = "INSERT INTO doanhthu(idkhoahoc,sotien) VALUES('$idkh','$doanhthu')";
	$stmt_doanhthu = $conn->prepare($sql_doanhthu);
	$query_doanhthu = $stmt_doanhthu->execute();


	//Lưu vào bảng lichsugiaodich

	$sql_vitien = "SELECT vitien FROM giaovien WHERE id = '$idgv'";
	$stmt_vitien = $conn->prepare($sql_vitien);
	$query_vitien = $stmt_vitien->execute();
	$result_vitien = array();
	while($row_vitien = $stmt_vitien->fetch(PDO::FETCH_ASSOC)){
		$result_vitien[] = $row_vitien;
	}
	foreach ($result_vitien as $items ) {
		$vitien= $items['vitien'];
	}


	$sql_lsgd = "INSERT INTO lichsugiaodich(idgiaovien,mota,biendong,tongtienconlai) VALUES($idgv,'Cộng tiền','$hocphi','$vitien')";
	$stmt_lsgd = $conn->prepare($sql_lsgd);
	$query_lsgd = $stmt_lsgd->execute();

	// Xóa khóa học
	$sql_xoa1 = "DELETE FROM pheduyetkhoahochoanthanh WHERE idkhoahoc='$idkh';";
	$stmt_xoa1 = $conn->prepare($sql_xoa1);
	$query_xoa1 = $stmt_xoa1->execute();


	$sql_xoa2 = "UPDATE khoahochocvien SET tinhtrang='Đã hoàn thành' WHERE idkhoahoc = '$idkh'";
	$stmt_xoa2 = $conn->prepare($sql_xoa2);
	$query_xoa2 = $stmt_xoa2->execute();


	$sql_xoa3 = "UPDATE khoahocgiaovien SET  tinhtrang='Đã hoàn thành' WHERE id ='$idkh'";
	$stmt_xoa3 = $conn->prepare($sql_xoa3);
	$query_xoa3 = $stmt_xoa3->execute();
	if($query_naptien && $query_doanhthu && $query_lsgd && $query_xoa1 && $query_xoa2 && $query_xoa3){
		header("location:giaodich_khoahoc.php");
	}
	else{
		echo "lỗi";
	}

?>