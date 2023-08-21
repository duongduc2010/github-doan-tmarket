<?php
	session_start();
	include('connect.php');
	if(!empty($_POST['submit'])){
		if(isset($_POST['taikhoan']) && isset($_POST['matkhau'])){
			$taikhoan=$_POST['taikhoan'];
			$matkhau=$_POST['matkhau'];
			$md5_mk = md5($matkhau);
			$sql_user="SELECT * from taikhoan WHERE taikhoan='$taikhoan' and matkhau='$md5_mk'";
			$stmt_user=$conn->prepare($sql_user);
			$query_user=$stmt_user->execute();
			$row_user=$stmt_user->fetch(PDO::FETCH_ASSOC);

			if($row_user){
				$sql_user = "SELECT id from taikhoan WHERE taikhoan='$taikhoan' and matkhau='$md5_mk'";
				$stmt_user=$conn->prepare($sql_user);
				$query_user = $stmt_user->execute();
				$result_user = array();
				while($row_user = $stmt_user->fetch(PDO::FETCH_ASSOC)){
					$result_user[] = $row_user;
				}
				foreach ($result_user as $items) {
					$iduser = $items['id'];
				}
				$_SESSION['taikhoan'] = $taikhoan;
				header("location:../saukhidangnhap/index.php?id=$iduser");
			}
			else{
				echo "Đăng nhập thất bại";
			}

			$sql_teacher="SELECT * from taikhoan WHERE taikhoan='$taikhoan' and matkhau='$md5_mk' and phanquyen='1'";
			$stmt_teacher=$conn->prepare($sql_teacher);
			$query_teacher=$stmt_teacher->execute();
			$row_teacher=$stmt_teacher->fetch(PDO::FETCH_ASSOC);

			if($row_teacher){
				$sql_teacher = "SELECT id from taikhoan WHERE taikhoan='$taikhoan' and matkhau='$md5_mk'";
				$stmt_teacher=$conn->prepare($sql_teacher);
				$query_teacher = $stmt_teacher->execute();
				$result_teacher = array();
				while($row_teacher = $stmt_teacher->fetch(PDO::FETCH_ASSOC)){
					$result_teacher[] = $row_teacher;
				}
				foreach ($result_teacher as $items) {
					$iduser = $items['id'];
				}
				$_SESSION['taikhoan'] = $taikhoan;
				header("location:../teacher/index.php?id=$iduser");
			}
			else{
				echo "Đăng nhập thất bại";
			}

		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
 	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript" href = "js/bootstrap.min.js"></script>
	<script type="text/javascript" href = "js/jquery-3.6.2.slim.js"></script>
    <link rel="stylesheet" type="text/css" href="style/dangnhap.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
	<title>Trang đăng nhập</title>
</head>
<body>
	<header>
		<div class="menu container">
            <a class="logo" href="index.php">
                <img class="logo-market" src="img/logo-market.png">
            </a>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="timgiaovien.php">Tìm giáo viên</a></li>
                <li class="nav-item"><a class="nav-link" href="trothanhgiaovien.php">Trở thành giáo viên</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Hướng dẫn</a>
                    <ul class="sub-menu">
                        <li><a href="huongdanwithgv.php">Hướng dẫn đối với giáo viên</a></li>
                        <li><a href="huongdanwithhv.php">Hướng dẫn đối với học viên</li>
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
                <li class="nav-item"><a class="nav-link" href="dangnhap.php">Đăng nhập</a></li>
                <li class="nav-item"><a class="nav-link" href="dangky.php">Đăng ký</a></li>
            </ul>   
        </div>
	</header>
	<div id="content">
		<div class="slogan">
			<label >Dễ dàng thành thạo tiếng anh</label>
		</div>
		<form action="" method="post">
			<div class="headingsContainer">
				<h3>ĐĂNG NHẬP</h3>
				<p>Đăng nhập với số điện thoại/email và mật khẩu của bạn</p>
			</div>

			<div class="mainContainer">
				<label for="username">Tên đăng nhập</label>
				<input type="text" placeholder="Nhập số điện thoại/email" name="taikhoan" required>
				
				<br></br>
				
				<label for="password">Mật khẩu</label>
				<input type="password" placeholder="Nhập mật khẩu" name="matkhau" required id="id_password"><i class="far fa-eye" id="togglePassword"  style="margin-left: -30px; cursor: pointer; color:black;"></i></input>

				<br>
				
				<div class="subcontainer">
					<label>
						<input type="checkbox" checked="checked" name="remember"> Duy trì đăng nhập
					</label>
					<p class="forgotpassword"> <a href="quenmatkhau.php">Quên mật khẩu?</a></p>
				</div>

				<input name="submit" type="submit" value="Đăng nhập">

				<p class="register">Bạn chưa có tài khoản?  <a href="dangky.php">Đăng ký ngay!</a></p>
			</div>
		</form>
	</div>
	
	<footer class="footer-distributed">

			<div class="footer-left">

				<h3><img src="img/logo-market.png"></h3>

				<p class="footer-links">
					<a href="index.php" class="link-1">Trang chủ</a>
					
					<a href="timgiaovien.php">Tìm giáo viên</a>
				
					<a href="trothanhgiaovien.php">Trở thành giáo viên</a>
				
					<a href="huongdanwithgv.php">Hướng dẫn đối với giáo viên</a>
					
					<a href="huongdanwithhv.php">Hướng dẫn đối với học viên</a>

					<a href="cauhoithuonggap.php">Câu hỏi thường gặp</a>
					
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
	<!-- <script src="http://code.jquery.com/jquery-3.5.1.js"></script>
	<script>
		$(document).ready(function() {
			$(window).scroll(function(){
				if($(this).scrollTop()){
					$('header').addClass('sticky');
				}
				else{
					$('header').addClass('sticky');
				}
			});
		});
	</script> -->
</body>
</html>

<script type="text/javascript">
	const togglePassword = document.querySelector('#togglePassword');
	  const password = document.querySelector('#id_password');
	  togglePassword.addEventListener('click', function (e) {
	    // toggle the type attribute
	    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
	    password.setAttribute('type', type);
	    // toggle the eye slash icon
	    this.classList.toggle('fa-eye-slash');
	});
</script>
