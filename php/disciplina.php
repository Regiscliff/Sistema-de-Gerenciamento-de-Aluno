<?php
include '../sessao/verifica_sessao.php';

// Incluir arquivo de configuração
require_once "config.php";
 
// Definir variáveis ​​e inicializar com valores vazios
$disciplina = "";
$disciplina_erro = "";
$conteudo = "";

// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Valida disciplina
    $input_disciplina = trim($_POST["materia"]);
    if(!filter_var($input_disciplina, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $disciplina_erro = "Por favor, entre com uma disciplina válida.";
    } else{
        $disciplina = $input_disciplina;
    }
    
    // Verifique os erros de entrada antes de inserir no banco de dados
    if(empty($disciplina_erro)){
        // Prepare uma instrução de inserção
        $sql = "INSERT INTO disciplina (nm_disciplina) VALUES (?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variáveis ​​à instrução preparada como parâmetros
            mysqli_stmt_bind_param($stmt, "s", $param_disciplina);
            
            // Definir parâmetros
            $param_disciplina = $disciplina;
            
            // Tentativa de executar a declaração preparada
            if(mysqli_stmt_execute($stmt)){
                // Registros criados com sucesso. Redirecionar para a página de destino
				echo '<script language="javascript" type="text/javascript">
						function sucesso(){
						window.alert("Disciplina cadastrada com sucesso!");
						window.location.href ="../index.php";
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
    }
    
    // Fecha conexão
    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="pt" dir="ltr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/paginas.css">
		<title>Cadastrar Disciplina</title>
    </head>

    <body>
		<div id="navbar">
			<nav>
				<div class="content">
					<ul>
						<li><a id="selecionado" name="disciplina" disabled>Cadastrar disciplina</a></li>
						<li><a href="estudante.php" name="estudante">Cadastrar estudante</a></li>
						<li><a href="lancarNota.php" name="lancar">Lançar nota</a></li>
						<li><a href="alterarNota.php" name="alterar">Alterar nota</a></li>
						<li><a href="relatorio.php" name="relatorio">Relatório</a></li>
						<li style="float:right"><a href="../sessao/logout.php" id="sair">Sair</a></li>
					</ul>
				</div>
			</nav>
		</div>
		<div id="conteudo">
			<div class="form">
				<h1>Cadastrar disciplina</h1><br><br>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<input type="text" id="materia" name="materia" placeholder="disciplina" required/>
					<span class="help-block"><?php echo $disciplina_erro;echo'<br><br>';?></span>
					<button type="submit" id="cadastrar" name="cadastrarDisciplina">cadastrar</button>
				</form>
			</div>
			<?php echo $conteudo;?>
		</div>
    </body>

</html>
