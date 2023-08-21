<?php
	include("../user/connect.php");
	$id_pdgv = $_GET['idpdgv'];
	$sql_chitiet = "SELECT pheduyetgiaovien.*, quocgia.quocgia as tenqg, gioitinh.gioitinh as tengt , theloaigiaovien.tentheloai
		FROM pheduyetgiaovien, quocgia,gioitinh,theloaigiaovien
		WHERE pheduyetgiaovien.id = '$id_pdgv' 
		and pheduyetgiaovien.quocgia = quocgia.id 
		and pheduyetgiaovien.gioitinh = gioitinh.id 
		and pheduyetgiaovien.theloaigiaovien = theloaigiaovien.id";
	$stmt_chitiet = $conn->prepare($sql_chitiet);
	$query_chitiet = $stmt_chitiet->execute();
	$result_chitiet = array();
	while( $row_chitiet = $stmt_chitiet->fetch(PDO::FETCH_ASSOC)){
		$result_chitiet[] = $row_chitiet;
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
    <link rel="stylesheet" type="text/css" href="style/pheduyetgiaovien_chitiet.css">
	<title>Tmarket</title>

</head>
<body>
	
	<div class="pdgv_chitiet">
		<div class="pdgv_h1">
			<h1>Chi tiết giáo viên</h1>
		</div>
		<div class="form">
			<?php foreach($result_chitiet as $items):?>
			<form style="height: 2500px;" >
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
					<label for="tlgv">Thể loại giáo viên</label>
					<input type="text" class="form-control" id="tlgv" value="<?php echo $items['tentheloai']?>" name="tlgv" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="quocgia">Quốc gia</label>
					<input type="text" class="form-control" id="quocgia" value="<?php echo $items['tenqg']?>" name="quocgia" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="gth1">Về tôi</label>
					<input style="height: 250px" type="text" class="form-control" id="gth1" value="<?php echo $items['gioithieubanthan1']?>" name="gth1" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="gth1">Video</label>
					<video controls="controls" class="form-control"  style=" height: 250px;">
						<source src="../teacher/video/<?php echo $items['video'];?>">
					</video>
				</fieldset>
				<fieldset class="form-group">
					<label for="gth1">Id card mặt trước</label>
					<img style="height: 250px" class="form-control" name="gth1" src="../teacher/img/idcard/<?php echo $items['idcard1']?>">
				</fieldset>
				<fieldset class="form-group">
					<label for="gth1">Id card mặt sau</label>
					<img style="height: 250px" class="form-control" name="gth1" src="../teacher/img/idcard/<?php echo $items['idcard2']?>">
				</fieldset>
				<fieldset class="form-group">
					<label for="gth1">Chứng chỉ bằng cấp</label>
					<img style="height: 250px" class="form-control" name="gth1" src="../teacher/img/chungchi/<?php echo $items['chungchi1']?>">
				</fieldset>
				<fieldset class="form-group">
					<label for="gth1">Thông tin thêm về chứng chỉ</label>
					<img style="height: 250px" class="form-control" name="gth1" src="../teacher/img/chungchi/<?php echo $items['chungchi2']?>">
				</fieldset>
			</form>
			<form style="height: 2500px;">
				<fieldset class="form-group">
					<label for="gioitinh">Giới tính</label>
					<input type="text" class="form-control" id="gioitinh" value="<?php echo $items['tengt']?>" name="gioitinh" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="diachi">Địa chỉ</label>
					<input type="text" class="form-control" id="diachi" value="<?php echo $items['diachi']?>" name="diachi" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="linkhoc">Link dạy học</label>
					<input type="text" class="form-control" id="linkhoc" value="<?php echo $items['linkdayhoc']?>" name="linkhoc" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="taikhoan">ID tài khoản</label>
					<input type="text" class="form-control" id="taikhoan" value="<?php echo $items['taikhoan']?>" name="taikhoan" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="gth2">Tôi với tư cách là giáo viên</label>
					<input style="height: 250px" type="text" class="form-control" id="gth2" value="<?php echo $items['gioithieubanthan2']?>" name="gth2" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="gth3">Các khóa học và phong cách của tôi</label>
					<input style="height: 250px" type="text" class="form-control" id="gth3" value="<?php echo $items['gioithieubanthan3']?>"  name="gth3" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="gth1">Máy tính</label>
					<img style="height: 250px" class="form-control" name="gth1" src="../teacher/img/congcudayhoc/<?php echo $items['congcu1']?>">
				</fieldset>
				<fieldset class="form-group">
					<label for="gth1">Laptop</label>
					<img style="height: 250px" class="form-control" name="gth1" src="../teacher/img/congcudayhoc/<?php echo $items['congcu2']?>">
				</fieldset>
				<fieldset class="form-group">
					<label for="gth1">Tai nghe</label>
					<img style="height: 250px" class="form-control" name="gth1" src="../teacher/img/congcudayhoc/<?php echo $items['congcu3']?>">
				</fieldset>
				<fieldset class="form-group">
					<label for="gth1">Camera</label>
					<img style="height: 250px" class="form-control" name="gth1" src="../teacher/img/congcudayhoc/<?php echo $items['congcu4']?>">
				</fieldset>
			</form>
			<?php endforeach?>

		</div>
		
	</div>
	<a href="pheduyetgiaovien.php"><input class="btn_quaylai" type="submit" value="Quay lại"></a>
</body>
</html>