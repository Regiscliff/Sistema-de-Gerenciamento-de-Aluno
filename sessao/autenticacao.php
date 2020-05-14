<?php
	if(isset($_POST['loginProfessor'])){
		session_start();
		$usuario = $_POST["usuario"];
		$senha = $_POST["senha"];
		if ($usuario == 'Ariel' && $senha == 123){
			$_SESSION['usuario'] = $usuario;
			header('Location: ../index.php');
			exit();
		}else{
			$_SESSION['nao_autenticado'] = true;
			header('Location: ../login.php');
			exit();
		}
	}elseif(isset($_POST['loginAluno'])){
		session_start();
		include '../php/config.php';
    
		$usuario = mysqli_real_escape_string($link, $_POST['usuario']);
		$senha = mysqli_real_escape_string($link, $_POST['senha']);
    
		$query = "SELECT * FROM aluno WHERE nm_aluno = '{$usuario}' AND cd_aluno ='{$senha}'";
    
		$result = mysqli_query($link, $query);
    
		$row = mysqli_num_rows($result);
    
		if ($row == 1) {
			$_SESSION['usuario'] = $usuario;
			header('Location: ../index2.php');
			exit();
		} else {
			$_SESSION['nao_autenticado'] = true;
			header('Location: ../login.php');
			exit();
		}
    mysqli_close($link);
	}
?>