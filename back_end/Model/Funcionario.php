<?php

class Funcionario {
    private $id;
    private $nome;
    private $pontos = [];

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function adicionarPonto($ponto) {
        array_push($this->pontos, $ponto);
    }
}