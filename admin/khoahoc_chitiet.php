<?php
	include("../user/connect.php");
	$id_sua = $_GET['id'];

	//Lấy dữ liệu
	$sql_kh = "SELECT * FROM theloaikhoahoc WHERE id = '$id_sua'";
	$stmt_kh = $conn->prepare($sql_kh);
	$query_kh = $stmt_kh->execute();
	$result_kh = array();
	while($row_kh = $stmt_kh->fetch(PDO::FETCH_ASSOC)){
		$result_kh[] = $row_kh;
	}
	foreach ($result_kh as $items) {
		$tenkh = $items['tenkhoahoc'];
		$mota = $items['mota'];
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
    <link rel="stylesheet" type="text/css" href="style/khoahoc_chitiet.css">
	<title>Tmarket</title>

</head>
<body>
	
	<div class="pdgv_chitiet">
		<div class="pdgv_h1">
			<h1>Chi tiết khóa học</h1>
		</div>
		<div class="form">
			<form>
				<fieldset class="form-group">
					<label for="hoten">Tên khóa học</label>
					<textarea class="form-control" id="hoten" disabled><?php echo $tenkh?></textarea>
				</fieldset>
				<fieldset class="form-group">
					<label for="email">Mô tả</label>
					<textarea style="height: 350px;text-align: justify;" id="email" class="form-control" disabled><?php echo $mota?></textarea>
				</fieldset>
			</form>
		</div>
		<a class="btn_ql" href="khoahoc.php"><input class="btn_quaylai" type="submit" value="Quay lại"></a>
	</div>
</body>
</html>