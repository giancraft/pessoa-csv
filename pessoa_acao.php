<?php

define("DESTINO", "index.php");
define("ARQUIVO_CSV", "pessoa.csv");

$acao = "";
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
        break;
    case 'POST':
        $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
        break;
}

switch ($acao) {
    case 'Salvar':
        salvar();
        break;
    case 'Alterar':
        alterar();
        break;
    case 'excluir':
        excluir();
        break;
}

function tela2array()
{
    $novo = array(
        'id' => isset($_POST['id']) ? $_POST['id'] : date("YmdHis"),
        'nome' => isset($_POST['nome']) ? $_POST['nome'] : "",
        'endereco' => isset($_POST['endereco']) ? $_POST['endereco'] : "",
        'numero' => isset($_POST['numero']) ? $_POST['numero'] : "",
        'cidade' => isset($_POST['cidade']) ? $_POST['cidade'] : "",
        'estado' => isset($_POST['estado']) ? $_POST['estado'] : "",
        'salario' => isset($_POST['salario']) ? $_POST['salario'] : "",
    );
    if ($novo['id'] == "0") {
        $novo['id'] = date("YmdHis");
    }
    return $novo;
}

/*function array2json($array_dados, $json_dados)
{
    $json_dados->id = $array_dados['id'];
    $json_dados->nome = $array_dados['nome'];
    $json_dados->peso = $array_dados['peso'];
    $json_dados->altura = $array_dados['altura'];

    return $json_dados;
}*/

function salvar_csv($dados, $arquivo)
{
    $fp = fopen($arquivo, "w");
    foreach ($dados as $linha) {
        fputcsv($fp, $linha);
    }
    fclose($fp);
}

function ler_csv($arquivo)
{
    $keys = ['id', 'nome', 'endereco', 'numero', 'cidade', 'estado', 'salario'];
    $fp = fopen($arquivo, "r");
    $dados = array();
    if ($fp) {

        while ($row = fgetcsv($fp, 1000, ",")) {
            $dados[] = array_combine($keys, $row);
        }
    }
    return $dados;
}

function carregar($id)
{
    $dados = ler_csv(ARQUIVO_CSV);

    foreach ($dados as $key) {
        if ($key['id'] == $id)
            return $key;
    }
}

function alterar()
{
    $novo = tela2array();

    $dados = ler_csv(ARQUIVO_CSV);

    for ($x = 0; $x < count($dados); $x++) {
        if ($dados[$x]['id'] == $novo['id']) {
            $dados[$x] = $novo;
        }
    }

    salvar_csv($dados, ARQUIVO_CSV);

    header("location:" . DESTINO);

}

function excluir()
{
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $dados = ler_csv(ARQUIVO_CSV);
    if ($dados == null)
        $dados = array();

    $novo = array();
    for ($x = 0; $x < count($dados); $x++) {
        if ($dados[$x]['id'] != $id)
            array_push($novo, $dados[$x]);
    }
    salvar_csv($novo, ARQUIVO_CSV);

    header("location:" . DESTINO);

}

function salvar()
{
    $dados = NULL;
    $novo = tela2array();

    $dados = ler_csv(ARQUIVO_CSV);

    if ($dados == NULL) {
        $dados = array();
    }

    array_push($dados, $novo);

    salvar_csv($dados, ARQUIVO_CSV);

    header("location:" . DESTINO);
}

?>