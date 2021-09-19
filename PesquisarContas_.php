<?php

include 'VerificarAcesso.php';

include 'Menu.php';

echo "<h2>Lista de Contas</h2>";

include 'DadosDeConexao.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("A conexão com o banco de dados falhou. Erro: " . $conn->connect_error);
}

$id = $_POST["id"];
$numero = $_POST["numero"];

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

  while ($linha = $resultado->fetch_assoc()) {
    echo "<input name='check_list[]' type='checkbox' value='" . $linha["id"] . "'>";
    echo "id: " . $linha["id"] . " - Número: " . $linha["numero"] . " - Saldo: " . $linha["saldo"] . " - Limite: " . $linha["limite"];
    echo ("&nbsp;");
    echo ("<input type=\"button\" value=\"Editar\" onclick=\"location.href='EditarConta.php?id=" . $linha["id"] . "'\" />");
    echo "<br>";
  }

  echo "<br>";

  echo "<input type='submit' onclick='return confirm(\"Deseja realmente excluir a(s) conta(s) selecionada(s)?\")' value='Excluir'>";

  echo "</form>";
} else {
  echo "Sem registros de conta no sistema.<br><br>";
}

echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='PesquisarContas.php'\" />");

$stmt->close();
$conn->close();
