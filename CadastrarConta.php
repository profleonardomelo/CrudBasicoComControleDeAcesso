<!DOCTYPE HTML>
<html>

<body>

      <?php
      include 'VerificarAcesso.php';
      ?>

      <h2>Cadastro de Conta</h2>
      <br>
      <form action="CadastrarConta_.php" method="post">
            Numero da Conta: <input type="text" name="numero"><br><br>
            Saldo da Conta: <input type="text" name="saldo"><br><br>
            Limite da Conta: <input type="text" name="limite"><br><br><br>
            <input type="button" value="Voltar" onclick="location.href='PesquisarContas.php'" />
            &nbsp;
            <input type="submit" value="Cadastrar">
      </form>

</body>

</html>