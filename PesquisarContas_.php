<?php

include 'VerificarAcesso.php';

if (!(isset($_POST['id'])) || (!isset($_POST['numero']))) {
  echo ("<h2>Acesso Direto à Página Não Permitido</h2>");
  echo ("É necessário realizar uma pesquisa antes de acessar esta página. <br><br>");
  echo ("Clique no botão abaixo para realizar uma pesquisa válida: <br><br>"); 
  echo ("<input type=\"button\" value=\"Pesquisar\" onclick=\"location.href='PesquisarContas.php'\" />");
  die();
}

$id = $_POST["id"];
$numero = $_POST["numero"];

include 'Menu.php';

echo "<h2>Lista de Contas</h2>";

include 'DadosDeConexao.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("A conexão com o banco de dados falhou. Erro: " . $conn->connect_error);
}

if ($numero == '' && $id == '') {
  $stmt = $conn->prepare("SELECT id, numero, saldo, limite FROM `bancoabc`.`conta`;");
}

if ($numero != '' && $id == '') {
  $stmt = $conn->prepare("SELECT id, numero, saldo, limite FROM `bancoabc`.`conta` WHERE numero =?;");
  
  $stmt->bind_param("i", $numero);
}

if ($numero == '' && $id != '') {
  $stmt = $conn->prepare("SELECT id, numero, saldo, limite FROM `bancoabc`.`conta` WHERE id =?;");
  
  $stmt->bind_param("i", $id);
}

if ($numero != '' && $id != '') {
  $stmt = $conn->prepare("SELECT id, numero, saldo, limite FROM `bancoabc`.`conta` WHERE id =? AND numero=?;");
  
  $stmt->bind_param("ii", $id, $numero);
}

$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

  echo "<form action='ExcluirContas.php' method='post'>";

  echo ("<table border='1' style='border-collapse: collapse'>");

  echo("<tr>");

     echo("<th></th>");
     echo("<th>ID</th>");
     echo("<th>Número</th>");
     echo("<th>Saldo</th>");
     echo("<th>Limite</th>");
     echo("<th></th>");

  echo("</tr>");

  while ($linha = $resultado->fetch_assoc()) {
    
    echo("<tr>");
    echo("<td>");
    echo "<input name='check_list[]' type='checkbox' value='" . $linha["id"] . "'>";
    echo("</td>");
    echo("<td>");
    echo ($linha["id"]);
    echo("</td>");
    echo("<td>");
    echo ($linha["numero"]);
    echo("</td>");
    echo("<td>");
    echo ($linha["saldo"]);
    echo("</td>");
    echo("<td>");
    echo ($linha["limite"]);
    echo("<td>"); 
    echo ("<input type=\"button\" value=\"Editar\" onclick=\"location.href='EditarConta.php?id=" . $linha["id"] . "'\" />");
    echo("</td>");
    echo("</tr>");

  }

  echo ("</table>");

  echo "<br>";

  echo "<input type='submit' onclick='return confirm(\"Deseja realmente excluir a(s) conta(s) selecionada(s)?\")' value='Excluir'>";

  echo "</form>";
} else {
  echo "Sem registros de conta no sistema.<br><br>";
}

echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='PesquisarContas.php'\" />");

$stmt->close();
$conn->close();
