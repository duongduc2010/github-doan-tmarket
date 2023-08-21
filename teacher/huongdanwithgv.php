<?php
	include('../user/connect.php');
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
    <link rel="stylesheet" type="text/css" href="style/huongdandvgv.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
	<title>Hướng dẫn đối với giáo viên</title>
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
		<div class="slogan">
			<label >Dễ dàng thành thạo tiếng anh</label>
		</div>
	<content >
		<h1>HƯỚNG DẪN SỬ DỤNG ĐỐI VỚI GIÁO VIÊN</h1>
		<section class="muc mot">
			<h4>I. Giới thiệu chung (Introduction)</h4>
			<p>Tmarket là nền tảng kết nối giữa Giáo viên và Học viên có nhu cầu học Ngoại ngữ, thông qua các lớp học trực tuyến với mô hình học 1 Thầy-1 Trò hoặc 1 Thầy-1 nhóm và lớp học được thực hiện trên nền tảng Zoom, Google meet, …</p>
			<p>Đường dẫn phần mềm bản chính thức: <a href="index.php?id=<?php echo $id_teacher ?>">https://tmarket.edu.vn/</a></p>
			<img src="img/hdgiaovien/1.jpg">
		</section>
		<section class="muc hai">
			<h4>II. Đăng ký/ đăng nhập tài khoản hệ thống</h4>
			<p>Vui lòng chuyển sang ngôn ngữ “English” để có thể dễ dàng sử dụng website</p>
			<img class="anh1" src="img/hdgiaovien/2.1.png">
			<h5>Bước 1: Truy cập vào địa chỉ <a href="index.php?id=<?php echo $id_teacher ?>">https://tmarket.edu.vn/</a></h5>
			<img src="img/hdgiaovien/2.2.jpg">
			<h5>Bước 2: Bên trên góc phải màn hình ấn hiển thị “Login” và “Register”</h5>
			<img src="img/hdgiaovien/2.3.jpg">
			<ul>
				<li>Nếu đã có tài khoản, bạn cần điền chính xác các thông tin của tài khoản sau đó ấn “Log in ”, có thể đăng nhập nhanh bằng tài khoản Gmail, Facebook… (Lưu ý đối với tài khoản Facebook thì chỉ chọn được đối tượng là Học viên)</li>
				<img src="img/hdgiaovien/2.4.jpg">
			</ul>
			<p style="font-weight: bold">TRANG CHỦ ĐĂNG NHẬP</p>
			<img src="img/hdgiaovien/2.5.jpg">
			<ul>
				<li>Nếu chưa có tài khoản thì ấn vào “Register ” và tiến hành đăng ký theo các bước :</li>
				<p>B1: Người dùng điền các thông tin Họ-tên, Email, mật khẩu.</p>
				<img src="img/hdgiaovien/2.6.jpg">
				<p>B2: Người dùng nhập mã “OTP” được gửi về Email đăng ký.</p>
				<img src="img/hdgiaovien/2.7.jpg">
				<p>B3: Chọn đối tượng là “Teacher”.</p>
				<img src="img/hdgiaovien/2.8.jpg">
				<p>B4: Sau khi chọn xong đối tượng thì tiếp tục chọn “Timezone” (nơi bạn đang sinh sống và học tập). Ví dụ, giờ GMT tại Việt Nam là +7 (GMT+07:00)</p>
				<img src="img/hdgiaovien/2.9.jpg">
				<p>Sau khi hoàn thành các bước đăng ký sẽ hiển thị ra Trang chủ tài khoản Tmarket của bạn.</p>
				<img src="img/hdgiaovien/2.10.jpg">
			</ul>

			
		</section>
		<section class="muc ba">
			<h4>III. TRỞ THÀNH GIÁO VIÊN (BECOME A TEACHER)</h4>
			<p>Bước 1 : Click vào phần “Become a teacher” để có thể xem 1 số các quy định, điều khoản và hướng dẫn trước khi đăng ký</p>
			<img src="img/hdgiaovien/3.1.jpg">
			<p>Trước khi trở thành giáo viên bạn cần tìm hiểu kỹ thông tin yêu cầu, ấn vào “Read more”</p>
			<img src="img/hdgiaovien/3.2.jpg">
			<p>Sau khi đã tìm hiểu xong các yêu cầu thì người dùng tích chọn đồng ý với các quy định, điều khoản của Tmarket và bấm vào “Register now”</p>
			<img src="img/hdgiaovien/3.3.jpg">
			<p>Tại trang “Types of teachers” bạn vui lòng chọn 1 trong 2 thể loại giáo viên phù hợp với mình: giáo viên chuyên nghiệp hoặc gia sư cộng đồng. Mỗi thể loại Giáo viên sẽ có những yêu cầu khác nhau tại phần bên dưới, rồi bấm “Next”.</p>
			<img src="img/hdgiaovien/3.4.jpg">
			<p>Tiếp đó đến màn “Personal information” tại đây bạn vui lòng điền đầy đủ thông tin cá nhân trong mục “Private”</p>
			<img src="img/hdgiaovien/3.5.jpg">
			<p>“Basic information” vui lòng chọn nền tảng bạn muốn sử dụng để giảng dạy. Lưu ý phải đính kèm đường link cá nhân (Meet, Zoom…) cho từng nền tảng để Học viên dễ dàng vào học)</p>
			<p>Ví dụ: Zoom: Meeting ID: 849 468 4674</p>
			<p>Google meet: <a href="#">https://meet.google.com/jed-xmsz-yob</a></p>
			<p>Tiếp đó đến màn “Personal information” tại đây bạn vui lòng điền đầy đủ thông tin cá nhân trong mục “Private”</p>
			<p>“Curriculums” vui lòng chọn những loại khoá học mà bạn có thể dạy được, cũng như đối tượng phù hợp. Không quên chèn thêm ảnh đại diện của mình( tuân thủ đúng yêu cầu về đại diện)</p>
			<img src="img/hdgiaovien/3.6.jpg">
			<p>Chọn “ Next” để tiếp tục. Người dùng upload video giới thiệu về bản thân, viết các đoạn văn về bản thân, kinh nghiệm giảng dạy, chứng minh thư, laptop</p>
			<ul>
				<li>Tại trang “Choose your video”</li>
			</ul>
			<p>1/ “Choose your video” vui lòng upload 1 video nhỏ giới thiệu về bản thân của mình. Nếu bạn chưa rõ phải làm thế nào có thể click vào phần “Requirements for introduction video” để có thể hiểu rõ hơn về cách làm</p>
			<img src="img/hdgiaovien/3.7.jpg">
			<p>2/ “Teacher’s introduction”, mỗi phần không được quá 500 kí tự</p>
			<img src="img/hdgiaovien/3.8.jpg">
			<p>a) “About me” giới thiệu đôi nét về bản thân của mình</p>
			<p>Hi, my name is Rosario and I’m a certified TEFL (Level 5) teacher. I’ve been teaching English for a couple of years and I love it more every day. If you’re looking for a friendly, easy-going but still enthusiastic and precise English (or Italian) tutor, you found me! I can help you with General and Business English, Conversation, Grammar, and even exam preparation.</p>
			<p>b) “Me as teacher” tôi là 1 giáo viên như thế nào</p>
			<p>I am friendly, laid back and understanding. I will challenge you to get out of your comfort zone in order for you to better improve your English, as making mistakes is the best way for you to learn! I have a good work ethic and will make it my prime concern for you to better your English with personalized lessons specific to YOU.</p>
			<p>c) “Learning courses and my teaching style” phong cách và phương pháp giảng dạy</p>
			<p>I believe that students must learn at their own pace following the course that best suits their needs, interests, and attitude. I constantly make an effort to devise and create new activities and set the best (achievable) goals in order to meet every student’s necessity. Generally speaking, I like to focus on making students develop a natural way of interaction in the target language by utilizing authentic materials in listening, writing, and reading according to what the student is most comfortable with.</p>
			<p>Vui lòng upload các hình ảnh như passport or ID, bằng cấp và các chứng chỉ liên quan</p>
			<img src="img/hdgiaovien/3.9.jpg">
			<ul>
				<li>Đồng ý với các điều khoản của Tmarket rồi bấm “ Next”</li>
			</ul>
			<img src="img/hdgiaovien/3.10.jpg">
			<p>Khi bạn hoàn thành đến bước này nghĩa là thông tin đã được gửi cho hệ thống Admin. Trong vòng 10 ngày làm việc gần nhất bạn sẽ nhận được email thông báo “Phê duyệt” hoặc “Từ chối” trở thành giáo viên</p>
			<img src="img/hdgiaovien/3.11.jpg">
			<p>LƯU Ý: Đối với học viên đăng ký trở thành giáo viên thì cần cập nhật email nếu học viên đăng ký bằng số điện thoại</p>
		</section>
		<section class="muc bon">
			<h4>IV. ĐĂNG KÝ TRỞ THÀNH GIÁO VIÊN THÀNH CÔNG</h4>
			<p>SAU KHI TÀI KHOẢN GIÁO VIÊN ĐƯỢC ADMIN PHÊ DUYỆT (ĐĂNG KÝ TRỞ THÀNH GIÁO VIÊN THÀNH CÔNG) SẼ VÀO TRANG CHỦ CỦA GIÁO VIÊN</p>
			<img src="img/hdgiaovien/4.1.jpg">
			<p>Tại giao diện trang chủ của giáo viên, vui lòng click vào “ setup now ” trên dòng chữ màu vàng để thiết lập nhanh khóa học và thời gian rảnh rỗi của bạn.</p>
			<img src="img/hdgiaovien/4.2.jpg">
			<p><span>SYSTEM COURSES</span> - Trong phần này bạn sẽ được xem nội dung các khóa học, mục tiêu giảng dạy và thiết lập các khóa học bạn có thể giảng dạy (bạn có thể lựa chọn giảng dạy nhiều khóa học)</p>
			<img src="img/hdgiaovien/4.3.jpg">
			<p>Ngoài ra, bạn cần thiết lập học phí cho mỗi buổi học.</p>
			<img src="img/hdgiaovien/4.4.jpg">
			<p>Sau khi đã hoàn thành, vui lòng chọn “Create course”. Làm tương tự cho những khoá học khác mà bạn có thể giảng dạy. Trong mục này, bạn cũng có thể đề xuất tài liệu giảng dạy khác phù hợp hơn hay khóa học khác mà bạn mong muốn.</p>
			<img src="img/hdgiaovien/4.5.jpg">
			<p><span>FREE TIME</span> - Giáo viên thiết lập thời gian rảnh rỗi của bạn để học viên có thể đăng ký các khóa học. Giáo viên cần thiết lập lịch giảng dạy tối thiểu 3 tháng với thời lượng 60 giờ hoặc hơn</p>
			<img src="img/hdgiaovien/4.6.jpg">
			<p>Những ô màu trắng là những ô mà giáo viên có thể chọn lịch rảnh => Click vào 1 ô xét lịch và Giáo viên có thể xét nhiều lịch giảng dạy trong ngày</p>
			<img src="img/hdgiaovien/4.7.jpg">
			<p>Có thể xóa lịch 1 ngày cụ thể</p>
			<img src="img/hdgiaovien/4.8.jpg">
			<p>Hoặc xóa tất cả các lịch rảnh:</p>
			<img src="img/hdgiaovien/4.9.jpg">
			<h5>4.1. “Lesson invitations” là nơi bạn sẽ chấp nhận hoặc từ chối học viên đăng ký bạn</h5>
			<p>Mỗi lời mời học của học viên thì có 3 phần</p>
			<ul>
				<li>View student test: bài test gần nhất mà Học viên test</li>
				<li>Confirm: chấp nhận dạy Học viên</li>
				<li>Decline: Từ chối dạy Học viên</li>
			</ul>
			<p>Lưu ý : Đối với trường hợp mà lời mời học mà Giáo viên chưa có hành động chấp nhận/ từ chối thì hệ thống sẽ tự động từ chối sau 24h hoặc từ chối trước buổi học đầu tiên diễn ra (trường hợp buổi học đầu tiên < 24h)</p>
			<img src="img/hdgiaovien/4.10.jpg">
			<p><span>4.2. “ TEACHER SETTINGS “</span> tại đây bạn có thể thiết lập và thay đổi những cài đặt trước đó trong “Teacher’s information” và “Teacher’s profile” hay thiết lập khoá học và thời gian phù hợp để Học viên có thể đăng ký mình trong”lessons and ready status” và thao tác rút tiền trong” Money withdrawal”</p>
			<img src="img/hdgiaovien/4.11.jpg">
			<h5>4.2.1 TEACHER’S INFORMATION</h5>
			<h5>1. Thông tin cơ bản (Basic information)</h5>
			<p>Giáo viên chọn “Basic information” => hiển thị các thông tin về avatar, tên, ngày sinh, giới tính, gmail, số điện thoại, quốc gia, timezone,địa chỉ sinh sống và có thể chỉnh sửa được những thông tin đó nếu bạn muốn và ấn “update” để cập nhật thành công.</p>
			<p>Lưu ý : email không được chỉnh sửa</p>
			<img src="img/hdgiaovien/4.12.jpg">
			<h5>2. Thông tin về giấy tờ cá nhân (Personal information)</h5>
			<p>Giáo viên chọn “Personal information” => hiển thị toàn bộ chứng minh nhân dân, chứng chỉ, các dụng cụ giảng dạy, các hình ảnh mà Giáo viên cung cấp cho quản trị viên</p>
			<p>Giáo viên được cập nhật các thông tin mới về chứng chỉ bằng cấp, chứng minh nhân dân,… nếu muốn => sau đó chọn update</p>
			<img src="img/hdgiaovien/4.13.jpg">
			<h5>3. Chỉnh sửa thông tin về công cụ giao tiếp (Edit information about communication tools)</h5>
			<p>Giáo viên tạo các link họp từ những ứng dụng của bên thứ 3 như Zoom, Google Meet,… để update công cụ giảng dạy với Học viên</p>
			<img src="img/hdgiaovien/4.14.jpg">
			<h5>4. Chỉnh sửa các thông tin mà Giáo viên muốn rút tiền</h5>
			<p>Giáo viên có thể chỉnh sửa các tài khoản muốn nhận tiền mà mình đã đăng ký ví dụ như paypal,momo, tài khoản ngân hàng,…</p>
			<img src="img/hdgiaovien/4.15.jpg">
			<h5>4.2.2 TEACHER’S PROFILE</h5>
			<p><span>1.INTRODUCTION</span> - Chỉnh sửa nội dung giới thiệu về bản thân, kinh nghiệm giảng dạy của Giáo viên**</p>
			<p>Giáo viên có thể chỉnh sửa lại nội dung giới thiệu về bản thân, kinh nghiệm giảng dạy,…</p>
			<img src="img/hdgiaovien/4.16.jpg">
			<p><span>2. CONTACT FORM</span> - Giáo viên có thể gửi những yêu cầu hỗ trợ về hệ thống,các vấn đề về giảng dạy, vấn đề về rút tiền về quản trị viên</p>
			<img src="img/hdgiaovien/4.17.jpg">
			<p><span>3. VIDEO</span> - Giáo viên có thể thay đổi video giới thiệu về cá nhân của mình</p>
			<img src="img/hdgiaovien/4.18.jpg">
			<p><span>4. LANGUAGE</span> - Giáo viên có thể cập nhật thông tin về ngôn ngữ mà mình giảng dạy</p>
			<img src="img/hdgiaovien/4.19.jpg">
			<p><span>5. CURRICULUM AND CERTIFICATES</span> - Giáo viên có thể update quá trình rèn luyện, update kinh nghiệm làm việc, các chứng chỉ đạt được.</p>
			<img src="img/hdgiaovien/4.20.jpg">
			<h5>4.2.3 LESSON AND READY STATUS</h5>
			<p><span>1.READY STATUS SETTINGS</span> - Cài đặt trạng thái sẵn sàng cho Giáo viên</p>
			<img src="img/hdgiaovien/4.21.jpg">
			<p><span>Lesson requests :</span> có 3 đối tượng để cho phép đặt lịch học với Giáo viên :</p>
			<ul>
				<li>All students( tất cả Học viên)</li>
				<li>Current students( các Học viên hiện tại)</li>
				<li>New students(các Học viên mới)</li>
			</ul>
			<p><span>Instant lessons :</span> chế độ học ngay : nếu bật thì lịch học sẽ hiển thị lịch rảnh từ thời gian hiện tại (thời gian tới lịch rảnh gần nhất của bạn), nếu tắt thì sẽ ẩn time học theo (2h/6h/12h) tính từ thời gian hiện tại so với lịch rảnh bạn cài đặt trước đó.</p>
			<img src="img/hdgiaovien/4.22.jpg">
			<p><span>Auto accept :</span> tự động chấp nhận giờ học với Học viên mới / Học viên cũ/ cả 2 đối tượng</p>
			<img src="img/hdgiaovien/4.23.jpg">
			<p>CÒN 2 PHẦN <span>“COURSES MANAGEMENT”</span> VÀ <span>“ TEACHER SCHEDULE”</span>ĐÃ ĐƯỢC HƯỚNG DẪN BÊN TRÊN NẰM Ở PHẦN “ SETUP NOW”</p>
			<h5>4.2.4. MONEY WITHDRAWAL - Rút tiền</h5>
			<img src="img/hdgiaovien/4.24.jpg">
			<p><span>“Accumulated Earnings”</span> : Tổng số tiền Giáo viên đã dạy</p>
			<p><span>“Balance”</span> : Số tiền Giáo viên chưa rút</p>
			<img src="img/hdgiaovien/4.25.jpg">
			<p>Giáo viên có thể tạo lệnh rút tiền : số tiền trong ví phải trên 30$, chọn phương thức muốn thanh toán rồi gửi yêu cầu rút tiền</p>
			<img src="img/hdgiaovien/4.26.jpg">
			<p>Lịch sử rút tiền của Giáo viên (Teacher withdrawal history)</p>
			<img src="img/hdgiaovien/4.27.jpg">
			<p>Lịch sử giao dịch của Giáo viên (Teacher transaction history)</p>
			<img src="img/hdgiaovien/4.28.jpg">
			<h5>4.3 “ My teaching schedule” tại đây Giáo viên có thể xem tất cả các lịch giảng dạy cũng như lịch học của mình</h5>
			<img src="img/hdgiaovien/4.29.jpg">
			<h5>4.4.”Message” tại đây Giáo viên có thể trao đổi kiến thức với Học viên thông qua tin nhắn</h5>
			<img src="img/hdgiaovien/4.30.jpg">
			<h5>4.5. Thanh mở rộng các công cụ (Tool extension bars)</h5>
			<img src="img/hdgiaovien/4.31.jpg">
		</section>
		<section class="muc nam">
			<h4>V. BẮT ĐẦU GIẢNG DẠY (START THE LESSON)</h4>
			<p>Sau khi xác nhận khóa học của Học viên thì tại Trang chủ của Giáo viên sẽ hiện ra những khóa học, tên Học viên mà mình đã xác nhận trước đó.</p>
			<img src="img/hdgiaovien/5.1.jpg">
			<p>Bấm vào từng khóa để xem chi tiết từng buổi học trong khóa: thời gian, nội dung buổi học, trạng thái buổi học, điểm bài kiểm tra của học viên…</p>
			<img src="img/hdgiaovien/5.2.jpg">
			<p>Buổi học sau 24h sẽ hiển thị thời gian đếm ngược.</p>
			<img src="img/hdgiaovien/5.3.jpg">
			<h5>5.1 ENTER CLASSROOM - VÀO LỚP HỌC</h5>
			<p>Sẽ hiển thị nút <span>“ENTER CLASSROOM ”</span> trước 5 phút khi buổi học bắt đầu.</p>
			<p>Sau khi ấn vào nút <span>“ENTER CLASSROOM ”</span> thì sẽ link tới hệ thống của bên thứ 3 ( Google Meet hoặc Zoom,…) => Ấn “Tham gia” và chờ Học viên vào lớp để bắt đầu buổi học.</p>
			<img src="img/hdgiaovien/5.4.jpg">
			<h5>5.2 CANCEL A CLASS - HỦY BUỔI HỌC</h5>
			<p>Đối với giáo viên hủy 1 buổi học, giáo viên bị phạt 30% học phí của buổi học trong khóa học đó và được trừ trực tiếp vào ví của Giáo viên và Học viên sẽ được đặt lại lịch học bù vào một buổi khác.</p>
			<img src="img/hdgiaovien/5.5.jpg">
			<h5>5.3 CANCEL COURSE - HUỶ KHOÁ HỌC (tất cả các buổi hoàn thành hết và các buổi khiếu nại phải giải quyết xong)</h5>
			<p>Đối với giáo viên hủy khóa học : Giáo viên sẽ bị phạt 100% học phí của 1 buổi học trong khóa học của buổi học trong khóa học đó và được trừ trực tiếp vào ví của Giáo viên</p>
			<p>(Điều kiện: Giáo viên phải dạy tối thiểu 1 buổi học)</p>
			<img src="img/hdgiaovien/5.6.jpg">
			<h5>5.4 KẾT THÚC BUỔI HỌC VÀ GIẢI QUYẾT KHIẾU NẠI CỦA HỌC VIÊN</h5>
			<p>Sau khi kết thúc buổi học Giáo viên cần để ý tin nhắn Gmail gửi về của hệ thống:</p>
			<ol>
				<li>Nếu Học viên xác nhận sau buổi học thì tiền từ ví của Học viên sẽ được chuyển ngay sang ví của Giáo viên</li>
				<li>Nếu Học viên có khiếu nại về buổi học thì Giáo viên cần xử lý phản hồi lại trong vòng 11 tiếng tính từ sau buổi học</li>
				<li>Học viên không xác nhận và cũng không khiếu lại thì sau 24 giờ tính từ khi buổi học kết thúc thì hệ thống sẽ tự động trừ tiền trong ví của học viên chuyển sang ví của Giáo viên</li>
			</ol>
			<p>Học viên có thời gian là 1 tiếng sau khi buổi học hoàn thành để khiếu nại.</p>
			<p>Và bạn sẽ phải giải quyết khiếu nại bằng việc xác nhận hay từ chối khiếu nại.</p>
			<img src="img/hdgiaovien/5.7.jpg">
			<p>CÁC TRƯỜNG HỢP CỤ THỂ NHƯ SAU:</p>
			<img style="width: 600px; height: 500px;" src="img/hdgiaovien/5.8.jpg">
			<br>
			<img src="img/hdgiaovien/5.9.jpg">
			<br>
			<img src="img/hdgiaovien/5.10.jpg">
			<br>
			<h4>Xem video</h4>
			<video width="700" height="700" controls>
			  <source src="img/quang.mp4" type="video/mp4">
			</video>
		</section>

	</content>
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
