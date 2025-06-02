<?php

namespace Source\App;

use Dompdf\Dompdf;
use League\Plates\Engine;
use Source\Models\Categorias;
use Source\Models\Clientes;
use Source\Models\Entradas;
use Source\Models\Fornecedores;
use Source\Models\Produtos;
use Source\Models\Saidas;
use Source\Core\Session;
use CoffeeCode\Uploader\Image;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Source\Support\PDFReport;
use Source\Support\ExcelReport;

class App
{
    private $view;

    public function __construct()
    {
        $this->view = new Engine(CONF_VIEW_APP, 'php');

        $session = new Session();
        if (!$session->has("user")) {
            header("Location: /stockDeps");
            exit();
        }
    }

    public function inicio(): void
    {
        $cliente = new Clientes();
        $clientes = $cliente->selectAll();

        $produto = new Produtos();
        $produtos = $produto->selectAll();

        $categoria = new Categorias();
        $categorias = $categoria->selectAll();

        $saidas = new Saidas();
        $saidas = $saidas->selectAll();

        echo $this->view->render("inicio", [
            "produtos" => $produtos,
            "categorias" => $categorias,
            "clientes" => $clientes,
            "saidas" => $saidas
        ]);
    }

    public function estoque(): void
    {
        $cliente = new Clientes();
        $clientes = $cliente->selectAll();

        $produto = new Produtos();
        $produtos = $produto->selectAll();

        $categoria = new Categorias();
        $categorias = $categoria->selectAll();

        $entradas = new Entradas();
        $entradas = $entradas->selectAll();

        $saidas = new Saidas();
        $saidas = $saidas->selectAll();

        echo $this->view->render("estoque", [
            "produtos" => $produtos,
            "categorias" => $categorias,
            "clientes" => $clientes,
            "entradas" => $entradas,
            "saidas" => $saidas
        ]);
    }

    public function fornecedores()
    {
        echo $this->view->render("fornecedores");
    }

    public function clientes()
    {
        echo $this->view->render("clientes");
    }

    /*------------ CRUD PRODUTOS ------------*/

