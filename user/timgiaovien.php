<?php
    include('../user/connect.php');
    //Lấy thông tin giáo viên
    if(empty($_POST['submit']) && empty($_POST['locgv'])&& empty($_POST['locqg'])){
        $sql_gv = "SELECT giaovien.* ,theloaigiaovien.tentheloai as tentl ,quocgia.quocgia as tenqg
                    FROM giaovien,theloaigiaovien,quocgia
                    WHERE giaovien.theloaigiaovien = theloaigiaovien.id
                    and giaovien.quocgia = quocgia.id
                    ORDER BY giaovien.danhgia DESC";
        $stmt_gv = $conn->prepare($sql_gv);
        $query_gv = $stmt_gv->execute();
        $result_gv = array();
        while($row_gv = $stmt_gv->fetch(PDO::FETCH_ASSOC)){
            $result_gv[] = $row_gv;
        }
        //Lấy số lượng giáo viên
        $sql_sl = "SELECT count(id) as slgv FROM giaovien";
        $stmt_sl= $conn->prepare($sql_sl);
        $query_sl = $stmt_sl->execute();
        $result_sl = array();
        while($row_sl = $stmt_sl->fetch(PDO::FETCH_ASSOC)){
            $result_sl[] = $row_sl;
        }
        foreach($result_sl as $items){
            $slgv = $items['slgv'];
        }
    }
    else{
        
        if(!empty($_POST['locgv'])){
             
            $timkiem='';
            if($_POST['gvcn']){
                $timkiem = $_POST['gvcn'];
            }

            if($_POST['gscd']){
                $timkiem = $_POST['gscd'];
            }
            $sql_gv = "SELECT giaovien.* ,theloaigiaovien.tentheloai as tentl ,quocgia.quocgia as tenqg
                        FROM giaovien,theloaigiaovien,quocgia
                        WHERE giaovien.theloaigiaovien = theloaigiaovien.id
                        and giaovien.quocgia = quocgia.id
                        and theloaigiaovien.tentheloai LIKE '%$timkiem%'
                        ORDER BY giaovien.danhgia DESC";
            $stmt_gv = $conn->prepare($sql_gv);
            $query_gv = $stmt_gv->execute();
            $result_gv = array();
            while($row_gv = $stmt_gv->fetch(PDO::FETCH_ASSOC)){
                $result_gv[] = $row_gv;
            }
            //Lấy số lượng giáo viên
            $sql_sl = "SELECT count(giaovien.id) as slgv,theloaigiaovien.tentheloai FROM giaovien,theloaigiaovien 
                    WHERE giaovien.theloaigiaovien = theloaigiaovien.id 
                    and theloaigiaovien.tentheloai LIKE '%$timkiem%'";
            $stmt_sl= $conn->prepare($sql_sl);
            $query_sl = $stmt_sl->execute();
            $result_sl = array();
            while($row_sl = $stmt_sl->fetch(PDO::FETCH_ASSOC)){
                $result_sl[] = $row_sl;
            }
            foreach($result_sl as $items){
                $slgv = $items['slgv'];
            }  
             
        }
        elseif(!empty($_POST['submit'])){
            $timkiem = $_POST['timkiem'];
            $sql_gv = "SELECT giaovien.* ,theloaigiaovien.tentheloai as tentl ,quocgia.quocgia as tenqg
                        FROM giaovien,theloaigiaovien,quocgia
                        WHERE giaovien.theloaigiaovien = theloaigiaovien.id
                        and giaovien.quocgia = quocgia.id
                        and hoten LIKE '%$timkiem%'
                        ORDER BY giaovien.danhgia DESC"; 
            $stmt_gv = $conn->prepare($sql_gv);
            $query_gv = $stmt_gv->execute();
            $result_gv = array();
            while($row_gv = $stmt_gv->fetch(PDO::FETCH_ASSOC)){
                $result_gv[] = $row_gv;
            }
    
    
            //Lấy số lượng giáo viên
            $sql_sl = "SELECT count(id) as slgv FROM giaovien WHERE hoten LIKE '%$timkiem%'";
            $stmt_sl= $conn->prepare($sql_sl);
            $query_sl = $stmt_sl->execute();
            $result_sl = array();
            while($row_sl = $stmt_sl->fetch(PDO::FETCH_ASSOC)){
                $result_sl[] = $row_sl;
            }
            foreach($result_sl as $items){
                $slgv = $items['slgv'];
            }
            // 
        }
        elseif(!empty($_POST['locqg'])){
            $timkiem='';
            if($_POST['vietnam']){
                $timkiem = $_POST['vietnam'];
            }
            if($_POST['my']){
                $timkiem = $_POST['my'];
            }
            if($_POST['Philippines']){
                $timkiem = $_POST['Philippines'];
            }
            
            $sql_gv = "SELECT giaovien.* ,theloaigiaovien.tentheloai as tentl ,quocgia.quocgia as tenqg
                        FROM giaovien,theloaigiaovien,quocgia
                        WHERE giaovien.theloaigiaovien = theloaigiaovien.id
                        and giaovien.quocgia = quocgia.id
                        and quocgia.quocgia = '$timkiem'
                        ORDER BY giaovien.danhgia DESC"; 
            $stmt_gv = $conn->prepare($sql_gv);
            $query_gv = $stmt_gv->execute();
            $result_gv = array();
            while($row_gv = $stmt_gv->fetch(PDO::FETCH_ASSOC)){
                $result_gv[] = $row_gv;
            }
    
    
            //Lấy số lượng giáo viên
            $sql_sl = "SELECT count(id) as slgv FROM giaovien WHERE hoten LIKE '%$timkiem%'";
            $stmt_sl= $conn->prepare($sql_sl);
            $query_sl = $stmt_sl->execute();
            $result_sl = array();
            while($row_sl = $stmt_sl->fetch(PDO::FETCH_ASSOC)){
                $result_sl[] = $row_sl;
            }
            foreach($result_sl as $items){
                $slgv = $items['slgv'];
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
    <title>Tìm giáo viên</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/timgv.css">
</head>
<body>
    <header>
        <div class="menu container">
            <a class="logo" href="index.php">
                <img class="logo-market" src="img/logo-market.png">
            </a>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="timgiaovien.php">Tìm giáo viên</a></li>
                <li class="nav-item"><a class="nav-link" href="trothanhgiaovien.php">Trở thành giáo viên</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Hướng dẫn</a>
                    <ul class="sub-menu">
                        <li><a href="huongdanwithgv.php">Hướng dẫn đối với giáo viên</a></li>
                        <li><a href="huongdanwithhv.php">Hướng dẫn đối với học viên</li>
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
    <container>
        <div class="search_teacher-container">
            <div class="search_teacher">
                <div class="contry">
                    <a href="#" class="search_tc1">Quốc gia</a>
                    <div class="dropdown">
                        <form method="post" class="dropdown-menu">
                            <div class="dropdown-item" href="#">
                                <input class="dropdown-item_cb" value="Việt Nam" type="radio" name="vietnam" id="tagt">
                                <label class="dropdown-item_lb" for="tagt">Việt Nam</label>
                            </div>
                            <div class="dropdown-item" href="#">
                                <input class="dropdown-item_cb" value="Mỹ" type="radio" name="my" id="2">
                                <label class="dropdown-item_lb" for="2">Mỹ</label>
                            </div>
                            <div class="dropdown-item" href="#">
                                <input class="dropdown-item_cb" value="Philipine" type="radio" name="Philippines" id="3">
                                <label class="dropdown-item_lb" for="3">Philippines</label>
                            </div>
                            <div class="dropdown-btn">
                                    <input class="submit" type="submit" name="locqg" value="Áp dụng">
                                </div>
                        </form>
                      </div>
                </div>
                <div class="typetc">
                    <a href="#" class="search_tc1">Loại giáo viên</a>
                        <div class="dropdown">
                            <form method="post" class="dropdown-menu">
                                <div method="post" class="dropdown-item" href="#">
                                    <input class="dropdown-item_cb" type="radio" value="Giáo viên chuyên nghiệp" name="gvcn" id="tagt">
                                    <label class="dropdown-item_lb" for="tagt">Giáo viên chuyên nghiệp</label>
                                </div>
                                
                                <div class="dropdown-item" href="#">
                                    <input class="dropdown-item_cb" type="radio" value="Gia sư cộng đồng" name="gscd" id="2">
                                    <label class="dropdown-item_lb" for="2">Gia sư cộng đồng</label>
                                </div>
                                
                                <div class="dropdown-btn">
                                    <input class="submit" type="submit" name="locgv" value="Áp dụng">
                                </div>
                            </form>
                        </div>
                    </div>
                <div class="search_tc">
                    <div class="search_tc">
                    <form class="search-form" method="post">
                        <input class="search_tc_input" name="timkiem" type="text" placeholder="Tìm kiếm theo từ khóa">
                        <!-- <i class="fa-solid fa-magnifying-glass search-icon"></i> -->
                        <input class="submit" type="submit" value="Tìm kiếm" name="submit">
                    </form>
                </div>

                </div>
            </div>
        </div>
        
        <div id="content">
            <div class="slogan">
                <label >Dễ dàng thành thạo tiếng anh</label>
            </div>
        </div>
        <div class="content">
            <div class="content_container">
                <div class="content_title">
                    <div class="content_title-text">Tìm giáo viên Tiếng Anh tốt nhất cho bạn.</div>
                    <div class="content_title-quantity"><?php echo $slgv;?></div>
                </div>
                <div class="content-title2">
                    <div class="content_title-text2">TÌM GIA SƯ TIẾNG ANH TRỰC TUYẾN TỐT NHẤT CHO BẠN</div>
                    <div class="content_title-desc">Chọn từ các giáo viên tiếng Anh có kinh nghiệm của chúng tôi trực tuyến và có được trải nghiệm học tập tốt nhất</div>
                </div>
    
                <!-- CARD -->
    
                <?php foreach ($result_gv as $items): ?>
                    <div class="content_card">
                        <div class="content_card-info">
                            <div class="content_card-info_tc">
                                <div class="content_card-info_tc1">
                                    <img src="../teacher/<?php echo $items['imgprofile']?>" alt="" class="content_card-img">
                                    <div class="content_card-add">Asia/Hai_Phong</div>
                                    <a href="dangnhap.php" class="content_card-sub">Các khóa học</a>
                                </div>
                                <div class="content_card-info_tc2">
                                    <div class="tc_name">
                                        <a href="#"><?php echo $items['hoten']?></a>
                                    </div>
                                    <div class="tc_desc">
                                        <span><?php echo $items['tentl']?></span>
                                        <p>Đến từ <?php echo $items['tenqg']?></p>
                                    </div>
                                    <div class="tc_course">
                                        <div class="course">
                                            <div class="course_label">Khóa học đang dạy</div>
                                            <div class="course_value">5</div>
                                        </div>
                                        <div class="student">
                                            <div class="student_label">Học viên</div>
                                            <div class="student_value">3</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="content_card-detail">
                            <div>
                                <ul class="card_detail-list">
                                    <li class="card_detail-item active">
                                        <span>Video tự giới thiệu</span>
                                    </li>
                                    <li class="card_detail-item">
                                        <span>Nội dung tự giới thiệu</span>
                                    </li>
                                    <div class="dong"></div>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <video class="video" controls>
                                      <source src="../teacher/<?php echo $items['video']?>" type="video/mp4">
                                    </video>
                                </div>
                                <div class="tab-pane">
                                  <p><?php echo $items['gioithieubanthan1']?></p>
                                </div>
                              </div>
                        </div>
                    </div>
                <?php endforeach ?>
                </div>

                <!-- ------------------------ -->
                <div class="show_more">
                    <a href="#" class="btn_more">HIỂN THỊ THÊM</a>
                </div>
                
            </div>
        </div>
    </container>



    <footer class="footer-distributed">

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

    </footer>
    <script src="./js/searchtc.js"></script>
</body>
</html>