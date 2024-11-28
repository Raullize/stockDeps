<?php

namespace Source\Models;

use Source\Core\Connect;

class Produtos
{
    private $id;
    private $idCategoria;
    private $nome;
    private $descricao;
    private $preco;

    public function __construct(
        int $id = NULL,
        int $idCategoria = NULL,
        string $nome = NULL,
        string $descricao = NULL,
        float $preco = NULL
    )
    {
        $this->id = $id;
        $this->idCategoria = $idCategoria;
        $this->nome = $nome;
        $this->descricao = $descricao;
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
    public function getIdCategoria(): ?int
    {
        return $this->idCategoria;
    }

    /**
     * @param string|null $name
     */
    public function setIdCategoria(?int $idCategoria): void
    {
        $this->idCategoria = $idCategoria;
    }

    /**
     * @return string|null
     */
    public function getNome(): ?string
    {
        return $this->nome;
    }

    /**
     * @param string|null $name
     */
    public function setNome(?string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string|null
     */
    public function getPreco(): ?float
    {
        return $this->preco;
    }

    /**
     * @param string|null $preco
     */
    public function setPreco(?float $preco): void
    {
        $this->preco = $preco;
    }

    /**
     * @return string|null
     */
    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    /**
     * @param string|null $descricao
     */
    public function setDescricao(?string $descricao): void
    {
        $this->descricao = $descricao;
    }

   
    public function selectAll ()
    {
        $query = "SELECT * FROM produtos";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return false;
        } else {
            return $stmt->fetchAll();
        }
    }

    public function validateProdutos($nome, $idCategoria) : bool
    {
        $query = "SELECT * FROM produtos WHERE nome = :nome AND idCategoria = :idCategoria";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":idCategoria", $idCategoria);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            return true;
        } else {
            return false;
        }
    }

    public function getQuantidadeById($id): mixed
    {
        $query = "SELECT * FROM produtos WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            $produto = $stmt->fetch();
            return $produto->quantidade;
        } else {
            return false;
        }
    }

    public function insert() : bool
    {
        $query = "INSERT INTO produtos (idCategoria, nome, descricao, preco) 
                    VALUES (:idCategoria, :nome, :descricao, :preco)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":idCategoria", $this->idCategoria);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindValue(":descricao", $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->execute();
        return true;
    }

    public function somaQuantidadeProdutos(int $idProduto, int $quantidade) : void
    {
        $query = "UPDATE produtos SET quantidade = quantidade + :quantidade WHERE id = :idProduto";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":quantidade", $quantidade);
        $stmt->bindParam(":idProduto", $idProduto);
        $stmt->execute();
    }

    public function subtraiQuantidadeProdutos(int $idProduto, int $quantidade) : void
    {
        $query = "UPDATE produtos SET quantidade = quantidade - :quantidade WHERE id = :idProduto";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":quantidade", $quantidade);
        $stmt->bindParam(":idProduto", $idProduto);
        $stmt->execute();
    }
}