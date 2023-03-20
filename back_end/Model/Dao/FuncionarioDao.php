<?php

require_once PASTA_RAIZ . '/Controller/Conexao.php';
require_once PASTA_RAIZ . '/Model/Funcionario.php';

class FuncionarioDao
{
    private $conexao;

    function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function cadastrar($nomeFuncionario)
    {
        $comando = "INSERT INTO funcionarios (nome) VALUES (:nome)";

        $retorno = $this->conexao->prepare($comando);
        $retorno->bindValue(":nome", $nomeFuncionario);
        $retorno->execute();
    }

    public function retornar($nome)
    {
        $comando = "SELECT * FROM funcionarios WHERE nome = :nome";

        $retorno = $this->conexao->prepare($comando);
        $retorno->bindValue(":nome", $nome);
        $retorno->execute();
        $retorno->setFetchMode(PDO::FETCH_CLASS, 'Funcionario');
        return $retorno->fetch(PDO::FETCH_CLASS);
    }

    public function retornarTodos() {
        $comando = "SELECT nome FROM funcionarios";

        $retorno = $this->conexao->query($comando);
        $retorno->execute();
        return $retorno->fetchAll();
    }
}
