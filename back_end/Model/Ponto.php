<?php

class Ponto implements JsonSerializable
{

    private $id;
    private $horario;
    private $funcionarioId;

    function __construct($id, $horario, $funcionarioId)
    {
        $this->id = $id;
        $this->horario = $horario;
        $this->funcionarioId = $funcionarioId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getHorario()
    {
        return $this->horario;
    }

    public function setHorario($horario)
    {
        $this->horario = $horario;
    }

    public function getFuncionarioId()
    {
        return $this->funcionarioId;
    }

    public function setFuncionarioId($funcionarioId)
    {
        $this->funcionarioId = $funcionarioId;
    }

    public function jsonSerialize(): mixed
    {
        return [$this->id, $this->horario, $this->funcionarioId];
    }
}
