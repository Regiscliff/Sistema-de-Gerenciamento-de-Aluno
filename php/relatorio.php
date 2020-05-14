<?php
include '../sessao/verifica_sessao.php';
	// Incluir arquivo de configuração
require_once "config.php";
 
// Definir variáveis ​​e inicializar com valores vazios
$conteudo = "";

// Tentativa de selecionar a execução da consulta
    // Tentativa de selecionar a execução da consulta
    $sql = "SELECT * FROM aluno AS a INNER JOIN aluno_disciplina AS ad
			ON(a.cd_aluno = ad.cd_aluno) INNER JOIN disciplina AS d
			ON(ad.cd_disciplina = d.cd_disciplina)
			ORDER BY nm_aluno, nm_disciplina";
    if($result = mysqli_query($link, $sql)){
		if(mysqli_num_rows($result) > 0){
			$conteudo = '
			<table class="table table-bordered table-striped">
			<thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Disciplina</th>
                    <th>Aval. 1</th>
                    <th>Aval. 2</th>
					<th>Aval. 3</th>
					<th>Média</th>
					<th>Conceito</th>
                 </tr>
            </thead>
            <tbody>';
			while($row = mysqli_fetch_array($result)){
				$conteudo = $conteudo.
				'<tr>
                    <td>' . $row['cd_aluno'] . '</td>
                    <td>' . $row['nm_aluno'] . '</td>
                    <td>' . $row['nm_disciplina'] . '</td>
                    <td>' . $row['a1'] . '</td>
					<td>' . $row['a2'] . '</td>
					<td>' . $row['a3'] . '</td>';
					$media = ($row['a1']+$row['a2']+$row['a3'])/3;
					$conteudo = $conteudo. '<td>' . round($media* 10) / 10 . '</td>';
					if ($media <= 10 && $media >=8.5){
						$conceito = "A";
					}elseif ($media <= 8.4 && $media >=7){
						$conceito = "B";
					}elseif ($media <= 6.9 && $media >=6){
						$conceito = "C";
					}elseif ($media <= 5.9 && $media >=4){
						$conceito = "D";
					}elseif ($media <= 3.9){
						$conceito = "F";
					}
                $conteudo = $conteudo. '<td>' . $conceito . '</td>
				</tr>';
				//<td>
                //<a href="read.php?id='. $row['cd_aluno'] .'" title="Visualizar Dados" data-toggle="tooltip"><span class="glyphicon glyphicon-eye-open"></span></a>
                //<a href="update.php?id='. $row['cd_aluno'] .'" title="Atualizar Dados" data-toggle="tooltip"><span class="glyphicon glyphicon-pencil"></span></a>
                //<a href="delete.php?id="'. $row['cd_aluno'] .'" title="Deletar Dados" data-toggle="tooltip"><span class="glyphicon glyphicon-trash"></span></a>
                //</td>
			}
				$conteudo = $conteudo.'</tbody>                            
                </table>';
			mysqli_free_result($result);
		}else{
			echo '<script language="javascript" type="text/javascript">
					function erro(){
					window.alert("Não há nada a exibir no momento.");
					window.location.href ="../index.php";
					}
					erro();
					</script>';
		}
	}else{
        echo "ERRO: Não foi possível executar $sql. " . mysqli_error($link);
    }
	
	// Fecha conexão
    mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="pt" dir="ltr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<link rel="stylesheet" href="../css/relatorio.css">
		<title>Relatório</title>
    </head>

    <body>
		<div id="navbar">
			<nav>
				<div class="content">
					<ul>
						<li><a href="disciplina.php" name="disciplina">Cadastrar disciplina</a></li>
						<li><a href="estudante.php" name="estudante">Cadastrar estudante</a></li>
						<li><a href="lancarNota.php" name="lancar">Lançar nota</a></li>
						<li><a href="alterarNota.php" name="alterar">Alterar nota</a></li>
						<li><a id="selecionado" name="relatorio" disabled>Relatório</a></li>
						<li style="float:right"><a href="../sessao/logout.php" id="sair">Sair</a></li>
					</ul>
				</div>
			</nav>
		</div>
		<div id="conteudo">
			<div class="form">
				<form action="../index.php">
					<?php echo $conteudo; ?>
					<b>Conceito A - C: aprovado
					/ Conceito D: reprovado por nota
					/ Conceito F: reprovado por falta.</b>
					<br><br>
					<button type="submit" id="voltar" name="voltar">voltar</button>
				</form>
			</div>
		</div>
    </body>

</html>
