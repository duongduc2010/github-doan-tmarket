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
        $vitien = $items['vitien'];
    }
    //Lấy dữ liệu khóa học
    $idkh = $_GET['idkh'];
    $idgv = $_GET['idgv'];
    $sql_kh = "SELECT khoahocgiaovien.*,giaovien.vitien,congcudayhoc.tencongcu,theloaikhoahoc.tenkhoahoc,cahoc.thoigian FROM khoahocgiaovien,congcudayhoc,giaovien,theloaikhoahoc,cahoc WHERE khoahocgiaovien.id = '$idkh' and khoahocgiaovien.theloaikhoahocid = theloaikhoahoc.id and khoahocgiaovien.cahoc = cahoc.id and giaovien.id = khoahocgiaovien.giaovienid and giaovien.idcongcudayhoc = congcudayhoc.id";
    $stmt_kh = $conn->prepare($sql_kh);
    $query_kh = $stmt_kh->execute();
    $result_kh = array();
    while($row_kh = $stmt_kh->fetch(PDO::FETCH_ASSOC)){
        $result_kh[] = $row_kh;
    }
    foreach ($result_kh as $items) {
        $tenkh = $items['tenkhoahoc'];
        $hocphi = $items['hocphi'];
        $tgbatdau = $items['thoigianbatdau'];
        $tgketthuc = $items['thoigianketthuc'];
        $cahoc = $items['thoigian'];
        $tencongcu = $items['tencongcu'];
        $vigv = $items['vitien'];
    }


    //Chỉ được đăng ký khóa học 1 lần
    $sql11="SELECT * FROM khoahochocvien";
    $stmt11=$conn->prepare($sql11);
    $query11 = $stmt11->execute();
    $result11=array();
    while($row11=$stmt11->fetch(PDO::FETCH_ASSOC)){
        $result11[]=$row11;
    }


    function ktra($idkh,$idhv,$result){  
        foreach ($result as $items)
        {
            if($items['idkhoahoc'] == $idkh && $items['idhocvien'] == $idhv){
                return true;
            }
        }
        return false;
    }

    //Đăng ký khóa học
    if(isset($_POST['submit'])){
        if(ktra($idkh,$iduser,$result11) == false){
            if($_POST['check'] == '1'){
                $sql_dky = "INSERT INTO khoahochocvien(idkhoahoc,idhocvien,tinhtrang,hinhthucthanhtoan) VALUES('$idkh','$iduser','Đang phê duyệt','2')";
                $stmt_dky = $conn->prepare($sql_dky);
                $query_dky = $stmt_dky->execute();
                if($query_dky){
                    header("location:dskh.php?id=$iduser");
                }
                else{
                    echo "Đăng ký thất bại";
                }
            }
            if($_POST['check'] == '2'){
                if($vitien >= $hocphi){
                    $sql_dky = "INSERT INTO khoahochocvien(idkhoahoc,idhocvien,tinhtrang,hinhthucthanhtoan) VALUES('
                                $idkh','$iduser','Phê duyệt thành công','1')";
                    $stmt_dky = $conn->prepare($sql_dky);
                    $query_dky = $stmt_dky->execute();


                    $sql_vitien = "UPDATE taikhoan SET vitien = vitien - $hocphi";
                    $stmt_vitien = $conn->prepare($sql_vitien);
                    $query_vitien = $stmt_vitien->execute();

                    $tienconlai = $vitien - $hocphi;
                    $sql_lsgd = "INSERT INTO lsgiaodich(idtaikhoan,mota,biendong,tienconlai) VALUES('$iduser','Trừ tiền','$hocphi','$tienconlai')";
                    $stmt_lsgd = $conn->prepare($sql_lsgd);
                    $query_lsgd = $stmt_lsgd->execute();

                    $sql_vigd = "UPDATE giaovien SET vitien = vitien + $hocphi*0.7 WHERE id='$idgv'";
                    $stmt_vigd = $conn->prepare($sql_vigd);
                    $query_vigd = $stmt_vigd->execute();

                    $congtien = $hocphi * 0.7;
                    $tienconlai = $vigv + $congtien;
                    $sql_lsgdgv = "INSERT INTO lichsugiaodich(idgiaovien,mota,biendong,tongtienconlai) VALUES('$idgv','Cộng tiền','$congtien','$tienconlai')";
                    $stmt_lsgdgv = $conn->prepare($sql_lsgdgv);
                    $query_lsgdgv = $stmt_lsgdgv->execute();

                    $doanhthu = $hocphi * 0.3;
                    $sql_doanhthu = "INSERT INTO doanhthu(idkhoahoc,sotien) VALUES('$idkh','$doanhthu')";
                    $stmt_doanhthu = $conn->prepare($sql_doanhthu);
                    $query_doanhthu = $stmt_doanhthu->execute();

                    if($query_dky && $query_lsgd && $query_vitien &&  $query_lsgdgv && $query_doanhthu && $query_vigd){
                        header("location:dskh.php?id=$iduser");
                    }
                    else{
                        echo "Đăng ký thất bại";
                    }
                }
                else{
                    echo "Số tiền trong ví phải lớn hơn học phí";
                }
        }
        }
        else{
            echo "Bạn đã đăng ký khóa học này rồi";
            header("location:timgiaovien.php?id=$iduser");
        }
    }
    //
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/xacnhandangkyhoc.css">
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
        <form method="post">
            <div class="noidungchinh">
                <div class="box">
                    <div class="label-top">Tên khóa học</div>
                    <div class="label-bottom">
                        <div class="label-bottom-left"><?php echo $tenkh?></div>
                        <div class="label-bottom-right"></div>
                    </div>
                </div>
                <div class="box">
                    <div class="label-top">Lịch học</div>
                    <div class="label-bottom">
                        <div class="label-bottom-left">Từ <?php echo date("d-m-Y",strtotime($tgbatdau));?> đến <?php echo date("d-m-Y",strtotime($tgketthuc));?></div>
                        <div class="label-bottom-right"></div>
                    </div>
                </div>
                <div class="box">
                    <div class="label-top">Thời gian học</div>
                    <div class="label-bottom">
                        <div class="label-bottom-left"><?php echo $cahoc?></div>
                        <div class="label-bottom-right"></div>
                    </div>
                </div>
                <div class="box">
                    <div class="label-top">Công cụ giao tiếp</div>
                    <div class="label-bottom">
                        <div class="label-bottom-left"><?php echo $tencongcu?></div>
                        <div class="label-bottom-right"><i class="box-icon fa-brands fa-google"></i></div>
                    </div>
                </div>
                <div class="box">
                    <div class="label-top">Học phí</div>
                    <div class="label-bottom">
                        <div class="label-bottom-left"><?php echo number_format($hocphi)?></div>
                        <div class="label-bottom-right"><i class="box-icon fa-solid fa-coins"></i></div>
                    </div>
                </div>
                <div class="box">
                    <div class="label-top">Phương thức thanh toán</div>
                    <div class="label-bottom">
                        <div class="label-bottom-left"><input value="1" onclick="checkedOnClick(this)" class="checkbox-type" id="tk" name="check" type="checkbox"><label for="tk">Tài khoản ngân hàng</label></div>
                        <div class="label-bottom-right"><input value="2" onclick="checkedOnClick(this)" class="checkbox-type" id="vitien" name="check" type="checkbox"><label for="vitien">Ví tmarket</label></div>
                    </div>
                </div>

                <div style="display: none" id="qr" class="qr">
                    <img class="qr-code" src="img/qr-code.jpg" alt="">
                    <div class="qr-description">
                        <p>Bạn vui lòng thanh toán đúng số tiền học phí và ghi rõ nội dung chuyển khoản </p>
                        <p>Hovaten-sodienthoai-tenkhoahoc</p>
                        <p>Ví dụ: NguyenVanA-0888666555-English Pronunciation</p>
                        <p><span style="color:red">Chú ý:</span> Chuyển khoản xong hãy ấn "Xác nhận đã thanh toán"</p>
                    </div>
                </div>
                <div style="display: none" id="vi" class="qr">
                    <div class="qr-description">
                        <p>Bạn vui lòng kiểm tra trong ví có đủ tiền thanh toán hay không</p>
                        <p>Nếu đủ bạn hãy ấn "Xác nhận đã thanh toán" để thanh toán</p>
                        <p><span style="color:red">Chú ý: </span>Số tiền trong ví sẽ bị trừ sau khi ấn "Xác nhận thanh toán"</p>
                    </div>
                </div>
                
                <input name="submit" class="btn-xacnhan" type="submit" value="Xác nhận đã thanh toán" />
                
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
          var tk = document.getElementById("tk");
          var content = document.getElementById("qr");
          if(tk.checked == true){
            content.style.display="block";
          }
          else{
            content.style.display="none";
          }
          var vi = document.getElementById("vitien");
          var noidung = document.getElementById("vi");
          if(vi.checked == true){
            noidung.style.display="block";
          }
          else{
            noidung.style.display="none";
          }
       }
    </script>
</footer>
</body>
</html>