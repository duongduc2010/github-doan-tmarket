<?php
	include("../user/connect.php");
	$id = $_GET['id'];
	$sql =  "DELETE FROM congcudayhoc WHERE id = '$id'";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();
	if($query){
		header("location:congcudayhoc.php");
	}
?>