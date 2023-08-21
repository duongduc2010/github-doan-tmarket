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
    $sql_pheduyetgv = "SELECT id FROM pheduyetgiaovien WHERE taikhoan ='$iduser'";
    $stmt_pheduyetgv = $conn->prepare($sql_pheduyetgv);
    $query_pheduyetgv = $stmt_pheduyetgv->execute();
    $result_pheduyetgv=array();
    while($row_pheduyetgv = $stmt_pheduyetgv->fetch(PDO::FETCH_ASSOC)){
        $result_pheduyetgv[] = $row_pheduyetgv;
    }
    foreach ($result_pheduyetgv as $items) {
        $id_pheduyetgv = $items['id'];
    }
    if(!empty($_POST['submit'])){
        if(isset($_POST['checkbox'])){
            if(!empty($id_pheduyetgv)){
                header("location:trothanhgiaovienbuoc4.php?id=$iduser");
            }
            else{
                header("location:xac-thuc-giao-vien.php?id=$iduser");
            }
            
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trở thành giáo viên</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
    <script type="text/javascript" href = "js/bootstrap.min.js"></script>
    <script type="text/javascript" href = "js/jquery-3.6.2.slim.js"></script>
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/becometc.css">
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
    <div id="content">
        <div class="slogan">
            <label >Dễ dàng thành thạo tiếng anh</label>
        </div>
    </div>
    <container class="trothanhgv">
        <div style="background-image: url(img/bggv.jpg);" class="bctc-container">
            <form method="post">
                <div class="banner2">
                    <p class="banner2_heading">Before starting</p>
                    <p class="banner2_desc">
                        Check the information below. You must read everything thoroughly.
                    </p>
                    <p class="banner2_desc">
                        After finding the answers and the documents you need, you can sign up.
                    </p>
                </div>
                <div class="card_container">
                    <div class="card">
                        <div class="card_item">
                            <img class="card_item-line" src="img/Group 247.svg" alt="">
                            <img src="img/application-icon-1.bd5b3e00 1.svg" alt="" class="card_item-icon">
                            <div class="card_item-label">Is your language ready for teaching?</div>
                            <div class="card_item-line2"></div>
                            <div class="card_item-desc">Before you apply, please check if your teaching language is open for teaching application or not.</div>
                            <div class="card_item-btn">Read more</div>
                        </div>
                        <div class="card_item">
                            <img class="card_item-line" src="img/Group 247.svg" alt="">
                            <img src="img/application-icon-1.bd5b3e00 1.svg" alt="" class="card_item-icon">
                            <div class="card_item-label">Is your language ready for teaching?</div>
                            <div class="card_item-line2"></div>
                            <div class="card_item-desc">Before you apply, please check if your teaching language is open for teaching application or not.</div>
                            <div class="card_item-btn">Read more</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card_item">
                            <img class="card_item-line" src="img/Group 247.svg" alt="">
                            <img src="img/application-icon-1.bd5b3e00 1.svg" alt="" class="card_item-icon">
                            <div class="card_item-label">Is your language ready for teaching?</div>
                            <div class="card_item-line2"></div>
                            <div class="card_item-desc">Before you apply, please check if your teaching language is open for teaching application or not.</div>
                            <div class="card_item-btn">Read more</div>
                        </div>
                        <div class="card_item">
                            <img class="card_item-line" src="img/Group 247.svg" alt="">
                            <img src="img/application-icon-1.bd5b3e00 1.svg" alt="" class="card_item-icon">
                            <div class="card_item-label">Is your language ready for teaching?</div>
                            <div class="card_item-line2"></div>
                            <div class="card_item-desc">Before you apply, please check if your teaching language is open for teaching application or not.</div>
                            <div class="card_item-btn">Read more</div>
                        </div>
                    </div>
                </div>
                
                <div class="law">
                    <input type="checkbox" name="checkbox" id="hi" value="1" class="check"> 
                    <label for="hi"> I agree with all requirements and regulations at Tmarket</label>
                </div>
                <input style="cursor: pointer;" type="submit" class="btn-register" name="submit" value="Register now">
            </form>
        </div>
    </container>
   
    
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

    <script src="./js/becometc.js"></script>
    <script>
        function menuFunction(x) {
            x.classList.toggle("change");
          document.getElementById("myDropdown").classList.toggle("show");
        }
    </script>
</body>
</html>