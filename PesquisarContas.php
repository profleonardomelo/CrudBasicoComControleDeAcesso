<!DOCTYPE HTML>
<html>

<body>

      <?php
      include 'VerificarAcesso.php';
      include 'Menu.php';
      ?>

      <h2>Pesquisa de Contas</h2>
      <br>
      <form action="PesquisarContas_.php" method="post">
            Id: <input type="text" name="id"><br><br>
            Numero da Conta: <input type="text" name="numero"><br><br><br>
            <input type='reset' value='Limpar'>&nbsp;
            <input type="submit" value="Pesquisar">
      </form>

</body>

</html>