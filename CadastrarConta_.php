<?php

include 'VerificarAcesso.php';

echo "<h2>Cadastro de Conta</h2>";

if (empty($_POST['numero']) || empty($_POST['saldo']) || empty($_POST['limite'])) {
  echo ("Os campos 'Número', 'Saldo' e 'Limite' são Obrigatórios.<br><br>");
  echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='CadastrarConta.php'\" />");
  die();
}

$numero = $_POST["numero"];
$saldo = $_POST["saldo"];
$limite = $_POST["limite"];

include 'DadosDeConexao.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("A conexão com o banco de dados falhou. Erro: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO `bancoabc`.`conta`
(`numero`, `saldo`, `limite`)
VALUES
(?, ?, ?);");

$stmt->bind_param("idd", $numero, $saldo, $limite);

if ($stmt->execute() === TRUE) {
  $idGeradoPeloInsert = $conn->insert_id;
  echo "Conta criada com sucesso! <br> Número de ID gerado no cadastro foi: " . $idGeradoPeloInsert . ".<br><br>";
} else {
  echo "Erro ao tentar cadastrar uma nova conta: " . $conn->error . "<br><br>";
}

echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='PesquisarContas.php'\" />");

$stmt->close();
$conn->close();
