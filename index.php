<?php 

require_once "pessoa_acao.php";
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="ligth">
<?php include 'cabecalho.php'; ?>

<body>
    <main class="container">
        <?php include 'menu.php'; ?>
        <table role="grid">
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Endereco</th>
                <th>Numero</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Salario</th>
                <th>Alterar</th>
                <th>Excluir</th>
            </tr>
            <?php
            $dados = ler_csv('pessoa.csv');
            if(($dados == NULL) || (count($dados)==0)){
                echo "<h1>sem dados a serem exibidos</h1>";
            }
            foreach ($dados as $key)
                echo "<tr><td>{$key['id']}</td>
                  <td>{$key['nome']}</td>
                  <td>{$key['endereco']}</td>
                  <td>{$key['numero']}</td>
                  <td>{$key['cidade']}</td>
                  <td>{$key['estado']}</td>
                  <td>{$key['salario']}</td>
                  <td align='center'><a role='button' href='pessoa_cad.php?id=" . $key['id'] . "';>A</a></td>
                  <td align='center'><a role='button' href=javascript:excluirRegistro('pessoa_acao.php?acao=excluir&id=" . $key['id'] . "');>E</a></td>
              </tr>";
            ?>
        </table>
    </main>
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
</body>
</html>