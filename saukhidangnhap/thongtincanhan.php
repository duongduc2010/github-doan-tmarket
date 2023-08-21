<?php
	include('../user/connect.php');
	$iduser = $_GET['id'];
	session_start();
	if (!isset($_SESSION['taikhoan'])) {
		header("location:../user/index.php");
	}
	//Trc khi cập nhật
	$sql_1 = "SELECT * FROM taikhoan WHERE taikhoan.id='$iduser'";
	$stmt_1 = $conn->prepare($sql_1);
	$query_1 = $stmt_1->execute();
	$result_1=array();
	while($row_1=$stmt_1->fetch(PDO::FETCH_ASSOC)){
		$result_1[] = $row_1;
	}
	foreach ($result_1 as $items) {
		$hoten = $items['hoten'];
		$img = $items['image'];
		$vitien = $items['vitien'];
	}

	//Sau khi cập nhật
	$sql = "SELECT taikhoan.* , quocgia.id as idqg ,quocgia.quocgia, gioitinh.id as idgt, gioitinh.gioitinh, timezone.id as idtz, timezone.ten  
		FROM taikhoan,quocgia,timezone,gioitinh 
		WHERE taikhoan.id='$iduser' 
		and quocgia.id = taikhoan.quocgia
		and timezone.id = taikhoan.timezone
		and gioitinh.id = taikhoan.gioitinh";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();
	$result=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		$result[] = $row;
	}
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	foreach ($result as $items){
			$taikhoan = $items['taikhoan'];
			$diachi = $items['diachi'];
			$sdt = $items['sodienthoai'];
			$ngaysinh = $items['ngaysinh'];
			$email = $items['email'];
			$id_qg = $items['idqg'];
			$quocgia = $items['quocgia'];
			$id_gt = $items['idgt'];
			$gioitinh = $items['gioitinh'];
			$id_tz = $items['idtz'];
			$timezone = $items['ten'];
	}

	$tachchuoi_hoten = explode(' ', $hoten);
	$ho = $tachchuoi_hoten[0];
	$ten = $tachchuoi_hoten[1];
	//Quốc gia
	$sql_quocgia = "SELECT * FROM quocgia";
	$stmt_quocgia = $conn->prepare($sql_quocgia);
	$query_quocgia = $stmt_quocgia->execute();
	$result_quocgia = array();
	while($row_quocgia = $stmt_quocgia->fetch(PDO::FETCH_ASSOC)){
		$result_quocgia[] = $row_quocgia;
	}
	// Giới tính
	$sql_gioitinh = "SELECT * FROM gioitinh";
	$stmt_gioitinh = $conn->prepare($sql_gioitinh);
	$query_gioitinh = $stmt_gioitinh->execute();
	$result_gioitinh = array();
	while($row_gioitinh = $stmt_gioitinh->fetch(PDO::FETCH_ASSOC)){
		$result_gioitinh[] = $row_gioitinh;
	}
	// Time zone
	$sql_timezone = "SELECT * FROM timezone";
	$stmt_timezone = $conn->prepare($sql_timezone);
	$query_timezone = $stmt_timezone->execute();
	$result_timezone = array();
	while($row_timezone = $stmt_timezone->fetch(PDO::FETCH_ASSOC)){
		$result_timezone[] = $row_timezone;
	}

	//Cập nhật thông tin
	if(isset($_POST['submit'])){
		if(isset($_POST['ho']) && isset($_POST['ten']) && isset($_POST['ngaysinh']) && isset($_POST['quocgia']) && isset($_POST['gioitinh']) && isset($_POST['timezone']) && isset($_POST['diachi']) && isset($_POST['sdt']) && isset($_POST['email'])){
			$ho_capnhat = $_POST['ho'];
			$ten_capnhat = $_POST['ten'];
			$ngaysinh = $_POST['ngaysinh'];
			$quocgia = $_POST['quocgia'];
			$gioitinh = $_POST['gioitinh'];
			$timezone = $_POST['timezone'];
			$diachi = $_POST['diachi'];
			$sdt = $_POST['sdt'];
			$email = $_POST['email'];
			// Nối chuỗi họ và tên
		    $my_string1 = "$ho_capnhat";
			var_dump($my_string1);
			$my_string2 = " $ten_capnhat";
			var_dump($my_string2);
			$hoten_capnhat = $my_string1 . $my_string2;

			

			$sql_capnhat = "UPDATE taikhoan SET hoten='$hoten_capnhat',ngaysinh='$ngaysinh',quocgia='$quocgia',gioitinh ='$gioitinh',timezone='$timezone',diachi='$diachi',sodienthoai='$sdt',email='$email' WHERE id='$iduser'";
			$stmt_capnhat = $conn->prepare($sql_capnhat);
			$query_capnhat = $stmt_capnhat->execute();
			if($query_capnhat){
				header("location:thongtincanhan.php?id=$iduser");
			}
			else{
				echo "Cập nhật không thành công";
			}
		}
		if(!file_exists($_FILES['anh']['tmp_name']) || !is_uploaded_file($_FILES['anh']['tmp_name'])){
			echo "Không có  ảnh";
		}	
		else{
			include("randomstring.php");
			$seo = generate_string($permitted_chars, 5);
			$anh = "./photo/".$iduser."1".$seo.".jpg";
    		move_uploaded_file($_FILES["anh"]["tmp_name"],$anh);
    		$sql_capnhat = "UPDATE taikhoan SET image='$anh' WHERE id='$iduser'";
			$stmt_capnhat = $conn->prepare($sql_capnhat);
			$query_capnhat = $stmt_capnhat->execute();
			if($query_capnhat){
				header("location:thongtincanhan.php?id=$iduser");
			}
			else{
				echo "Cập nhật không thành công";
			}
		}
	}
	//Phân trang ds giáo viên
	$pageSize=3;
	$startRow=0;
	$pageNum = 1;
	if(isset($_GET['pageNum'])==true){
		$pageNum = $_GET['pageNum'];
	}
	$startRow = ($pageNum-1) * $pageSize;
	$sql = "SELECT giaovien.* ,theloaigiaovien.tentheloai as tentl ,quocgia.quocgia as tenqg
                FROM giaovien,theloaigiaovien,quocgia
                WHERE giaovien.theloaigiaovien = theloaigiaovien.id
                and giaovien.quocgia = quocgia.id LIMIT $startRow,$pageSize";
	$data = $conn->query($sql);

	$sql = "SELECT COUNT(*) FROM theloaikhoahoc";
	$kq = $conn->query($sql);
	$r = $kq->fetch();
	$tongSoRecord = $r[0];
	$tongSoTrang = ceil($tongSoRecord/$pageSize);

	$from = $pageNum-2; if($from < 1){ $from=1;}
	$to = $pageNum+2; if($to>$tongSoTrang){ $to=$tongSoTrang;}
	$pagePrev = $pageNum-1;
	$pageNext = $pageNum+1;
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
    <link rel="stylesheet" type="text/css" href="style/ttcn.css">
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

	<div id="content">
		<div class="slogan">
			<label >Dễ dàng thành thạo tiếng anh</label>
		</div>
		<div class="noidungchinh">
			<div class="cot mot">
				<img style="border-radius: 100px;" src="<?php echo $img?>">
				<p><?php echo $hoten?></p>
				<p>Đến từ</p>
				<p style="color: #65af54">Asia/Hai_Phong</p>
				<h5>Bài học tiếp theo</h5>
				<img src="img/Rectangle207.png">
				<div class="vi">
					<p class="cot1">Ví của tôi</p>
					<p class="cot2" style="color: #65af54"><?php echo number_format($vitien)?> VND</p>
				</div>
				<p style="margin: 0px 15px 30px 15px;">Số dư ví dùng để thanh toán các khoá học tại TMarket. Xin vui lòng nạp tiền trước khi mua các khoá học của chúng tôi!</p>
				<a class="napngay" href="naptien.php?id=<?php echo $iduser?>">Nạp ngay</a>
				<div class="hotro">
					<a href="cauhoithuonggap.php?id=<?php echo $iduser?>"><h4 style="font-weight: bold;">Hỗ trợ?</h4></a>
				</div>
				<div class="cauhoi mot">
					<a href="#"><p>Làm thế nào để sử dụng bài học tức thì để có một bài học ngay bây giờ?</p></a>
				</div>
				<div class="cauhoi hai">
					<a href="#"><p>Làm cách nào để thay đổi / đặt lại mật khẩu của tôi?</p></a>
				</div>
				<div class="cauhoi ba">
					<a href="#"><p>Tôi có thể sử dụng những phương thức thanh toán nào để thanh toán?</p></a>
				</div>
				<div class="dangxuat">
					<a href="dangxuat.php">Đăng xuất</a>
				</div>
				
			</div>
			<div class="cot hai">
				<h2>Thông tin cá nhân</h2>
				<div class="chitiet">
					<form method="post" enctype="multipart/form-data">
							 <img src="<?php echo $img?>"> 
							 <label>Hình ảnh</label>
                            <input type="file" id="images" name="anh" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">

							<div class="formchitiet">
							<div class="chitietcot mot">
									<fieldset class="form-group">
										<label for="ten">Tên</label>
										<input name="ten" value="<?php echo $ten?>" type="text" class="form-control" id="ten" placeholder="Tên">
									</fieldset>
									<fieldset class="form-group">
										<label for="ngaysinh">Ngày sinh</label>
										<input value="<?php echo $ngaysinh?>" name="ngaysinh" type="date" class="form-control" id="ngaysinh">
									</fieldset>
									<fieldset class="form-group">
										<label for="email">Email</label>
										<input value="<?php echo $email?>" name="email" type="text" class="form-control" id="email" placeholder="Email">
									</fieldset>
									<fieldset class="form-group">
										<label for="quocgia">Quốc gia</label>
										<select name="quocgia" id="quocgia" class="form-control" class="c-select">
											<option value="<?php echo $id_qg?>" selected><?php echo $quocgia?></option>
											<?php foreach ($result_quocgia as $items):?>
												<option value="<?php echo $items['id']?>"><?php echo $items['quocgia']?></option>
											<?php endforeach ?>
										</select>
									</fieldset>
									<fieldset class="form-group">
										<label for="diachi">Địa chỉ</label>
										<textarea name="diachi" style="height: 150px;" type="text" class="form-control" id="diachi" placeholder="Địa chỉ"><?php echo $diachi;?></textarea> 
									</fieldset>
							</div>
							<div class="chitietcot hai">
									<fieldset class="form-group">
										<label for="ho">Họ</label>
										<input name="ho" value="<?php echo $ho?>" type="text" class="form-control" id="ho" placeholder="Họ">
									</fieldset>
									<fieldset class="form-group">
										<label for="gioitinh">Giới tính</label>
										<select name="gioitinh" id="gioitinh" class="form-control" class="c-select">
											<option value="<?php echo $id_gt?>" selected><?php echo $gioitinh?></option>
											<?php foreach($result_gioitinh as $items):?>
												<option value="<?php echo $items['id']?>"><?php echo $items['gioitinh']?></option>
											<?php endforeach?>
										</select>
									</fieldset>
									<fieldset class="form-group">
										<label  for="sodt">Số điện thoại</label>
										<input value="<?php echo $sdt?>" name="sdt" type="text" class="form-control" id="sodt" placeholder="Số điện thoại">
									</fieldset>
									<fieldset class="form-group">
										<label for="timezone">Timezone</label>
										<select name="timezone" id="timezone" class="form-control" class="c-select">
											<option value="<?php echo $id_tz?>" selected><?php echo $timezone?></option>
											<?php foreach($result_timezone as $items):?>
												<option value="<?php echo $items['id'];?>"><?php echo $items['ten'];?></option>
											<?php endforeach?>
										</select>
									</fieldset>
							</div>
						</div>
						<input  class="capnhattt" type="submit" name="submit" value="Cập nhật thông tin">
					</form>
				</div>
			</div>
		</div>
		<!-- <div class="quatrinh">
			<div class="quatrinhhoctap">
				<h5>Quá trình học tập rèn luyện</h5>
				<div class="chitiet">
					<div class="cot mot">
						<h6 style="font-weight: bold;">Tổng khóa học</h6>
						<h6 style="font-size: 15pt;color: #65af54;font-weight: bold;">0</h6>
					</div>
					<div class="cot hai">
						<h6 style="font-weight: bold;">Bài học tiếp theo</h6>
						<h6 style="font-size: 15pt;color: #65af54;font-weight: bold;">0</h6>
					</div>
					<div class="cot ba">
						<h6 style="font-weight: bold;">Tổng các bài đã test</h6>
						<h6 style="font-size: 15pt;color: #65af54;font-weight: bold;">0</h6>
					</div>
				</div>
			</div>
			<div class="vicuatoi">
				<h5>Ví của tôi</h5>
				<div class="chitiet">
					<div class="cot mot">
						<h6 style="font-weight: bold;">Số tiền đã mua khoá học</h6>
						<h6 style="font-size: 15pt;color: #65af54;font-weight: bold;">0</h6>
					</div>
					<div class="cot hai">
						<h6 style="font-weight: bold;">Ví TMarket</h6>
						<h6 style="font-size: 15pt;color: #65af54;font-weight: bold;">0</h6>
					</div>
					<div class="cot ba">
						<h6 style="font-weight: bold;">Ví khuyến mại</h6>
						<h6 style="font-size: 15pt;color: #65af54;font-weight: bold;">0</h6>
					</div>
				</div>
			</div>
		</div> -->
		<div class="dsgv">
			
			<div class="tgv">
				<h2 style="font-weight: bold">Bài học tức thời</h2>
				<h5>Bạn muốn thực hiện một bài học ngay lúc này? Tìm giáo viên mà có sẵn ngay bây giờ và bắt đầu học!</h5>
			</div>
			<div class="gv">
				<?php foreach ($data as $row): ?>
					<div class="giaovien">
						<h6><img src="../teacher/<?php echo $row['imgprofile']?>">           <?php echo $row['hoten']?></h6>
						<h7><?php echo $row['tentl']?></h7>
						<br>
						<h7>Đến từ <?php echo $row['tenqg']?></h7>
						<br>
						<video width="330" height="200" controls>
						  <source src="../teacher/<?php echo $row['video']?>" type="video/mp4">
						</video>
						<ul>
							<li class="cot1">3⭐⭐⭐</li>
							<li class="cot2"><a href="chitietkhoahochv.php?id=<?php echo $iduser?>&&idgv=<?php echo $row['id']?>">Xem chi tiết</a></li>
						</ul>
					</div>
				<?php endforeach ?>
			</div>
			<div class="product__pagination">
	            <?php if($pageNum>1){?>
					<a href="thongtincanhan.php?pageNum=<?id=<?php echo $iduser?>&&php echo $pagePrev?>"> < </a>
				<?php }?>
				<?php for($i=$from;$i<=$to;$i++){?>
					<?php if($i==$pageNum){?>
						<a class="active" href="thongtincanhan.php?id=<?php echo $iduser?>&&pageNum=<?php echo $i?>"><?php echo $i?></a>
					<?php } else {?>
						<a href="thongtincanhan.php?id=<?php echo $iduser?>&&pageNum=<?php echo $i?>"><?php echo $i?></a>
	        		<?php }?>
	        	<?php }?>
	        	<?php if($pageNum<$tongSoTrang){?>
					<a href="thongtincanhan.php?id=<?php echo $iduser?>&&pageNum=<?php echo $pageNext?>"> > </a>
				<?php }?>
	        </div>
			<img class="bg" src="img/green-background.jpg">
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


