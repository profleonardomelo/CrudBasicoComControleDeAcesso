<?php

include("VerificarAcesso.php");

if (empty($_GET['id'])) {
    echo ("É necessário informar um ID válido para editar uma conta.<br><br>");
    echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='PesquisarContas.php'\" />");
    die();
}

$id = $_GET["id"];

include 'DadosDeConexao.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("A conexão com o banco de dados falhou. Erro: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT id, numero, saldo, limite FROM `conta` WHERE id =?;");

$stmt->bind_param("i", $id);

$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {
       
        $linha = $resultado->fetch_assoc(); 

        $numero = $linha["numero"];
        $saldo = $linha["saldo"];
        $limite = $linha["limite"];

        echo ("<h2>Edição de Conta</h2>");

        echo ("<br>");

        echo ("<form action=\"EditarConta_.php\" method=\"post\">");
        
        echo ("ID da Conta: <input type=\"text\" name=\"id2\"  value=\"" . $id . "\" disabled><br><br>");

        echo ("<input type=\"hidden\" name=\"id\"  value=\"" . $id . "\">");
        
        echo ("Numero da Conta: <input type=\"text\" name=\"numero\"  value=\"" . $numero . "\"><br><br>");

        echo ("Saldo da Conta: <input type=\"text\" name=\"saldo\" value=\"" . $saldo . "\"><br><br>");

        echo ("Limite da Conta: <input type=\"text\" name=\"limite\" value=\"" . $limite . "\"><br><br><br>");

        echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='PesquisarContas.php'\" />");
        
        echo ("&nbsp;");
        echo ("<input type=\"submit\" value=\"Editar\">");
        echo ("</form>");
    
} else {
    echo ("É necessário informar um ID válido para editar uma conta.<br><br>");
    echo ("<input type=\"button\" value=\"Voltar\" onclick=\"location.href='PesquisarContas.php'\" />");
}

$stmt->close();
$conn->close();
