<?php
include '../sessao/verifica_sessao.php';
// Incluir arquivo de configuração
require_once "config.php";
 
// Definir variáveis ​​e inicializar com valores vazios
$conteudo = "";
$email = "";
$symbol="'";

// Tentativa de selecionar a execução da consulta
    // Tentativa de selecionar a execução da consulta
    $sql = "SELECT * FROM aluno AS a INNER JOIN telefone_aluno AS ta
			ON(a.cd_aluno = ta.cd_aluno) WHERE nm_aluno = '".$usuariologado."'";
    if($result = mysqli_query($link, $sql)){
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_array($result);
			$conteudo = '
			<input type="text" name="telefone" placeholder="telefone" value="('.$row['ddd'].') '.substr($row['num_telefone'],0,4).
			'-'.substr($row['num_telefone'],4,5).'" autocomplete="off" maxlength="13" size="13" 
			onkeydown="$(this).mask('.$symbol.'(00) 0000-00009'.$symbol.')" required>
			<input type="email" name="email" placeholder="e-mail" value="'. $row['email'] .'" autocomplete="off" required>';
			mysqli_free_result($result);
		}
	}else{
        echo "ERRO: Não foi possível executar $sql. " . mysqli_error($link);
    }
	
if(isset($_POST['atualizarDados'])){
	if($_SERVER["REQUEST_METHOD"] == "POST" && strlen($_POST["telefone"])>13){
	$raw_telefone=$_POST["telefone"];
	
	$email=$_POST["email"];
	$simbolos = array("-","(",")");
	$telefone = str_replace($simbolos,"",$raw_telefone);
    // Verifique os erros de entrada antes de inserir no banco de dados
        // Prepare uma instrução de inserção
        $sql = "UPDATE aluno SET email=? WHERE cd_aluno=
		(SELECT cd_aluno FROM aluno WHERE nm_aluno='".$usuariologado."');";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variáveis ​​à instrução preparada como parâmetros
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Definir parâmetros
            $param_email = $email;
            
            // Tentativa de executar a declaração preparada
            if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_close($stmt);
                // Registros criados com sucesso. 
				
				$sql = "UPDATE telefone_aluno SET ddd=?, num_telefone=? WHERE cd_aluno=
				(SELECT cd_aluno FROM aluno WHERE nm_aluno='".$usuariologado."');";
				if($stmt = mysqli_prepare($link, $sql)){
					mysqli_stmt_bind_param($stmt, "ss", $param_ddd, $param_telefone);
					$param_ddd = substr($telefone,0,2);
					if(strlen($telefone) == 12){
						$param_telefone = substr($telefone,-9);
					}else{
						$param_telefone = substr($telefone,-8);
					}
					// Tentativa de executar a declaração preparada
					if(mysqli_stmt_execute($stmt)){
						echo '<script language="javascript" type="text/javascript">
							function sucesso(){
								window.alert("Dados atualizados com sucesso!");
								window.location.href ="../index2.php";
							}
							sucesso();
							</script>';
					}else{
						echo "Algo deu errado: ".mysqli_error($link).". Por favor, tente novamente mais tarde.";
					}
				}
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
	}else{
	echo '<script language="javascript" type="text/javascript">
			function exibirErro(){
				window.alert("Telefone inválido");
			}
			exibirErro();
		</script>';
	}
}

?>

<!DOCTYPE html>
<html lang="pt" dir="ltr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/paginas.css">
		<title>Atualizar Dados</title>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </head>

    <body>
		<div id="conteudo">
			<div class="form">
				<h1>Atualizar Dados</h1><br><br>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<?php echo $conteudo; ?>
					<br><br>
					<button type="submit" id="atualizar" name="atualizarDados">atualizar</button>
				</form>
			</div>
		</div>
    </body>

</html>
