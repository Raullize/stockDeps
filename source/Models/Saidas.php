<?php

namespace Source\Models;

use Source\Core\Connect;

class Saidas
{
    private $id;
    private $idClientes;
    private $idProdutos;
    private $quantidade;
    private $preco;

    public function __construct(
        int $id = NULL,
        int $idClientes = NULL,
        int $idProdutos = NULL,
        int $quantidade = NULL,
        float $preco = NULL
    )
    {
        $this->id = $id;
        $this->idClientes = $idClientes;
        $this->idProdutos = $idProdutos;
        $this->quantidade = $quantidade;
        $this->preco = $preco;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getIdClientes(): ?int
    {
        return $this->idClientes;
    }

    /**
     * @param string|null $name
     */
    public function setIdClientes(?int $idClientes): void
    {
        $this->idClientes = $idClientes;
    }

    /**
     * @return string|null
     */
    public function getIdProdutos(): ?int
    {
        return $this->idProdutos;
    }

    /**
     * @param string|null $idProdutos
     */
    public function setIdProdutos(?int $idProdutos): void
    {
        $this->idProdutos = $idProdutos;
    }

    /**
     * @return string|null
     */
    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    /**
     * @param string|null $quantidade
     */
    public function setQuantidade(?int $quantidade): void
    {
        $this->quantidade = $quantidade;
    }

    /**
     * Get the value of preco
     */ 
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * Set the value of preco
     *
     * @return  self
     */ 
    public function setPreco($preco)
    {
        $this->preco = $preco;

        return $this;
    }

    public function selectAll ()
    {
        $query = "SELECT * FROM saidas";
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

        $query = "INSERT INTO saidas (idClientes, idProdutos, quantidade, preco) 
                    VALUES (:idClientes, :idProdutos, :quantidade, :preco)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":idClientes", $this->idClientes);
        $stmt->bindParam(":idProdutos", $this->idProdutos);
        $stmt->bindParam(":quantidade", $this->quantidade);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->execute();
        return true;
    }
    
    public function delete($idProduto)
    {
        $query = "DELETE FROM saidas WHERE idProdutos = :idProdutos";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":idProdutos", $idProduto);

        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return false;  
        } else {
            return true;  
        }
    }

}
