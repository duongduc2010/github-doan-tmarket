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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Câu hỏi thường gặp</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style/question.css">
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">

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
    <container>
        <div class="content-question">
            <div class="question-container">
                <div class="list-question">
                    <button class="quiz-btn">Câu hỏi thường gặp</button>
                    <div class="tab-list">
                        <div class="tab-list_item">
                            <div class="tab">
                                <div class="tab-item">
                                    <div class="tab-label">Giáo viên</div>
                                    <div class="tab-icon">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane ">
                                <div class="tab-pane_item">
                                    <ul class="tab-pane_list">
                                        <li class="tab-link"> 
                                            <a href="#">Làm thế nào để trở thành giáo viên</a> 
                                        </li>
                                        <li class="tab-link"> 
                                            <a href="#">Quy tắc và yêu cầu</a>
                                        </li>
                                        <li class="tab-link"> 
                                            <a href="#">Bạn là kiểu giáo viên nào</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-list_item">
                            <div class="tab">
                                <div class="tab-item">
                                    <div class="tab-label">Giáo viên</div>
                                    <div class="tab-icon">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane ">
                                <div class="tab-pane_item">
                                    <ul class="tab-pane_list">
                                        <li class="tab-link"> 
                                            <a href="#">Làm thế nào để trở thành giáo viên</a> 
                                        </li>
                                        <li class="tab-link"> 
                                            <a href="#">Quy tắc và yêu cầu</a>
                                        </li>
                                        <li class="tab-link"> 
                                            <a href="#">Bạn là kiểu giáo viên nào</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="tab-list_item">
                            <div class="tab">
                                <div class="tab-item">
                                    <div class="tab-label">Giáo viên</div>
                                    <div class="tab-icon">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane ">
                                <div class="tab-pane_item">
                                    <ul class="tab-pane_list">
                                        <li class="tab-link"> 
                                            <a href="#">Làm thế nào để trở thành giáo viên</a> 
                                        </li>
                                        <li class="tab-link"> 
                                            <a href="#">Quy tắc và yêu cầu</a>
                                        </li>
                                        <li class="tab-link"> 
                                            <a href="#">Bạn là kiểu giáo viên nào</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
    
                <div class="post">
                    <img class="logo" src="./img/logo-market.png" alt="">
                    <br>
                    <br>
                    <b>Làm thế nào để trở thành Giáo viên chuyên? Các điều kiện về chứng chỉ?</b>
                    <div class="post-content">
                        <span>Đầu tiên, giáo viên chuyên cần phải chứng minh được trình độ của họ để giảng dạy tất cả (các) ngôn ngữ mà họ định giảng dạy.</span>
                    </div>

                </div>
            </div>
        </div>
    </container>
    <footer class="footer-distributed">

            <div class="footer-left">

                <h3><img class="logo-market" src="img/logo-market.png"></h3>

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
    <script src="./js/question.js"></script>
    <script>
        function menuFunction(x) {
            x.classList.toggle("change");
          document.getElementById("myDropdown").classList.toggle("show");
        }
    </script>
</body>
</html>