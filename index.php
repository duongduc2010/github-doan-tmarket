<?php
	include("./user/connect.php");
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

	if(isset($_POST['submit'])){
		if(!empty($_POST['ten']) && !empty($_POST['email']) && !empty($_POST['sodienthoai']) && !empty($_POST['noidung'])){
			$ten = $_POST['ten'];
			$email = $_POST['email'];
			$sodienthoai = $_POST['sodienthoai'];
			$noidung = $_POST['noidung'];
			$sql = "INSERT INTO donggopykien(hoten,sodienthoai,email,ykiendonggop) VALUES('$ten','$sodienthoai','$email','$noidung')";
			$stmt  = $conn->prepare($sql);
			$query = $stmt->execute();
			if($query){
				header("location:index.php");
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
	<link rel="stylesheet" type="text/css" href="./user/css/bootstrap.min.css">
	<script type="text/javascript" href = "./user/js/bootstrap.min.js"></script>
	<script type="text/javascript" href = "./user/js/jquery-3.6.2.slim.js"></script>
    <link rel="stylesheet" type="text/css" href="./user/style/index.css">
    <link rel="stylesheet" type="text/css" href="./user/style/header.css">
    <link rel="stylesheet" type="text/css" href="./user/style/footer.css">
	<title>Trang chủ</title>
</head>
<body>
	<header>
		<div class="menu container">
            <a class="logo" href="index.php">
                <img class="logo-market" src="./user/img/logo-market.png">
            </a>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="./user/timgiaovien.php">Tìm giáo viên</a></li>
                <li class="nav-item"><a class="nav-link" href="./user/trothanhgiaovien.php">Trở thành giáo viên</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Hướng dẫn</a>
                    <ul class="sub-menu">
                        <li><a href="./user/huongdanwithgv.php">Hướng dẫn đối với giáo viên</a></li>
                        <li><a href="./user/huongdanwithhv.php">Hướng dẫn đối với học viên</li>
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
		<div class="timgv">
			<a href="./user/timgiaovien.php">
				<input type="submit" name="" value="Tìm giáo viên">
			</a>
			<img src="./user/img/anh banner.jpg">
		</div>
		<div class="muonhoc">
			<h1>TÔI MUỐN HỌC</h1>
			<ul class="nav">
				<li class="nav-item">
					<a class="nav-link" href="#">Tiếng Anh Giao Tiếp</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Tiếng Anh Văn Phòng</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Tiếng Anh Trẻ Em</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Tiếng Anh Thiếu Niên</a>
				</li>
			</ul>
		</div>
		<div class ="dsgv">
			<div class="gv">
				<?php foreach ($data as $row): ?>
					<div class="giaovien">
						<h6><img src="./teacher/<?php echo $row['imgprofile']?>">           <?php echo $row['hoten']?></h6>
						<h7><?php echo $row['tentl']?></h7>
						<br>
						<h7>Đến từ <?php echo $row['tenqg']?></h7>
						<br>
						<video width="330" height="200" controls>
						  <source src="./teacher/<?php echo $row['video']?>" type="video/mp4">
						</video>
						<ul>
							<li class="cot1">3⭐⭐⭐</li>
							<li class="cot2"><a href="dangnhap.php">Xem chi tiết</a></li>
						</ul>
					</div>
				<?php endforeach ?>
			</div>
			<div class="product__pagination">
				<?php if($pageNum>1){?>
					<a href="index.php?pageNum=<?php echo $pagePrev?>"> < </a>
				<?php }?>
				<?php for($i=$from;$i<=$to;$i++){?>
					<?php if($i==$pageNum){?>
						<a class="active" href="index.php?pageNum=<?php echo $i?>"><?php echo $i?></a>
					<?php } else {?>
						<a href="index.php?pageNum=<?php echo $i?>"><?php echo $i?></a>
	        		<?php }?>
	        	<?php }?>
	        	<?php if($pageNum<$tongSoTrang){?>
					<a href="index.php?pageNum=<?php echo $pageNext?>"> > </a>
				<?php }?>
	        </div>
		</div>
		<div class="cacbuocsd">
			<h1>CÁC BƯỚC SỬ DỤNG TMARKET</h1>
			<img src="./user/img/hdsd.jpg">

		</div>
		<div class="huongdansd">
			<h1>HƯỚNG DẪN SỬ DỤNG</h1>
			<div class="danhcho">
				<div class="hocvien">
					<h6>DÀNH CHO HỌC VIÊN</h6>
					<div class="vien"></div>
					<p>Tmarket là nền tảng kết nối giữa Giáo viên và Học viên có nhu cầu học Ngoại ngữ, thông qua các lớp học trực tuyến với mô hình học 1 Thầy-1 Trò hoặc 1 Thầy-1 nhóm và lớp học được thực hiện trên nền tảng Zoom, Google meet, …</p>
					<div class="nut">
						<a class="ct" href="./user/huongdanwithhv.php">Xem chi tiết</a>
						<a class="vd" href="#">Xem video</a>
					</div>

				</div>
				<div class="giaovien">
					<h6>DÀNH CHO GIÁO VIÊN</h6>
					<div class="vien"></div>
					<p>Tmarket là nền tảng kết nối giữa Giáo viên và Học viên có nhu cầu học Ngoại ngữ, thông qua các lớp học trực tuyến với mô hình học 1 Thầy-1 Trò hoặc 1 Thầy-1 nhóm và lớp học được thực hiện trên nền tảng Zoom, Google meet, …</p>
					<div class="nut">
						<a class="ct" href="./user/huongdanwithgv.php">Xem chi tiết</a>
						<a class="vd" href="#">Xem video</a>
					</div>
				</div>
			</div>
		</div>

		<div class="vechungtoi">
			<h1>VỀ CHÚNG TÔI</h1>
			<p>Tmarket là nền tảng kết nối giữa Giáo viên và Học viên có nhu cầu học Ngoại ngữ, thông qua các lớp học trực tuyến với mô hình học 1 Thầy-1 Trò hoặc 1 Thầy-1 nhóm và lớp học được thực hiện trên nền tảng Zoom, Google meet, … Ở đây Bạn có thể tự do lựa chọn Giáo viên sau khi xem tất cả thông tin như: Video giới thiệu để biết được ngoại hình và giọng nói , xem đánh giá và nhận xét mà học viên cũ đã để lại. Số lượng bài học, Học viên mà Giáo viên đã dạy để biết được kinh nghiệm của Giáo viên ra sao, bạn có thể tự do lựa chọn mức học phí, chương trình học, thời gian bạn muốn học và sau cùng bạn có thể đi đến quyết định học thử với Giáo viên bất kỳ trước khi đi đến quyết định đăng ký khóa học chính thức.</p>
			<div class="soluong">
				<div class="cot">
					<h2>40 000 +</h2>
					<h6>GIÁO VIÊN</h6>
				</div>
				<div class="cot">
					<h2>100 000 +</h2>
					<h6>HỌC VIÊN</h6>
				</div>
				<div class="cot">
					<h2>2</h2>
					<h6>NGÔN NGỮ</h6>
				</div>
			</div>
		</div>

		<div class="baihoctgv">
			<div class="hang">
				<div class="gth1">
					<h2>BÀI HỌC 1 THẦY KÈM 1 TRÒ HOẶC 1 THẦY KÈM 1 NHÓM</h2>
					<p>Học với những giáo viên được chứng nhận với các kinh nghiệm đã được chứng minh</p>
					<p>Tự do lựa chọn chương trình học và thời gian bạn muốn học</p>
					<p>Bạn có thể tự lựa chọn mức học phí phù hợp</p>
					<a href="">Tìm giáo viên ⇾</a>
				</div>
				<img src="./user/img/1kem1.jpg">
			</div>
			<div class="hang">
				<img src="./user/img/lophoc.jpg">
				<div class="gth2">
					<h2>HƠN CẢ LỚP HỌC</h2>
					<p>Thực hiện đánh giá trình độ tiếng anh của bạn thông qua hệ thống bài kiểm tra của Tmarket</p>
					<p>Nhận được nhận xét và gợi ý để bạn chọn cấp độ học phù hợp</p>
					<p>Đặt mục tiêu thử thách bằng việc đăng ký khóa học và theo đến cuối khóa</p>
					<a href="">Tìm giáo viên ⇾</a>
				</div>
				
			</div>
		</div>
		<h2 class="chtg">CÂU HỎI THƯỜNG GẶP</h2>
		<div class="cauhoitg">
			<div class="cot1">
				<div class="cau1">
					<h6><img src="./user/img/QA.jpg">Bài học thử là gì</h6>
					<p>1. Để giúp học viên có cơ hội trải nghiệm với giáo viên bất kỳ trước khi đưa ra quyết định đăng ký khóa học chính thức với giáo viên đó.</p>
					<p>2. Các buổi học thử được Giáo viên cung cấp với giá ưu đãi.</p>
					<p>3. Với mỗi khóa học với Giáo viên mới, bạn sẽ được đăng ký học thử 1 buổi học thử.</p>
					<p>4. Bạn có thể tìm thấy các bài học thử trên mỗi khóa học mà bạn muốn đăng ký.</p>
				</div>
				<div class="cau2">
					<h6><img src="./user/img/QA.jpg">Khi nào và làm thế nào để khiếu nại một vấn đề của buổi học?</h6>
					<p>- Học viên có 1 tiếng kể từ khi buổi học kết thúc, để có thể khiếu nại vấn đề của buổi học và Giáo viên có 11 tiếng để phản hồi khiếu nại của học viên. Nếu học viên không khiếu nại thì buổi học sẽ được tự động xác nhận là đã hoàn thành sau 24 giờ kể từ thời gian kết thúc buổi học và phí bài học sẽ được chuyển cho Giáo viên.</p>
					<p>- Nếu có vấn đề với bài học của bạn, hãy đảm bảo bạn giữ liên lạc với Giáo viên của mình hoặc phản hồi tới Tmarket, để vấn đề được giải quyết kịp thời.</p>
				</div>
				<div class="cau3">
					<h6><img src="./user/img/QA.jpg">Làm thế nào để sử dụng bài học tức thời?</h6>
					<h7>Bài học tức thời là gì?</h7>
					<p>Bài học tức thời cho phép bạn bắt đầu bài học với giáo viên ngay lập tức! Sau khi mua Bài học tức thời, bạn sẽ có thể bắt đầu học trong vòng 5 phút.</p>
					<h7>Những điều bạn nên biết về Bài học tức thì:</h7>
					<p>- Bài học tức thì hiện chỉ có sẵn cho các bài học thử 30 phút. Các bài học này được tự động chấp nhận và bắt đầu sau 5 phút kể từ khi mua.</p>
					<p>- Nếu bạn có bài học sắp tới trong vòng 40 phút tới, bạn không thể đặt Bài học tức thì.</p>
					<p>- Bạn phải vào bài học tức thời đúng giờ và bài học tức thời của bạn không thể bị hủy hoặc lên lịch lại.</p>
				</div>
			</div>
			<div class="cot2">
				<div class="cau1">
					<h6><img src="./user/img/QA.jpg">Bài học thử là gì</h6>
					<p>1. Để giúp học viên có cơ hội trải nghiệm với giáo viên bất kỳ trước khi đưa ra quyết định đăng ký khóa học chính thức với giáo viên đó.</p>
					<p>2. Các buổi học thử được Giáo viên cung cấp với giá ưu đãi.</p>
					<p>3. Với mỗi khóa học với Giáo viên mới, bạn sẽ được đăng ký học thử 1 buổi học thử.</p>
					<p>4. Bạn có thể tìm thấy các bài học thử trên mỗi khóa học mà bạn muốn đăng ký.</p>
				</div>
				<div class="cau2">
					<h6><img src="./user/img/QA.jpg">Khi nào và làm thế nào để khiếu nại một vấn đề của buổi học?</h6>
					<p>- Học viên có 1 tiếng kể từ khi buổi học kết thúc, để có thể khiếu nại vấn đề của buổi học và Giáo viên có 11 tiếng để phản hồi khiếu nại của học viên. Nếu học viên không khiếu nại thì buổi học sẽ được tự động xác nhận là đã hoàn thành sau 24 giờ kể từ thời gian kết thúc buổi học và phí bài học sẽ được chuyển cho Giáo viên.</p>
					<p>- Nếu có vấn đề với bài học của bạn, hãy đảm bảo bạn giữ liên lạc với Giáo viên của mình hoặc phản hồi tới Tmarket, để vấn đề được giải quyết kịp thời.</p>
				</div>
				<div class="cau3">
					<h6><img src="./user/img/QA.jpg">Làm thế nào để sử dụng bài học tức thời?</h6>
					<h7>Bài học tức thời là gì?</h7>
					<p>Bài học tức thời cho phép bạn bắt đầu bài học với giáo viên ngay lập tức! Sau khi mua Bài học tức thời, bạn sẽ có thể bắt đầu học trong vòng 5 phút.</p>
					<h7>Những điều bạn nên biết về Bài học tức thì:</h7>
					<p>- Bài học tức thì hiện chỉ có sẵn cho các bài học thử 30 phút. Các bài học này được tự động chấp nhận và bắt đầu sau 5 phút kể từ khi mua.</p>
					<p>- Nếu bạn có bài học sắp tới trong vòng 40 phút tới, bạn không thể đặt Bài học tức thì.</p>
					<p>- Bạn phải vào bài học tức thời đúng giờ và bài học tức thời của bạn không thể bị hủy hoặc lên lịch lại.</p>
				</div>
			</div>
		</div>
		<a href="./user/cauhoithuonggap.php"><input id="chtg" type="submit" name="" value="HIỂN THỊ THÊM"></a>
		
		<div class="gopy">
			<div class="feedback">
				<form method ="post">
					<label>Góp ý về chúng tôi</label>
					<fieldset class="form-group">
						<input name="ten" type="text" class="form-control"  placeholder="Tên của bạn">
					</fieldset>
					<fieldset class="form-group">
						
						<input name="sodienthoai" type="text" class="form-control"  placeholder="Số điện thoại">
					</fieldset>
					<fieldset class="form-group">
						<input name="email" type="text" class="form-control"  placeholder="Email">
					</fieldset>
					<fieldset class="form-group">
						<textarea name="noidung" class="form-control" placeholder="Nội dung góp ý"></textarea>
					</fieldset>
					<input name="submit" type="submit" class="submit"  value="GỬI GÓP Ý">
				</form>
				<img src="./user/img/feedback.jpg">
			</div>
			<img src="./user/img/green-background.jpg">
		</div>
	</div>
	
	<footer >
			<div class="footer-distributed">
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


