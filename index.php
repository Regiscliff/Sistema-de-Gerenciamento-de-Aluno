<?php
    include 'sessao/verifica_sessao2.php';
?>
    <!DOCTYPE html>
    <html lang="pt" dir="ltr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/menu.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <title>Início</title>
    </head>

    <body>
        <div class="pagina-menu">
            <div class="form">
				<h3> Sistema de Gerenciamento de Aluno </h3>
				<h3> <?php echo "Bem vindo ".$usuariologado."!"; ?> </h3>
				<br>
				<button type="submit" name="disciplina" onclick="location.href='php/disciplina.php';">Cadastrar disciplina</button>
				<br><br>
				<button type="submit" name="estudante" onclick="location.href='php/estudante.php';">Cadastrar estudante</button>
				<br><br>
				<button type="submit" name="lancar" onclick="location.href='php/lancarNota.php';">Lançar nota</button>
				<br><br>
				<button type="submit" name="alterar" onclick="location.href='php/alterarNota.php';">Alterar nota</button>
				<br><br>
				<button type="submit" name="relatorio" onclick="location.href='php/relatorio.php';">Relatório</button>
				<br><br>
				<button type="submit" name="sair" id="sair" onclick="location.href='sessao/logout.php';">Sair</button>
            </div>
        </div>
    </body>
    </html>
