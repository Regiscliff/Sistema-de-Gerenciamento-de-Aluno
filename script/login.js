	function alterarParaAluno(){
		document.getElementById("duvida").type = "image";
		document.getElementById("duvida").src = "img/duvida.png";
		document.getElementById("usuario").value = "";
		document.getElementById("senha").value = "";
				
		document.getElementById("professor").disabled = false;
		document.getElementById("aluno").disabled = true;
		document.getElementById("aluno").id = "troca";
		document.getElementById("professor").id = "aluno";
		document.getElementById("troca").id = "professor";
				
		document.getElementById("login").name = "loginAluno";
	}
			
	function alterarParaProfessor(){
		document.getElementById("duvida").src = "";
		document.getElementById("duvida").type = "hidden";
		document.getElementById("usuario").value = "";
		document.getElementById("senha").value = "";
				
		document.getElementById("professor").disabled = false;
		document.getElementById("aluno").disabled = true;
		document.getElementById("aluno").id = "troca";
		document.getElementById("professor").id = "aluno";
		document.getElementById("troca").id = "professor";
				
		document.getElementById("login").name = "loginProfessor";
	}
	
	function duvida(){
		window.alert("Para logar como aluno, primeiro é necessário cadastrar um aluno no sistema.\nNome: nome completo do aluno\nSenha: código do aluno.");
	}