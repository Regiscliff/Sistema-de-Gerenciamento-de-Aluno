<?php
	session_start();
	if(!isset($_SESSION['usuario']) == true) {
		unset($_SESSION['usuario']);
		header('Location: login.php');
	}
	$usuariologado = $_SESSION['usuario'];
?>