    public function estoquePc(?array $data): void
    {
        // Limpa qualquer saída anterior e inicia buffer
        ob_clean();
        ob_start();
        
        // Define o cabeçalho para garantir que sempre retorne JSON
        header('Content-Type: application/json; charset=utf-8');
        
        try {
            if (!empty($data)) {

                if (in_array("", $data)) {
                    $json = [
                        "message" => "Informe todos os campos para cadastrar!",
                        "type" => "error"
                    ];
                    ob_clean();
                    echo json_encode($json);
                    return;
                }

                $newpreco = $data["preco"];

                // Remove o símbolo de moeda 'R$'
                $newpreco = str_replace('R$', '', $newpreco);

                // Remove os pontos (separadores de milhar)
                $newpreco = str_replace('.', '', $newpreco);

                // Substitui a vírgula decimal por um ponto
                $newpreco = str_replace(',', '.', $newpreco);

                // Converte para float
                $precoFloat = (float)$newpreco;

                $produto = new Produtos();

                if ($produto->validateProduto($data["nome"], $data["categoria"], $data["codigo_produto"])) {
                    $json = [
                        "message" => "Produto já cadastrado!",
                        "type" => "warning"
                    ];
                    ob_clean();
                    echo json_encode($json);
                    return;
                }

                $image = new Image("uploads", "images", true);

                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $site = "http://127.0.0.1/stockDeps/";
                    $upload = $image->upload($_FILES['image'], $data['nome']);
                    if (!$upload) {
                        ob_clean();
                        echo json_encode(["message" => $image->message()->getText(), "type" => "error"]);
                        return;
                    }
                    $link = $site . $upload;
                } else {
                    $link = null;
                }

                $produto = new Produtos(
                    NULL,
                    $data["categoria"],
                    $data["nome"],
                    $data["descricao"],
                    $precoFloat,
                    $link,
                    $data["unidade"],
                    $data["codigo_produto"]
                );

                if ($produto->insert()) {

                    $json = [
                        "produtos" => $produto->selectAll(),
                        "nome" => $data["nome"],
                        "imagem" => $link,
                        "categoria" => $data["categoria"],
                        "preco" => $precoFloat,
                        "descricao" => $data["descricao"],
                        "unidade" => $data["unidade"],
                        "codigo" => $data["codigo_produto"],
                        "message" => "Produto cadastrado com sucesso!",
                        "type" => "success"
                    ];
                    // Limpa buffer e envia resposta
                    ob_clean();
                    echo json_encode($json);
                    return;
                } else {
                    $json = [
                        "message" => "Produto não cadastrado!",
                        "type" => "error"
                    ];
                    ob_clean();
                    echo json_encode($json);
                    return;
                }
            } else {
                $json = [
                    "message" => "Dados não recebidos!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        } catch (Exception $e) {
            // Captura qualquer erro e retorna como JSON
            $json = [
                "message" => "Erro interno: " . $e->getMessage(),
                "type" => "error",
                "debug" => $e->getTraceAsString()
            ];
            // Limpa buffer e envia resposta de erro
            ob_clean();
            echo json_encode($json);
            return;
        }
        
        // Finaliza o buffer
        ob_end_flush();
    }

    public function estoquePd(?array $data): void
    {
        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            $entradas = new Entradas();
            $saidas = new Saidas();
            $produtos = new Produtos();

            $produtoId = $data["idProdutoExcluir"]; // Obtém o ID do produto a ser excluído
            $produtoDeletado = $produtos->delete($produtoId);

            if ($produtoDeletado) {
                $json = [
                    "entradas" => $entradas->selectAll(),
                    "saidas" => $saidas->selectAll(),
                    "produtos" => $produtos->selectAll(),
                    "produtoExcluidoId" => $produtoId, // Envia o ID do produto excluído de volta ao frontend
                    "message" => "Produto deletado com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Produto não deletado!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function estoquePu(?array $data): void
    {
        if (!empty($data)) {
            // Processamento do preço
            $precoFloat = isset($data["preco"]) ? (float) str_replace(['R$', '.', ','], ['', '', '.'], $data["preco"]) : null;
    
            $entradas = new Entradas();
            $saidas = new Saidas();
            $image = new Image("uploads", "images", true);
            $produtos = new Produtos();
    
            // Buscar o produto no banco ANTES de atualizar
            $produtoAtual = $produtos->getById($data["idProdutoUpdate"]); // Nova função para pegar os dados atuais
            $precoAtual = $produtoAtual["preco"] ?? null;
            $imagemAtual = $produtoAtual["imagem"] ?? null;
    
            // Se não houver um novo preço enviado, mantenha o preço atual
            $precoFloat = $precoFloat ?? $precoAtual;
    
            // Processamento da imagem
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $site = "http://127.0.0.1/stockDeps/";
                $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $uniqueFileName = $data['nome'] . "_" . time() . "." . $fileExtension;
                $upload = $image->upload($_FILES['image'], $uniqueFileName);
                $link = $site . $upload;
            } else {
                $link = $imagemAtual; // Mantém a imagem existente caso não haja novo upload
            }
    
            // Atualiza o produto
            $produtoAtualizado = $produtos->update(
                $data["idProdutoUpdate"],
                $data["nome"] ?? $produtoAtual["nome"],
                $data["descricao"] ?? $produtoAtual["descricao"],
                $data["categoria"] ?? $produtoAtual["categoria"],
                $precoFloat,
                $link, // Mantém a imagem existente se não for enviada uma nova
                $data["unidade"] ?? $produtoAtual["unidade_medida"],
                $data["codigo_produto"] ?? $produtoAtual["codigo_produto"]
            );
    
            $json = $produtoAtualizado ? [
                "entradas" => $entradas->selectAll(),
                "saidas" => $saidas->selectAll(),
                "produtos" => $produtos->selectAll(),
                "message" => "Produto atualizado com sucesso!",
                "type" => "success"
            ] : [
                "message" => "Produto não atualizado!",
                "type" => "error"
            ];
    
            echo json_encode($json);
        }
    }

    /*------------ CRUD CATEGORIA ------------*/

    public function estoqueCc(?array $data): void
    {

        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            $categoria = new Categorias(
                NULL,
                $data["nome"],
                $data["descricao"]
            );

            if ($categoria->findByName($data["nome"])) {
                $json = [
                    "message" => "Categoria já cadastrada!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            if ($categoria->insert()) {

                $json = [
                    "categorias" => $categoria->selectAll(),
                    "nome" => $data["nome"],
                    "descricao" => $data["descricao"],
                    "message" => "Categoria cadastrada com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Categoria não cadastrada!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function estoqueCd(?array $data): void
    {

        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            $categoria = new Categorias();
            $categoriaDeletada = $categoria->delete($data["idCategoriaExcluir"]);

            if ($categoriaDeletada) {

                $json = [
                    "categorias" => $categoria->selectAll(),
                    "message" => "Categoria deletada com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Categoria não deletada!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function estoqueCu(?array $data): void
    {

        if (!empty($data)) {

            $categoria = new Categorias();
            $categoriaAtualizar = $categoria->update(
                $data["idCategoriaEditar"],
                $data["nome"],
                $data["descricao"]
            );

            if ($categoriaAtualizar) {

                $json = [
                    "categorias" => $categoria->selectAll(),
                    "message" => "Categoria atualizada com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Categoria não atualizada!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    /*------------ CRUD ENTRADAS ------------*/

    public function estoqueEc(?array $data): void
    {

        if (!empty($data)) {
            $data["quantidade"] = round((float)$data["quantidade"], 3);
            if (in_array("", $data)) {
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            $newpreco = $data["preco"];

            // Remove o símbolo de moeda 'R$'
            $newpreco = str_replace('R$', '', $newpreco);

            // Remove os pontos (separadores de milhar)
            $newpreco = str_replace('.', '', $newpreco);

            // Substitui a vírgula decimal por um ponto
            $newpreco = str_replace(',', '.', $newpreco);

            // Converte para float
            $precoFloat = (float)$newpreco;

            $fornecedor = new Fornecedores();
            $idFonecedor = $fornecedor->findByIdName($data["nome"]);

            if ($data["quantidade"] <= 0) {
                $json = [
                    "message" => "Quantidade Inválida!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            if ($precoFloat <= 0) {
                $json = [
                    "message" => "Preço Inválido!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            if ($idFonecedor == false) {
                $json = [
                    "message" => "Fornecedor não encontrado!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            $entradas = new Entradas(
                NULL,
                $idFonecedor,
                $data["produtoId"],
                $data["quantidade"],
                $precoFloat
            );

            if ($entradas->insert()) {

                $produto = new Produtos();
                $produto->somaQuantidadeProdutos($data["produtoId"], $data["quantidade"]);

                $json = [
                    "entradas" => $entradas->selectAll(),
                    "produtos" => $produto->selectAll(),
                    "nome" => $data["nome"],
                    "idFornecedor" => $idFonecedor,
                    "idProdutos" => $data["produtoId"],
                    "quantidade" => $data["quantidade"],
                    "preco" => $precoFloat,
                    "message" => "Entrada cadastrada com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Entrada não cadastrada!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function estoqueEd(?array $data): void
    {
        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            $entrada = new Entradas();
            $valoresEntrada = $entrada->selectInfoEntradaById($data["idEntradaExcluir"]);
            $entradaDeletada = $entrada->delete($data["idEntradaExcluir"]);

            if ($entradaDeletada) {
                $produto = new Produtos();
                $produto->subtraiQuantidadeProdutos($valoresEntrada->idProdutos, $valoresEntrada->quantidade);

                // Incluindo produtos atualizados na resposta
                $json = [
                    "entradas" => $entrada->selectAll(), // Lista atualizada de entradas
                    "produtos" => $produto->selectAll(), // Lista atualizada de produtos
                    "message" => "Entrada deletada com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Entrada não deletada!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function estoqueEu(?array $data): void
    {

        if (!empty($data)) {
            $data["quantidade"] = round((float)$data["quantidade"], 3);
            $entrada = new Entradas();
            $produto = new Produtos();

            if ($data["quantidade"] <= 0) {
                $json = [
                    "message" => "Quantidade Inválida!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            if ($data["preco"] <= 0) {
                $json = [
                    "message" => "Preço Inválido!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            $entradaDados = $entrada->selectInfoEntradaById($data["idEntradaEditar"]);

            $produto->subtraiQuantidadeProdutos($entradaDados->idProdutos, $entradaDados->quantidade);

            $entradaAtualizar = $entrada->update(
                $data["idEntradaEditar"],
                $data["quantidade"],
                $data["preco"]
            );

            if ($entradaAtualizar) {

                $produto->somaQuantidadeProdutos($entradaDados->idProdutos, $data["quantidade"]);

                $json = [
                    "entradas" => $entrada->selectAll(),
                    "message" => "Entrada atualizada com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Entrada não atualizada!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    /*------------ CRUD SAÍDAS ------------*/

    public function estoqueSc(?array $data): void
    {
        if (!empty($data)) {
            try {
                // Log dos dados recebidos para depuração
                file_put_contents("saida_log.txt", "Dados recebidos: " . json_encode($data) . "\n", FILE_APPEND);
                
                // Verificar se o cliente não é cadastrado usando o campo oculto
                $clienteNaoCadastrado = isset($data["cliente_nao_cadastrado"]) && $data["cliente_nao_cadastrado"] === "1";
                
                // Log do status do cliente não cadastrado
                file_put_contents("saida_log.txt", "Cliente não cadastrado: " . ($clienteNaoCadastrado ? "Sim" : "Não") . "\n", FILE_APPEND);
                
                // Verificar campos vazios apenas se o cliente não for marcado como não cadastrado
                if (!$clienteNaoCadastrado && in_array("", $data)) {
                    $json = [
                        "message" => "Informe todos os campos para cadastrar!",
                        "type" => "error"
                    ];
                    echo json_encode($json);
                    return;
                }

                $newpreco = $data["preco"];

                // Remove completamente o símbolo de moeda 'R$'
                $newpreco = str_replace('R$', '', $newpreco);

                // Remove espaços extras (inclusive invisíveis) no início e no final
                $newpreco = trim(preg_replace('/[^\S\r\n]+/u', '', $newpreco));

                // Remove os pontos (separadores de milhar)
                $newpreco = str_replace('.', '', $newpreco);

                // Substitui a vírgula decimal por um ponto
                $newpreco = str_replace(',', '.', $newpreco);

                // Converte para float
                $precoFloat = (float)$newpreco;
                
                // Log do preço processado
                file_put_contents("saida_log.txt", "Preço processado: " . $precoFloat . "\n", FILE_APPEND);

                // Verifica se é cliente não cadastrado e define idCliente como null diretamente
                $idCliente = null;
                if ($clienteNaoCadastrado || $data["nome"] === "Cliente não cadastrado") {
                    // Cliente não cadastrado, mantém idCliente como null
                    file_put_contents("saida_log.txt", "Cliente não cadastrado, idCliente = null\n", FILE_APPEND);
                } else {
                    $cliente = new Clientes();
                    $idCliente = $cliente->findByIdName($data["nome"]);
                    
                    // Log do resultado da busca pelo cliente
                    file_put_contents("saida_log.txt", "Busca por cliente: " . $data["nome"] . ", resultado: " . ($idCliente ? $idCliente : "não encontrado") . "\n", FILE_APPEND);
                    
                    // Se não encontrar, mantém como null
                    if ($idCliente == false) {
                        $idCliente = null;
                    }
                }

                if ($data["quantidade"] <= 0) {
                    $json = [
                        "message" => "Quantidade Inválida!",
                        "type" => "warning"
                    ];
                    echo json_encode($json);
                    return;
                }

                if ($precoFloat <= 0) {
                    $json = [
                        "message" => "Preço Inválido!",
                        "type" => "warning"
                    ];
                    echo json_encode($json);
                    return;
                }

                $produto = new Produtos();
                $quantidadeProduto = $produto->getQuantidadeById($data["produtoId2"]);

                if ($quantidadeProduto < $data["quantidade"]) {
                    $json = [
                        "quantidadeProduto" => $quantidadeProduto,
                        "quantidade" => $data["quantidade"],
                        "message" => "Quantidade inválida!",
                        "type" => "warning"
                    ];
                    echo json_encode($json);
                    return;
                }

                $saidas = new Saidas(
                    NULL,
                    $idCliente,
                    $data["produtoId2"],
                    $data["quantidade"],
                    $precoFloat
                );

                if ($saidas->insert()) {

                    $produto->subtraiQuantidadeProdutos($data["produtoId2"], $data["quantidade"]);

                    $json = [
                        "saidas" => $saidas->selectAll(),
                        "produtos" => $produto->selectAll(),
                        "nome" => $data["nome"],
                        "idCliente" => $idCliente,
                        "idProdutos" => $data["produtoId2"],
                        "quantidade" => $data["quantidade"],
                        "preco" => $precoFloat,
                        "message" => "Saída cadastrada com sucesso!",
                        "type" => "success"
                    ];
                    echo json_encode($json);
                    return;
                } else {
                    $json = [
                        "message" => "Saída não cadastrada!",
                        "type" => "error"
                    ];
                    echo json_encode($json);
                    return;
                }
            } catch (\Exception $e) {
                // Log de erro
                file_put_contents("saida_error.txt", date('Y-m-d H:i:s') . " - " . $e->getMessage() . "\n", FILE_APPEND);
                $json = [
                    "message" => "Erro ao processar a solicitação: " . $e->getMessage(),
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function estoqueSd(?array $data): void
    {
        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            $saida = new Saidas();
            $valoresSaida = $saida->selectInfoSaidaById($data["idSaidaExcluir"]);
            $saidaDelete = $saida->delete($data["idSaidaExcluir"]);

            if ($saidaDelete) {
                $produto = new Produtos();
                $produto->somaQuantidadeProdutos($valoresSaida->idProdutos, $valoresSaida->quantidade);

                // Incluindo produtos atualizados na resposta
                $json = [
                    "saidas" => $saida->selectAll(), // Lista atualizada de saídas
                    "produtos" => $produto->selectAll(), // Lista atualizada de produtos
                    "message" => "Saída deletada com sucesso!",
                    "type" => "success"
                ];

                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Saída não deletada!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function estoqueSu(?array $data): void
    {
        if (!empty($data)) {
            $data["quantidade"] = round((float)$data["quantidade"], 3);
            $saida = new Saidas();
            $produto = new Produtos();

            if ($data["quantidade"] <= 0) {
                $json = [
                    "message" => "Quantidade Inválida!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            if ($data["preco"] <= 0) {
                $json = [
                    "message" => "Preço Inválido!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            $saidaDados = $saida->selectInfoSaidaById($data["idEditarSaida"]);

            $produto->somaQuantidadeProdutos($saidaDados->idProdutos, $saidaDados->quantidade);

            $saidaUpdate = $saida->update(
                $data["idEditarSaida"],
                $data["quantidade"],
                $data["preco"]
            );

            if ($saidaUpdate) {

                $produto->subtraiQuantidadeProdutos($saidaDados->idProdutos, $data["quantidade"]);

                $json = [
                    "saidas" => $saida->selectAll(),
                    "quantidade" => $data["quantidade"],
                    "preco" => $data["preco"],
                    "message" => "Saída atualizada com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Saída não atualizada!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    /*------------ CRUD CLIENTES ------------*/

    public function cadastroClientes(?array $data): void
    {
        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            $client = new Clientes(
                NULL,
                $data["nome"],
                $data["cpf"],
                $data["celular"]
            );

            if ($client->findByCpf($data["cpf"])) {
                $json = [
                    "message" => "Cliente já cadastrado!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            if ($client->insert()) {

                $json = [
                    "clientes" => $client->selectAll(),
                    "nome" => $data["nome"],
                    "cpf" => $data["cpf"],
                    "message" => "Cliente cadastrado com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Cliente não cadastrado!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }

        echo $this->view->render("clientes");
    }

    public function deleteClientes(?array $data): void
    {
        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            $cliente = new Clientes();
            $clienteDeletado = $cliente->delete($data["idClienteExcluir"]);

            if ($clienteDeletado) {
                $json = [
                    "clientes" => $cliente->selectAll(),
                    "message" => "Cliente deletado com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Cliente não deletado!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function updateClientes(?array $data): void
    {
        if (!empty($data)) {

            $cliente = new Clientes();
            $clienteAtualizado = $cliente->update(
                $data["idClienteUpdate"],
                $data["nome"],
                $data["cpf"],
                $data["celular"]
            );



            if ($clienteAtualizado) {
                $json = [
                    "clientes" => $cliente->selectAll(),
                    "message" => "Cliente atualizado com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Cliente não atualizado!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    /*------------ CRUD FORNECEDORES ------------*/

    public function cadastroFornecedores(?array $data): void
    {
        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            $fornecedor = new Fornecedores(
                NULL,
                $data["nome"],
                $data["cnpj"],
                $data["email"],
                $data["telefone"],
                $data["endereco"],
                $data["municipio"],
                $data["cep"],
                $data["uf"]
            );

            if ($fornecedor->findByCnpj($data["cnpj"])) {
                $json = [
                    "message" => "Fornecedor já cadastrado!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            if ($fornecedor->insert()) {

                $json = [
                    "fornecedores" => $fornecedor->selectAll(),
                    "nome" => $data["nome"],
                    "cnpj" => $data["cnpj"],
                    "message" => "Fornecedor cadastrado com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Fornecedor não cadastrado!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }

        echo $this->view->render("fornecedores");
    }

    public function deleteFornecedores(?array $data): void
    {
        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            $entrada = new Entradas();
            $allEntradas = $entrada->selectAllByIdFornecedor($data["idFornecedorExcluir"]);

            if (!empty($allEntradas)) {
                $produto = new Produtos();

                foreach ($allEntradas as $entrada) {
                    $produto->subtraiQuantidadeProdutos($entrada->idProdutos, $entrada->quantidade);
                }
            }

            $fornecedor = new Fornecedores();
            $fornecedorDeletado = $fornecedor->delete($data["idFornecedorExcluir"]);

            if ($fornecedorDeletado) {
                $json = [
                    "fornecedores" => $fornecedor->selectAll(),
                    "message" => "Fornecedor deletado com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Fornecedor não deletado!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function updateFornecedores(?array $data): void
    {
        if (!empty($data)) {

            $fornecedor = new Fornecedores();
            $fornecedorAtualizado = $fornecedor->update(
                $data["idFornecedorEditar"],
                $data["nome"],
                $data["cnpj"],
                $data["email"],
                $data["telefone"],
                $data["endereco"],
                $data["municipio"],
                $data["cep"],
                $data["uf"]
            );



            if ($fornecedorAtualizado) {
                $json = [
                    "fornecedor" => $fornecedor->selectAll(),
                    "message" => "Fornecedor atualizado com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Fornecedor não atualizado!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    /*------------ RELATORIOS ------------*/
    public function relatorio(): void
    {
        echo $this->view->render("relatorio");
    }

    public function relatorioClientes(): void
    {
        $pdfReport = new PDFReport();
        $pdfReport->generateClientReport();
    }

    public function relatorioFornecedores(): void
    {
        $pdfReport = new PDFReport();
        $pdfReport->generateSupplierReport();
    }

    public function relatorioProdutos(): void
    {
        $pdfReport = new PDFReport();
        $pdfReport->generateProductReport();
    }

    /*------------ RELATORIOS EXCEL ------------*/
    public function relatorioClientesExcel(): void
    {
        $excelReport = new ExcelReport();
        $excelReport->generateClientReport();
    }

    public function relatorioFornecedoresExcel(): void
    {
        $excelReport = new ExcelReport();
        $excelReport->generateSupplierReport();
    }

    public function relatorioProdutosExcel(): void
    {
        $excelReport = new ExcelReport();
        $excelReport->generateProductReport();
    }

    /*------------ FUNÇÕES GET ------------*/
    public function getHistoricoCliente(?array $data)
    {
        $cliente = new Clientes();
        $historico = $cliente->getHistoricoSaidas($data['idCliente']);
        $nomeCliente = $cliente->getDadosCliente($data['idCliente'])[0]['nome'];

        $retorno = array("nomeCliente" => $nomeCliente, "historico" => $historico);
        echo json_encode($retorno);
    }

    public function getProdutos()
    {
        $produto = new Produtos();
        echo json_encode($produto->selectAll());
    }

    public function getCategorias()
    {
        $categoria = new Categorias();
        echo json_encode($categoria->selectAll());
    }

    public function getClientes()
    {
        $cliente = new Clientes();
        echo json_encode($cliente->selectAll());
    }

    public function getFornecedores()
    {
        $fornecedores = new Fornecedores();
        echo json_encode($fornecedores->selectAll());
    }

    public function getEntradas()
    {
        $entradas = new Entradas();
        echo json_encode($entradas->selectAll());
    }

    public function getSaidas()
    {
        $saidas = new Saidas();
        echo json_encode($saidas->selectAll());
    }

    /*------------ NOTAS ------------*/
    public function processarXmlNota($request)
    {
        $pdo = \Source\Core\Connect::getInstance();

        if (!isset($_FILES['arquivoNota']) || $_FILES['arquivoNota']['error'] != UPLOAD_ERR_OK) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['type' => 'error', 'message' => 'Erro no upload do arquivo XML']);
            return;
        }

        $xmlPath = $_FILES['arquivoNota']['tmp_name'];
        $xmlContent = file_get_contents($xmlPath);
        $xml = simplexml_load_string($xmlContent);

        if (!$xml) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['type' => 'error', 'message' => 'Arquivo XML inválido']);
            return;
        }

        // Registrar namespace do XML
        $namespaces = $xml->getNamespaces(true);
        if (isset($namespaces[''])) {
            $xml->registerXPathNamespace('nfe', $namespaces['']);
        }

        // Extrair informações do fornecedor
        $emit = $xml->xpath('//nfe:emit')[0] ?? null;
        if (!$emit) {
            echo json_encode(['type' => 'error', 'message' => 'Dados do fornecedor não encontrados no XML']);
            return;
        }

        $fornecedor = [
            'CNPJ' => (string)($emit->CNPJ ?? ''),
            'Nome' => (string)($emit->xNome ?? ''),
            'Endereco' => (string)($emit->enderEmit->xLgr ?? ''),
            'Municipio' => (string)($emit->enderEmit->xMun ?? ''),
            'CEP' => (string)($emit->enderEmit->CEP ?? ''),
            'UF' => (string)($emit->enderEmit->UF ?? ''),
            'Telefone' => (string)($emit->enderEmit->fone ?? ''),
        ];

        // Processar produtos
        $produtos = [];
        $detElements = $xml->xpath('//nfe:det');

        if (!$detElements || count($detElements) < 1) {
            echo json_encode(['type' => 'error', 'message' => 'Nenhum produto encontrado no XML']);
            return;
        }

        foreach ($detElements as $det) {
            $prod = $det->prod ?? null;

            if (!$prod) {
                echo json_encode(['type' => 'warning', 'message' => 'Produto com estrutura inválida ignorado']);
                continue;
            }

            $produto = [
                'codigo_produto' => (string)($prod->cProd ?? ''),
                'nome' => (string)($prod->xProd ?? ''),
                'descricao' => (string)($prod->xProd ?? ''),
                'quantidade' => (float)($prod->qCom ?? 0),
                'preco' => (float)($prod->vUnCom ?? 0),
                'unidade_medida' => (string)($prod->uCom ?? ''),
            ];

            // Validações dos campos obrigatórios
            if (empty($produto['codigo_produto']) || empty($produto['nome']) || $produto['quantidade'] <= 0) {
                echo json_encode(['type' => 'error', 'message' => 'Produto inválido: ' . json_encode($produto)]);
                continue;
            }

            $produtos[] = $produto;
        }

        if (count($produtos) === 0) {
            echo json_encode(['type' => 'error', 'message' => 'Nenhum produto válido encontrado no XML']);
            return;
        }

        // Registrar dados no banco de dados
        $this->cadastrarNota($fornecedor, $produtos);

        echo json_encode(['type' => 'success', 'message' => 'Nota processada com sucesso!']);
    }

    public function cadastrarNota(array $fornecedorData, array $produtosData): void
    {
        $pdo = \Source\Core\Connect::getInstance();

        try {
            $pdo->beginTransaction();

            // Verifica se o fornecedor já existe
            $queryFornecedor = "SELECT id FROM fornecedores WHERE cnpj = :cnpj LIMIT 1";
            $stmtFornecedor = $pdo->prepare($queryFornecedor);
            $stmtFornecedor->execute(['cnpj' => $fornecedorData['CNPJ']]);
            $fornecedorId = $stmtFornecedor->fetchColumn();

            // Obter o primeiro idCategoria disponível
            $queryFirstCategory = "SELECT id FROM categorias ORDER BY id ASC LIMIT 1";
            $stmtFirstCategory = $pdo->prepare($queryFirstCategory);
            $stmtFirstCategory->execute();
            $firstCategoryId = $stmtFirstCategory->fetchColumn();

            if (!$fornecedorId) {
                $queryInsertFornecedor = "
            INSERT INTO fornecedores (nome, cnpj, telefone, endereco, municipio, cep, uf, created_at) 
            VALUES (:nome, :cnpj, :telefone, :endereco, :municipio, :cep, :uf, NOW())
            ";
                $stmtInsertFornecedor = $pdo->prepare($queryInsertFornecedor);
                $stmtInsertFornecedor->execute([
                    'nome' => $fornecedorData['Nome'],
                    'cnpj' => $fornecedorData['CNPJ'],
                    'telefone' => $fornecedorData['Telefone'],
                    'endereco' => $fornecedorData['Endereco'],
                    'municipio' => $fornecedorData['Municipio'],
                    'cep' => $fornecedorData['CEP'],
                    'uf' => $fornecedorData['UF'],
                ]);
                $fornecedorId = $pdo->lastInsertId();
            }

            // Processar produtos
            foreach ($produtosData as $produto) {
                $queryProduto = "SELECT id FROM produtos WHERE codigo_produto = :codigo_produto LIMIT 1";
                $stmtProduto = $pdo->prepare($queryProduto);
                $stmtProduto->execute(['codigo_produto' => $produto['codigo_produto']]);
                $produtoId = $stmtProduto->fetchColumn();

                if (!$produtoId) {
                    // Produto não existe, inserir um novo registro
                    $queryInsertProduto = "
                INSERT INTO produtos (idCategoria, nome, descricao, preco, quantidade, codigo_produto, unidade_medida, created_at)
                VALUES (:idCategoria, :nome, :descricao, :preco, :quantidade, :codigo_produto, :unidade_medida, NOW())
                ";
                    $stmtInsertProduto = $pdo->prepare($queryInsertProduto);
                    $stmtInsertProduto->execute([
                        'idCategoria' => $firstCategoryId,
                        'nome' => $produto['nome'],
                        'descricao' => $produto['descricao'],
                        'preco' => 0, // Insere o preço como 0 no banco
                        'quantidade' => $produto['quantidade'],
                        'codigo_produto' => $produto['codigo_produto'],
                        'unidade_medida' => $produto['unidade_medida'],
                    ]);
                    $produtoId = $pdo->lastInsertId();
                } else {
                    // Produto já existe, apenas soma a quantidade
                    $produtos = new Produtos();
                    $produtos->somaQuantidadeProdutos($produtoId, $produto['quantidade']);
                }

                $queryInsertEntrada = "
            INSERT INTO entradas (idFornecedor, idProdutos, quantidade, preco, created_at)
            VALUES (:idFornecedor, :idProdutos, :quantidade, :preco, NOW())
            ";
                $stmtInsertEntrada = $pdo->prepare($queryInsertEntrada);
                $stmtInsertEntrada->execute([
                    'idFornecedor' => $fornecedorId,
                    'idProdutos' => $produtoId,
                    'quantidade' => $produto['quantidade'],
                    'preco' => $produto['preco'],
                ]);
            }

            $pdo->commit();
        } catch (\Exception $e) {
            $pdo->rollBack();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => "Erro ao processar a nota: " . $e->getMessage()]);
        }
    }

    /**
     * Método para realizar o logout do usuário
     */
    public function logout(): void
    {
        $session = new \Source\Core\Session();
        $session->destroy();
        
        $json = [
            "message" => "Logout realizado com sucesso!",
            "type" => "success"
        ];
        
        echo json_encode($json);
    }
}
