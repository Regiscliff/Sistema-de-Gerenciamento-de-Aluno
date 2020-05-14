<?php
include '../sessao/verifica_sessao.php';
// Incluir arquivo de configuração
require_once "config.php";
 
// Definir variáveis ​​e inicializar com valores vazios
$conteudo = "";
$erro = '<script language="javascript" type="text/javascript">
			function erro(){
				window.alert("Para inserir as notas, primeiro associe uma disciplina a um aluno.");
				window.location.href ="../index.php";
			}
			erro();
		</script>';

// Tentativa de selecionar a execução da consulta
    // Tentativa de selecionar a execução da consulta
    $sql = "SELECT * FROM aluno ORDER BY nm_aluno";
    if($result = mysqli_query($link, $sql)){
		if(mysqli_num_rows($result) > 0){
			$parteConteudo = '
			<input list="alunos" name="listaAlunos" placeholder="aluno" autocomplete="off" required>
			<datalist id="alunos">';
			while($row = mysqli_fetch_array($result)){
				$parteConteudo = $parteConteudo.
				'<option value="'.$row['nm_aluno'].'">';
			}
			mysqli_free_result($result);
			
			// Tentativa de selecionar a execução da consulta
			$sql = "SELECT * FROM disciplina ORDER BY nm_disciplina";
			if($result = mysqli_query($link, $sql)){
				if(mysqli_num_rows($result) > 0){
					$parteConteudo = $parteConteudo.
					'</datalist>
					<input list="disciplinas" name="listaDisciplinas" placeholder="disciplina" autocomplete="off" required>
					<datalist id="disciplinas">';
					while($row = mysqli_fetch_array($result)){
					$parteConteudo = $parteConteudo.
					'<option value="'.$row['nm_disciplina'].'">';
					}
					$parteConteudo = $parteConteudo.
					'</datalist>';
					$conteudo = $parteConteudo;
					mysqli_free_result($result);
				}else{
					echo '<script language="javascript" type="text/javascript">
						function erro(){
						window.alert("Para cadastrar as notas, primeiro insira ao menos uma disciplina no sistema.");
						window.location.href ="../index.php";
						}
						erro();
						</script>';
				}
			}
			else{
				echo "ERRO: Não foi possível executar $sql. " . mysqli_error($link);
			}
		}else{
			echo '<script language="javascript" type="text/javascript">
					function erro(){
					window.alert("Para cadastrar as notas, primeiro insira ao menos um aluno no sistema.");
					window.location.href ="../index.php";
					}
					erro();
					</script>';
		}
	}else{
        echo "ERRO: Não foi possível executar $sql. " . mysqli_error($link);
    }
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){

	$aluno=$_POST["listaAlunos"];
	$disciplina=$_POST["listaDisciplinas"];
	$a1=$_POST["nota1"];
	$a2=$_POST["nota2"];
	$a3=$_POST["nota3"];
    // Verifique os erros de entrada antes de inserir no banco de dados
        // Prepare uma instrução de inserção
        $sql = "INSERT INTO aluno_disciplina VALUES(
		(SELECT cd_aluno FROM aluno WHERE nm_aluno='".$aluno."'),
		(SELECT cd_disciplina FROM disciplina WHERE nm_disciplina='".$disciplina."'),
		?,?,?)";
         
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
						window.alert("Notas lançadas com sucesso!");
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
         
        // Fecha declaração
        mysqli_stmt_close($stmt);
    
    // Fecha conexão
    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="pt" dir="ltr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/paginas.css">
		<title>Lançar Nota</title>
    </head>

    <body>
		<div id="navbar">
			<nav>
				<div class="content">
					<ul>
						<li><a href="disciplina.php" name="disciplina">Cadastrar disciplina</a></li>
						<li><a href="estudante.php" name="estudante">Cadastrar estudante</a></li>
						<li><a id="selecionado" name="lancar" disabled>Lançar nota</a></li>
						<li><a href="alterarNota.php" name="alterar">Alterar nota</a></li>
						<li><a href="relatorio.php" name="relatorio">Relatório</a></li>
						<li style="float:right"><a href="../sessao/logout.php" id="sair">Sair</a></li>
					</ul>
				</div>
			</nav>
		</div>
		<div id="conteudo">
			<div class="form">
				<h1>Lançar notas</h1><br><br>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<?php echo $conteudo; ?>
					<br><br>
					<input type="number" min="1" max="10" name="nota1" maxlength="5" placeholder="primeira avaliação" required>
					<input type="number" min="1" max="10" name="nota2" maxlength="5" placeholder="segunda avaliação" required>
					<input type="number" min="1" max="10" name="nota3" maxlength="5" placeholder="avaliação final" required>
					<button type="submit" id="cadastrar" name="cadastrarDisciplina">cadastrar</button>
				</form>
			</div>
		</div>
    </body>

</html>
