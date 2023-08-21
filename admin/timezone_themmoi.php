<?php
	include("../user/connect.php");
	if(isset($_POST['submit'])){
		if(!empty($_POST['id'])&&!empty($_POST['ten'])){
			$id=$_POST['id'];
			$ten = $_POST['ten'];
			$sql_them = "INSERT INTO timezone(id,ten) VALUES('$id','$ten')";
			$stmt_them = $conn->prepare($sql_them);
			$query_them= $stmt_them->execute();
			if($query_them){
				header("location:timezone.php");
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
			<h1>Thêm Timezone</h1>
		</div>
		<div class="form">
			<form method = "post">
				<fieldset class="form-group">
					<label for="ten">ID</label>
					<input type="text" name="id" class="form-control" id="ten">
				</fieldset>
				<fieldset class="form-group">
					<label for="ten">Tên timezone</label>
					<input type="text" name="ten" class="form-control" id="ten">
				</fieldset>
				<input type="submit" name="submit" value="Thêm mới">
			</form>
		</div>
	</div>
</body>
</html>