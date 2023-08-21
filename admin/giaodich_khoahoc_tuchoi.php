<?php
	include("../user/connect.php");
	$id = $_GET['id'];
	$sql_xoa1 = "DELETE FROM pheduyetkhoahochoanthanh WHERE idkhoahoc='$id';";
	$stmt_xoa1 = $conn->prepare($sql_xoa1);
	$query_xoa1 = $stmt_xoa1->execute();
	if($query_xoa1){
		header("location:giaodich_khoahoc.php");
	}
?>