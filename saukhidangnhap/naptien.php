<?php
	include('../user/connect.php');
	$iduser = $_GET['id'];
	session_start();
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
	//Nạp tiền vào ví
	if(isset($_POST['submit'])){
		if(!empty($_POST['tongtien'])){
			$tongtien = $_POST['tongtien'];
			$sql_naptien = "INSERT INTO naptien(idtaikhoan,sotien) VALUES('$iduser','$tongtien')";;
			$stmt_naptien = $conn->prepare($sql_naptien);
			$query_naptien = $stmt_naptien->execute();
			if($query_naptien){
				header("location:naptien.php?id=$iduser");
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
    <link rel="stylesheet" type="text/css" href="style/naptien.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
	<title>Trang chủ</title>
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

	<div  id="content">
		<div class="slogan">
			<label >Dễ dàng thành thạo tiếng anh</label>
		</div>
		<div class="noidungchinh">
			<div class="cot mot">
				<div class="sotiennap">
					<h5>Số tiền nạp</h5>
					<div class="hang mot">
						<button class="tien" type="button" onclick="nhaptienFunction(event)">10000</button>
						<button class="tien" type="button" onclick="nhaptienFunction(event)">20000</button>
						<button class="tien" type="button" onclick="nhaptienFunction(event)">50000</button>
						<button class="tien" type="button" onclick="nhaptienFunction(event)">100000</button>
					</div>
					<div class="hang hai">
						<button class="tien" type="button" onclick="nhaptienFunction(event)">200000</button>
						<button class="tien" type="button" onclick="nhaptienFunction(event)">500000</button>
						<button class="khac" type="button" onclick="nhaptienkhacFunction(event)">Số khác</button>
					</div>
					<div id="nhaptienkhac" class="sotienkhac">
						<span>VND</span>
						<input id="tienkhac" onclick="NhapTienKhac()"  type="number" class="tienkhac" name="" min="0" max = "10000000" placeholder ="Nhập số tiền khác">
					</div>
					<div class="khuyenmai">
						<h5>Mã khuyến mãi</h5>
						<div class="nhapma">
							<input type="text" name="" placeholder="Nhập mã">
							<button type="button">Kiểm tra</button>
						</div>
					</div>
					<div class="phuongthuctt">
						<h5>Phương Thức thanh toán</h5>
						<div class="nhapma">
							
							<label for ="chuyenkhoan"><img src="img/iconbank.png">Chuyển khoản ngân hàng</label>
							<input type="radio" id="chuyenkhoan" name="" checked>
						</div>
						<div class="qr">
							<img style="height: 300px" class="qr-code" src="img/qr-code.jpg" alt="">
			                <div class="qr-description">
			                    <p>Ghi rõ nội dung chuyển khoản </p>
			                    <p>Hovaten-sodienthoai-noidungck</p>
			                    <p>Ví dụ: NguyenVanA-0888666555-Naptien</p>
			                    <p><span style="color:red">Chú ý:</span> Chuyển khoản xong hãy chọn số tiền và ấn "Thanh toán"</p>
			                </div>
						</div>
					</div>
				</div>
			</div>
			<div class="cot hai">
				<div class="ttnaptien">
					<h5>Thông tin nạp tiền</h5>
					<div class="dong">
						<p>Tạm tính</p>
						<p name="sotien" id="sotien">0 VND</p>
					</div>
					<div class="dong">
						<p>Phí nạp tiền</p>
						<p>0 VND</p>
					</div>
					<form method = "post">
						<div class="dong">
							<p>Tổng</p>
							<input type="text" id="tongtien2" name="tongtien" style="color: #65af54;border:none;font-size:13pt;">
							<p style="color: #65af54;">VND</p>
						</div>
						<!-- <button type="button" class="">Thanh toán</button> -->
						<input type="submit" name="submit" value="Thanh toán">
					</form>
				</div>
				<div class="warning">
						<h5><img src="img/warning.png">Chú ý!</h5>
						<ul>
							<li>Số tiền trong ví bạn nhận được có thể lớn hơn hoặc ít hơn một chút so với dự kiến ​​do sự điều chỉnh trong chuyển khoản ngân hàng quốc tế và tỷ giá hối đoái tiền tệ được quy định.</li>
							<li>Chuyển khoản Ngân hàng phải bao gồm THÔNG TIN TÀI KHOẢN. Đảm bảo nhập đúng cú pháp EMAIL_SỐ TIỀN trong phần "Ghi chú" khi thao tác Chuyển khoản Ngân hàng. Nếu bạn không cung thông tin tài khoản tham chiếu, giao dịch của bạn không thể được xử lý. Chúng tôi không chịu trách nhiệm cho các khoản thanh toán được thực hiện mà không có thông tin ghi chú.</li>
						</ul>
							
									
				</div>
			</div>
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
		function nhaptienFunction(viw){
			var i,tien;
			tien = document.getElementsByClassName("tien");
			khac = document.getElementsByClassName("khac");
			for( i = 0 ; i < tien.length ; i++){
				tien[i].className = tien[i].className.replace(" active","");
			}
			for( i = 0 ; i < khac.length ; i++){
				khac[i].className = khac[i].className.replace(" active","");
			}
			viw.currentTarget.className += " active";
			document.getElementById("sotien").innerHTML = viw.currentTarget.innerHTML +" VND";
			document.getElementById("tongtien2").value = viw.currentTarget.innerHTML;
			document.getElementById("nhaptienkhac").style.display="none";
		}
		function nhaptienkhacFunction(viw){
			var i,khac,tien;
			tien = document.getElementsByClassName("tien");
			khac = document.getElementsByClassName("khac");
			for( i = 0 ; i < tien.length ; i++){
				tien[i].className = tien[i].className.replace(" active","");
			}

			viw.currentTarget.className += " active";
			document.getElementById("nhaptienkhac").style.display="block";

		}
		function NhapTienKhac(){
			let inputValue = document.getElementById("tienkhac").value;
			if(inputValue != null){
				document.getElementById("sotien").innerHTML = inputValue + " VND";
				document.getElementById("tongtien2").value = inputValue;
			}
		}
		
	</script>
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


