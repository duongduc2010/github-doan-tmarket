<?php
	include("../user/connect.php");

	$id_pdgv = $_GET['idpdgv'];
	// Lấy dữ liệu bảng pheduyet

	$sql_pheduyet = "SELECT * FROM pheduyetgiaovien WHERE id = '$id_pdgv'";
	$stmt_pheduyet = $conn->prepare($sql_pheduyet);
	$query_pheduyet = $stmt_pheduyet->execute();
	$result_pheduyet = array();
	while($row_pheduyet = $stmt_pheduyet->fetch(PDO::FETCH_ASSOC)){
		$result_pheduyet[] = $row_pheduyet;
	}
	foreach ($result_pheduyet as $items) 
	{
		$hoten = $items['hoten'];
		$email = $items['email'];
		$sdt = $items['sodienthoai'];
		$theloai = $items['theloaigiaovien'];
		$quocgia = $items['quocgia'];
		$gioitinh = $items['gioitinh'];
		$diachi = $items['diachi'];
		$ccdh = $items['congcudayhoc'];
		$linkdayhoc = $items['linkdayhoc'];
		$gth1 = $items['gioithieubanthan1'];
		$gth2 = $items['gioithieubanthan2'];
		$gth3 = $items['gioithieubanthan3'];
		$taikhoan = $items['taikhoan'];
		$timezone = $items['timezone'];
		$imgprofile = $items['imgprofile'];
		$video = $items['video'];
		$idcard1=$items['idcard1'];
		$idcard2 = $items['idcard2'];
		$chungchi1 = $items['chungchi1'];
		$chungchi2 = $items['chungchi2'];
		$congcu1 = $items['congcu1'];
		$congcu2 = $items['congcu2'];
		$congcu3 = $items['congcu3'];
		$congcu4 = $items['congcu4'];
	}
	// Thêm vào bảng giaovien
	
	$sql_them = "INSERT INTO giaovien(hoten,email,sodienthoai,theloaigiaovien,timezone,quocgia,gioitinh,diachi,idcongcudayhoc,linkdayhoc,gioithieubanthan1,gioithieubanthan2,gioithieubanthan3,imgprofile,taikhoan,video,idcard1,idcard2,chungchi1,chungchi2,congcu1,congcu2,congcu3,congcu4) VALUES('$hoten','$email','$sdt','$theloai','$timezone','$quocgia','$gioitinh','$diachi','$ccdh','$linkdayhoc','$gth1','$gth2','$gth3','./img/profile/$imgprofile','$taikhoan','./video/$video','./img/idcard/$idcard1','./img/idcard/$idcard2','./img/chungchi/$chungchi1','./img/chungchi/$chungchi2','./img/congcudayhoc/$congcu1','./img/congcudayhoc/$congcu2','./img/congcudayhoc/$congcu3','./img/congcudayhoc/$congcu4')";
	$stmt_them = $conn->prepare($sql_them);
	$query_them = $stmt_them->execute();;

	//Update phân quyền thành giáo viên
	$sql_update = "UPDATE taikhoan SET phanquyen = '1' WHERE id = '$taikhoan'";
	$stmt_update = $conn->prepare($sql_update);
	$query_update = $stmt_update->execute();

	//Tạo thư mục giáo viên
	$sql_tm = "SELECT id,hoten FROM giaovien ORDER BY id DESC LIMIT 1";
	$stmt_tm = $conn->prepare($sql_tm);
	$query_tm = $stmt_tm->execute();
	$result_tm = array();
	while($row_rm = $stmt_tm->fetch(PDO::FETCH_ASSOC)){
		$result_tm[] = $row_rm;
	}
	foreach ($result_tm as $items) {
		$id = $items['id'];
		$hoten = $items['hoten'];
	}
	mkdir("../teacher/ttgv/$id-$hoten");
	mkdir("../teacher/ttgv/$id-$hoten/chungchi");
	mkdir("../teacher/ttgv/$id-$hoten/congcudayhoc");
	mkdir("../teacher/ttgv/$id-$hoten/idcard");
	mkdir("../teacher/ttgv/$id-$hoten/profile");
	mkdir("../teacher/ttgv/$id-$hoten/video");
	mkdir("../teacher/ttgv/$id-$hoten/tailieukhoahoc");
	$sql_tm = "UPDATE giaovien SET imgprofile='./ttgv/$id-$hoten/profile/$imgprofile', video = './ttgv/$id-$hoten/video/$video' , idcard1 = './ttgv/$id-$hoten/idcard/$idcard1', idcard2 = './ttgv/$id-$hoten/idcard/$idcard2', chungchi1 = './ttgv/$id-$hoten/chungchi/$chungchi1', chungchi2 = './ttgv/$id-$hoten/chungchi/$chungchi2', congcu1 = './ttgv/$id-$hoten/congcu/$congcu1', congcu2 = './ttgv/$id-$hoten/congcu/$congcu2' , congcu3 = './ttgv/$id-$hoten/congcu/$congcu3' ,congcu4 ='./ttgv/$id-$hoten/congcu/$congcu4' WHERE id = '$id'";
	$stmt_tm = $conn->prepare($sql_tm);
	$query_tm = $stmt_tm->execute();
	// Xóa
	
	$sql_xoa = "DELETE FROM pheduyetgiaovien WHERE id = '$id_pdgv'";
	$stmt_xoa = $conn->prepare($sql_xoa);
	$query_xoa = $stmt_xoa->execute();
	if($query_update && $query_them && $query_xoa){
		header("location:pheduyetgiaovien.php");
	}
	else{
		echo "Xóa thất bại";
	}

?>