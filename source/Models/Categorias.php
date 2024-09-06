<?php

namespace Source\Models;

use Source\Core\Connect;

class Categorias
{
    private $id;
    private $nome;
    private $descricao;

    /**
     * @param $id
     * @param $nome
     * @param $descricao
     */
    public function __construct(
        $id = null, 
        $nome = null, 
        $descricao = null
    )
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed|null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|null
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed|null $nome
     */
    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao): void
    {
        $this->descricao = $descricao;
    }

    public function selectAll ()
    {
        $query = "SELECT * FROM Categorias";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return false;
        } else {
            return $stmt->fetchAll();
        }
    }

    public function insert()
{
    $query = "INSERT INTO categorias (nome, descricao) 
              VALUES(:nome, :descricao)";
    $stmt = Connect::getInstance()->prepare($query);
    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":descricao", $this->descricao);
    $stmt->execute();

    return true;
}


public function findByName($nome) : bool
{
    $query = "SELECT * FROM categorias WHERE nome = :nome";
    $stmt = Connect::getInstance()->prepare($query);
    $stmt->bindParam(":nome", $nome);
    $stmt->execute();
    if($stmt->rowCount() == 1){
        return true;
    } else {
        return false;
    }
}

}