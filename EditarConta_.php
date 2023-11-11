<?php

include 'VerificarAcesso.php';

echo "<h2>Edição de Conta</h2>";

if (empty($_POST['id']) || empty($_POST['numero']) || empty($_POST['saldo']) || empty($_POST['limite'])) {
  echo ("Os campos 'id', 'Número', 'Saldo' e 'Limite' são Obrigatórios.<br><br>");
  echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='PesquisarContas.php'\" />");
  die();
}

$id = $_POST["id"];
$numero = $_POST["numero"];
$saldo = $_POST["saldo"];
$limite = $_POST["limite"];

include 'DadosDeConexao.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("A conexão com o banco de dados falhou. Erro: " . $conn->connect_error);
}

$stmt = $conn->prepare("UPDATE `conta` SET `numero`=?, `saldo`=?, `limite`=? WHERE `id`=?;");

$stmt->bind_param("iddi", $numero, $saldo, $limite, $id);

if ($stmt->execute() === TRUE) {
  echo "Conta " . $id . " editada com sucesso!<br><br>";
} else {
  echo "Erro ao tentar editar uma conta: " . $conn->error . "<br><br>";
}

echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='PesquisarContas.php'\" />");

$stmt->close();
$conn->close();
