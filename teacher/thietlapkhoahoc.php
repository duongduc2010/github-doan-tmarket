<?php
	include('../user/connect.php');
	include("randomstring.php");
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

	//Hiển thị khóa học
	$sql_kh = "SELECT * FROM theloaikhoahoc";
	$stmt_kh = $conn->prepare($sql_kh);
	$query_kh = $stmt_kh->execute();
	$result_kh = array();
	while($row_kh = $stmt_kh->fetch(PDO::FETCH_ASSOC)){
		$result_kh[] = $row_kh;
	}
	//cahoc
	$sql_cahoc = "SELECT * FROM cahoc";
	$stmt_cahoc = $conn->prepare($sql_cahoc);
	$query_cahoc = $stmt_cahoc->execute();
	$result_cahoc = array();
	while($row_cahoc = $stmt_cahoc->fetch(PDO::FETCH_ASSOC)){
		$result_cahoc[] = $row_cahoc;
	}

	//Thời gian của khóa học không được trùng nhau
	$sql11="SELECT * FROM khoahocgiaovien WHERE giaovienid = '$id_giaovien'";
    $stmt11=$conn->prepare($sql11);
    $query11 = $stmt11->execute();
    $result11=array();
    while($row11=$stmt11->fetch(PDO::FETCH_ASSOC)){
        $result11[]=$row11;
    }

	function ktra($tgbatdau,$tgketthuc,$cahoc,$result){  
        foreach ($result as $items)
        {
            if($items['thoigianbatdau'] == $tgbatdau && $items['thoigianketthuc'] == $tgketthuc && $items['cahoc'] == $cahoc){
                return true;
            }
            if($items['thoigianbatdau'] != $tgbatdau && $items['thoigianketthuc'] == $tgketthuc && $items['cahoc'] == $cahoc){
                return true;
            }
            if($items['thoigianbatdau'] == $tgbatdau && $items['thoigianketthuc'] != $tgketthuc && $items['cahoc'] == $cahoc){
                return true;
            }
        }	
        return false;
    }

	//Thêm khóa học cho giáo viên
	if(isset($_POST['submit'])){
		if(!empty($_POST['tlkh'])  && !empty($_POST['tgbatdau']) && !empty($_POST['tgketthuc']) && !empty($_POST['cahoc'])){
			$tlkh = $_POST['tlkh'];
			$tgbatdau = $_POST['tgbatdau'];
			$tgketthuc = $_POST['tgketthuc'];
			$cahoc = $_POST['cahoc'];
			if(ktra($tgbatdau,$tgketthuc,$cahoc,$result11)==false){
				$seo = generate_string($permitted_chars, 5);
				$tentailieu1 = $_FILES['tailieu1'];
				$tailieu1 = "./ttgv/$id_giaovien-$hoten/tailieukhoahoc/".$id_teacher."1".$seo.$tentailieu1['name'];
				move_uploaded_file($_FILES["tailieu1"]["tmp_name"],$tailieu1);


				$seo = generate_string($permitted_chars, 5);
				$tentailieu2 = $_FILES['tailieu2'];
				$tailieu2 = "./ttgv/$id_giaovien-$hoten/tailieukhoahoc/".$id_teacher."1".$seo.$tentailieu2['name'];
				move_uploaded_file($_FILES["tailieu2"]["tmp_name"],$tailieu2);

				$t = strtotime(date("d-m-Y"));
				$tgketthuc1 = strtotime(date("d-m-Y",strtotime($tgketthuc)));
				$tgbatdau1 = strtotime(date("d-m-Y",strtotime($tgbatdau)));
				if($tgketthuc1 > $t && $tgketthuc1 > $tgbatdau1){
					$sql_them = "INSERT INTO khoahocgiaovien(giaovienid,theloaikhoahocid,thoigianbatdau,thoigianketthuc,cahoc,tinhtrang,tailieu1,tailieu2) VALUES('$id_giaovien','$tlkh','$tgbatdau','$tgketthuc','$cahoc','Chưa hoạt động','$tailieu1','$tailieu2')";
					$stmt_them = $conn->prepare($sql_them);
					$query_them = $stmt_them->execute();
					if($query_them){
						header("location:thongtincanhan.php?id=$id_teacher");
					}
				}

				
			}
			else{
				echo "Khóa học đã trùng thời gian ca học với khóa học khác của bạn";
				header("location:thietlapkhoahoc.php?id=$id_teacher");
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
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" href = "js/bootstrap.min.js"></script>
	<script type="text/javascript" href = "js/jquery-3.6.2.slim.js"></script>
    <link rel="stylesheet" type="text/css" href="style/thietlapkhoahoc.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
	<title>Thiết lập khóa học</title>
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
	<div  id="content">
		<h1>Thiết lập khóa học</h1>
		<div class="chitiet__thietlapkhoahoc">
			<form method="post" enctype="multipart/form-data">
				<fieldset class="form-group">
					<label for="tenkhoahoc">Tên khóa học: </label>
					<select name="tlkh"  id="tenkhoahoc" class="chitiet__tenkhoahoc form-control">
						<?php foreach ($result_kh as $items): ?>
							<option value="<?php echo $items['id']?>"><?php echo $items['tenkhoahoc']?></option>
						<?php endforeach ?>
						
					</select>
				</fieldset>
				<!-- <fieldset class="form-group">
					<label for="motakhoahoc">Mô tả khóa học: </label>
					<p name=""  class="chitiet__motakhoahoc form-control" id="motakhoahoc"></p>
				</fieldset> -->
				<!-- <fieldset class="chitiet__hocphidong form-group">
					<label for="hocphi">Học phí: </label>
					<span>VND</span>
					<input required name="hocphi"  min="1000" max="2000000" type="number" placeholder="Nhập học phí: " class="chitiet__hocphi form-control" id="hocphi"/>
				</fieldset> -->
				<fieldset class="form-group">
					<label for="tgbatdau">Thời gian bắt đầu: </label>
					<input required name="tgbatdau"  type="date" placeholder="Nhập học phí: " class="chitiet__tgbatdau form-control" id="tgketthuc"/>

				</fieldset>
				<fieldset class="form-group">
					<label for="tgketthuc">Thời gian kết thúc: </label>
					<input  required name="tgketthuc" type="date" placeholder="Nhập học phí: " class="chitiet__tgbatdau form-control" id="tgketthuc"/>
				</fieldset>
				<fieldset class="form-group">
					<label for="cahoc">Ca học: </label>
					<select required name="cahoc"  id="cahoc" class="chitiet__cahoc form-control">
						<?php foreach ($result_cahoc as $items): ?>
							<option value="<?php echo $items['id']?>"><?php echo $items['thoigian']?></option>
						<?php endforeach ?>
					</select>
				</fieldset>
				<fieldset class="form-group">
					<label for="tailieu1">Tài liệu 1: </label>
					<input  required name="tailieu1" type="file" class="form-control" id="tailieu1"/>
				</fieldset>
				<fieldset class="form-group">
					<label for="tailieu2">Tài liệu 2: </label>
					<input  required name="tailieu2" type="file" class="form-control" id="tailieu2"/>
				</fieldset>
				<fieldset class="form-group">
					<input name="submit" type="submit" class="chitiet__btn form-control" id="taokh" value="Tạo khóa học">
				</fieldset>
			</form>
		</div>
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
