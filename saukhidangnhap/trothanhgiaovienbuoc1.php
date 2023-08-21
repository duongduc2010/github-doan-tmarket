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
    //Công cụ dạy học
    $sql_ccdh = "SELECT * FROM congcudayhoc";
    $stmt_ccdh = $conn->prepare($sql_ccdh);
    $query_ccdh = $stmt_ccdh->execute();
    $result_ccdh = array();
    while($row_ccdh = $stmt_ccdh->fetch(PDO::FETCH_ASSOC)){
        $result_ccdh[] = $row_ccdh;
    }
    //Add thông tin vào bảng pheduyetgiaovien
    $tlgv=$_GET['tlgv'];
    //Submit_back
    if(!empty($_POST['submit_back'])){
        header("location:xac-thuc-giao-vien.php?id=$iduser");
    }
    
    if(!empty($_POST['submit_next'])){
        if(!empty($_POST['ho']) && !empty($_POST['ten']) && !empty($_POST['ngaysinh']) && !empty($_POST['quocgia']) && !empty($_POST['diachi']) && !empty($_POST['sdt']) && !empty($_POST['linkhoc']) && !empty($_POST['gioitinh']) && !empty($_POST['email']))
        {
            $ho = $_POST['ho'];
            $ten = $_POST['ten'];
            $ngaysinh = $_POST['ngaysinh'];
            $quocgia = $_POST['quocgia'];
            $gioitinh = $_POST['gioitinh'];
            $sdt = $_POST['sdt'];
            $linkhoc = $_POST['linkhoc'];
            $diachi = $_POST['diachi'];
            $email = $_POST['email'];
            $congcudayhoc = $_POST['congcudayhoc'];

            include("randomstring.php");
            $seo = generate_string($permitted_chars, 5);
            $duongdanluu = "../teacher/img/profile/".$iduser."1".$seo.".jpg";
            $anh = $iduser."1".$seo.".jpg";
            move_uploaded_file($_FILES["anh"]["tmp_name"],$duongdanluu);



            header("location:trothanhgiaovienbuoc2.php?id=$iduser&&tlgv=$tlgv&&ho=$ho&&ten=$ten&&ngaysinh=$ngaysinh&&quocgia=$quocgia&&gioitinh=$gioitinh&&sdt=$sdt&&linkhoc=$linkhoc&&diachi=$diachi&&email=$email&&ccdh=$congcudayhoc&&anhprofile=$anh");
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
    <title>Trở thành giáo viên</title>
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/becometc1.css">
    <link rel="stylesheet" href="style/footer.css">
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
    <container>
        <div class="banner">
            DỄ DÀNG THÀNH THẠO TIẾNG ANH
        </div>
        <div class="content">
            <form method="post" enctype="multipart/form-data">
                <div class="content-container"> 
                        <div class="title">Personal information</div>
                        <div class="box-step">
                            <img src="./img/Subtract.png" alt="" class="step">
                            <img src="./img/Subtract2.png" alt="" class="step">
                            <img src="./img/Subtract2.png" alt="" class="step">
                            <img src="./img/Subtract2.png" alt="" class="step">
                        </div>
                        <div class="box-form">
                            <div class="title">Private</div>
                            <div class="form-input">
                                <div class="form-input_input">
                                    <div class="input-label">Last name</div>
                                    <input name="ho" class="input-value" type="text" >
                                </div>
                                <div class="form-input_input">
                                    <div class="input-label">First name</div>
                                    <input name="ten" class="input-value" type="text">
                                </div>
                            </div>
                            <div class="form-input">
                                <div class="form-input_input">
                                    <div class="input-label">Email</div>
                                    <input name="email" class="input-value" type="text" >
                                </div>
                                <div class="form-input_input">
                                    <div class="input-label">Phone number</div>
                                    <input name="sdt" class="input-value" type="text">
                                </div>
                            </div>
                            <div class="form-input">
                                <div class="form-input_input">
                                    <div class="input-label">Date of birth</div>
                                    <input name="ngaysinh" class="input-value" type="date" >
                                </div>
                                <div class="form-input_input">
                                    <div class="input-label">Sex</div>
                                    <select name="gioitinh" class="input-value">
                                        <?php foreach ($result_gioitinh as $items): ?>
                                            <option value="<?php echo $items['id'];?>"><?php echo $items['gioitinh'];?></option>
                                        <?php endforeach ?>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="form-input2">
                                <div class="input-label">Country</div>
                                <select name="quocgia" class="input-value2">
                                    <?php foreach ($result_quocgia as $items):?>
                                         <option value="<?php echo $items['id'];?>"><?php echo $items['quocgia'];?></option>
                                    <?php endforeach?>
                                   
                                </select>
                            </div>

                            <div class="form-input2">
                                <div class="input-label">Address</div>
                                <input name="diachi" class="input-value" type="text" >
                            </div>
                        </div>

                        <div class="box-form">
                            <div class="title">Basic information*</div>
                            <div class="form-input">
                                <div class="form-input_input">
                                    <div class="input-label">Chat platform</div>
                                    <select class="input-value" name="congcudayhoc">
                                        <?php foreach ($result_ccdh as $items):?>
                                            <option value="<?php echo $items['id']?>"><?php echo $items['tencongcu']?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-input_input">
                                    <div class="input-label">Link</div>
                                    <input name="linkhoc" class="input-value" type="text" placeholder="Link for teacher" >
                                </div>
                            </div>
                            
                        </div>

                        <div class="box-form">
                            <div class="title">Curriculums*</div>
                            <div class="profile">
                                <div class="input-label">Teacher’s profile picture*</div>
                                <div class="profile-note">
                                    <div class="profile-note_label">Note</div>
                                    <div>
                                        <ul class="profile-note_value">
                                            <li>Edit your profile picture</li>
                                            <li>At least 500x500 pixel</li>
                                            <li>Format JPG, PNG, and BMP</li>
                                            <li>Maximum of 2MB</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="profile-img">
                                    <div class="profile-img_box">
                                        <img src="./img/Vector.svg" alt="">
                                        <div class="profile-img_box-label">Insert image</div>
                                        <label>Hình ảnh</label>
                                        <input type="file" required id="images" name="anh" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh">
                                    </div>
                                </div>

                                <div class="profile-note2">
                                    <div class="profile-note2_left">
                                        <div class="profile-note2_label">Your image must follow these features:</div>
                                        <ul class="profile-note2_left-list">
                                            <li>Photo of yourself</li>
                                            <li>Not too close or too far away</li>
                                            <li>Clearly show your face and your eyes</li>
                                            <li>Be clear and have good brightness</li>
                                        </ul>
                                    </div>
                                    <div class="profile-note2_right">
                                        <div class="profile-note2_label">Does your photo look like this? If yes, it’s amazing.</div>
                                        <div class="profile-note2_right-img">
                                            <img class="note-img" src="./img/good_sample1 1.png" alt="">
                                            <img class="note-img" src="./img/good_sample1 1.png" alt="">
                                            <img class="note-img" src="./img/good_sample1 1.png" alt="">
                                            <img class="note-img" src="./img/good_sample1 1.png" alt="">
                                        </div>
                                        <div class="profile-note2_label">DO NOT use photos like below:</div>
                                        <div class="profile-note2_right-img">
                                            <img class="note-img" src="./img/bad_sample2.png" alt="">
                                            <img class="note-img" src="./img/bad_sample2.png" alt="">
                                            <img class="note-img" src="./img/bad_sample2.png" alt="">
                                            <img class="note-img" src="./img/bad_sample2.png" alt="">
                                        </div>
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
    </container>
    <footer class="footer-distributed">

        <div class="footer-left">

            <h3><img class="logo" src="img/logo-market.png"></h3>

            <p class="footer-links">
                <a href="index.php?id=<?php echo $iduser?>" class="link-1">Trang chủ</a>
                
                <a href="#">Tìm giáo viên</a>
            
                <a href="#">Trở thành giáo viên</a>
            
                <a href="#">Hướng dẫn đối với giáo viên</a>
                
                <a href="#">Hướng dẫn đối với học viên</a>

                <a href="#">Câu hỏi thường gặp</a>
                
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