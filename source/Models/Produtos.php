<?php

namespace Source\Models;
use PDO;
use Source\Core\Connect;

class Produtos
{
    private $id;
    private $idCategoria;
    private $nome;
    private $descricao;
    private $preco;
    private $imagem;
    private $unidade_medida;
    private $codigo_produto;

    public function __construct(
        int $id = NULL,
        int $idCategoria = NULL,
        string $nome = NULL,
        string $descricao = NULL,
        float $preco = NULL,
        string $imagem = NULL,
        string $unidade_medida = NULL,
        string $codigo_produto = NULL
    )
    {
        $this->id = $id;
        $this->idCategoria = $idCategoria;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->imagem = $imagem;
        $this->unidade_medida = $unidade_medida;
        $this->codigo_produto = $codigo_produto;
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

    /**
     * Get the value of imagem
     */ 
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set the value of imagem
     *
     * @return  self
     */ 
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;

        return $this;
    }

    /**
     * Get the value of unidade_medida
     */ 
    public function getUnidade_medida()
    {
        return $this->unidade_medida;
    }

    /**
     * Set the value of unidade_medida
     *
     * @return  self
     */ 
    public function setUnidade_medida($unidade_medida)
    {
        $this->unidade_medida = $unidade_medida;

        return $this;
    }

    /**
     * Get the value of codigo_produto
     */ 
    public function getCodigo_produto()
    {
        return $this->codigo_produto;
    }

    /**
     * Set the value of codigo_produto
     *
     * @return  self
     */ 
    public function setCodigo_produto($codigo_produto)
    {
        $this->codigo_produto = $codigo_produto;

        return $this;
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

    public function getById($id)
    {
        $pdo = Connect::getInstance(); // Garante que está chamando corretamente a conexão
        $query = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function validateProduto($nome, $idCategoria, $codigo_produto) : bool
    {
        try {
            $query = "SELECT * FROM produtos WHERE (nome = :nome AND idCategoria = :idCategoria) OR (codigo_produto = :codigo_produto)";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":idCategoria", $idCategoria);
            $stmt->bindParam(":codigo_produto", $codigo_produto);
            $stmt->execute();
            if($stmt->rowCount() >= 1){
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Log do erro para debug
            error_log("Erro ao validar produto: " . $e->getMessage());
            // Em caso de erro, assume que o produto já existe para evitar duplicatas
            return true;
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
        try {
            $query = "INSERT INTO produtos (idCategoria, nome, descricao, preco, quantidade, imagem, unidade_medida, codigo_produto) 
                        VALUES (:idCategoria, :nome, :descricao, :preco, :quantidade, :imagem, :unidade_medida, :codigo_produto)";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":idCategoria", $this->idCategoria);
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindValue(":descricao", $this->descricao);
            $stmt->bindParam(":preco", $this->preco);
            $stmt->bindValue(":quantidade", 0); // Quantidade inicial como 0
            $stmt->bindParam(":imagem", $this->imagem);
            $stmt->bindParam(":unidade_medida", $this->unidade_medida);
            $stmt->bindParam(":codigo_produto", $this->codigo_produto);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Log do erro para debug (opcional)
            error_log("Erro ao inserir produto: " . $e->getMessage());
            return false;
        }
    }

    public function somaQuantidadeProdutos(int $idProduto, float $quantidade) 
    {
        $query = "UPDATE produtos SET quantidade = quantidade + :quantidade WHERE id = :idProduto";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":quantidade", $quantidade);
        $stmt->bindParam(":idProduto", $idProduto);
        $stmt->execute();
        return true;
    }

    public function subtraiQuantidadeProdutos(int $idProduto, float $quantidade) 
    {
        $query = "UPDATE produtos SET quantidade = quantidade - :quantidade WHERE id = :idProduto";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":quantidade", $quantidade);
        $stmt->bindParam(":idProduto", $idProduto);
        $stmt->execute();
        return true;
    }

    public function delete($id)
    {
        $query = "DELETE FROM produtos WHERE id = :id";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function update($id, $nome = null, $descricao = null, $idCategoria = null, $preco = null, $imagem = null, $unidade_medida = null, $codigo_produto = null)
    {
        $query = "UPDATE produtos SET";
        $params = [];
        
        if (!is_null($nome)) {
            $query .= " nome = :nome,";
            $params[":nome"] = $nome;
        }
        if (!is_null($descricao)) {
            $query .= " descricao = :descricao,";
            $params[":descricao"] = $descricao;
        }
        if (!is_null($idCategoria)) {
            $query .= " idCategoria = :idCategoria,";
            $params[":idCategoria"] = $idCategoria;
        }
        if (!is_null($preco)) {
            $query .= " preco = :preco,";
            $params[":preco"] = $preco;
        }
        if (!is_null($imagem)) {
            $query .= " imagem = :imagem,";
            $params[":imagem"] = $imagem;
        }
        if (!is_null($unidade_medida)) {
            $query .= " unidade_medida = :unidade_medida,";
            $params[":unidade_medida"] = $unidade_medida;
        }
        if (!is_null($codigo_produto)) {
            $query .= " codigo_produto = :codigo_produto,";
            $params[":codigo_produto"] = $codigo_produto;
        }
    
        // Removendo a última vírgula para evitar erro de SQL
        $query = rtrim($query, ',');
        
        $query .= " WHERE id = :id";
        $params[":id"] = $id;
    
        // Prepara e executa a query
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->execute($params);
    
        // Retorna se houve alterações
        return $stmt->rowCount() > 0;
    }
}