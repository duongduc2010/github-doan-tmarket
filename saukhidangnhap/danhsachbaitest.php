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
		$vitien = $items['vitien'];
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

	//Lấy lịch sử làm bài tập
	if(empty($_POST['submit'])){
			$sql_kq = "SELECT baikiemtra.tenbaitap,theloaikhoahoc.tenkhoahoc,ketqualambaitap.*
							FROM ketqualambaitap,baikiemtra,khoahocgiaovien,theloaikhoahoc
							WHERE ketqualambaitap.idbaikiemtra = baikiemtra.id
							and baikiemtra.idkhoahoc = khoahocgiaovien.id
							and khoahocgiaovien.theloaikhoahocid = theloaikhoahoc.id
							and ketqualambaitap.idhocvien = '$iduser'";
			$stmt_kq = $conn->prepare($sql_kq);
			$query_kq = $stmt_kq->execute();
			$result_kq = array();
			while($row_kq = $stmt_kq->fetch(PDO::FETCH_ASSOC)){
				$result_kq[] = $row_kq;
			}
			$sodapandung = 0;
			$tongsocau = 0;
			foreach ($result_kq as $items) {
				$ketqua = explode('/',$items['ketqua']);
				$dapandung = $ketqua['0'];
				$socau = $ketqua['1'];
				$sodapandung = $sodapandung+$dapandung;
				$tongsocau = $tongsocau + $socau;
			}
			if($tongsocau != 0){
				$kqtb = $sodapandung/$tongsocau;
				$kqtb = round($kqtb, 3);
			}
			else{
				$tongsocau=1;
				$kqtb = $sodapandung/$tongsocau;
				$kqtb = round($kqtb, 3);
			}
			
	}
	else{
		$timkiem = $_POST['timkiem'];
		$sql_kq = "SELECT baikiemtra.tenbaitap,theloaikhoahoc.tenkhoahoc,ketqualambaitap.*
							FROM ketqualambaitap,baikiemtra,khoahocgiaovien,theloaikhoahoc
							WHERE ketqualambaitap.idbaikiemtra = baikiemtra.id
							and baikiemtra.idkhoahoc = khoahocgiaovien.id
							and khoahocgiaovien.theloaikhoahocid = theloaikhoahoc.id
							and ketqualambaitap.idhocvien = '$iduser'
							and baikiemtra.tenbaitap LIKE '%$timkiem%'";
		$stmt_kq = $conn->prepare($sql_kq);
		$query_kq = $stmt_kq->execute();
		$result_kq = array();
		while($row_kq = $stmt_kq->fetch(PDO::FETCH_ASSOC)){
			$result_kq[] = $row_kq;
		}
		$sodapandung = 0;
		$tongsocau = 0;
		foreach ($result_kq as $items) {
			$ketqua = explode('/',$items['ketqua']);
			$dapandung = $ketqua['0'];
			$socau = $ketqua['1'];
			$sodapandung = $sodapandung+$dapandung;
			$tongsocau = $tongsocau + $socau;
		}
		$kqtb = $sodapandung/$tongsocau;
		$kqtb = round($kqtb, 3);
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
    <link rel="stylesheet" type="text/css" href="style/dsbt.css">
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
			<div style="margin-bottom: 100px;height: auto;" class="cot hai">
				<h2>Bài test đã làm</h2>
				<div class="timkiem">
					<form method="post">
						<label>Tìm kiếm</label>
						<input type="text" name="timkiem" placeholder="Nhập tên bài tập ">
						<input type="submit" name="submit" value="Tìm">
					</form>
					<h4>Kết quả trung bình: <?php echo $kqtb?> ( <?php echo $sodapandung?>/<?php echo $tongsocau?> )</h4>
				</div>
				
				<div class="dskh">
					<table class="table table-inverse">
						<thead>
							<tr>
								<th>STT</th>
								<th>Tên bài tập</th>
								<th>Tên khóa học</th>
								<th>Kết quả</th>
								<th>Thời gian</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; foreach ($result_kq as $items): ?>
								<tr>
									<td><?php echo $i?></td>
									<td><?php echo $items['tenbaitap']?></td>
									<td><?php echo $items['tenkhoahoc']?></td>
									<td><?php echo $items['ketqua']?></td>
									<td>
										<?php
										$thoigian = $items['thoigian'];
										echo date("d-m-Y",strtotime($thoigian));
										?></td>
									<td><a href="chitietketqua.php?id=<?php echo $iduser?>&&idketqua=<?php echo $items['id']?>">Chi tiết</a></td>
								</tr>
							<?php $i++; endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
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
					<a href="danhsachbaitest.php?pageNum=<?id=<?php echo $iduser?>&&php echo $pagePrev?>"> < </a>
				<?php }?>
				<?php for($i=$from;$i<=$to;$i++){?>
					<?php if($i==$pageNum){?>
						<a class="active" href="danhsachbaitest.php?id=<?php echo $iduser?>&&pageNum=<?php echo $i?>"><?php echo $i?></a>
					<?php } else {?>
						<a href="danhsachbaitest.php?id=<?php echo $iduser?>&&pageNum=<?php echo $i?>"><?php echo $i?></a>
	        		<?php }?>
	        	<?php }?>
	        	<?php if($pageNum<$tongSoTrang){?>
					<a href="danhsachbaitest.php?id=<?php echo $iduser?>&&pageNum=<?php echo $pageNext?>"> > </a>
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


