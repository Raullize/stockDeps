<?php

namespace Source\Models;

use Source\Core\Connect;

class Entradas
{
    private $id;
    private $idFornecedor;
    private $idProdutos;
    private $quantidade;

    public function __construct(
        int $id = NULL,
        int $idFornecedor = NULL,
        int $idProdutos = NULL,
        int $quantidade = NULL
    )
    {
        $this->id = $id;
        $this->idFornecedor = $idFornecedor;
        $this->idProdutos = $idProdutos;
        $this->quantidade = $quantidade;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */


    /**
     * @return string|null
     */
    public function getIdProdutos()
    {
        return $this->idProdutos;
    }

    /**
     * @param string|null $idProdutos
     */
    public function setIdProdutos($idProdutos): void
    {
        $this->idProdutos = $idProdutos;
    }

    /**
     * @return string|null
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * @param string|null $quantidade
     */
    public function setQuantidade($quantidade): void
    {
        $this->quantidade = $quantidade;
    }

    public function selectAll ()
    {
        $query = "SELECT * FROM entradas";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return false;
        } else {
            return $stmt->fetchAll();
        }
    }

    public function insert() : bool
    {
        $query = "INSERT INTO entradas (idFornecedor, idProdutos, quantidade) VALUES (:idFornecedor, :idProdutos, :quantidade)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":idFornecedor", $this->idFornecedor);
        $stmt->bindParam(":idProdutos", $this->idProdutos);
        $stmt->bindValue(":quantidade", $this->quantidade);
        $stmt->execute();
        return true;
    }
    
    /*

    public function getArray() : array
    {
        return ["user" => [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "document" => $this->getDocument(),
            "photo" => $this->getPhoto()
        ]];
    }

    */

}
