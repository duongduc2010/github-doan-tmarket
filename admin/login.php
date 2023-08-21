<?php
    include("../user/connect.php");
    session_start();
    if(!empty($_POST['submit'])){
        if(isset($_POST['taikhoan']) && isset($_POST['matkhau'])){
            $taikhoan=$_POST['taikhoan'];
            $matkhau=$_POST['matkhau'];
            $md5_mk = md5($matkhau);
            $sql_dangnhap = "SELECT * FROM admin WHERE taikhoan = '$taikhoan' and matkhau = '$md5_mk'";
            $stmt_dangnhap = $conn->prepare($sql_dangnhap);
            $query_dangnhap = $stmt_dangnhap->execute();
            $row_dangnhap = $stmt_dangnhap->fetch(PDO::FETCH_ASSOC);
            if(!$row_dangnhap){
                echo "Đăng nhập thất bại";
            }
            else{
                $_SESSION['taikhoan']=$taikhoan;
                header("location:index.php");
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" href = "js/bootstrap.min.js"></script>
	<script type="text/javascript" href = "js/jquery-3.6.2.slim.js"></script>
    <link rel="stylesheet" href="style/login.css">
    <title>Đăng nhập admin</title>
</head>
<body>
    <div id="form__dangnhap">
        <form method="post">
            
            <h1 class="title">Admin</h1>
            <fieldset class="form-group">
                <label for="formGroupExampleInput">Tài khoản</label>
                <input name="taikhoan" type="text" class="form-control" name="taikhoan" placeholder="Nhập tài khoản">
            </fieldset>
            <fieldset class="form-group">
                <label for="formGroupExampleInput2">Mật khẩu</label>
                <input name=matkhau type="password" class="form-control" name="matkhau" placeholder="Nhập mật khẩu">
            </fieldset>
            
            <input name="submit" class="login" type="submit" value="Đăng nhập"></input>
        </form>
    </div>
   
</body>
</html>