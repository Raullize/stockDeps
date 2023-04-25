<?php

namespace Source\Models;

use Source\Core\Connect;

class Produtos
{
    private $id;
    private $idCategoria;
    private $nome;
    private $preco;
    private $quantidade;

    public function __construct(
        int $id = NULL,
        string $idCategoria = NULL,
        string $nome = NULL,
        string $preco = NULL,
        string $quantidade= NULL
    )
    {
        $this->id = $id;
        $this->idCategoria = $idCategoria;
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
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
    public function getIdCategoria(): ?string
    {
        return $this->idCategoria;
    }

    /**
     * @param string|null $name
     */
    public function setIdCategoria(?string $idCategoria): void
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
    public function getPreco(): ?string
    {
        return $this->preco;
    }

    /**
     * @param string|null $preco
     */
    public function setPreco(?string $preco): void
    {
        $this->preco = $preco;
    }

    /**
     * @return string|null
     */
    public function getQuantidade(): ?string
    {
        return $this->quantidade;
    }

    /**
     * @param string|null $quantidade
     */
    public function setQuantidade(?string $quantidade): void
    {
        $this->quantidade = $quantidade;
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

    public function findById() : bool
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":id",$this->id);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return false;
        } else {
            $user = $stmt->fetch();
            $this->name = $user->name;
            $this->email = $user->email;
            $this->document = $user->document;
            $this->photo = $user->photo;
            return true;
        }
    }

    public function findByEmail(string $email) : bool
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE users SET name = :name, email = :email, photo = :photo, document = :document WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":photo",$this->photo);
        $stmt->bindParam(":document",$this->document);
        $stmt->bindParam(":id",$this->id);
        $stmt->execute();
        $arrayUser = [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "photo" => $this->photo,
            "document" => $this->document
        ];
        $_SESSION["user"] = $arrayUser;
        $this->message = "Usuário alterado com sucesso!";
    }

    public function insert() : bool
    {
        $query = "INSERT INTO users (name, email, password, type) VALUES (:name, :email, :password, :type)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":type",$this->type);
        $stmt->bindValue(":password", password_hash($this->password,PASSWORD_DEFAULT));
        $stmt->execute();
        $this->id = Connect::getInstance()->lastInsertId();
        $this->message = "Usuário cadastrado com sucesso!";
        $_SESSION["user"] = $this;
        return true;
    }

    public function validate (string $email, string $password) : bool
    {
        $query = "SELECT * FROM users WHERE email LIKE :email";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            $this->message = "Usuário e/ou Senha não cadastrados!";
            return false;
        } else {
            $user = $stmt->fetch();
            if(!password_verify($password, $user->password)){
                $this->message = "Usuário e/ou Senha não cadastrados!";
                return false;
            }
        }

        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->document = $user->document;
        $this->message = "Usuário Autorizado, redirect to APP!";

        $arrayUser = [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "photo" => $this->photo,
        ];

        $_SESSION["user"] = $arrayUser;
        setcookie("user","Logado",time()+60*60,"/");
        return true;
    }

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

}