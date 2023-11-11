<?php

include 'VerificarAcesso.php';

echo "<h2>Exclusão de Contas</h2>";

if (empty($_POST['check_list'])) {
  echo ("Não foram selecionadas contas a serem deletadas.<br><br>");
} else {
  include 'dadosDeConexao.php';

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("A conexão com o banco de dados falhou. Erro: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("DELETE FROM `conta` WHERE id=?;");

  $sucessoDelete = TRUE;

  foreach ($_POST['check_list'] as $id) {

    $stmt->bind_param("i", $id);

    if (!($stmt->execute() === TRUE)) {

      echo "Erro ao tentar excluir a conta " . $id . ": " . $conn->error;
      $sucessoDelete = FALSE;
    } else {
      echo "Conta com ID " . $id . " apagada.<br>";
    }
  }

  $stmt->close();
  $conn->close();

  if ($sucessoDelete) {
    echo "<br>Conta(s) apagada(s) com sucesso.<br><br>";
  } else {
    echo "Existe(m) Conta(s) não apagada(s) com sucesso.<br><br>";
  }
}

echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='PesquisarContas.php'\" />");
