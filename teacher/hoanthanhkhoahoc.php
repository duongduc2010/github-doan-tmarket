<?php
	$taikhoan = $_GET['id'];
	$idgv = $_GET['idgv'];
	$idkh = $_GET['idkh'];
	include("../user/connect.php");

	$sql = "SELECT tinhtrang FROM khoahocgiaovien WHERE id = '$idkh'";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();
	$result = array();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$result[] = $row;
	}
	foreach ($result as $items) {
		$tinhtrang = $items['tinhtrang'];
	}
	if($tinhtrang != "Đã hoàn thành"){
		//Thêm
		$sql_them = "INSERT INTO pheduyetkhoahochoanthanh(idkhoahoc,idgiaovien) VALUES('$idkh','$idgv')";
		$stmt_them = $conn->prepare($sql_them);
		$query_them = $stmt_them->execute();
		if($query_them){
			header("location:danhsachkhoahoc.php?id=$taikhoan");
		}
		else{
			echo "Lỗi";
		}
	}
	else{
		header("location:danhsachkhoahoc.php?id=$taikhoan");
	}
	
?>
