<?php
	include('../user/connect.php');
	session_start();
	if (!isset($_SESSION['taikhoan'])) {
		header("location:../user/index.php");
	}
	$id_teacher = $_GET['id'];
	$sql_teacher = "SELECT giaovien.*, theloaigiaovien.tentheloai, quocgia.quocgia as tenqg,gioitinh.gioitinh as tengt,timezone.ten as tentz 
		FROM giaovien,theloaigiaovien, quocgia,gioitinh,timezone
		WHERE giaovien.taikhoan='$id_teacher' 
		and giaovien.theloaigiaovien = theloaigiaovien.id
		and giaovien.quocgia = quocgia.id
		and giaovien.gioitinh = gioitinh.id
		and giaovien.timezone = timezone.id";
	$stmt_teacher = $conn->prepare($sql_teacher);
	$query_teacher = $stmt_teacher->execute();
	$result_teacher=array();
	while($row_teacher=$stmt_teacher->fetch(PDO::FETCH_ASSOC)){
		$result_teacher[] = $row_teacher;
	}

	foreach ($result_teacher as $items) {
		$hoten = $items['hoten'];
		$img = $items['imgprofile'];
		$id_giaovien = $items['id'];
	}


	//Danh sách khóa học của giáo viên
	if(empty($_POST['submit'])){
		$sql_dskh = "SELECT khoahocgiaovien.*,cahoc.thoigian,theloaikhoahoc.tenkhoahoc 
					FROM khoahocgiaovien,cahoc,theloaikhoahoc
					WHERE khoahocgiaovien.cahoc = cahoc.id and khoahocgiaovien.theloaikhoahocid = theloaikhoahoc.id
					and khoahocgiaovien.giaovienid = '$id_giaovien'
					ORDER BY khoahocgiaovien.tinhtrang DESC";
		$stmt_dskh = $conn->prepare($sql_dskh);
		$query_dskh = $stmt_dskh->execute();
		$result_dskh = array();
		while($row_dskh = $stmt_dskh->fetch(PDO::FETCH_ASSOC)){
			$result_dskh[] = $row_dskh;
		}
	}
	else{
		$tinhtrang = $_POST['timkiem'];
		$sql_dskh = "SELECT khoahocgiaovien.*,cahoc.thoigian,theloaikhoahoc.tenkhoahoc 
					FROM khoahocgiaovien,cahoc,theloaikhoahoc
					WHERE khoahocgiaovien.cahoc = cahoc.id and khoahocgiaovien.theloaikhoahocid = theloaikhoahoc.id
					and khoahocgiaovien.giaovienid = '$id_giaovien'
					and khoahocgiaovien.tinhtrang LIKE '%$tinhtrang%'
					ORDER BY khoahocgiaovien.tinhtrang DESC ";
		$stmt_dskh = $conn->prepare($sql_dskh);
		$query_dskh = $stmt_dskh->execute();
		$result_dskh = array();
		while($row_dskh = $stmt_dskh->fetch(PDO::FETCH_ASSOC)){
			$result_dskh[] = $row_dskh;
		}
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
    <link rel="stylesheet" type="text/css" href="style/danhsachkhoahoc.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
	<title>Danh sách khóa học</title>
</head>
<body>
	<header>
		<div class="menu container">
            <a class="logo" href="index.php?id=<?php echo $id_teacher ?>">
                <img class="logo-market" src="img/logo-market.png">
            </a>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="danhsachkhoahoc.php?id=<?php echo $id_teacher ?>">Danh sách khóa học</a></li>
                <li class="nav-item"><a class="nav-link" href="thongtincanhan.php?id=<?php echo $id_teacher ?>">Thông tin cá nhân</a></li>
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
						<label><?php echo $hoten;?></label>
						<div class="menuicon">
						  <div class="bar1"></div>
						  <div class="bar2"></div>
						  <div class="bar3"></div>
						</div>
					</button>
					
					<div id="myDropdown" class="dropdown-content">
						<a href="danhsachkhoahoc.php?id=<?php echo $id_teacher ?>">Danh sách khóa học</a>
                        <a href="thongtincanhan.php?id=<?php echo $id_teacher ?>">Thông tin cá nhân</a>
                        <a href="doimatkhau.php?id=<?php echo $id_teacher ?>">Đổi mật khẩu</a>
                        <a href="huongdanwithgv.php?id=<?php echo $id_teacher ?>">Hướng dẫn đối với giáo viên</a>
                        <a href="dangxuat.php">Đăng xuất</a>
					</div>
				</li>
            </ul>   
        </div>
	</header>
	<div id="content">
		<h4 class="content__title">Hệ thống khóa học</h4>
		<form class="filter" method="post">
			<label>Lọc khóa học theo tình trạng</label><br>
			<input type="radio" name="timkiem" value="Đang hoạt động" id="danghd">
			<label for="danghd">Đang hoạt động</label><br>
			<input type="radio" name="timkiem" value="Đã hoàn thành" id="daht">
			<label for="daht">Đã hoàn thành</label><br>
			<input type="radio" name="timkiem" value="Chưa hoạt động" id="chuahd">
			<label for="chuahd">Chưa hoạt động</label><br>
			<input type="submit" name="submit" value="Áp dụng">
		</form>
		<table class="table table-inverse">
			<thead>
				<tr>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($result_dskh as $items): ?>
					<tr>
						<td>
							<div class="khoahoc">

								<label><span>Tên khóa học:</span> <?php echo $items['tenkhoahoc'];?></label>
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
								<label><span>Ca học:</span> <?php echo $items['thoigian'];?></label>
								<br>
								<label><span>Tình trạng:</span> <span style="color: #4dd31d;font-weight: bold"><?php echo $items['tinhtrang'];?></span></label><br>
								<label style="color:#4dd31d;font-weight: bold;">
								<?php
									// Return current date from the remote server
									$date = strtotime(date('d-m-Y'));
									$tgketthuc = $items['thoigianketthuc'];
									$tgketthuc = strtotime(date("d-m-Y",strtotime($tgketthuc)));
									if($tgketthuc <= $date && $items['tinhtrang']!="Đã hoàn thành"){
										echo "Đã đến hạn! Bạn vui lòng hãy ấn xác nhận hoàn thành khóa học";
									}
								?></label>
								
							</div>
						</td>
						<td><br><br><a href="chitietkhoahoc.php?id=<?php echo $id_teacher?>&&idgv=<?php echo $id_giaovien ?>&&idkh=<?php echo $items['id']?>">Chi tiết khóa học</a></td>
						<td><br><br><a class="btn-hoanthanh" href="hoanthanhkhoahoc.php?id=<?php echo $id_teacher?>&&idgv=<?php echo $id_giaovien ?>&&idkh=<?php echo $items['id']?>">Hoàn thành khóa học</a></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<footer class="footer-distributed">

			<div class="footer-left">

				<h3><img src="img/logo-market.png"></h3>

				<p class="footer-links">
					<a href="index.php?id=<?php echo $id_teacher ?>" class="link-1">Trang chủ</a>
                    
                    <a href="timgiaovien.php?id=<?php echo $id_teacher ?>">Tìm giáo viên</a>
                
                    <a href="trothanhgiaovien.php?id=<?php echo $id_teacher ?>">Trở thành giáo viên</a>
                
                    <a href="huongdanwithgv.php?id=<?php echo $id_teacher ?>">Hướng dẫn đối với giáo viên</a>
                    
                    <a href="huongdanwithhv.php?id=<?php echo $id_teacher ?>">Hướng dẫn đối với học viên</a>

                    <a href="cauhoithuonggap.php?id=<?php echo $id_teacher ?>">Câu hỏi thường gặp</a>
                    
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
