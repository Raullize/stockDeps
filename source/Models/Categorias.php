<?php

namespace Source\Models;

<<<<<<< HEAD
use PDOException;
=======
>>>>>>> 4906133f697bf8a57791c54a769827aa53362dec
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

<<<<<<< HEAD
    public function insert() : bool
{
    try {
        $query = "INSERT INTO categorias (nome, descricao) 
                  VALUES (:nome, :descricao)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);

        // Executa a query e verifica se foi bem-sucedida
        if ($stmt->execute()) {
            return true; // Sucesso
        } else {
            return false; // Falha
        }

    } catch (PDOException $e) {
        // Captura a exceção e faz log ou trata o erro
        error_log("Erro ao inserir categoria: " . $e->getMessage());
        return false;
    }
}

=======
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


>>>>>>> 4906133f697bf8a57791c54a769827aa53362dec
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

<<<<<<< HEAD
public function findById($id) : bool
{
    $query = "SELECT * FROM categorias WHERE id = :id";
    $stmt = Connect::getInstance()->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    if($stmt->rowCount() == 1){
        return true;
    } else {
        return false;
    }
}
public function delete($id) : bool
{
    try {
        $query = "DELETE FROM categorias WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":id", $id);

        // Executa a query e verifica se foi bem-sucedida
        if ($stmt->execute()) {
            return true; // Sucesso
        } else {
            return false; // Falha
        }

    } catch (PDOException $e) {
        // Captura a exceção e faz log ou trata o erro
        error_log("Erro ao inserir categoria: " . $e->getMessage());
        return false;
    }
}

=======
>>>>>>> 4906133f697bf8a57791c54a769827aa53362dec
}