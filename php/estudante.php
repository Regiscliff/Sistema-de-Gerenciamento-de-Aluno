<?php
include '../sessao/verifica_sessao.php';
	// Incluir arquivo de configuração
	require_once "config.php";
 
	// Definir variáveis ​​e inicializar com valores vazios
	$nome_erro = "";
	
	$nome="";
	$rua = "";
	$numero ="";
	$bairro = "";
	$cidade = "";
	$estado = "";
	$cep = "";
	$telefone="";
	$email="";
	$novoBotao="";
	$conteudo="";
	$exige="";
	$exigeNome="";
	$symbol="'";
	$desabilitado = "disabled";
	$telefone_erro = "";
	
if(isset($_POST['cadastrarEstudante'])){
	$raw_telefone=$_POST["telefone"];
	$simbolos = array("-","(",")"," ");
	$telefone = str_replace($simbolos,"",$raw_telefone);
	$ddd = substr($telefone, 0, 2);
	if(strlen($telefone) == 10){
		$telefone = substr($telefone, -8);
	}elseif(strlen($telefone) == 11){
		$telefone = substr($telefone, -9);
	}else{
		$telefone_erro = "Formato inválido de telefone.";
	}
	$email=$_POST["email"];
	$cep=$_POST["cep"];
	$rua=$_POST["rua"];
	$numero=$_POST["numero"];
	$bairro=$_POST["bairro"];
	$cidade=$_POST["cidade"];
	$estado=$_POST["estado"];
	$nome = $_POST["nome"];
	$numero = $_POST["numero"];
	
	// Processando dados do formulário quando o formulário é enviado
	if($_SERVER["REQUEST_METHOD"] == "POST" && empty($telefone_erro)){
		// Valida nome
		$input_nome = trim($_POST["nome"]);
		if(!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
			$nome_erro = "Por favor, entre com um nome válido.";
		} else{
			$nome = $input_nome;
		}
		
		$cep = str_replace($simbolos,"",$cep);
    
		// Verifique os erros de entrada antes de inserir no banco de dados
		if(empty($nome_erro)){
			// Prepare uma instrução de inserção
			$sql = "INSERT INTO aluno (nm_aluno,email) VALUES (?,?)";
         
			if($stmt = mysqli_prepare($link, $sql)){
				// Vincular variáveis ​​à instrução preparada como parâmetros
				mysqli_stmt_bind_param($stmt, "ss", $param_nome, $param_email);
            
				// Definir parâmetros
				$param_nome = $nome;
				$param_email = $email;
            
				// Tentativa de executar a declaração preparada
				if(mysqli_stmt_execute($stmt)){
					// Registros criados com sucesso.
					mysqli_stmt_close($stmt);
					
					// Prepare uma instrução de inserção
					$sql = "INSERT INTO endereco_aluno (cep, numero, rua, bairro, cidade, estado, cd_aluno) VALUES(?,?,?,?,?,?,
					(SELECT cd_aluno FROM aluno WHERE nm_aluno='".$param_nome."' AND email='".$param_email."'))";
					if($stmt = mysqli_prepare($link, $sql)){
						// Vincular variáveis ​​à instrução preparada como parâmetros
						mysqli_stmt_bind_param($stmt, "ssssss", $param_cep, $param_numero, $param_rua,
						$param_bairro, $param_cidade, $param_estado);
						
						// Definir parâmetros
						$param_cep = $cep;
						$param_numero = $numero;
						$param_rua = $rua;
						$param_bairro = $bairro;
						$param_cidade = $cidade;
						$param_estado = $estado;
						
						// Tentativa de executar a declaração preparada
						if(mysqli_stmt_execute($stmt)){
							// Registros criados com sucesso.
							mysqli_stmt_close($stmt);
						
							// Prepare uma instrução de inserção
							$sql = "INSERT INTO telefone_aluno (ddd, num_telefone, cd_aluno) VALUES(?,?,
							(SELECT cd_aluno FROM aluno WHERE nm_aluno='".$param_nome."' AND email='".$param_email."'))";
							if($stmt = mysqli_prepare($link, $sql)){
								// Vincular variáveis ​​à instrução preparada como parâmetros
								mysqli_stmt_bind_param($stmt, "ss", $param_ddd, $param_telefone);
						
								// Definir parâmetros
								$param_ddd = $ddd;
								$param_telefone = $telefone;
						
								// Tentativa de executar a declaração preparada
								if(mysqli_stmt_execute($stmt)){
									
								// Registros criados com sucesso. Redirecionar para a página de destino
								echo '<script language="javascript" type="text/javascript">
										function sucesso(){
										window.alert("Aluno cadastrado com sucesso!");
										window.location.href ="../index.php";
										}
										sucesso();
									</script>';
								//header("location: inicio.php");
								//exit();
								
								}else{
									echo "Algo deu errado. Por favor, tente novamente mais tarde.";
								}
							}
						}else{
							echo "Algo deu errado. Por favor, tente novamente mais tarde.";
						}
					}
				} else{
					echo "Algo deu errado. Por favor, tente novamente mais tarde.";
				}
			}
         
			// Fecha declaração
			mysqli_stmt_close($stmt);
		}
    
		// Fecha conexão
		mysqli_close($link);
	}else{
		echo '<script language="javascript" type="text/javascript">
				function exibirErro(){
					window.alert("'.$telefone_erro.'");
				}
				exibirErro();
			</script>';
		$novoBotao='<button id="cadastrar" name="cadastrarEstudante">cadastrar</button>';
		$conteudo='<tr>
						<td><input type="text" name="telefone" id="telefone" placeholder="telefone" autocomplete="off"
							size="13" onkeydown="$(this).mask('.$symbol.'(00) 0000-00009'.$symbol.')" required>
					</tr>
					<tr>
						<td><input type="email" name="email" id="email" size="42" maxlength="60" placeholder="e-mail" 
						value="'.$email.'" autocomplete="off" required></td>
					</tr>';
		$desabilitado = "readonly";
		$exige = "required";
		$exigeNome = 'pattern="([A-Za-z ]{10,50})" required';
		$telefone_erro = "";
	}
}elseif(isset($_POST['buscar'])){
	$raw_cep = $_POST["cep"];
	$nome = $_POST["nome"];
	$numero = $_POST["numero"];
	
    $cep = str_replace("-","",$raw_cep);
	
	$arq = file_get_contents('http://viacep.com.br/ws/'.$cep.'/json/');
	$json = json_decode($arq);
	
	if(!isset($json->erro)){
		$rua = $json->logradouro;
		$bairro = $json->bairro;
		$cidade = $json->localidade;
		$estado = $json->uf;
		$cep = substr($cep,0,5).'-'.substr($cep,5,3);
		$novoBotao='<button id="cadastrar" name="cadastrarEstudante">cadastrar</button>';
		$conteudo='<tr>
						<td><input type="text" name="telefone" id="telefone" placeholder="telefone" autocomplete="off"
							size="13" onkeydown="$(this).mask('.$symbol.'(00) 0000-00009'.$symbol.')" required>
					</tr>
					<tr>
						<td><input type="email" name="email" id="email" size="42" maxlength="60" placeholder="e-mail" 
						value="'.$email.'" autocomplete="off" required></td>
					</tr>';
		$desabilitado = "readonly";
		$exige = "required";
		$exigeNome = 'pattern="([A-Za-z ]{10,50})" required';
	}else{
		$cep = "";
		echo '<script language="javascript" type="text/javascript">
			function exibirErro(){
				window.alert("CEP inválido");
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
        <link rel="stylesheet" href="../css/estudante.css">
		<title>Cadastrar Estudante</title>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </head>

    <body>
		<div id="navbar">
			<nav>
				<div class="content">
					<ul>
						<li><a href="disciplina.php" name="disciplina">Cadastrar disciplina</a></li>
						<li><a id="selecionado" name="estudante" disabled>Cadastrar estudante</a></li>
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
				<h1>Cadastrar estudante</h1><br><br>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<table>
						<tr>
							<td><input type="text" name="nome" maxlength="50" size="42" placeholder="nome completo do aluno" 
							value="<?php echo $nome;?>" <?php echo $exigeNome;?> autocomplete="off"></td>
							</tr>
							<tr>
						</tr>
						<tr>
							<td><input type="text" name="cep" placeholder="00000-000" pattern="([0-9]{5}-[0-9]{3})|([0-9]{8})" 
							required maxlength="9" size="6" onkeydown="$(this).mask('00000-000')" value="<?php echo $cep;?>">
							<button id="buscarCEP" type="submit" name="buscar">Buscar CEP</button></td>
						</tr>
						<tr>
							<td><input type="text" name="rua" size="30" placeholder="rua" id="rua"  value="<?php echo $rua;?>" <?php echo $desabilitado;?>>
							<input type="text" name="numero" id="numero" maxlength="5" size="3" placeholder="Nº" value="<?php echo $numero;?>" 
							<?php echo $exige;?> autocomplete="off"></td>
						</tr>
						<tr>
							<td><input type="text" name="bairro" size="30" placeholder="bairro" id="bairro" 
							value="<?php echo $bairro;?>" <?php echo $desabilitado;?>></td>
						</tr>
						<tr>
							<td><input type="text" name="cidade" size="17" placeholder="cidade" id="cidade" value="<?php echo $cidade;?>" <?php echo $desabilitado;?>> -
							<input type="text" name="estado" size="2" id="estado" value="<?php echo $estado;?>" <?php echo $desabilitado;?>></td>
						</tr>
						<?php echo $conteudo; ?>
					</table>
					<?php echo $novoBotao; ?>
				</form>
			</div>
		</div>
    </body>

</html>
