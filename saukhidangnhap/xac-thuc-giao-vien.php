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
    if(!empty($_POST['submit'])){
        if(isset($_POST['checkbox'])){
            $value=$_POST['checkbox'];
            header("location:trothanhgiaovienbuoc1.php?id=$iduser&&tlgv=$value");
        }
        
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/header.css">
    <link rel="stylesheet" href="./style/xacthucgv.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./style/footer.css">
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
            
            <div class="content-container">
                <form method="post">
                    <div class="logo">
                        <img src="./img/logo-market.png" alt="">
                    </div>
                    <div class="title-post">Types of teachers</div>
                    <div class="container-icon">
                        
                            <div class="box-icon">
                                <div class="icon">
                                    <img src="./img/APPLICATION.svg" alt="" class="icon-img">
                                    <div name="lgv"   class="icon-text">Professional teacher</div>
                                </div>
                                <div class="checkbox">
                                    <input name="checkbox"  type="checkbox" onclick="checkedOnClick(this)" value="1" class="checkbox-type">
                                </div>
                            </div>
                            <div class="box-icon">
                                <div class="icon">
                                    <img src="./img/APPLICATION.svg" alt="" class="icon-img">
                                    <div class="icon-text">Community tutor</div>
                                </div>
                                <div class="checkbox">
                                    <input name="checkbox"  type="checkbox" onclick="checkedOnClick(this)" value="2" class="checkbox-type">
                                </div>
                            </div>
                    </div>
                    <div class="title2">Requirements</div>

                    <div class="container-text">
                        <div class="box-text">Native speakers or near-native speakers with teaching experiences or be qualified for language teaching as a second language or a foreign language. Above 18 years old.</div>
                        <div class="box-text">Native speakers or near-native speakers who love teaching part-time. Above 18 years old.</div>
                    </div>

                    <div class="title2">Certifications</div>
                    <div class="container-text">
                        <div class="box-text">Native speakers or near-native speakers with teaching experiences or be qualified for language teaching as a second language or a foreign language. Above 18 years old.</div>
                        <div class="box-text">Native speakers or near-native speakers who love teaching part-time. Above 18 years old.</div>
                    </div>
                    <div class="title2">Introduction Video</div>
                    <div class="container-text">
                        <div class="box-text">Length: 1 to 3 minutes.</div>
                        <div class="box-text">Length: 1 to 3 minutes.</div>
                    </div>
                    <div class="title2">Options</div>
                    <div class="container-text">
                        <div class="box-text">Set your own tuition fee.</div>
                        <div class="box-text">Set your own tuition fee.</div>
                    </div>
                    <input style="cursor: pointer;" type="submit" class="button-next" name="submit" value="Next">
                </form>
            </div>
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
</body>
<script>
        function menuFunction(x) {
            x.classList.toggle("change");
          document.getElementById("myDropdown").classList.toggle("show");
        }
        function checkedOnClick(el){

          // Select all checkboxes by class
          var checkboxesList = document.getElementsByClassName("checkbox-type");
          for (var i = 0; i < checkboxesList.length; i++) {
             checkboxesList.item(i).checked = false; // Uncheck all checkboxes
          }

          el.checked = true; // Checked clicked checkbox
       }
    </script>
</html>