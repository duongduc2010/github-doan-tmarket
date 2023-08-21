<?php
    include("../user/connect.php");
    $sql_kh = "SELECT khoahocgiaovien.id ,theloaikhoahoc.tenkhoahoc,giaovien.hoten
                FROM khoahocgiaovien,giaovien,theloaikhoahoc
                WHERE khoahocgiaovien.giaovienid = giaovien.id
                and theloaikhoahoc.id = khoahocgiaovien.theloaikhoahocid";
    $stmt_kh  = $conn->prepare($sql_kh);
    $query_kh  = $stmt_kh->execute();
    $result_kh  = array();
    while($row_kh = $stmt_kh->fetch(PDO::FETCH_ASSOC)){
        $result_kh[] = $row_kh;
    }

    $sql_sl = "SELECT count(id) as dem FROM khoahocgiaovien";
    $stmt_sl = $conn->prepare($sql_sl);
    $query_sl = $stmt_sl->execute();
    $result_sl = array();
    while($row_sl = $stmt_sl->fetch(PDO::FETCH_ASSOC)){
        $result_sl[] = $row_sl;
    }
    foreach ($result_sl as $items) {
        $slusers = $items['dem'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" href = "js/bootstrap.min.js"></script>
    <script type="text/javascript" href = "js/jquery-3.6.2.slim.js"></script>
    <script src="https://kit.fontawesome.com/bb17412d66.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/admin.css">
    <link rel="stylesheet" type="text/css" href="style/danhsach.css">
    <title>Trang chủ admin</title>
</head>
<body>
    <div id="content">
        <div id="admin__sidebar">
            <div class="admin__profile">
                <h1>Admin</h1>
                <!-- <h3>Đức</h3> -->
            </div>
            <div class="admin__list">
                <ul>
                    <li class="admin__list--nhanvien">
                        <a href="nhanvien.php"><i class="fa-solid fa-person" style="color: #4dd31d;"></i> Quản lý nhân viên</a>
                    </li>
                    <li class="admin__list--giaovien">
                        <a href="#"  onclick="myFunction('toggle1')"><i class="fa-solid fa-person" style="color: #4dd31d;"></i> Quản lý giáo viên <i class="icondrop active fa-solid fa-chevron-right" style="color: #4dd31d;"></i><i class="icondrop fa-solid fa-chevron-down" style="color: #4dd31d;"></i></a>
                        <ul class="nav-second-level" id="toggle1">
                            <li>
                                <a href="pheduyetgiaovien.php">Phê duyệt giáo viên</a>
                            </li>
                            <li>
                                <a href="giaovien.php">Giáo viên</a>
                            </li>
                        </ul>
                    </li>
                    <li class="admin__list--hocvien">
                        <a href="#" onclick="myFunction('toggle5')"> <i class="fa-solid fa-person" style="color: #4dd31d;"></i> Quản lý học viên <i class="icondrop active fa-solid fa-chevron-right" style="color: #4dd31d;"></i><i class="icondrop fa-solid fa-chevron-down" style="color: #4dd31d;"></i></a>
                        <ul class="nav-second-level" id="toggle5">
                            <li>
                                <a href="hocvien.php">Học viên</a>
                            </li>
                            <li>
                                <a href="hocvien_pheduyet.php">Phê duyệt khóa học</a>
                            </li>
                        </ul>
                    </li>
                    <li class="admin__list--khoahoc">
                        <a href="#" onclick="myFunction('toggle6')"> <i class="fa-sharp fa-solid fa-book" style="color: #4dd31d;"></i> Quản lý khóa học <i class="icondrop active fa-solid fa-chevron-right" style="color: #4dd31d;"></i><i class="icondrop fa-solid fa-chevron-down" style="color: #4dd31d;"></i></a>
                        <ul class="nav-second-level" id="toggle6">
                            <li>
                                <a href="khoahoc.php">Thể loại khóa học</a>
                            </li>
                            <li>
                                <a href="khoahoc_giaovien.php">Khóa học giáo viên</a>
                            </li>
                        </ul>

                    </li>
                    <li class="admin__list--giaodich">
                        <a href="#" onclick="myFunction('toggle2')"><i class="fa-solid fa-money-bill" style="color: #4dd31d;"></i> Quản lý giao dịch <i class="icondrop active fa-solid fa-chevron-right" style="color: #4dd31d;"></i><i class="icondrop fa-solid fa-chevron-down" style="color: #4dd31d;"></i></a>
                        <ul class="nav-second-level" id="toggle2">
                            <li>
                                <a href="giaodich_khoahoc.php">Xét duyệt khóa học đã hoàn thành</a>
                            </li>
                            <li>
                                <a href="giaovien_ruttien.php">Quản lý rút tiền</a>
                            </li>
                            <li>
                                <a href="naptien.php">Quản lý nạp tiền</a>
                            </li>
                        </ul>
                    </li>
                    <li class="admin__list--baocao">
                        <a href="#" onclick="myFunction('toggle3')"> <i class="fa-sharp fa-solid fa-book" style="color: #4dd31d;"></i> Báo cáo <i class="icondrop active fa-solid fa-chevron-right" style="color: #4dd31d;"></i><i class="icondrop fa-solid fa-chevron-down" style="color: #4dd31d;"></i></a>
                        <ul class="nav-second-level" id="toggle3">
                            <li>
                                <a href="khoahoc_danghd.php">Khóa học đang hoạt động</a>
                            </li>
                            <li>
                                <a href="giaovien_vitien.php">Ví của giáo viên</a>
                            </li>
                            <li>
                                <a href="lichsugiaodich_gv.php">Lịch sử giao dịch của giáo viên</a>
                            </li>
                            <li>
                                <a href="lichsugiaodich_vi.php">Lịch sử giao dịch của học viên</a>
                            </li>
                            <li>
                                <a href="nguoidungmoi.php">Người dùng mới</a>
                            </li>
                            <li>
                                <a href="doanhthu.php">Doanh thu</a>
                            </li>
                            <li>
                                <a href="ykiendanhgia.php">Ý kiến đánh giá</a>
                            </li>
                            <li>
                                <a href="donggopykien.php">Đóng góp ý kiến</a>
                            </li>
                    </ul>
                    </li>
                    <li class="admin__list--hethong">
                        <a href="#" onclick="myFunction('toggle4')"> <i class="fa-sharp fa-solid fa-book" style="color: #4dd31d;"></i> Cài đặt hệ thống <i class="icondrop active fa-solid fa-chevron-right" style="color: #4dd31d;"></i><i class="icondrop fa-solid fa-chevron-down" style="color: #4dd31d;"></i></a>
                        <ul class="nav-second-level" id="toggle4">
                            <li>
                                <a href="congcudayhoc.php">Công cụ dạy học</a>
                            </li>
                            <li>
                                <a href="hinhthucthanhtoan.php">Hình thức thanh toán</a>
                            </li>
                            <li>
                                <a href="quocgia.php">Quốc gia</a>
                            </li>
                            <li>
                                <a href="timezone.php">Timezone</a>
                            </li>
                        </ul>
                    </li>
                    <li class="admin__list--dangxuat">
                        <a href="logout.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>
             
        </div>
         <div id="main_content">
            <div class="title">
                <h2>Danh sách khóa học (<?php echo $slusers?>)</h2>
            </div>
            <div class="chitiet_content">
                
                <table class="table table-inverse">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID khóa học</th>
                            <th>Tên khóa học</th>
                            <th>Tên giáo viên</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($result_kh as $items):?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $items['id'];?></td>
                            <td><?php echo $items['tenkhoahoc'];?></td>
                            <td><?php echo $items['hoten'];?></td>
                            <td><a class="btn-thongtinchitiet" href="khoahoc_danghd_chitiet.php?id=<?php echo $items['id']?>"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
                        <?php $i++; endforeach?>
                    </tbody>
                </table>      
            </div>

         </div>
    </div>
    <script type="text/javascript">
        const icondowns = document.querySelectorAll('.fa-chevron-down')
            const iconrights = document.querySelectorAll('.fa-chevron-right')
            iconrights.forEach((iconright,index)=>{
                const icondown = icondowns[index]
                iconright.onclick = function(){
                    if(iconright.classList.contains('active')){
                        iconright.classList.remove('active')
                        icondown.classList.add('active')
                    }
                }
                icondown.onclick = function(){
                    if(icondown.classList.contains('active')){
                        icondown.classList.remove('active')
                        iconright.classList.add('active')
                    }
                }
            })
        function myFunction(toggle){
            var x = document.getElementById(toggle);
            if (x.style.display === "block") {
              x.style.display = "none";
            } else {
            x.style.display = "block";
            // var spanrorate,i;
            // spanrorate = document.getElementsByClassName('toggle');
            // for( i = 0 ;i < spanrorate.length;i++){
            //     spanrorate[i].className = spanrorate[i].className.replace(" cd","");
            // }
            // span.currentTarget.className += " cd";
       
        }
    }
    </script>
</body>
</html>