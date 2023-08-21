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


	//Danh sách câu trả lời
	$idkh = $_GET['idkh'];
	$idketqua = $_GET['idketqua'];
	$sql_ketqua = "SELECT chitietbaikiemtra.*,chitietketqua.dapanchon
					FROM chitietketqua,chitietbaikiemtra
					WHERE idketqua='$idketqua'
					and chitietketqua.idcauhoi=chitietbaikiemtra.STT";
	$stmt_ketqua = $conn->prepare($sql_ketqua);
	$query_ketqua = $stmt_ketqua->execute();
	$result_ketqua = array();
	while($row_ketqua = $stmt_ketqua->fetch(PDO::FETCH_ASSOC)){
		$result_ketqua[] = $row_ketqua;
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
    <link rel="stylesheet" type="text/css" href="style/chitietkhoahoc.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
    <link rel="stylesheet" type="text/css" href="style/lambaitap.css">
	<title>Chi tiết khóa học</title>
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
                        <a href="dangxuat.php?id=<?php echo $id_teacher ?>">Đăng xuất</a>
					</div>
				</li>
            </ul>   
        </div>
	</header>
	<div id="content">
		<form>
			<div class="question">
				<?php $i=0; foreach ($result_ketqua as $items):?>
					<div class="text-question">
						<div class="text-question_id">Câu số <?php echo $i+1?></div>
						<div class="text-question_content"><?php echo $items['tencauhoi']?></div>
					</div>
					<div class="text-rep">
						<input disabled  type="radio" name="chon<?php echo $i?>"  value="a">
						<input style="border:none" readonly  name="a<?php echo $i?>" type="text" placeholder="Nội dung câu trả lời" value="<?php echo $items['dapana']?>"><br>
						<input disabled  type="radio" name="chon<?php echo $i?>"  value="b">
						<input style="border:none" readonly  name="b<?php echo $i?>" type="text" placeholder="Nội dung câu trả lời" value="<?php echo $items['dapanb']?>"><br>
						<input disabled  type="radio" name="chon<?php echo $i?>"  value="c">
						<input style="border:none" readonly  name="c<?php echo $i?>" type="text" placeholder="Nội dung câu trả lời" value="<?php echo $items['dapanc']?>"><br>
						<input disabled type="radio" name="chon<?php echo $i?>"  value="d">
						<input style="border:none" readonly  name="d<?php echo $i?>" type="text" placeholder="Nội dung câu trả lời" value="<?php echo $items['dapand']?>"><br>
						<label style="color:green;font-weight: bold">Đáp án chọn: <?php echo $items['dapanchon']?></label><br>
						<label style="color: blue;font-weight: bold">Đáp án đúng: <?php echo $items['dapandung']?></label>
					</div>
				<?php $i++; endforeach ?>
			</div>
			<div class="submit"> 
				<a class="btn-submit" href="chitietkhoahoc.php?id=<?php echo $id_teacher?>&&idkh=<?php echo $idkh?>&&idgv=<?php echo $id_giaovien?>">Quay lại</a>
			</div>
		</form>
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
