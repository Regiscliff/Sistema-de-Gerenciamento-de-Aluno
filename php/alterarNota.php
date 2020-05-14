<?php
include '../sessao/verifica_sessao.php';
// Incluir arquivo de configuração
require_once "config.php";
 
// Definir variáveis ​​e inicializar com valores vazios
$conteudo = "";
$aluno = "";
$disciplina = "";

// Tentativa de selecionar a execução da consulta
    // Tentativa de selecionar a execução da consulta
    $sql = "SELECT * FROM aluno AS a INNER JOIN aluno_disciplina AS ad
			ON(a.cd_aluno = ad.cd_aluno) INNER JOIN disciplina AS d
			ON(ad.cd_disciplina = d.cd_disciplina)
			WHERE a1!='' OR a2!='' OR a3!=''
			GROUP BY nm_aluno";
    if($result = mysqli_query($link, $sql)){
		if(mysqli_num_rows($result) > 0){
			$conteudo = '
			<input list="alunos" name="listaAlunos" placeholder="aluno" autocomplete="off" required>
			<datalist id="alunos">';
			while($row = mysqli_fetch_array($result)){
				$conteudo = $conteudo.
					'<option value="'.$row['nm_aluno'].'">';
				}
			$conteudo = $conteudo.'</datalist>
			<button type="submit" id="buscar" name="buscarDisciplina">Buscar disciplinas</button>';
			mysqli_free_result($result);	
		}else{
			echo '<script language="javascript" type="text/javascript">
					function erro(){
					window.alert("Para alterar as notas, é necessário primeiro lançar as notas do aluno.");
					window.location.href ="../index.php";
					}
					erro();
					</script>';
		}
	}else{
        echo "ERRO: Não foi possível executar $sql. " . mysqli_error($link);
    }
	
if(isset($_POST['buscarDisciplina'])){
	$aluno=$_POST["listaAlunos"];
	$conteudo = '<input type="text" name="aluno" value="'.$aluno.'" required readonly>';
	$sql = "SELECT * FROM aluno AS a INNER JOIN aluno_disciplina AS ad
			ON(a.cd_aluno = ad.cd_aluno) INNER JOIN disciplina AS d
			ON(ad.cd_disciplina = d.cd_disciplina)
			WHERE (a1!='' OR a2!='' OR a3!='') AND nm_aluno = '".$aluno."'
			GROUP BY nm_disciplina";
	if($result = mysqli_query($link, $sql)){
		if(mysqli_num_rows($result) > 0){
			$conteudo = $conteudo.'
			<input list="disciplinas" name="listaDisciplinas" placeholder="disciplina" autocomplete="off" required>
			<datalist id="disciplinas">';
			while($row = mysqli_fetch_array($result)){
				$conteudo = $conteudo.
					'<option value="'.$row['nm_disciplina'].'">';
				}
			$conteudo = $conteudo.'</datalist>
			<button type="submit" id="buscar" name="buscarNota">Buscar notas</button>';
			mysqli_free_result($result);	
		}
	}
}elseif(isset($_POST['buscarNota'])){
	$disciplina=$_POST["listaDisciplinas"];
	$aluno=$_POST["aluno"];
	$sql = "SELECT * FROM aluno AS a INNER JOIN aluno_disciplina AS ad
			ON(a.cd_aluno = ad.cd_aluno) INNER JOIN disciplina AS d
			ON(ad.cd_disciplina = d.cd_disciplina)
			WHERE (a1!='' OR a2!='' OR a3!='') AND (nm_aluno = '".$aluno."' AND nm_disciplina = '".$disciplina."')
			GROUP BY nm_disciplina";
	if($result = mysqli_query($link, $sql)){
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_array($result);
			$conteudo = '<input type="text" name="aluno" value="'.$aluno.'" required readonly>
				<input type="text" name="disciplina" value="'.$disciplina.'" required readonly>
				<br><br>
				<input type="number" min="1" max="10" name="nota1" maxlength="5" placeholder="primeira avaliação" value="'.$row['a1'].'">
				<input type="number" min="1" max="10" name="nota2" maxlength="5" placeholder="segunda avaliação" value="'.$row['a2'].'">
				<input type="number" min="1" max="10" name="nota3" maxlength="5" placeholder="avaliação final" value="'.$row['a3'].'">
				<button type="submit" id="alterar" name="alterarNota">Alterar notas</button>';
				mysqli_free_result($result);
		}
	}
}elseif(isset($_POST['alterarNota'])){
	$disciplina=$_POST["disciplina"];
	$aluno=$_POST["aluno"];
	$a1 =$_POST["nota1"];
	$a2 = $_POST["nota2"];
	$a3 = $_POST["nota3"];
	$sql = "UPDATE aluno_disciplina SET a1=?, a2=?, a3=?
			WHERE cd_aluno = (SELECT cd_aluno FROM aluno WHERE nm_aluno = '".$aluno."') 
			AND cd_disciplina = (SELECT cd_disciplina FROM disciplina WHERE nm_disciplina = '".$disciplina."')";
			if($stmt = mysqli_prepare($link, $sql)){
				// Vincular variáveis ​​à instrução preparada como parâmetros
				mysqli_stmt_bind_param($stmt, "sss", $param_a1, $param_a2, $param_a3);
				
				// Definir parâmetros
				$param_a1 = $a1;
				$param_a2 = $a2;
				$param_a3 = $a3;
				
				// Tentativa de executar a declaração preparada
				if(mysqli_stmt_execute($stmt)){
					// Registros criados com sucesso. Redirecionar para a página de destino
					echo '<script language="javascript" type="text/javascript">
							function sucesso(){
							window.alert("Notas alteradas com sucesso!");
							window.location.href ="relatorio.php";
						}
						sucesso();
						</script>';
						//header("location: inicio.php");
						//exit();
				} else{
					echo "Algo deu errado: ".mysqli_error($link).". Por favor, tente novamente mais tarde.";
				}	
			}
}
?>

<!DOCTYPE html>
<html lang="pt" dir="ltr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/paginas.css">
		<title>Alterar Nota</title>
		<script src="../script/alterarNota.js" type="text/javascript"></script>
    </head>

    <body>
		<div id="navbar">
			<nav>
				<div class="content">
					<ul>
						<li><a href="disciplina.php" name="disciplina">Cadastrar disciplina</a></li>
						<li><a href="estudante.php" name="estudante">Cadastrar estudante</a></li>
						<li><a href="lancarNota.php" name="lancar">Lançar nota</a></li>
						<li><a id="selecionado" name="alterar" disabled>Alterar nota</a></li>
						<li><a href="relatorio.php" name="relatorio">Relatório</a></li>
						<li style="float:right"><a href="../sessao/logout.php" id="sair">Sair</a></li>
					</ul>
				</div>
			</nav>
		</div>
		<div id="conteudo">
			<div class="form">
				<h1>Alterar notas</h1><br><br>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<?php echo $conteudo; ?>
				</form>
			</div>
		</div>
    </body>

</html>
