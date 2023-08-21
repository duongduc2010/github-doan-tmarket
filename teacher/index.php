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
		$vitien = $items['vitien'];
	}

	//Số lượng học viên
	$sql_slhv = "SELECT count(taikhoan.id) as dem
				FROM khoahochocvien,taikhoan
				WHERE khoahochocvien.idkhoahoc = '$idkh'
				and khoahochocvien.idhocvien = taikhoan.id";
	$stmt_slhv = $conn->prepare($sql_slhv);
	$query_slhv = $stmt_slhv->execute();
	$result_slhv = array();
	while($row_slhv = $stmt_slhv->fetch(PDO::FETCH_ASSOC)){
		$result_slhv[] = $row_slhv;
	}


	//Số lượng khóa học
	$sql_slkh = "SELECT COUNT(khoahocgiaovien.id) as dem
				FROM khoahocgiaovien,giaovien,taikhoan
				WHERE khoahocgiaovien.giaovienid = giaovien.id
				and giaovien.taikhoan = taikhoan.id
				and taikhoan.id = '$id_teacher'";
	$stmt_slkh = $conn->prepare($sql_slkh);
	$query_slkh = $stmt_slkh->execute();
	$result_slkh = array();
	while($row_slkh = $stmt_slkh->fetch(PDO::FETCH_ASSOC)){
		$result_slkh[] = $row_slkh;
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
	<link rel="stylesheet" type="text/css" href="style/index.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
	<title>Trang chủ giáo viên</title>
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
                        <a href="thongtincanhan.php?id=<?php echo $id_teacher ?>">Cài đặt thông tin</a>
                        <a href="doimatkhau.php?id=<?php echo $id_teacher ?>">Đổi mật khẩu</a>
                        <a href="huongdanwithgv.php?id=<?php echo $id_teacher ?>">Hướng dẫn đối với giáo viên</a>
                        <a href="dangxuat.php">Đăng xuất</a>
					</div>
				</li>
            </ul>   
        </div>
	</header>
	<div id="content">
		<div class="content__thongtin">
			<img style="height: 150px;width: 150px;border-radius: 100%" src="<?php echo $img?>">
			<h5 class="ten"><?php echo $hoten;?></h5>
			<a href="thongtincanhan.php?id=<?php echo $id_teacher?>" style="color:var(--green-color)">Edit</a>
			<h5 class="quocgia">Asia/Hai_Phong</h5>
		</div>
		<div class="content__soluong">
			<div class="content__soluong--hocvien">
				<h1>0</h1>
				<h5>Số lượng học viên</h5>
			</div>
			<div class="content__soluong--khoahoc">
				<?php foreach ($result_slkh as $items): ?>
				<h1><?php echo $items['dem']?></h1>
				<?php endforeach ?>
				<h5>Số lượng khóa học</h5>
			</div>
		</div>
		<div class="content__sotien">
			<div class="content__sotien--vi">
				<h5>Tổng tiền trong ví</h5>
				<h5 style="color:var(--green-color);font-weight: bold;font-size: 20pt"><?php
					echo number_format($vitien);
					?> đồng</h5>
				<a style="color:var(--green-color);" href="thongtincanhan.php?id=<?php echo $id_teacher ?>"><h5>Lịch sử giao dịch</h5></a>
			</div>
			
		</div>
	</div>
	<footer >
			<div class="footer-distributed">
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