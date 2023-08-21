<?php
	include('../user/connect.php');
	session_start();
	if (!isset($_SESSION['taikhoan'])) {
		header("location:../user/index.php");
	}
	$id_teacher = $_GET['id'];
	$idgv = $_GET['idgv'];
	$idkh = $_GET['idkh'];
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
	$idbkt=$_GET['idbkt'];
	$idcauhoi = $_GET['idcauhoi'];
	$idbkt = $_GET['idbkt'];
	if(isset($_POST['submit_them'])){
		if(!empty($_POST['cauhoi']) && !empty($_POST['a']) && !empty($_POST['b']) && !empty($_POST['c']) && !empty($_POST['d']) && isset($_POST['chon'])){
			$cauhoi = $_POST['cauhoi'];
			$a = $_POST['a'];
			$b = $_POST['b'];
			$c = $_POST['c'];
			$d = $_POST['d'];
			$dapandung = $_POST['chon'];
			$sql_them = "INSERT INTO chitietbaikiemtra(idbkt,tencauhoi,dapana,dapanb,dapanc,dapand,dapandung) VALUES('$idbkt','$cauhoi','$a','$b','$c','$d','$dapandung')";
			$stmt_them = $conn->prepare($sql_them);
			$query_them = $stmt_them->execute();
			if($query_them){
				header("location:bkt_chitiet_them.php?id=$id_teacher&&idgv=$idgv&&idkh=$idkh&&idbkt=$idbkt");
			}
			else{
				echo "Vui lòng điền đầy đủ thông tin";
			}

		}
	}
	if(isset($_POST['submit_hoantat'])){
		header("location:bkt_chitiet.php?id=$id_teacher&&idgv=$idgv&&idkh=$idkh&&idbkt=$idbkt");
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
    <link rel="stylesheet" type="text/css" href="style/thembaikiemtra.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
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
                        <li><a href="#">Tiếng Anh</a></li>
                        <li><a href="#">Tiếng Việt</li>
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
		
			<div class="warning">
				<h5>Vui lòng thêm Câu hỏi và câu trả lời tương ứng vào các ô phía dưới</h5><br>
				<h5>Để chọn câu trả lời đúng thì tích vào câu đó</h5><br>
				<h5>Nhấn "Hoàn tất" sau khi đã thêm đầy đủ câu hỏi của bài tập</h5>
				<h5>Lưu ý: Phải điền đầy đủ thông tin câu hỏi và tích chọn đáp án đúng thì câu hỏi mới được thêm vào bài tập</h5>
			</div>
			<form method="post">
				<div class="container-box">
					<!-- <div class="name-question">
						<label for="">Tên bài tập</label>
						<input name="tenbai" type="text" placeholder="Tên của bài tập này">
					</div> -->
					<div class="box">
						<div class="box-child">
							<label for="">Câu hỏi</label>
							<!-- <input type="text" > -->
							<textarea class="hi" name="cauhoi" id="" cols="50" rows="2" placeholder="Nội dung câu hỏi"></textarea>
						</div>
						<div class="box-rep">
							<input type="radio" name="chon" id="" value="a">
							<input name="a" type="text" placeholder="Nội dung câu trả lời"><br>
							<input type="radio" name="chon" id="" value="b">
							<input name="b" type="text" placeholder="Nội dung câu trả lời"><br>
							<input type="radio" name="chon" id="" value="c">
							<input name="c" type="text" placeholder="Nội dung câu trả lời"><br>
							<input type="radio" name="chon" id="" value="d">
							<input name="d" type="text" placeholder="Nội dung câu trả lời"><br>
						</div>
					</div>
				</div>
				<div class="footer-btn">
				<!-- <button class="btnAdd">Thêm câu hỏi</button> -->
					<input type="submit" name="submit_them" class="btn" value="Thêm"/>
					<input type="submit" name="submit_hoantat" class="btn" value="Hoàn tất"/>
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

// ---------------------------------Scrip logic thêm câu hỏi--------------

  //       var btnAdd = document.querySelector('.btnAdd')
		// var t = document.createTextNode('hi');
		// var label = document.createElement("label");
		// label.appendChild(t)	

		// var input = document.createElement("input");
		// input.setAttribute("type", "radio");
		// var i = 1
		// btnAdd.onclick = function(){
		// 	i++;
		// 	//tên câu hỏi
		// 	$name="cau".$i;
		// 	var div1 = document.createElement("div");
		// 	div1.classList.add("box-child")
		// 	var containerBox =document.querySelector('.container-box')
		// 	var textarea = document.createElement("textarea")
		// 	textarea.setAttribute("placeholder","Nội dung câu hỏi");
		// 	textarea.setAttribute("name", `cau${i}`);
		// 	var t = document.createTextNode('Câu hỏi');
		// 	var label = document.createElement("label");
		// 	var box =document.createElement('div')
		// 	box.classList.add("box")
		// 	label.appendChild(t)	
		// 	div1.appendChild(label)
		// 	div1.appendChild(textarea)
		// 	box.appendChild(div1)
		// 	// câu trả lời
		// 	var div2 = document.createElement("div");
		// 	div2.classList.add("box-rep")

		// 	var br = document.createElement("br");
		// 	var radio = document.createElement("input");
		// 	radio.setAttribute("type", "radio");
		// 	radio.setAttribute("value", "A");
		// 	radio.setAttribute("name", `dapan1${i}`);
		// 	var input = document.createElement("input");
		// 	input.setAttribute("placeholder","Nội dung câu trả lời");
		// 	input.setAttribute("type", "text");
		// 	input.setAttribute("name", `a${i}`);
		// 	div2.appendChild(radio)
		// 	div2.appendChild(input)
		// 	div2.appendChild(br)

		// 	var br = document.createElement("br");
		// 	var radio = document.createElement("input");
		// 	radio.setAttribute("type", "radio");
		// 	radio.setAttribute("value", "B");
		// 	radio.setAttribute("name", `${i}`);
		// 	var input = document.createElement("input");
		// 	input.setAttribute("placeholder","Nội dung câu trả lời");
		// 	input.setAttribute("type", "text");
		// 	input.setAttribute("name", `b${i}`);
		// 	div2.appendChild(radio)
		// 	div2.appendChild(input)
		// 	div2.appendChild(br)

		// 	var br = document.createElement("br");
		// 	var radio = document.createElement("input");
		// 	radio.setAttribute("type", "radio");
		// 	radio.setAttribute("value", "C");
		// 	radio.setAttribute("name", `${i}`);
		// 	var input = document.createElement("input");
		// 	input.setAttribute("type", "text");
		// 	input.setAttribute("placeholder","Nội dung câu trả lời");
		// 	input.setAttribute("name", `c${i}`);
		// 	div2.appendChild(radio)
		// 	div2.appendChild(input)
		// 	div2.appendChild(br)

		// 	var br = document.createElement("br");
		// 	var radio = document.createElement("input");
		// 	radio.setAttribute("type", "radio");
		// 	radio.setAttribute("value", "D");
		// 	radio.setAttribute("name", `${i}`);
		// 	var input = document.createElement("input");
		// 	input.setAttribute("type", "text");
		// 	input.setAttribute("placeholder","Nội dung câu trả lời");
		// 	input.setAttribute("name", `d${i}`);
		// 	div2.appendChild(radio)
		// 	div2.appendChild(input)
		// 	div2.appendChild(br)

		// 	box.appendChild(div2)
		// 	containerBox.appendChild(box)
		// }
// -----------------------------------------


	</script>
</body>
</html>
