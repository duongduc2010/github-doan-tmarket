<?php
	include('../user/connect.php');
	$id = $_GET['id'];
	$sql_dongy = "UPDATE khoahochocvien SET tinhtrang='Phê duyệt thành công' WHERE id ='$id'";
	$stmt_dongy = $conn->prepare($sql_dongy);
	$query_dongy = $stmt_dongy->execute();

	$idkh = $_GET['khgv'];
	$sql_update1 = "UPDATE khoahocgiaovien SET tinhtrang = 'Đang hoạt động' WHERE id = '$idkh'";
	$stmt_update1 = $conn->prepare($sql_update1);
	$query_update1 = $stmt_update1->execute();
	//Update phân quyền thành học viên
	$idhv = $_GET['idhv'];
	$sql_update = "UPDATE taikhoan SET phanquyen = '2' WHERE id = '$idhv'";
	$stmt_update = $conn->prepare($sql_update);
	$query_update = $stmt_update->execute();
	//Thêm vào danh sách học viên
	$idtk = $_GET['idtk'];
	$sql_tthv = "SELECT * FROM taikhoan WHERE id = '$idtk'";
	$stmt_tthv = $conn->prepare($sql_tthv);
	$query_tthv = $stmt_tthv->execute();
	$result_tthv = array();
	while($row_tthv = $stmt_tthv->fetch(PDO::FETCH_ASSOC)){
		$result_tthv[] = $row_tthv;
	}
	foreach ($result_tthv as $items) {
		$hoten = $items['hoten'];
		$sdt = $items['sodienthoai'];
		$email = $items['email'];
		$gioitinh = $items['gioitinh'];
	}


	$sql1="SELECT * FROM hocvien";
	$stmt1=$conn->prepare($sql1);
	$query1 = $stmt1->execute();
	$result1=array();
	while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
		$result1[]=$row1;
	}
	function ktra($hoten,$result1){	
		foreach ($result1 as $items)
		{
			if($items['hoten'] == $hoten ){
				return true;
			}
		}
		return false;


	}
	if(ktra($hoten,$result1) == false){
		$sql_themhv = "INSERT INTO hocvien(hoten,sodienthoai,email,gioitinh,taikhoan) VALUES('$hoten','$sdt','$email','$gioitinh','$idtk')";
		$stmt_themhv = $conn->prepare($sql_themhv);
		$query_themhv = $stmt_themhv->execute();
	}
	

	if($query_update && $query_dongy && $query_update1){
		header("location:hocvien_pheduyet.php");
	}
	else{
		echo "Xóa thất bại";
	}
?>