<?php

$login = $_POST["login"];
$senha = $_POST["senha"];

if ($login == '' || $senha == '') {

    echo ("<h2>Acesso Ao Sistema Não Permitido</h2>");

    echo ("Os campos Login e Senha são obrigatórios.<br><br>");

    echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='Acesso.php'\" />");

    die();
}

include 'DadosDeConexao.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("A conexão com o banco de dados falhou. Erro: " . $conn->connect_error);
}

$stmt = $conn->prepare("select id FROM `bancoabc`.`usuario` WHERE login=? AND senha=?;");
$stmt->bind_param("ss", $login, $senha);

$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {

    session_start();

    if (!isset($_SESSION['logado'])) {

        $_SESSION['logado'] = true;
    }

    $stmt->close();
    $conn->close();

    $URL = "PesquisarContas";
    header("Location: $URL.php");
} else {
    session_start();

    session_unset();
    session_destroy();

    $stmt->close();
    $conn->close();

    include("VerificarAcesso.php");
}
