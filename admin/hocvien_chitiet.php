<?php
	include("../user/connect.php");
	$id_hv = $_GET['id'];

	//Danh sách học viên
	$sql_hv = "SELECT *,gioitinh.gioitinh as tengt,quocgia.quocgia as tenqg
			FROM taikhoan,gioitinh,quocgia
			WHERE taikhoan.id = '$id_hv'
			and taikhoan.gioitinh = gioitinh.id
			and taikhoan.quocgia = quocgia.id";
	$stmt_hv = $conn->prepare($sql_hv);
	$query_hv = $stmt_hv->execute();
	$result_hv = array();
	while( $row_hv = $stmt_hv->fetch(PDO::FETCH_ASSOC)){
		$result_hv[] = $row_hv;
	}

	//Danh sách khóa học
	$sql_khhv= "SELECT giaovien.hoten as tengv, theloaikhoahoc.tenkhoahoc
				FROM taikhoan,giaovien,theloaikhoahoc,khoahochocvien,khoahocgiaovien
				WHERE taikhoan.id = '$id_hv'
				and taikhoan.id = khoahochocvien.idhocvien
				and khoahochocvien.idkhoahoc = khoahocgiaovien.id
				and khoahocgiaovien.theloaikhoahocid = theloaikhoahoc.id
				and khoahocgiaovien.giaovienid = giaovien.id
				and khoahocgiaovien.tinhtrang='Đang hoạt động'";
	$stmt_khhv = $conn->prepare($sql_khhv);
	$query_khhv = $stmt_khhv->execute();
	$result_khhv = array();
	while( $row_khhv = $stmt_khhv->fetch(PDO::FETCH_ASSOC)){
		$result_khhv[] = $row_khhv;
	}



	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" href = "js/bootstrap.min.js"></script>
    <script type="text/javascript" href = "js/jquery-3.6.2.slim.js"></script>
    <script src="https://kit.fontawesome.com/bb17412d66.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style/hocvien_chitiet.css">
	<title>Tmarket</title>

</head>
<body>
	
	<div class="pdgv_chitiet">
		<div class="pdgv_h1">
			<h1>Chi tiết học viên</h1>
		</div>
		<div class="form">
			<form >
				<?php foreach ($result_hv as $items): ?>
					<fieldset class="form-group">
						<label for="hoten">Họ tên</label>
						<input type="text" class="form-control" id="hoten" value="<?php echo $items['hoten']?>" name="hoten" disabled>
					</fieldset>
					<fieldset class="form-group">
						<label for="email">Email</label>
						<input type="text" class="form-control" id="email" value="<?php echo $items['email']?>" name="email" disabled>
					</fieldset>
					<fieldset class="form-group">
						<label for="sdt">Số điện thoại</label>
						<input type="text" class="form-control" id="sdt" value="<?php echo $items['sodienthoai']?>" name="sdt" disabled>
					</fieldset>
					<fieldset class="form-group">
						<label for="diachi">Địa chỉ</label>
						<input type="text" class="form-control" id="diachi" value="<?php echo $items['diachi']?>" name="tlgv" disabled>
					</fieldset>
					<fieldset class="form-group">
						<label for="gioitinh">Giới tính</label>
						<input type="text" class="form-control" id="gioitinh" value="<?php echo $items['tengt']?>" name="quocgia" disabled>
					</fieldset>
					<fieldset class="form-group">
						<label for="quocgia">Quốc gia</label>
						<input type="text" class="form-control" id="quocgia" value="<?php echo $items['tenqg']?>" name="gth1" disabled>
					</fieldset>
				<?php endforeach ?>
			</form>
			<form>
				
					
				<h2>Khóa học tham gia</h2>
				<table class="table table-inverse">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên giáo viên</th>
							<th>Khóa học</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; foreach ($result_khhv as $items): ?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $items['tengv']?></td>
							<td><?php echo $items['tenkhoahoc']?></td>
						</tr>
						<?php $i++; endforeach ?>
					</tbody>
					
				</table>
			</form>
		</div>
		
	</div>
	<a href="hocvien.php"><input class="btn_quaylai" type="submit" value="Quay lại"></a>
</body>
</html>