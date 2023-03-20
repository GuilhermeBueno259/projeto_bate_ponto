<?php
header('Access-Control-Allow-Origin: *');
header('Acess-Control-Allow-Credentials: true');
header('Acess-Control-Max-Age: 1000');
header('content-type: application/json');

define('PASTA_RAIZ', dirname(__FILE__));
define('HORARIO_BRASILIA', new DateTimeZone('America/Sao_Paulo'));

require_once PASTA_RAIZ . '/Model/Funcionario.php';
require_once PASTA_RAIZ . '/Model/Dao/FuncionarioDao.php';
require_once PASTA_RAIZ . '/Model/Dao/PontoDao.php';
require_once PASTA_RAIZ . '/Controller/RespostasRequisicoes.php';

$funcionarioDao = new FuncionarioDao();
$pontoDao = new PontoDao();
$respostasRequisicoes = new RespostasRequisicoes();

if (isset($_POST['nomeFuncionario'])) {

    if ($nomeFuncionario = filter_input(INPUT_POST, 'nomeFuncionario', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
        if (preg_match('/\\d/', $nomeFuncionario) == 0) {

            switch ($_GET['operacao']) {
                case 'cadastrar_funcionario':
                    $respostasRequisicoes->cadastrarFuncionario($nomeFuncionario);
                    break;

                case 'bater_ponto':
                    $respostasRequisicoes->baterPonto($nomeFuncionario);
                    break;
            }
        }
    }
}

if ($_GET['operacao'] == 'relatorio_batimentos_dia')
    $respostasRequisicoes->retornarTabela();
