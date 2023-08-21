<?php
	include('../user/connect.php');
	session_start();
	$iduser = $_GET['id'];
	if (!isset($_SESSION['taikhoan'])) {
		header("location:../user/index.php");
	}
	$sql = "SELECT * FROM taikhoan WHERE id='$iduser'";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();
	$result=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		$result[] = $row;
	}

	foreach ($result as $items) {
		$hoten = $items['hoten'];
		$img = $items['image'];
	}
	//Chi tiết khóa học
	
	$idgv = $_GET['idgv'];
	$idkh = $_GET['idkh'];
	$sql_chitiet = "SELECT khoahocgiaovien.*, congcudayhoc.tencongcu,giaovien.linkdayhoc,theloaikhoahoc.tenkhoahoc, theloaikhoahoc.mota, cahoc.thoigian
		FROM khoahocgiaovien,cahoc,theloaikhoahoc,giaovien,congcudayhoc
		WHERE khoahocgiaovien.giaovienid = '$idgv'
		and khoahocgiaovien.id = '$idkh'
		and khoahocgiaovien.theloaikhoahocid = theloaikhoahoc.id
		and khoahocgiaovien.cahoc = cahoc.id
		and congcudayhoc.id = giaovien.idcongcudayhoc
		and giaovien.id = khoahocgiaovien.giaovienid";
	$stmt_chitiet = $conn->prepare($sql_chitiet);
	$query_chitiet = $stmt_chitiet->execute();
	$result_chitiet = array();
	while($row_chitiet = $stmt_chitiet->fetch(PDO::FETCH_ASSOC)){
		$result_chitiet[] = $row_chitiet;
	}

		
	//Gui y kien danh gia
	if(isset($_POST['submit'])){
		if(!empty($_POST['ykien'])){
			$ykien = $_POST['ykien'];
			$sql_ykien = "INSERT INTO ykiendanhgia(idkhoahoc,idhocvien,ykiendanhgia) 
						  VALUES('$idkh','$iduser','$ykien')";
			$stmt_ykien = $conn->prepare($sql_ykien);
			$query_ykien = $stmt_ykien->execute();
			$sql_them = "UPDATE giaovien SET danhgia = danhgia + 1 WHERE id = '$idgv'";
			$stmt_them = $conn->prepare($sql_them);
			$query_them = $stmt_them->execute();
			if($query_ykien && $query_them){
				header("location:vaolophoc.php?id=$iduser&&idkh=$idkh&&idgv=$idgv");
			}
			else{
				echo "Lỗi";
 			}
		}
	}
	//Danh sách ý kiến của khóa học
	$sql_dsyk = "SELECT taikhoan.hoten,ykiendanhgia.* FROM taikhoan,ykiendanhgia WHERE taikhoan.id=ykiendanhgia.idhocvien and ykiendanhgia.idkhoahoc = '$idkh' ";
	$stmt_dsyk = $conn->prepare($sql_dsyk);
	$query_dsyk = $stmt_dsyk->execute();
	$result_dsyk=array();
	while($row_dsyk = $stmt_dsyk->fetch(PDO::FETCH_ASSOC)){
		$result_dsyk[] = $row_dsyk;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" href = "js/bootstrap.min.js"></script>
	<script type="text/javascript" href = "js/jquery-3.6.2.slim.js"></script>
    <link rel="stylesheet" type="text/css" href="style/vaolophoc.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
	<title>Vào lớp học</title>
</head>
<body>
	<header>
		<div class="menu container">
			<a class="logo" href="index.php?id=<?php echo $iduser?>">
				<img class="logo-market" src="img/logo-market.png">
			</a>
			<ul class="nav">
				<li class="nav-item"><a class="nav-link" href="timgiaovien.php?id=<?php echo $iduser?>">Tìm giáo viên</a></li>
				<li class="nav-item"><a class="nav-link" href="trothanhgiaovien.php?id=<?php echo $iduser?>">Trở thành giáo viên</a></li>
				<li class="nav-item"><a class="nav-link" href="#">Hướng dẫn</a>
					<ul class="sub-menu">
						<li><a href="huongdanwithgv.php?id=<?php echo $iduser?>">Hướng dẫn đối với giáo viên</a></li>
						<li><a href="huongdanwithhv.php?id=<?php echo $iduser?>">Hướng dẫn đối với học viên</li>
					</ul>
				</li>
				<li class="nav-item"><a class="nav-link" href="#">Ngôn ngữ</a>
					<ul class="sub-menu">
						<div class="translate" id="google_translate_element"></div>
                        <script type="text/javascript">
                            function googleTranslateElementInit() {  new google.translate.TranslateElement({pageLanguage: 'us'}, 'google_translate_element');}
                        </script>
                        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<button  onclick="menuFunction(this)" class="dropbtn">
						<img src="<?php echo $img?>">
						<label><?php echo $hoten?></label>
						<div class="menuicon">
						  <div class="bar1"></div>
						  <div class="bar2"></div>
						  <div class="bar3"></div>
						</div>
					</button>
					
					<div id="myDropdown" class="dropdown-content">
						<a href="dskh.php?id=<?php echo $iduser?>">Danh sách khóa học</a>
                        <a href="danhsachbaitest.php?id=<?php echo $iduser?>">Danh sách bài test</a>
                        <a href="thongtincanhan.php?id=<?php echo $iduser?>">Thông tin cá nhân</a>
                        <a href="#">Giáo viên yêu thích</a>
                        <a href="trothanhgiaovien.php?id=<?php echo $iduser?>">Trở thành giáo viên</a>
                        <a href="lichsudanhgia.php?id=<?php echo $iduser?>">Lịch sử đánh giá</a>
                        <a href="naptien.php?id=<?php echo $iduser?>">Nạp tiền</a>
                        <a href="vicuatoi.php?id=<?php echo $iduser?>">Ví của tôi</a>
                        <a href="cauhoithuonggap.php?id=<?php echo $iduser?>">Hỗ trợ</a>
                        <a href="thaydoimatkhau.php?id=<?php echo $iduser?>">Thay đổi mật khẩu</a>
                        <a href="dangxuat.php">Đăng xuất</a>
					</div>
				</li>
			</ul>
		</div>
	</header>
	<div id="content">
		<h1>Thông tin khóa học</h1>
		<div class="ttkh">
			<?php foreach ($result_chitiet as $items): ?>
				<label><span>Tên khóa học:</span> <?php echo $items['tenkhoahoc']?></label>
				<br>
				<label><span>Học phí:</span> 
					<?php
					$hocphi = $items['hocphi'];
					echo number_format($hocphi);
					?> đồng</label>
				<br>
				<label><span>Thời gian:</span> Từ 
					<?php 
					$tgbatdau = $items['thoigianbatdau'];
					echo date("d-m-Y",strtotime($tgbatdau));
					
					?> 
					đến
					<?php 
					$tgketthuc = $items['thoigianketthuc'];
					echo date("d-m-Y",strtotime($tgketthuc));
					?>
				</label>
				<br>
				<label><span>Ca học:</span> <?php echo $items['thoigian']?></label>
				<br>
				<label><span>Mô tả khóa học: </span></label>
				<br>
				<label><?php echo $items['mota']?></label>
				<br>
				<label><span>Công cụ giao tiếp: </span><?php echo $items['tencongcu']?></label>
				<br>
				<label><span>Link: </span><?php echo $items['linkdayhoc']?></label>
				<br>
				<label>File bài giảng</label>
				<br>
				<label>Tài liệu 1:  <a href="../teacher/<?php echo $items['tailieu1']?>">File 1</a></label>
				<br>
				<label>Tài liệu 2: <a href="../teacher/<?php echo $items['tailieu2']?>">File 2</a></label>
			<?php endforeach ?>
			<form method="post">
				<fieldset class="form-group">
					<label for="yien">Đánh giá khóa học</label>
					<textarea name="ykien" class="form-control" id="yien" placeholder="Nhập ý kiến đánh giá"></textarea>
				</fieldset>
				<fieldset style="margin-top: 20px;margin-bottom: 20px" class="form-group">
					<input name="submit" type="submit" class="submit_danhgia form-control" id="submit" placeholder="Gửi đánh giá">
				</fieldset>
			</form>
			<h4>Các ý kiến đánh giá</h4>
			<table class="table table-inverse">
				<thead>
					<tr>
						<th>STT</th>
						<th>Họ tên</th>
						<th>Ý kiến</th>
						<th>Thời gian</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; foreach ($result_dsyk as $items): ?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $items['hoten'];?></td>
							<td><?php echo $items['ykiendanhgia'];?></td>
							<td><?php 
									$thoigian = $items['thoigian'];
									echo date("d-m-Y",strtotime($thoigian));
									?></td>
						</tr>
					<?php $i++; endforeach ?>
				</tbody>
			</table>
			<br>
			<!-- <button class="btnAddRequest"><a href="thembaikiemtra.php?id=<?php echo $id_teacher?>&&idgv=<?php echo $idkh?>&&idkh=<?php echo $idkh?>">Thêm bài kiểm tra</a></button> -->
		</div>
	</div>
	<footer class="footer-distributed">

			<div class="footer-left">

				<h3><img src="img/logo-market.png"></h3>

				<p class="footer-links">
					<a href="index.php?id=<?php echo $iduser?>" class="link-1">Trang chủ</a>
                    
                    <a href="timgiaovien.php?id=<?php echo $iduser?>">Tìm giáo viên</a>
                
                    <a href="trothanhgiaovien.php?id=<?php echo $iduser?>">Trở thành giáo viên</a>
                
                    <a href="huongdanwithgv.php?id=<?php echo $iduser?>">Hướng dẫn đối với giáo viên</a>
                    
                    <a href="huongdanwithhv.php?id=<?php echo $iduser?>">Hướng dẫn đối với học viên</a>

                    <a href="cauhoithuonggap.php?id=<?php echo $iduser?>">Câu hỏi thường gặp</a>
                    
                    <a href="#">Góp ý về chúng tôi</a>
				</p>

				<p class="footer-company-name">Tmarket ©</p>
			</div>

			<div class="footer-center">

				<div>
					<i class="fa fa-map-marker"></i>
					<p><span>46 Quán Nam</span>Kênh Dương, Lê Chân, TP. Hải Phòng</p>
				</div>

				<div>
					<i class="fa fa-phone"></i>
					<p>+1.555.555.5555</p>
				</div>

				<div>
					<i class="fa fa-envelope"></i>
					<p><a href="mailto:support@company.com">quang84560@st.vimaru.edu.vn</a></p>
				</div>

			</div>

			<div class="footer-right">

				<p class="footer-company-about">
					<span>Về chúng tôi</span>
					Tmarket là nền tảng kết nối giữa Giáo viên và Học viên có nhu cầu học Ngoại ngữ, thông qua các lớp học trực tuyến với mô hình học 1 Thầy-1 Trò hoặc 1 Thầy-1 nhóm và lớp học được thực hiện trên nền tảng Zoom, Google meet.
				</p>

				<div class="footer-icons">

					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-twitter"></i></a>
					<a href="#"><i class="fa fa-youtube"></i></a>
					<a href="#"><i class="fa fa-instagram"></i></a>

				</div>

			</div>

	</footer>
	<script>
		function menuFunction(x) {
			x.classList.toggle("change");
		  document.getElementById("myDropdown").classList.toggle("show");
		}
	</script>
</body>
</html>
