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
	$idkh = $_GET['idkh'];
	$idbkt = $_GET['idbkt'];
	//Danh sách câu hỏi
	$sql_cauhoi = "SELECT * FROM chitietbaikiemtra WHERE idbkt = '$idbkt'";
	$stmt_cauhoi = $conn->prepare($sql_cauhoi);
	$query_cauhoi = $stmt_cauhoi->execute();
	$result_cauhoi = array();
	while($row_cauhoi = $stmt_cauhoi->fetch(PDO::FETCH_ASSOC)){
		$result_cauhoi[] = $row_cauhoi;
	}
	//Kiểm tra kết quả
	$sql = "SELECT COUNT(*) FROM chitietbaikiemtra WHERE idbkt = '$idbkt'";
	$kq = $conn->query($sql);
	$r = $kq->fetch();
	$tongsocau = $r[0];
	$tongsocaudung = 0;
	
	if(isset($_POST['submit'])){
		for($i=0;$i<$tongsocau;$i++)
		{
			if(isset($_POST['chon'.$i]))
			{
				$value1 = $_POST['chon' . $i];
				$value2 = $result_cauhoi[$i]['dapandung'];
				if($value1 == $value2)
				{
					$tongsocaudung++;
				}
			}
		}
		//Lưu kết quả
		$sql_ketqua = "INSERT INTO ketqualambaitap(idbaikiemtra,idhocvien,ketqua) VALUES('$idbkt','$iduser','$tongsocaudung/$tongsocau')";
		$stmt_ketqua =$conn->prepare($sql_ketqua);
		$query_ketqua = $stmt_ketqua->execute();

		//Lưu chi tiết câu chọn
		$sql_maxid = "SELECT MAX(id) FROM ketqualambaitap";
		$kq_maxid = $conn->query($sql_maxid);
		$r = $kq_maxid->fetch();
		$idketqua = $r[0];
		for( $i = 0; $i < $tongsocau; $i++){


			$idcauhoi = $_POST['idcauhoi'.$i];
			$dapanchon = $_POST['chon' . $i];


			$sql_luu = "INSERT INTO chitietketqua(idketqua,idcauhoi,dapanchon) VALUES('$idketqua','$idcauhoi','$dapanchon')";
			$stmt_luu =$conn->prepare($sql_luu);
			$query_luu = $stmt_luu->execute();
		}
		if($query_ketqua){
			header("location:diemso.php?id=$iduser&&idkh=$idkh&&idbkt=$idbkt&&diemso=$tongsocaudung&&tong=$tongsocau");
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
    <link rel="stylesheet" type="text/css" href="style/chitietkhoahochv.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
    <link rel="stylesheet" type="text/css" href="style/lambaitap.css">
	<title>Chi tiết khóa học</title>
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
		<form method="post">
			<div class="question">
				<?php $i=0; foreach ($result_cauhoi as $items):?>
					<div class="text-question">
						<div class="text-question_id">Câu số <?php echo $i+1?></div>
						<div name="tencauhoi" class="text-question_content"><?php echo $items['tencauhoi']?></div>
						<input hidden type="text" name="idcauhoi<?php echo $i?>" value="<?php echo $items['STT']?>">
					</div>
					<div class="text-rep">
						<input  type="radio" name="chon<?php echo $i?>"  value="a">
						<input style="border:none" readonly  name="a<?php echo $i?>" type="text" placeholder="Nội dung câu trả lời" value="<?php echo $items['dapana']?>"><br>
						<input  type="radio" name="chon<?php echo $i?>"  value="b">
						<input style="border:none" readonly  name="b<?php echo $i?>" type="text" placeholder="Nội dung câu trả lời" value="<?php echo $items['dapanb']?>"><br>
						<input  type="radio" name="chon<?php echo $i?>"  value="c">
						<input style="border:none" readonly  name="c<?php echo $i?>" type="text" placeholder="Nội dung câu trả lời" value="<?php echo $items['dapanc']?>"><br>
						<input  type="radio" name="chon<?php echo $i?>"  value="d">
						<input style="border:none" readonly  name="d<?php echo $i?>" type="text" placeholder="Nội dung câu trả lời" value="<?php echo $items['dapand']?>"><br>
					</div>
				<?php $i++; endforeach ?>
			</div>
			<div class="submit"> 
				<input class="btn-submit" type="submit" name="submit" value="Nộp bài">
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
	<script>
		function menuFunction(x) {
			x.classList.toggle("change");
		  document.getElementById("myDropdown").classList.toggle("show");
		}
	</script>
</body>
</html>
