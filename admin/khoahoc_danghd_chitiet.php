<?php
	include("../user/connect.php");
	$id = $_GET['id'];
	$sql_chitiet = "SELECT khoahocgiaovien.*, cahoc.thoigian, theloaikhoahoc.tenkhoahoc,giaovien.hoten
			FROM khoahocgiaovien,cahoc,theloaikhoahoc,giaovien
			WHERE khoahocgiaovien.giaovienid = giaovien.id
			and khoahocgiaovien.cahoc = cahoc.id
			and khoahocgiaovien.theloaikhoahocid = theloaikhoahoc.id
			and khoahocgiaovien.id = '$id'";
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
    <link rel="stylesheet" type="text/css" href="style/khoahoc_danghd_chitiet.css">
	<title>Tmarket</title>

</head>
<body>
	
	<div class="pdgv_chitiet">
		<div class="pdgv_h1">
			<h1>Chi tiết khóa học</h1>
		</div>
		<div class="form">
			<?php foreach($result_chitiet as $items):?>
			<form >
				<fieldset class="form-group">
					<label for="tenkhoahoc">Tên khóa học</label>
					<textarea  class="form-control" id="tenkhoahoc" disabled><?php echo $items['tenkhoahoc']?></textarea>
				</fieldset>
				<fieldset class="form-group">
					<label for="tengv">Tên giáo viên</label>
					<input type="text" class="form-control" id="tengv" value="<?php echo $items['hoten']?>" name="email" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="hocphi">Học phí</label>
					<input type="text" class="form-control" id="hocphi" value="<?php echo $items['hocphi']?> VNĐ" name="sdt" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="tailieu1">Tài liệu 1</label>
					<a id="tailieu1" href="../teacher/<?php echo $items['tailieu1']?>">File 1</a>
				</fieldset>
			</form>
			<form>
				<fieldset class="form-group">
					<label for="tgbatdau">Thời gian bắt đầu</label>
					<input type="date" class="form-control" id="tgbatdau" value="<?php echo $items['thoigianbatdau']?>" name="tlgv" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="tgketthuc">Thời gian kết thúc</label>
					<input type="date" class="form-control" id="tgketthuc" value="<?php echo $items['thoigianketthuc']?>" name="quocgia" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="cahoc">Ca học</label>
					<input type="text" class="form-control" id="cahoc" value="<?php echo $items['thoigian']?>" name="gioitinh" disabled>
				</fieldset>
				<fieldset class="form-group">
					<label for="tailieu2">Tài liệu 2</label>
					<a id="tailieu2" href="../teacher/<?php echo $items['tailieu2']?>">File 2</a>
				</fieldset>
			</form>
			<?php endforeach?>

		</div>
		
	</div>
	<a href="khoahoc_danghd.php"><input class="btn_quaylai" type="submit" value="Quay lại"></a>
</body>
</html>