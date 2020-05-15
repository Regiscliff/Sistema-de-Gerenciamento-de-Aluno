# Sistema-de-Gerenciamento-de-Aluno
Atividade final de Desenvolvimento de Software para Web

Reginaldo Daniel Ferreira

<p>=======================================================
<br>================== <b>DESCRIÇÃO DO PROJETO</b> ===================
=======================================================</p>

Trata-se de um site que possui um sistema de gerenciamento de alunos, onde é
<br>possível cadastrar disciplinas, alunos, vincular os alunos às disciplinas cadastradas,
<br>inserir e alterar as notas desses alunos nessas disciplinas e visualizar as informações
<br>cadastradas no sistema.

<p>=======================================================
<br>==================== <b>FUNCIONALIDADES</b> =====================
=======================================================</p>

Logo na tela de login, é possível logar como professor ou como aluno. O professor é
<br>capaz de realizar todos os cadastros e alterações citadas acima, assim como gerar um
<br>relatório com todos os alunos e notas cadastradas. O usuário e senha padrões para
<br>logar como professor são "Ariel" e "123", respectivamente. Já o aluno, pode atualizar
<br>os dados de telefone e e-mail cadastrados e visualizar suas notas. Informações sobre
<br>como logar como aluno estão na tela de login do aluno. Ao logar, será exibido um
<br>menu com as funcionalidades do sistema. As funcionalidades são:

<b>Cadastrar disciplina:</b> basta informar o nome da disciplina que ela será
<br>cadastrada no sistema;

<b>Cadastrar aluno:</b> para cadastrar o aluno, primeiro é necessário fazer uma busca do CEP
<br>do aluno para liberar os campos seguintes. O endereço será preenchido automaticamente;

<b>Lançar notas:</b> nesta tela, é possível selecionar um aluno e uma disciplina cadastrados e
<br>inserir as notas para aquele aluno naquela disciplina. É nesse momento que o aluno é
<br>inserido na disciplina. Optei por fazer dessa forma para permitir que um único aluno possa
<br>ser cadastrado em mais de uma disciplina.
<br><b>Obs.: só é possível lançar as notas se houver pelo menos um aluno e uma disciplina
<br>previamente cadastrados no sistema</b>;

<b>Alterar notas:</b> primeiramente, deve-se selecionar um aluno cadastrado previamente no
<br>sistema. Em seguida, selecionar uma das disciplinas que estão vinculadas a esse aluno.
<br>Serão exibidas as notas que foram lançadas para aquele aluno naquela disciplina, sendo
<br>possível realizar a alteração das notas desejadas;

<b>Relatório:</b> aqui será exibida uma lista de todos os alunos cadastrados, bem como as
<br>disciplinas vinculadas a esses alunos, suas notas e o conceito de aprovação;

<b>Bônus:</b>
<br><b>Atualizar dados:</b> nessa tela, o aluno poderá atualizar o telefone e e-mail cadastrados;

<b>Minhas notas:</b> relatório do aluno em particular.

<p>=======================================================
<br>=================== <b>RECURSOS UTILIZADOS</b> ===================
=======================================================</p>
<br>Notepad++ (PHP, CSS, JS), BootStrap, HeidiSQL (MySQL), Xampp
