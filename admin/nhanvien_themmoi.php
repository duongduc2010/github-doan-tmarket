<?php
	include("../user/connect.php");
	if(isset($_POST['submit'])){
		if(!empty($_POST['taikhoan']) && !empty($_POST['matkhau']) && !empty($_POST['hoten']) && !empty($_POST['email'])){
			$taikhoan = $_POST['taikhoan'];
			$matkhau = $_POST['matkhau'];
			$mk = md5($matkhau);
			$hoten = $_POST['hoten'];
			$email = $_POST['email'];
			$sql_them = "INSERT INTO admin(taikhoan,matkhau,hoten,email) VALUES('$taikhoan','$mk','$hoten','$email')";
			$stmt_them = $conn->prepare($sql_them);
			$query_them= $stmt_them->execute();
			if($query_them){
				header("location:nhanvien.php");
			}
			else{
				echo "Thêm thất bại";
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
    <link rel="stylesheet" type="text/css" href="style/nhanvien_themmoi.css">
	<title>Tmarket</title>

</head>
<body>
	
	<div class="pdgv_chitiet">
		<div class="pdgv_h1">
			<h1>Thêm tài khoản</h1>
		</div>
		<div class="form">
			<form method = "post">
				<fieldset class="form-group">
					<label for="taikhoan">Tài khoản</label>
					<input type="text" name="taikhoan" class="form-control" id="hoten">
				</fieldset>
				<fieldset class="form-group">
					<label for="matkhau">Mật khẩu</label>
					<input type="password" name="matkhau" class="form-control" id="matkhau">
				</fieldset>
				<fieldset class="form-group">
					<label for="hoten">Họ tên</label>
					<input type="text" name="hoten" class="form-control" id="hoten">
				</fieldset>
				<fieldset class="form-group">
					<label for="email">Email</label>
					<input type="text" name="email" class="form-control" id="email">
				</fieldset>
				<input type="submit" name="submit" value="Thêm mới">
			</form>
		</div>
	</div>
</body>
</html>