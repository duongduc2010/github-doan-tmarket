<?php
	include('../user/connect.php');
	session_start();
	if (!isset($_SESSION['taikhoan'])) {
		header("location:../user/index.php");
	}
	// Cập nhật thông tin 
	$id_teacher = $_GET['id'];
	
	$sql_teacher = "SELECT giaovien.*,congcudayhoc.tencongcu, theloaigiaovien.tentheloai, quocgia.quocgia as tenqg,gioitinh.gioitinh as tengt,timezone.ten as tentz, taikhoan.ngaysinh 
		FROM giaovien,taikhoan,theloaigiaovien, quocgia,gioitinh,timezone,congcudayhoc
		WHERE giaovien.taikhoan='$id_teacher' 
		and giaovien.theloaigiaovien = theloaigiaovien.id
		and giaovien.quocgia = quocgia.id
		and giaovien.gioitinh = gioitinh.id
		and giaovien.timezone = timezone.id
		and giaovien.taikhoan = taikhoan.id
		and giaovien.idcongcudayhoc = congcudayhoc.id";
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
		$ngaysinh = $items['ngaysinh'];
		$diachi = $items['diachi'];
		$gioitinh_id = $items['gioitinh'];
		$gioitinh_ten = $items['tengt'];
		$email = $items['email'];;
		$sdt = $items['sodienthoai'];
		$quocgia_id = $items['quocgia'];
		$quocgia_ten =$items['tenqg'];
		$timezone_id = $items['timezone'];
		$timezone_ten = $items['tentz'];
		$linkdayhoc = $items['linkdayhoc'];
		$gth1 = $items['gioithieubanthan1'];
		$gth2 = $items['gioithieubanthan2'];
		$gth3 = $items['gioithieubanthan3'];
		$vitien = $items['vitien'];
		$idcongcu = $items['idcongcudayhoc'];
		$tencongcu = $items['tencongcu'];
		$video = $items['video'];
		$idcard1 = $items['idcard1'];
		$idcard2 = $items['idcard2'];
		$chungchi1 = $items['chungchi1'];
		$chungchi2 = $items['chungchi2'];
		$congcu1 = $items['congcu1'];
		$congcu2 = $items['congcu2'];
		$congcu3 = $items['congcu3'];
		$congcu4 = $items['congcu4'];

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
	//Công cụ dạy học
	$sql_ccdh = "SELECT * FROM congcudayhoc";
	$stmt_ccdh = $conn->prepare($sql_ccdh);
	$query_ccdh = $stmt_ccdh->execute();
	$result_ccdh = array();
	while($row_ccdh = $stmt_ccdh->fetch(PDO::FETCH_ASSOC)){
		$result_ccdh[] = $row_ccdh;
	}
	//Cập nhật thông tin
	if(isset($_POST['submit_ttcb'])){
		if(!empty($_POST['ho']) && !empty($_POST['ten']) && !empty($_POST['ngaysinh']) && !empty($_POST['gioitinh']) && !empty($_POST['email']) && !empty($_POST['sdt']) && !empty($_POST['quocgia']) && !empty($_POST['timezone']) && !empty($_POST['diachi'])){
			$ho = $_POST['ho'];
			$ten = $_POST['ten'];
			$ngaysinh = $_POST['ngaysinh'];
			$gioitinh = $_POST['gioitinh'];
			$email = $_POST['email'];
			$sdt = $_POST['sdt'];
			$quocgia = $_POST['quocgia'];
			$timezone = $_POST['timezone'];
			$diachi = $_POST['diachi'];
			$my_string1 = "$ho";
			var_dump($my_string1);
			$my_string2 = " $ten";
			var_dump($my_string2);
			$hoten = $my_string1 . $my_string2;
			if(!file_exists($_FILES['anh']['tmp_name']) || !is_uploaded_file($_FILES['anh']['tmp_name'])){
			echo "Không có  ảnh";
			}	
			else{
				include("randomstring.php");
				$seo = generate_string($permitted_chars, 5);
				$anh = "./ttgv/$id_giaovien-$hoten/profile/".$id_teacher."1".$seo.".jpg";

	    		move_uploaded_file($_FILES["anh"]["tmp_name"],$anh);

	    		$sql_capnhat = "UPDATE giaovien SET imgprofile='$anh' WHERE taikhoan='$id_teacher'";
				$stmt_capnhat = $conn->prepare($sql_capnhat);
				$query_capnhat = $stmt_capnhat->execute();
				if($query_capnhat){
					header("location:thongtincanhan.php?id=$id_teacher");
				}
				else{
					echo "Cập nhật không thành công";
				}
			}
			$sql_ttcb = "UPDATE giaovien SET hoten = '$hoten', gioitinh = '$gioitinh', email ='$email', sodienthoai = '$sdt', quocgia = '$quocgia', timezone = '$timezone', diachi = '$diachi' WHERE taikhoan = '$id_teacher';UPDATE taikhoan SET ngaysinh = '$ngaysinh' WHERE id ='$id_teacher'";
			$stmt_ttcb = $conn->prepare($sql_ttcb);
			$query_ttcb = $stmt_ttcb->execute();
			if($query_ttcb){
				header("location:thongtincanhan.php?id=$id_teacher");
			}
			else{
				echo "Cập nhật thất bại";
			}
		}
	}
	if(isset($_POST['submit_linkdayhoc'])){
		if(!empty($_POST['linkdayhoc']) && isset($_POST['congcudayhoc'])){
			$ccdh = $_POST['congcudayhoc'];
			$link = $_POST['linkdayhoc'];
			$sql_link = "UPDATE giaovien SET idcongcudayhoc = '$ccdh', linkdayhoc = '$link' 
							WHERE taikhoan='$id_teacher'";
			$stmt_link = $conn->prepare($sql_link);
			$query_link = $stmt_link->execute();
			if($query_link){
				header("location:thongtincanhan.php?id=$id_teacher");
			}
			else{
				echo "Cập nhật thất bại";
			}
		}
	}
	if(isset($_POST['submit_gioithieu'])){
		if(!empty($_POST['gth1']) && !empty($_POST['gth2']) && !empty($_POST['gth3'])){
			$gth1 = $_POST['gth1'];
			$gth2 = $_POST['gth2'];
			$gth3 = $_POST['gth3'];
			$sql_gth = "UPDATE giaovien SET gioithieubanthan1 = '$gth1',gioithieubanthan2 = '$gth2',gioithieubanthan3 = '$gth3' WHERE taikhoan='$id_teacher'";
			$stmt_gth = $conn->prepare($sql_gth);
			$query_gth = $stmt_gth->execute();
			if($query_link){
				header("location:thongtincanhan.php?id=$id_teacher");
			}
			else{
				echo "Cập nhật thất bại";
			}
		}
	}
	if(isset($_POST['submit_chungchi'])){
		if(!file_exists($_FILES['anh1']['tmp_name']) || !is_uploaded_file($_FILES['anh1']['tmp_name'])){
			echo "Không có  ảnh";
			}	
			else{
				include("randomstring.php");
				$seo = generate_string($permitted_chars, 5);
				$anh1 = "./ttgv/$id_giaovien-$hoten/idcard/".$id_teacher."1".$seo.".jpg";

	    		move_uploaded_file($_FILES["anh1"]["tmp_name"],$anh1);

	    		$sql_capnhat = "UPDATE giaovien SET idcard1='$anh1' WHERE taikhoan='$id_teacher'";
				$stmt_capnhat = $conn->prepare($sql_capnhat);
				$query_capnhat = $stmt_capnhat->execute();
				if($query_capnhat){
					header("location:thongtincanhan.php?id=$id_teacher");
				}
				else{
					echo "Cập nhật không thành công";
				}
			}
		if(!file_exists($_FILES['anh2']['tmp_name']) || !is_uploaded_file($_FILES['anh2']['tmp_name'])){
			echo "Không có  ảnh";
			}	
			else{
				include("randomstring.php");
				$seo = generate_string($permitted_chars, 5);
				$anh2 = "./ttgv/$id_giaovien-$hoten/idcard/".$id_teacher."2".$seo.".jpg";

	    		move_uploaded_file($_FILES["anh2"]["tmp_name"],$anh2);

	    		$sql_capnhat = "UPDATE giaovien SET idcard2='$anh2' WHERE taikhoan='$id_teacher'";
				$stmt_capnhat = $conn->prepare($sql_capnhat);
				$query_capnhat = $stmt_capnhat->execute();
				if($query_capnhat){
					header("location:thongtincanhan.php?id=$id_teacher");
				}
				else{
					echo "Cập nhật không thành công";
				}
			}
			if(!file_exists($_FILES['anh3']['tmp_name']) || !is_uploaded_file($_FILES['anh3']['tmp_name'])){
			echo "Không có  ảnh";
			}	
			else{
				include("randomstring.php");
				$seo = generate_string($permitted_chars, 5);
				$anh3 = "./ttgv/$id_giaovien-$hoten/chungchi/".$id_teacher."1".$seo.".jpg";

	    		move_uploaded_file($_FILES["anh3"]["tmp_name"],$anh3);

	    		$sql_capnhat = "UPDATE giaovien SET chungchi1='$anh3' WHERE taikhoan='$id_teacher'";
				$stmt_capnhat = $conn->prepare($sql_capnhat);
				$query_capnhat = $stmt_capnhat->execute();
				if($query_capnhat){
					header("location:thongtincanhan.php?id=$id_teacher");
				}
				else{
					echo "Cập nhật không thành công";
				}
			}
			if(!file_exists($_FILES['anh4']['tmp_name']) || !is_uploaded_file($_FILES['anh4']['tmp_name'])){
			echo "Không có  ảnh";
			}	
			else{
				include("randomstring.php");
				$seo = generate_string($permitted_chars, 5);
				$anh4 = "./ttgv/$id_giaovien-$hoten/chungchi/".$id_teacher."1".$seo.".jpg";

	    		move_uploaded_file($_FILES["anh4"]["tmp_name"],$anh4);

	    		$sql_capnhat = "UPDATE giaovien SET chungchi2='$anh4' WHERE taikhoan='$id_teacher'";
				$stmt_capnhat = $conn->prepare($sql_capnhat);
				$query_capnhat = $stmt_capnhat->execute();
				if($query_capnhat){
					header("location:thongtincanhan.php?id=$id_teacher");
				}
				else{
					echo "Cập nhật không thành công";
				}
			}
			if(!file_exists($_FILES['anh5']['tmp_name']) || !is_uploaded_file($_FILES['anh5']['tmp_name'])){
			echo "Không có  ảnh";
			}	
			else{
				include("randomstring.php");
				$seo = generate_string($permitted_chars, 5);
				$anh5 = "./ttgv/$id_giaovien-$hoten/congcudayhoc/".$id_teacher."5".$seo.".jpg";

	    		move_uploaded_file($_FILES["anh5"]["tmp_name"],$anh5);

	    		$sql_capnhat = "UPDATE giaovien SET congcu1='$anh5' WHERE taikhoan='$id_teacher'";
				$stmt_capnhat = $conn->prepare($sql_capnhat);
				$query_capnhat = $stmt_capnhat->execute();
				if($query_capnhat){
					header("location:thongtincanhan.php?id=$id_teacher");
				}
				else{
					echo "Cập nhật không thành công";
				}
			}
			if(!file_exists($_FILES['anh6']['tmp_name']) || !is_uploaded_file($_FILES['anh6']['tmp_name'])){
			echo "Không có  ảnh";
			}	
			else{
				include("randomstring.php");
				$seo = generate_string($permitted_chars, 5);
				$anh6 = "./ttgv/$id_giaovien-$hoten/congcudayhoc/".$id_teacher."1".$seo.".jpg";

	    		move_uploaded_file($_FILES["anh6"]["tmp_name"],$anh6);

	    		$sql_capnhat = "UPDATE giaovien SET congcu2='$anh6' WHERE taikhoan='$id_teacher'";
				$stmt_capnhat = $conn->prepare($sql_capnhat);
				$query_capnhat = $stmt_capnhat->execute();
				if($query_capnhat){
					header("location:thongtincanhan.php?id=$id_teacher");
				}
				else{
					echo "Cập nhật không thành công";
				}
			}
			if(!file_exists($_FILES['anh7']['tmp_name']) || !is_uploaded_file($_FILES['anh7']['tmp_name'])){
			echo "Không có  ảnh";
			}	
			else{
				include("randomstring.php");
				$seo = generate_string($permitted_chars, 5);
				$anh7 = "./ttgv/$id_giaovien-$hoten/congcudayhoc/".$id_teacher."1".$seo.".jpg";

	    		move_uploaded_file($_FILES["anh7"]["tmp_name"],$anh7);

	    		$sql_capnhat = "UPDATE giaovien SET congcu3='$anh7' WHERE taikhoan='$id_teacher'";
				$stmt_capnhat = $conn->prepare($sql_capnhat);
				$query_capnhat = $stmt_capnhat->execute();
				if($query_capnhat){
					header("location:thongtincanhan.php?id=$id_teacher");
				}
				else{
					echo "Cập nhật không thành công";
				}
			}
			if(!file_exists($_FILES['anh8']['tmp_name']) || !is_uploaded_file($_FILES['anh8']['tmp_name'])){
			echo "Không có  ảnh";
			}	
			else{
				include("randomstring.php");
				$seo = generate_string($permitted_chars, 5);
				$anh8 = "./ttgv/$id_giaovien-$hoten/congcudayhoc/".$id_teacher."1".$seo.".jpg";

	    		move_uploaded_file($_FILES["anh8"]["tmp_name"],$anh8);

	    		$sql_capnhat = "UPDATE giaovien SET congcu4='$anh8' WHERE taikhoan='$id_teacher'";
				$stmt_capnhat = $conn->prepare($sql_capnhat);
				$query_capnhat = $stmt_capnhat->execute();
				if($query_capnhat){
					header("location:thongtincanhan.php?id=$id_teacher");
				}
				else{
					echo "Cập nhật không thành công";
				}
			}
	}
	if(isset($_POST['submit_video'])){
		if(!file_exists($_FILES['video']['tmp_name']) || !is_uploaded_file($_FILES['video']['tmp_name'])){
			echo "Không có video";
			}	
			else{
				include("randomstring.php");
				$seo = generate_string($permitted_chars, 5);
				$video = "./ttgv/$id_giaovien-$hoten/video/".$id_teacher."1".$seo.".mp4";

	    		move_uploaded_file($_FILES["video"]["tmp_name"],$video);

	    		$sql_capnhat = "UPDATE giaovien SET video='$video' WHERE taikhoan='$id_teacher'";
				$stmt_capnhat = $conn->prepare($sql_capnhat);
				$query_capnhat = $stmt_capnhat->execute();
				if($query_capnhat){
					header("location:thongtincanhan.php?id=$id_teacher");
				}
				else{
					echo "Cập nhật không thành công";
				}
			}
	}

	if(isset($_POST['submit_rutien'])){
		if(!empty($_POST['nganhang']) && !empty($_POST['stk']) && !empty($_POST['sotien'])){
			$nganhang = $_POST['nganhang'];
			$stk = $_POST['stk'];
			$sotien = $_POST['sotien'];
			$sql_ruttien = "INSERT INTO ruttien(idgiaovien,tennganhang,sotaikhoan,sotien) VALUES('$id_giaovien','$nganhang','$stk','$sotien')";
			$stmt_ruttien = $conn->prepare($sql_ruttien);
			$query_ruttien = $stmt_ruttien->execute();
			if($query_ruttien){
				header("location:thongtincanhan.php?id=$id_teacher");
			}
			else{
				echo "Lỗi";
			}
		}	
	}

	//Danh sách khóa học của giáo viên
	$sql_dskh = "SELECT khoahocgiaovien.*,cahoc.thoigian,theloaikhoahoc.tenkhoahoc 
					FROM khoahocgiaovien,cahoc,theloaikhoahoc
					WHERE khoahocgiaovien.cahoc = cahoc.id and khoahocgiaovien.theloaikhoahocid = theloaikhoahoc.id
					and khoahocgiaovien.giaovienid = '$id_giaovien'";
	$stmt_dskh = $conn->prepare($sql_dskh);
	$query_dskh = $stmt_dskh->execute();
	$result_dskh = array();
	while($row_dskh = $stmt_dskh->fetch(PDO::FETCH_ASSOC)){
		$result_dskh[] = $row_dskh;
	}

	//Lịch sử giao dịch
	$sql_lsgd = "SELECT * FROM lichsugiaodich WHERE lichsugiaodich.idgiaovien = '$id_giaovien'";
	$stmt_lsgd = $conn->prepare($sql_lsgd);
	$query_lsgd = $stmt_lsgd->execute();
	$result_lsgd = array();
	while($row_lsgd = $stmt_lsgd->fetch(PDO::FETCH_ASSOC)){
		$result_lsgd[] = $row_lsgd;
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
	<link rel="stylesheet" type="text/css" href="style/thongtincanhan.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
	<title>Trang chủ giáo viên</title>
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
	<div id="content">
		<div class="content content__sidebar">
			<h4>Thông tin giáo viên</h4>
			<button onclick="btnClick(event,'ttcb')" class="content__tablinks content__tablinks--separate" id="defaultClick">Thông tin cơ bản</button>
			<button onclick="btnClick(event,'bangcap')" class="content__tablinks content__tablinks--separate" >Bằng cấp chứng chỉ</button>
			<button onclick="btnClick(event,'congcu')" class="content__tablinks content__tablinks--separate" >Công cụ dạy học</button>
			<button onclick="btnClick(event,'gth')" class="content__tablinks content__tablinks--separate" >Giới thiệu</button>
			<button onclick="btnClick(event,'video')" class="content__tablinks content__tablinks--separate" >Video</button>
			<button onclick="btnClick(event,'quanlykh')" class="content__tablinks content__tablinks--separate" >Quản lý khóa học</button>
			<button onclick="btnClick(event,'vitien')" class="content__tablinks content__tablinks--separate" >Ví tiền</button>
		</div>
		<div class="content content__main">
			<form method="post" enctype="multipart/form-data">
				<div id="ttcb" class="content__tabmain content__tabmain--ttcb">
					<h2>Thông tin cơ bản</h2>
					<div class="chitiet">
						<img  src="<?php echo $img?>">
						<label>Hình ảnh</label>
                        <input type="file" id="images" name="anh" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
						

						<div class="formchitiet">
							<div class="chitietcot mot">
								
									<fieldset class="form-group">
										<label for="formGroupExampleInput">Tên</label>
										<input value="<?php echo $ten;?>" name="ten" type="text" class="form-control" id="" placeholder="Tên">
									</fieldset>
									<fieldset class="form-group">
										<label for="formGroupExampleInput2">Ngày sinh</label>
										<input value="<?php echo $ngaysinh;?>"  name="ngaysinh" type="date" class="form-control" id="">
									</fieldset>
									<fieldset class="form-group">
										<label for="formGroupExampleInput2">Email</label>
										<input value="<?php echo $email;?>" name="email" type="text" class="form-control" id="" placeholder="Email">
									</fieldset>
									<fieldset class="form-group">
										<label for="formGroupExampleInput2">Quốc gia</label>
										<select name="quocgia" id="quocgia" class="form-control" class="c-select">
												<option value="<?php echo $quocgia_id?>" selected><?php echo $quocgia_ten?></option>
												<?php foreach ($result_quocgia as $items):?>
													<option value="<?php echo $items['id']?>"><?php echo $items['quocgia']?></option>
												<?php endforeach ?>
											</select>
									</fieldset>
									<fieldset class="form-group">
										<label for="formGroupExampleInput2">Địa chỉ</label>
										<textarea name="diachi" style="height: 150px;" type="text" class="form-control" id="" placeholder="Địa chỉ"><?php echo $diachi;?></textarea> 
									</fieldset>
								
							</div>

							<div class="chitietcot hai">
								
									<fieldset class="form-group">
										<label for="formGroupExampleInput">Họ</label>
										<input name="ho" value="<?php echo $ho;?>" type="text" class="form-control" id="" placeholder="Họ">
									</fieldset>
									<fieldset class="form-group">
										<label for="formGroupExampleInput2">Giới tính</label>
										<select name="gioitinh" id="gioitinh" class="form-control" class="c-select">
												<option value="<?php echo $gioitinh_id?>" selected><?php echo $gioitinh_ten?></option>
												<?php foreach($result_gioitinh as $items):?>
													<option value="<?php echo $items['id']?>"><?php echo $items['gioitinh']?></option>
												<?php endforeach?>
											</select>
									</fieldset>
									<fieldset class="form-group">
										<label for="formGroupExampleInput">Số điện thoại</label>
										<input name="sdt" value="<?php echo $sdt;?>" type="text" class="form-control" id="" placeholder="Số điện thoại">
									</fieldset>
									<fieldset class="form-group">
										<label for="formGroupExampleInput2">Timezone</label>
										<select name="timezone" id="timezone" class="form-control" class="c-select">
												<option value="<?php echo $timezone_id?>" selected><?php echo $timezone_ten?></option>
												<?php foreach($result_timezone as $items):?>
													<option value="<?php echo $items['id'];?>"><?php echo $items['ten'];?></option>
												<?php endforeach?>
											</select>
									</fieldset>
								
							</div>
						</div>
						<input class="capnhattt" type="submit" name="submit_ttcb" value="Cập nhật thông tin">
					
					</div>

				</div>
				<div id="bangcap" class="content__tabmain content__tabmain--bangcap">
					<div class="bangcap">
						<h2>Bằng cấp chứng chỉ</h2>
						<label>Giấy chứng nhận và các tài liệu liên quan</label>
						<div class="caccot mot">
							<div class="cot mot">
								<img style="height: 150px;width: 150px;padding: 0" src="<?php echo $idcard1?>">
								<br>
								<label>Mặt trước CMND</label>
								<input type="file" id="images" name="anh1" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot hai">
								<img style="height: 150px;width: 150px;padding: 0" src="<?php echo $idcard2?>">
								<br>
								<br>
								<label>Mặt sau CMND</label>
								<input type="file" id="images" name="anh2" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot ba">
								<img style="height: 150px;width: 150px;padding: 0" src="<?php echo $chungchi1?>">
								<br>
								<br>
								<label>Chứng chỉ tiếng Anh</label>
								<input type="file" id="images" name="anh3" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot bon">
								<img style="height: 150px;width: 150px;padding: 0" src="<?php echo $chungchi2?>">
								<br>
								<br>
								<label>Thêm nhiều chứng chỉ của bạn</label>
								<input type="file" id="images" name="anh4" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
						</div>
						<label>Đồ dùng dạy học</label>
						<div class="caccot hai">
							<div class="cot mot">
								<img style="height: 150px;width: 150px;padding: 0" src="<?php echo $congcu1?>">
								<br>
								<label>Máy tính</label>
								<input type="file" id="images" name="anh5" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot hai">
								<img style="height: 150px;width: 150px;padding: 0" src="<?php echo $congcu2?>">
								<br>
								<label>Laptop</label>
								<input type="file" id="images" name="anh6" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot ba">
								<img style="height: 150px;width: 150px;padding: 0" src="<?php echo $congcu3?>">
								<br>
								<label>Tai nghe</label>
								<input type="file" id="images" name="anh7" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
							<div class="cot bon">
								<img style="height: 150px;width: 150px;padding: 0" src="<?php echo $congcu4?>">
								<br>
								<label>Camera</label>
								<input type="file" id="images" name="anh8" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
							</div>
						</div>
					</div>
					<input class="capnhattt" type="submit" name="submit_chungchi" value="Cập nhật thông tin">
				</div>
				<div id="congcu" class="content__tabmain content__tabmain--congcu">
					<h2>Công cụ dạy học</h2>
					<div class="chitiet">
						<h6>Chat apps</h6>
						<select name="congcudayhoc">
							<option value="<?php echo $idcongcu?>" selected><?php echo $tencongcu?></option>
							<?php foreach ($result_ccdh as $items):?>
								<option value="<?php echo $items['id']?>"><?php echo $items['tencongcu']?></option>
							<?php endforeach ?>
						</select>
						<input value="<?php echo $linkdayhoc;?>" type="text" name="linkdayhoc" placeholder="Link">
					</div>
					<input  class="capnhattt" type="submit" name="submit_linkdayhoc" value="Cập nhật thông tin">
				</div>
				<div id="gth" class="content__tabmain content__tabmain--gth">
					<h2>Giới thiệu</h2>
					<div class="chitiet">
						<label for="gth1">Về bản thân tôi</label>
						<br>
						<textarea name="gth1" id="gth1" placeholder="About me"><?php echo $gth1?></textarea>
						<br>
						<label for="gth2">Tôi với tư cách là một giáo viên</label>
						<br>
						<textarea name="gth2" id="gth2" placeholder="Me as a teacher"><?php echo $gth2?></textarea>
						<br>
						<label for="gth3">Các khóa học và phong cách giảng dạy của tôi</label>
						<br>
						<textarea name="gth3" id="gth3" placeholder="Learning courses and my teaching style"><?php echo $gth3?></textarea>
					</div>
					<input class="capnhattt" type="submit" name="submit_gioithieu" value="Cập nhật thông tin">
				</div>
				<div id="video" class="content__tabmain content__tabmain--video">
					<h2>Video</h2>
					<div class="chitiet">
						<video controls="controls" style="width: 745px; height: 372px;">
							<source src="<?php echo $video?>">
						</video>
						<br>
						<label>Thay đổi video</label>
                    	<input type="file" id="images" name="video" accept="video/mp4,video/x-m4v,video/*" data-text="Chọn video">
					</div>
					<input class="capnhattt" type="submit" name="submit_video" value="Cập nhật thông tin">
				</div>
			</form>
			<div id="quanlykh" class="content__tabmain content__tabmain--quanlykh">
				<h2>Hệ thống khóa học</h2>
				<div class="chitiet">
					<table class="table table-inverse">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($result_dskh as $items): ?>
								<tr>
									<td>
										<div class="khoahoc">
											<label><span>Tên khóa học:</span> <?php echo $items['tenkhoahoc'];?></label>
											<br>
											<label><span>Học phí:</span> <?php
											$hocphi = $items['hocphi'];
											echo number_format($hocphi);
											?> đồng</label>
											<br>
											<label><span>Thời gian: </span>Từ <?php 
											$tgbatdau = $items['thoigianbatdau'];
											echo date("d-m-Y",strtotime($tgbatdau));
											
											?> 
											đến
											<?php 
											$tgketthuc = $items['thoigianketthuc'];
											echo date("d-m-Y",strtotime($tgketthuc));
											?></label>
											<br>
											<label><span>Ca học:</span> <?php echo $items['thoigian'];?></label>
										</div>
									</td>

									<td><br><br><a class="suaxoa" href="khoahocgiaovien_sua.php?id=<?php echo $id_teacher ?>&&idkh=<?php echo $items['id'] ?>">Sửa</a></td>
									<td><br><br><a class="suaxoa" href="khoahocgiaovien_xoa.php?id=<?php echo $id_teacher ?>&&idkh=<?php echo $items['id'] ?>">Xóa</a></td>
								</tr>
							<?php endforeach ?>

						</tbody>
					</table>
				</div>
				<a href="thietlapkhoahoc.php?id=<?php echo $id_teacher ?>"><input class="capnhattt" type="submit" name="" value="Thiết lập khóa học"></a>
			</div>
			<div id="vitien" class="content__tabmain content__tabmain--vitien">
				<h2>Ví tiền</h2>
				<div class="chitiet">
					<div class="button">
						<button id="defaultOpen" class="content__tabmain--vitien--tablinks" onclick="btnClickVi(event,'vicuatoi')">Ví của tôi</button>
						<button class="content__tabmain--vitien--tablinks" onclick="btnClickVi(event,'lichsugd')">Lịch sử giao dịch</button>
					</div>
					<div id="vicuatoi" class="content__tabmain--vitien--tabcontent">
						<div class="chitiet">
							<h4>Tổng tiền</h4>
							<h4>
								<?php
								echo number_format($vitien);
								?>
							đồng</h4>

						</div>
						<form method="post">
							<fieldset class="form-group">
								<label for="formGroupExampleInput1">Tên ngân hàng</label>
								<input name="nganhang" id="formGroupExampleInput1" type="text" class="form-control" placeholder="Tên ngân hàng">
							</fieldset>
							<fieldset class="form-group">
								<label for="formGroupExampleInput2">Số tài khoản</label>
								<input name="stk" id="formGroupExampleInput2" type="text" class="form-control" placeholder="Số tài khoản">
							</fieldset>
							<fieldset class="form-group">
								<label for="formGroupExampleInput3">Số tiền</label>
								<input name="sotien" id="formGroupExampleInput3" type="number" class="form-control" placeholder="Số tiền">
							</fieldset>
							<fieldset class="form-group">
								<input name="submit_rutien" type="submit" class="form-control" value="Rút tiền">
							</fieldset>
						</form>
					</div>
					</div>
					<div id="lichsugd" class="content__tabmain--vitien--tabcontent">
						<table class="table table-inverse">
							<thead>
								<tr>
									<th>STT</th>
									<th>Thời gian</th>
									<th>Mô tả</th>
									<th>Biến động</th>
									<th>Tổng tiền còn lại</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($result_lsgd as $items):?>
									<tr>
										<td><?php echo $i;?></td>
										<td>
											<?php 
											$thoigian = $items['thoigian'];
											echo date("d-m-Y",strtotime($thoigian));
											?>
												
										</td>
										<td><?php echo $items['mota'];?></td>
										<td>
											<?php
											$biendong = $items['biendong'];
											echo number_format($biendong);
											?>
										</td>
										<td><?php
											$tongtien = $items['tongtienconlai'];
											echo number_format($tongtien);
											?>	
										</td>
									</tr>
								<?php $i++; endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer >
			<div class="footer-distributed">
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
		</div>
	</footer>
	<script>
		function menuFunction(x) {
			x.classList.toggle("change");
		  document.getElementById("myDropdown").classList.toggle("show");
		}
		function btnClick(evt,titleName){
			var i,tabmain,tablinks;
			tabmain = document.getElementsByClassName('content__tabmain');
			for(i = 0 ; i< tabmain.length;i++){
				tabmain[i].style.display="none";
			}
			tablinks = document.getElementsByClassName('content__tablinks');
		 	 for (i = 0; i < tablinks.length; i++) {
			    tablinks[i].className = tablinks[i].className.replace(" active", "");
			  }
			document.getElementById(titleName).style.display='block';
			evt.currentTarget.className += " active";
		}

		function btnClickVi(evn,titleName){
			var i,tablink,tabcontent;
			tabcontent = document.getElementsByClassName('content__tabmain--vitien--tabcontent');
			for( i = 0 ; i < tabcontent.length;i++){
				tabcontent[i].style.display="none";
			}
			tablinks = document.getElementsByClassName('content__tabmain--vitien--tablinks');
			for( i = 0 ; i< tablinks.length; i++){
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			document.getElementById(titleName).style.display="block";
			evn.currentTarget.className+=" active";
			
		}
		document.getElementById('defaultClick').click();
		document.getElementById('defaultOpen').click();
	</script>
</body>
</html>