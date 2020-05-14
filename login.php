<?php
    session_start();
?>
    <!DOCTYPE html>
    <html lang="pt" dir="ltr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/login.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
		<script src="script/login.js" type="text/javascript"></script>
        <title>Login</title>
    </head>

    <body>
        <div class="pagina-login">
		<div class="menu">
			<table>
                <input type="submit" id="professor" onClick="alterarParaProfessor()" value="Professor" disabled>
                <input type="submit" id="aluno" onClick="alterarParaAluno()" value="Aluno">
			<table>
		</div>
            <div class="form">
                <form class="form-login" action="sessao/autenticacao.php" method="POST">
                    <input type="text" id="usuario" name="usuario" placeholder="nome" autocomplete="off" required/>
                    <input type="password" id="senha" name="senha" placeholder="senha" required/>
					<br><br>
                    <button type="submit" id="login" name="loginProfessor">login</button>
                    <?php
                      if(isset($_SESSION['nao_autenticado'])):
                    ?>
                    <p class="message" style="color:#f44336;">usuário ou senha inválido</p>
                    <?php
                    endif;
                    unset($_SESSION['nao_autenticado']);
                    ?>
                </form>
				<br><br>
				<input type="hidden" id="duvida" name="duvida" onClick="duvida()"/>
            </div>
        </div>
    </body>
    <script src="script/login.js"></script>

    </html>
