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
		$img_2 = $items['image'];
	}
	//Submit_back
	$tlgv = $_GET['tlgv'];
	$ho = $_GET['ho'];
	$ten = $_GET['ten'];
	$ngaysinh = $_GET['ngaysinh'];
	$quocgia = $_GET['quocgia'];
	$gioitinh = $_GET['gioitinh']; 
	$sdt = $_GET['sdt']; 
	$linkhoc = $_GET['linkhoc'];
	$diachi = $_GET['diachi'];
	$email = $_GET['email'];
	$ccdh = $_GET['ccdh'];
	$img = $_GET['anhprofile'];
	if(!empty($_POST['submit_back'])){
		header("location:trothanhgiaovienbuoc1.php?id=$iduser&&tlgv=$tlgv");
	}	
	//Submit next
	if(isset($_POST['submit_next'])){
		include("randomstring.php");
        $seo = generate_string($permitted_chars, 5);
        $duongdanluu = "../teacher/video/".$iduser."1".$seo.".mp4";
        $video = $iduser."1".$seo.".mp4";
        move_uploaded_file($_FILES["video"]["tmp_name"],$duongdanluu);

        $seo = generate_string($permitted_chars, 5);
        $duongdanluu = "../teacher/img/idcard/".$iduser."1".$seo.".jpg";
        $anh1 = $iduser."1".$seo.".jpg";
        move_uploaded_file($_FILES["anh1"]["tmp_name"],$duongdanluu);

        $seo = generate_string($permitted_chars, 5);
        $duongdanluu = "../teacher/img/idcard/".$iduser."1".$seo.".jpg";
        $anh2 = $iduser."1".$seo.".jpg";
        move_uploaded_file($_FILES["anh2"]["tmp_name"],$duongdanluu);

        $seo = generate_string($permitted_chars, 5);
        $duongdanluu = "../teacher/img/chungchi/".$iduser."1".$seo.".jpg";
        $anh3 = $iduser."1".$seo.".jpg";
        move_uploaded_file($_FILES["anh3"]["tmp_name"],$duongdanluu);

        $seo = generate_string($permitted_chars, 5);
        $duongdanluu = "../teacher/img/chungchi/".$iduser."1".$seo.".jpg";
        $anh4 = $iduser."1".$seo.".jpg";
        move_uploaded_file($_FILES["anh4"]["tmp_name"],$duongdanluu);

        $seo = generate_string($permitted_chars, 5);
        $duongdanluu = "../teacher/img/congcudayhoc/".$iduser."1".$seo.".jpg";
        $anh5 = $iduser."1".$seo.".jpg";
        move_uploaded_file($_FILES["anh5"]["tmp_name"],$duongdanluu);

        $seo = generate_string($permitted_chars, 5);
        $duongdanluu = "../teacher/img/congcudayhoc/".$iduser."1".$seo.".jpg";
        $anh6 = $iduser."1".$seo.".jpg";
        move_uploaded_file($_FILES["anh6"]["tmp_name"],$duongdanluu);

        $seo = generate_string($permitted_chars, 5);
        $duongdanluu = "../teacher/img/congcudayhoc/".$iduser."1".$seo.".jpg";
        $anh7 = $iduser."1".$seo.".jpg";
        move_uploaded_file($_FILES["anh7"]["tmp_name"],$duongdanluu);

        $seo = generate_string($permitted_chars, 5);
        $duongdanluu = "../teacher/img/congcudayhoc/".$iduser."1".$seo.".jpg";
        $anh8 = $iduser."1".$seo.".jpg";
        move_uploaded_file($_FILES["anh8"]["tmp_name"],$duongdanluu);

		if(isset($_POST['checkboxmot']) && isset($_POST['checkboxhai'])  && !empty($_POST['gth1']) && !empty($_POST['gth2']) && !empty($_POST['gth3'])){
			$gth1=$_POST['gth1'];
			$gth2=$_POST['gth2'];
			$gth3=$_POST['gth3'];
			header("location:trothanhgiaovienbuoc3.php?id=$iduser&&tlgv=$tlgv&&ho=$ho&&ten=$ten&&ngaysinh=$ngaysinh&&quocgia=$quocgia&&gioitinh=$gioitinh&&sdt=$sdt&&linkhoc=$linkhoc&&diachi=$diachi&&email=$email&&gth1=$gth1&&gth2=$gth2&&gth3=$gth3&&ccdh=$ccdh&&img=$img&&video=$video&&anh1=$anh1&&anh2=$anh2&&anh3=$anh3&&anh4=$anh4&&anh5=$anh5&&anh6=$anh6&&anh7=$anh7&&anh8=$anh8");
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
    
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/becometc2.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
	<title>Trở thành giáo viên bước 2</title>
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
						<img src="<?php echo $img_2?>">
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
		<div class="slogan">
			<label >Dễ dàng thành thạo tiếng anh</label>
		</div>
		<form method="post" enctype="multipart/form-data">
			<div class="chitiet">
				<div class="content">
		            <div class="content-container">
		                <div class="title">Update your information</div>
		                <div class="box-step">
		                    <img src="./img/Subtract2.png" alt="" class="step">
		                    <img src="./img/Subtract.png" alt="" class="step">
		                    <img src="./img/Subtract2.png" alt="" class="step">
		                    <img src="./img/Subtract2.png" alt="" class="step">
		                </div>
		        	</div>
		        </div>
				 <h4>Choose your video</h4>
				 <h6 style="color: #ff0202;">Note</h6>
				 <div class="ds mot">
				 	<label>Before updating your video</label>
				 	<ul>
					 	
					 	<li>By sending your video to Tmarket,You have agreed with our Terms and Policies.</li>
					 	<li>Make sure not to violate others’ privacy and copyrights.</li>
					 	<li>The maximum of file size is 500MB</li>
					 	<li>Best quality with aspect ratio of 16:9.</li>
					 	<li>Read the <span style="color:#65af54">Requirements for introduction video</span> before uploading your video.</li>
					 </ul>
				 </div>
				 <div class="ds hai">
				 	<label>Your video must follow these features:</label>
				 	<ul>
					 	
					 	<li>It shows that you speak English fluently</li>
					 	<li>It’s filmed horizontally</li>
					 	<li>1-4 minutes</li>
					 	<li>Clear image and sound</li>
					 	<li>Not include your personal contact information and other advertisements</li>
					 </ul>
				 </div>
				 <h6><span style="color: #ff0202;">Compulsory: </span>Teachers must update an introduction video</h6>
				 <div class="themvideo">
				 	<div class="video">
				 		<img src="img/iconvideo.png">
				 		<label>Insert video</label>
				 	</div>
				 	<label style="margin-top: 12px;display: flex;justify-content: center;font-size: 12pt; "><input type="file" required id="images" name="video" accept="video/mp4,video/x-m4v,video/*" data-text="Chọn video"></label>


				 </div>
				 <div class="dieukhoan">
				 	<div class="checkmot">
				 		<input value="1" id="checkboxmot" type="checkbox" name="checkboxmot">
						<label >I have a webcam and I can provide video lessons.</label>
				 	</div>
				 	<div class="checkhai">
				 		<input value="2" id="checkboxhai" type="checkbox" name="checkboxhai">
						<label >I agree that if my video does not follow Tmarket’s policy, my application can be rejected. To guarantee Tmarket’s accessibility and visibility to all students regardless of locations and places, I agree to let Tmarket to upload my videos to Tmarket’s official channels on the third site’s online storage and livestream services, like Youtube, Vimeo, and Youku ..., </label>
				 	</div>
				</div>
				<div class="thongtingioithieu">
					<h4>Teacher’s introduction</h4>
					<h6>Note: You cannot add other links or use offensive phrases in your introduction</h6>
					<label>About me*</label>
					<br>
					<textarea name="gth1" placeholder="About me"></textarea>
					<br>
					<label>Me as a teacher*</label>
					<br>
					<textarea name="gth2" placeholder="Me as a teacher"></textarea>
					<br>
					<label>Learning courses and my teaching style*</label>
					<br>
					<textarea name="gth3" placeholder="Learning courses and my teaching style"></textarea>
					<div class="bangcap">
						<label>Certificates and relevant documents*</label>
						<div class="caccot mot">
							<div class="cot mot">
								<img src="img/Vector-add.png">
								<br>
								<label>Front side of ID card *</label>
								<input type="file" required id="images" name="anh1" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot hai">
								<img src="img/Vector-add.png">
								<br>
								<label>Back side of ID card *</label>
								<input type="file" required id="images" name="anh2" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot ba">
								<img src="img/Vector-add.png">
								<br>
								<label>English Language Certificates *</label>
								<input type="file" required id="images" name="anh3" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot bon">
								<img src="img/Vector-add.png">
								<br>
								<label>Add more your certificates</label>
								<input type="file" required id="images" name="anh4" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
						</div>
						<label>Teaching tools</label>
						<div class="caccot hai">
							<div class="cot mot">
								<img src="img/Vector-add.png">
								<br>
								<label>Computer</label>
								<input type="file" required id="images" name="anh5" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot hai">
								<img src="img/Vector-add.png">
								<br>
								<label>Laptop</label>
								<input type="file" required id="images" name="anh6" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot ba">
								<img src="img/Vector-add.png">
								<br>
								<label>Headphones/ Earphones</label>
								<input type="file" required id="images" name="anh7" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot bon">
								<img src="img/Vector-add.png">
								<br>
								<label>Camera</label>
								<input type="file" required id="images" name="anh8" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
						</div>
					</div>
				</div>
				<div class="button">
					<input class="btn" type="submit" name="submit_back" value="Back">
					<input class="btn" type="submit" name="submit_next" value="Next">
				</div>
			</div>
		</form>
		
		
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
<script>
		function menuFunction(x) {
			x.classList.toggle("change");
		  document.getElementById("myDropdown").classList.toggle("show");
		}
</script>
