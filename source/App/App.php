<?php

namespace Source\App;

use Smalot\PdfParser\Parser;
use Dompdf\Dompdf;
use League\Plates\Engine;
use Source\Models\Categorias;
use Source\Models\Clientes;
use Source\Models\Entradas;
use Source\Models\Fornecedores;
use Source\Models\Produtos;
use Source\Models\Saidas;
use Source\Models\EstoqueFeatures;


class App
{
    private $view;
    private EstoqueFeatures $estoqueFeatures;

    public function __construct()
    {
        $this->view = new Engine(CONF_VIEW_APP, 'php');
        $this->estoqueFeatures = new EstoqueFeatures();
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

    public function estoquePc(?array $data): void
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

            if ($produto->validateProdutos($data["nome"], $data["categoria"])) {
                $json = [
                    "message" => "Produto já cadastrado!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            $produto = new Produtos(
                NULL,
                $data["categoria"],
                $data["nome"],
                $data["descricao"],
                $precoFloat
            );

            if ($produto->insert()) {

                $json = [
                    "produtos" => $produto->selectAll(),
                    "nome" => $data["nome"],
                    "categoria" => $data["categoria"],
                    "preco" => $precoFloat,
                    "descricao" => $data["descricao"],
                    "message" => "Produto cadastrado com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;

            } else {
                $json = [
                    "message" => "Produto não cadastrado!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function estoquePe(?array $data): void
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

            if ($produto->validateProdutos($data["nome"], $data["categoria"])) {
                $json = [
                    "message" => "Produto já cadastrado!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            $produto = new Produtos(
                NULL,
                $data["categoria"],
                $data["nome"],
                $data["descricao"],
                $precoFloat
            );

            if ($produto->insert()) {

                $json = [
                    "produtos" => $produto->selectAll(),
                    "nome" => $data["nome"],
                    "categoria" => $data["categoria"],
                    "preco" => $precoFloat,
                    "descricao" => $data["descricao"],
                    "message" => "Produto cadastrado com sucesso!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;

            } else {
                $json = [
                    "message" => "Produto não cadastrado!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

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

    public function estoqueEc(?array $data): void
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

            if($idFonecedor == false){
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
                    "preco" => $data["preco"],
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

    public function estoqueSc(?array $data): void
    {
        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "nome" => $data["nome"],
                    "idProdutos" => $data["produtoId2"],
                    "quantidade" => $data["quantidade"],
                    "preco" => $data["preco"],
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

            $cliente = new Clientes();
            $idCliente = $cliente->findByIdName($data["nome"]);

            $produto = new Produtos();
            $quantidadeProduto = $produto->getQuantidadeById($data["produtoId2"]);

            if ($quantidadeProduto < $data["quantidade"]){
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
                    "preco" => $data["preco"],
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
        }
    }

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

    public function estoqueSaidas(?array $data): void
    {

        $cliente = new Clientes();

        $saidas = new Saidas(
            NULL,
            $data["categoria"],
            $cliente->findByIdName($data["cliente"]),
            $data["produto"],
            $data["quantidade"]
        );


        if (!empty($data)) {

            if (in_array("", $data)) {
                $json = [
                    "message" => "<div style='color: red'>Informe todos os campos para dar saída neste produto!</div>",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            $cliente = new Clientes();

            $saidas = new Saidas(
                NULL,
                $data["categoria"],
                $cliente->findByIdName($data["cliente"]),
                $data["produto"],
                $data["quantidade"]
            );

            if ($saidas->insert()) {
                $json = [
                    "message" => "<div style='margin-left: 25px; color: green'>Produtos retirados com sucesso!</div>",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "<div style='margin-left: 25px; color: red'>Saldo insuficiente para retirada!</div>",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }
    }

    public function estoqueDeletar(?array $data)
    {
        $output = $this->estoqueFeatures->deleteRegister($data['table'], $data['id']);
        echo json_encode($output);
    }

    public function estoqueAtualizar(?array $data)
    {
        $output = $this->estoqueFeatures->updateRegister($data['table'], $data['id'], $data['quantidade'], $data['idProduto']);
        echo json_encode($output);
    }

    
    public function relatorio(): void
    {

        echo $this->view->render("relatorio");
    }

    public function relatorioClientes(): void
    {

        $cliente = new Clientes();
        $clientes = $cliente->selectAll();

        $clienteList = "";
        foreach ($clientes as $cliente) {
            $clienteList .= "
            <tr>
                <td>{$cliente->nome}</td>
                <td>{$cliente->email}</td>
                <td>{$cliente->celular}</td>
                <td>{$cliente->cidade}</td>
                <td>{$cliente->bairro}</td>
                <td>{$cliente->uf}</td>
            </tr>
        ";
        }

        $dompdf = new Dompdf();

        $dompdf->loadHtml("<html>
    <body>
    <div>
        <h1>Relatório de Clientes</h1>
    </div>
    
    <h2>Lista de clientes cadastrados:</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Cidade</th>
            <th>Bairro</th>
            <th>UF</th>
        </tr>
        $clienteList
    </table>
            
    </body>
    
    <style>
        body {
            font-family: arial, sans-serif;
        }
        h1 {
            text-align: center;margin-bottom: 100px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 90px;
        }
        
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    
    </html>");

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("relatório-clientes");
    }

    public function relatorioProdutos(): void
    {

        $produto = new Produtos();
        $produtos = $produto->selectAll();

        $produtoList = "";
        foreach ($produtos as $produto) {
            $produtoList .= "
            <tr>
                <td>{$produto->nome}</td>
                <td>{$produto->preco}</td>
                <td>{$produto->descricao}</td>
                <td>{$produto->created_at}</td>
            </tr>
        ";
        }

        $dompdf = new Dompdf();

        $dompdf->loadHtml("<html>
    <body>
    <div>
        <h1>Relatório de Produtos</h1>
    </div>
    
    <h2>Lista de Produtos em Estoque:</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Descrição</th>
            <th>Data</th>
        </tr>
        $produtoList
    </table>
            
    </body>
    
    <style>
        body {
            font-family: arial, sans-serif;
        }
        h1 {
            text-align: center;margin-bottom: 100px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 90px;
        }
        
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    
    </html>");

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("relatório-produtos");
    }

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

    public function uploadPdf(): void
    {
        echo $this->view->render("uploadPdf");
    }

    // Método para processar o PDF enviado
    public function processarPdf(): void
    {
        // Verifica se a requisição é POST e se o arquivo foi enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
            $pdfFile = $_FILES['pdf'];

            // Verifica se o upload do arquivo ocorreu sem erros
            if ($pdfFile['error'] === UPLOAD_ERR_OK) {
                // Define o diretório de uploads
                $uploadDir = __DIR__ . '/uploads/';

                // Cria o diretório de uploads, caso não exista
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Define o caminho completo para o arquivo PDF
                $pdfPath = $uploadDir . basename($pdfFile['name']);

                // Move o arquivo PDF para o diretório de uploads
                if (move_uploaded_file($pdfFile['tmp_name'], $pdfPath)) {
                    // Processa o PDF
                    $itens = $this->extrairItensDoPDF($pdfPath);

                    // Exclui o arquivo PDF após o processamento (opcional)
                    unlink($pdfPath);

                    // Exibe os itens extraídos do PDF
                    echo '<pre>';
                    print_r($itens);
                    echo '</pre>';
                } else {
                    echo "Erro ao salvar o arquivo PDF.";
                }
            } else {
                echo "Erro no envio do arquivo PDF.";
            }
        }
    }

    // Função para processar e extrair os itens do PDF
    // Caminho: Source/App/App.php
    // Função para processar e extrair os itens do PDF

    private function extrairItensDoPDF($pdfPath)
    {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($pdfPath);

        // Obtém o texto do PDF
        $text = $pdf->getText();

        // Verifica se o texto foi extraído corretamente
        if (empty($text)) {
            echo "Texto não extraído do PDF.<br>";
            return [];
        }

        echo "<h3>Texto Completo do PDF:</h3>";
        echo "<pre>" . htmlspecialchars($text) . "</pre>";

        // Lista para armazenar os itens extraídos
        $itens = [];

        // Divide o texto em linhas
        $linhas = explode("\n", $text);

        echo "<h3>Linhas Extraídas:</h3>";
        echo "<pre>";
        print_r($linhas);
        echo "</pre>";

        // Percorre as linhas do texto e tenta aplicar o regex
        foreach ($linhas as $linha) {
            echo "<strong>Processando Linha:</strong> " . htmlspecialchars($linha) . "<br>";

            // Regex para capturar Código, Descrição, NCM/SH, Unidade, Quantidade, Valor Unitário e Valor Total
            // Captura:
            // - Código: sequência numérica inicial
            // - Descrição: Nome do produto (permitindo espaços e hífens)
            // - NCM/SH: Sequência numérica após a descrição
            // - Unidade: 1KG, POTE, etc.
            // - Quantidade: Ex: 3,0000
            // - Valor Unitário: Ex: 72,3500
            // - Valor Total: Ex: 217,05
            if (preg_match('/^(\d+)\s+([A-Za-z\s\-\(\),]+)\s+(\d+)\s+(\w+)\s+([\d,.]+)\s+([\d,.]+)\s+([\d,.]+)\b/', $linha, $matches)) {
                $itens[] = [
                    'codigo' => trim($matches[1]),                        // Código do produto
                    'descricao' => trim($matches[2]),                     // Nome do produto
                    'ncm_sh' => trim($matches[3]),                        // NCM/SH
                    'unidade' => trim($matches[4]),                       // Unidade (ex: 1KG, POTE)
                    'quantidade' => (float)str_replace(',', '.', $matches[5]),  // Quantidade
                    'valor_unitario' => (float)str_replace(',', '.', $matches[6]), // Valor unitário
                    'valor_total' => (float)str_replace(',', '.', $matches[7])  // Valor total
                ];
                echo "<strong>Item capturado:</strong> ";
                print_r($itens[count($itens) - 1]);
                echo "<br>";
            } else {
                echo "<strong>Regex não aplicável para esta linha.</strong><br>";
            }
        }

        // Exibe o array final
        echo "<h3>Itens Extraídos:</h3>";
        echo "<pre>";
        print_r($itens);
        echo "</pre>";

        return $itens;
    }
}
