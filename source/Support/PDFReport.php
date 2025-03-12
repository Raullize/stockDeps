<?php

namespace Source\Support;

use Dompdf\Dompdf;
use Source\Models\Clientes;
use Source\Models\Fornecedores;
use Source\Models\Produtos;
use Source\Models\Categorias;

/**
 * Classe responsável pela geração de relatórios em PDF
 */
class PDFReport
{
    /**
     * Gera um relatório de clientes em PDF
     * 
     * @return void
     */
    public function generateClientReport(): void
    {
        $cliente = new Clientes();
        $clientes = $cliente->selectAll();

        $clienteList = "";
        foreach ($clientes as $cliente) {
            $clienteList .= "
            <tr>
                <td>{$cliente->nome}</td>
                <td>{$cliente->cpf}</td>
                <td>{$cliente->celular}</td>
            </tr>
        ";
        }

        $dompdf = new Dompdf();

        $dompdf->loadHtml("<html>
        <body>
        <div>
            <h1>Relatório de Clientes</h1>
        </div>
        
        <h2>Lista de Clientes Cadastrados:</h2>
        <table>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Celular</th>
            </tr>
            $clienteList
        </table>
        </body>
        
        <style>
            body {
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                margin: 20px;
                padding: 0;
                color: #333;
            }

            h1 {
                text-align: center;
                margin-bottom: 20px;
                color: #4361ee;
            }

            h2 {
                font-size: 16px;
                margin-bottom: 15px;
                color: #333;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 20px;
                font-size: 12px;
            }

            th, td {
                border: 1px solid #ddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #4361ee;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            td {
                word-wrap: break-word;
                max-width: 150px;
            }
        </style>
        
        </html>");

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // Utiliza o formato A4 e orientação retrato

        // Render the HTML as PDF
        $dompdf->render();

        // Cabeçalhos para evitar problemas de cache e garantir download
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        
        // Output the generated PDF to Browser
        $dompdf->stream("relatório-clientes.pdf", ["Attachment" => true]);
    }

    /**
     * Gera um relatório de fornecedores em PDF
     * 
     * @return void
     */
    public function generateSupplierReport(): void
    {
        $fornecedor = new Fornecedores();
        $fornecedores = $fornecedor->selectAll();

        $fornecedorList = "";
        foreach ($fornecedores as $fornecedor) {
            $fornecedorList .= "
            <tr>
                <td>{$fornecedor->nome}</td>
                <td>{$fornecedor->cnpj}</td>
                <td>{$fornecedor->email}</td>
                <td>{$fornecedor->telefone}</td>
                <td>{$fornecedor->endereco}</td>
                <td>{$fornecedor->municipio}</td>
                <td>{$fornecedor->cep}</td>
                <td>{$fornecedor->uf}</td>
            </tr>
        ";
        }

        $dompdf = new Dompdf();

        $dompdf->loadHtml("<html>
    <body>
    <div>
        <h1>Relatório de Fornecedores</h1>
    </div>

    <h2>Lista de Fornecedores em Estoque:</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>Cnpj</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Município</th>
            <th>CEP</th>
            <th>UF</th>
        </tr>
        $fornecedorList
    </table>
    </body>

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 20px;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #4361ee;
        }

        h2 {
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #4361ee;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td {
            word-wrap: break-word;
            max-width: 150px;
        }

    </style>
    
    </html>");

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape'); // Mude para 'landscape' para um layout mais largo

        // Render the HTML as PDF
        $dompdf->render();
        
        // Cabeçalhos para evitar problemas de cache e garantir download
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        // Output the generated PDF to Browser
        $dompdf->stream("relatório-fornecedores.pdf", ["Attachment" => true]);
    }

    /**
     * Gera um relatório de produtos em PDF
     * 
     * @return void
     */
    public function generateProductReport(): void
    {
        $produto = new Produtos();
        $produtos = $produto->selectAll();
        $categoria = new Categorias();

        $produtoList = "";
        foreach ($produtos as $produto) {
            $categoriaNome = $categoria->findNameById($produto->idCategoria);
            $produtoList .= "
            <tr>
                <td>{$produto->codigo_produto}</td>
                <td>{$produto->nome}</td>
                <td>{$categoriaNome}</td>
                <td>{$produto->descricao}</td>
                <td>{$produto->preco}</td>
                <td>{$produto->quantidade}</td>
                <td>{$produto->unidade_medida}</td>
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
                <th>Código</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Unidade</th>
            </tr>
            $produtoList
        </table>
        </body>
        
        <style>
            body {
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                margin: 20px;
                padding: 0;
                color: #333;
            }

            h1 {
                text-align: center;
                margin-bottom: 20px;
                color: #4361ee;
            }

            h2 {
                font-size: 16px;
                margin-bottom: 15px;
                color: #333;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 20px;
                font-size: 12px;
            }

            th, td {
                border: 1px solid #ddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #4361ee;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            td {
                word-wrap: break-word;
                max-width: 150px;
            }
        </style>
        
        </html>");

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // Utiliza o formato A4 e orientação retrato

        // Render the HTML as PDF
        $dompdf->render();
        
        // Cabeçalhos para evitar problemas de cache e garantir download
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        // Output the generated PDF to Browser
        $dompdf->stream("relatório-produtos.pdf", ["Attachment" => true]);
    }
} 