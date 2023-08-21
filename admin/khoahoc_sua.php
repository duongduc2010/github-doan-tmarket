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
	if(isset($_POST['submit'])){
		if(!empty($_POST['ten']) && !empty($_POST['mota'])){

			$ten = $_POST['ten'];
			$motakh = $_POST['mota'];
			$sql_sua = "UPDATE theloaikhoahoc SET tenkhoahoc = '$ten', mota ='$motakh' 
						WHERE id ='$id_sua'";
			$stmt_sua = $conn->prepare($sql_sua);
			$query_sua = $stmt_sua->execute();
			if($query_sua){
				header("location:khoahoc_sua.php?id=$id_sua");
			}
			else{
				echo "Sửa thất bại";
			}
		}
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
    <link rel="stylesheet" type="text/css" href="style/khoahoc_sua.css">
	<title>Tmarket</title>

</head>
<body>
	
	<div class="pdgv_chitiet">
		<div class="pdgv_h1">
			<h1>Sửa khóa học</h1>
		</div>
		<div class="form">
			<form method = "post">
				<fieldset class="form-group">
					<label for="hoten">Tên khóa học</label>
					<textarea name="ten" class="form-control" id="hoten"><?php echo $tenkh?></textarea>
				</fieldset>
				<fieldset class="form-group">
					<label for="email">Mô tả</label>
					<textarea style="height: 350px;text-align: justify;" id="email" class="form-control" name="mota"><?php echo $mota?></textarea>
				</fieldset>
				<input type="submit" name="submit" value="Cập nhật">
			</form>
		</div>
		
	</div>
	<a href="khoahoc.php"><input class="btn_quaylai" type="submit" value="Quay lại"></a>
</body>
</html>