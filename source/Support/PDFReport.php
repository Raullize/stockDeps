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
                <td class='nome-column'>{$cliente->nome}</td>
                <td>{$cliente->cpf}</td>
                <td>{$cliente->celular}</td>
            </tr>
        ";
        }

        $dompdf = new Dompdf();
        $currentDate = date('d/m/Y H:i:s');

        $dompdf->loadHtml("<html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <title>Relatório de Clientes</title>
        </head>
        <body>
            <header>
                <div class='header-container'>
                    <div class='logo-container'>
                        <div class='logo'>StockDeps</div>
                    </div>
                    <div class='title-container'>
                        <h1>Relatório de Clientes</h1>
                        <p class='subtitle'>Lista completa de clientes cadastrados no sistema</p>
                    </div>
                </div>
                <div class='date-container'>
                    <p>Gerado em: {$currentDate}</p>
                </div>
                <div class='header-line'></div>
            </header>
            
            <main>
                <div class='info-block'>
                    <h2>Informações do Relatório</h2>
                    <p>Este relatório contém a lista de todos os clientes cadastrados no sistema StockDeps, com seus respectivos dados de identificação e contato.</p>
                </div>
                
                <div class='table-container'>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome Completo</th>
                                <th>CPF</th>
                                <th>Telefone Celular</th>
                            </tr>
                        </thead>
                        <tbody>
                            $clienteList
                        </tbody>
                    </table>
                </div>
                
                <div class='summary-block'>
                    <h3>Resumo</h3>
                    <p>Total de clientes cadastrados: <strong>" . count($clientes) . "</strong></p>
                </div>
            </main>
            
            <footer>
                <div class='footer-line'></div>
                <div class='footer-content'>
                    <p>© " . date('Y') . " StockDeps - Sistema de Gestão de Estoque</p>
                    <p>Página <span class='pagenum'></span></p>
                </div>
            </footer>
        </body>
        
        <style>
            @page {
                margin: 1.5cm 1.2cm;
                size: A4 portrait;
            }
            
            body {
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                margin: 0;
                padding: 0;
                color: #2d3748;
                font-size: 11pt;
                line-height: 1.6;
                background-color: #ffffff;
            }
            
            /* Cabeçalho */
            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            }
            
            .logo-container {
                width: 20%;
            }
            
            .logo {
                font-size: 20pt;
                font-weight: bold;
                color: #4361ee;
                letter-spacing: -1px;
            }
            
            .title-container {
                width: 80%;
                text-align: right;
            }
            
            h1 {
                color: #4361ee;
                font-size: 22pt;
                margin: 0;
                padding: 0;
                font-weight: 800;
            }
            
            .subtitle {
                color: #4a5568;
                font-size: 11pt;
                margin: 5px 0 0 0;
                font-style: italic;
            }
            
            .date-container {
                text-align: right;
                font-size: 9pt;
                color: #718096;
                margin-bottom: 5px;
            }
            
            .header-line {
                height: 5px;
                background: linear-gradient(90deg, #4361ee, #3a0ca3);
                margin-bottom: 15px;
                border-radius: 2px;
            }
            
            /* Conteúdo */
            main {
                margin-bottom: 2cm;
            }
            
            .info-block {
                background-color: #f8fafc;
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 15px;
                border-left: 4px solid #4361ee;
            }
            
            h2 {
                color: #4361ee;
                font-size: 14pt;
                margin: 0 0 8px 0;
                padding: 0;
            }
            
            .table-container {
                margin-top: 15px;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                box-shadow: 0 2px 6px rgba(67, 97, 238, 0.1);
                font-size: 9pt;
            }
            
            thead {
                background-color: #4361ee;
                color: white;
            }
            
            th {
                text-align: left;
                padding: 10px 8px;
                font-weight: 600;
                font-size: 10pt;
                text-transform: uppercase;
                letter-spacing: 0.3px;
            }
            
            tr:nth-child(even) {
                background-color: #f8fafc;
            }
            
            td {
                padding: 8px;
                border-bottom: 1px solid #e2e8f0;
            }
            
            .nome-column {
                min-width: 200px;
                max-width: 280px;
            }
            
            .summary-block {
                background-color: #edf2f7;
                border-radius: 6px;
                padding: 12px;
                margin-top: 20px;
                border-left: 4px solid #4361ee;
            }
            
            h3 {
                color: #4361ee;
                font-size: 12pt;
                margin: 0 0 8px 0;
                padding: 0;
            }
            
            /* Rodapé */
            footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                font-size: 8pt;
                color: #718096;
                z-index: 1000;
            }
            
            .footer-line {
                height: 2px;
                background-color: #e2e8f0;
                margin-bottom: 8px;
            }
            
            .footer-content {
                display: flex;
                justify-content: space-between;
            }
            
            .pagenum:before {
                content: counter(page);
            }
            
            /* Garantir que o número de página apareça em todas as páginas */
            @page {
                counter-increment: page;
            }
        </style>
        
        </html>");

        // Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

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
                <td class='endereco-column'>{$fornecedor->endereco}, {$fornecedor->municipio}, {$fornecedor->cep}, {$fornecedor->uf}</td>
            </tr>
        ";
        }

        $dompdf = new Dompdf();
        $currentDate = date('d/m/Y H:i:s');

        $dompdf->loadHtml("<html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <title>Relatório de Fornecedores</title>
        </head>
        <body>
            <header>
                <div class='header-container'>
                    <div class='logo-container'>
                        <div class='logo'>StockDeps</div>
                    </div>
                    <div class='title-container'>
                        <h1>Relatório de Fornecedores</h1>
                        <p class='subtitle'>Lista completa de fornecedores cadastrados no sistema</p>
                    </div>
                </div>
                <div class='date-container'>
                    <p>Gerado em: {$currentDate}</p>
                </div>
                <div class='header-line'></div>
            </header>
            
            <main>
                <div class='info-block'>
                    <h2>Informações do Relatório</h2>
                    <p>Este relatório contém a lista de todos os fornecedores cadastrados no sistema StockDeps, com seus respectivos dados de identificação, contato e localização.</p>
                </div>
                
                <div class='table-container'>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome/Razão Social</th>
                                <th>CNPJ</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Endereço Completo</th>
                            </tr>
                        </thead>
                        <tbody>
                            $fornecedorList
                        </tbody>
                    </table>
                </div>
                
                <div class='summary-block'>
                    <h3>Resumo</h3>
                    <p>Total de fornecedores cadastrados: <strong>" . count($fornecedores) . "</strong></p>
                </div>
            </main>
            
            <footer>
                <div class='footer-line'></div>
                <div class='footer-content'>
                    <p>© " . date('Y') . " StockDeps - Sistema de Gestão de Estoque</p>
                    <p>Página <span class='pagenum'></span></p>
                </div>
            </footer>
        </body>
        
        <style>
            @page {
                margin: 1.5cm 1.2cm;
                size: A4 portrait;
            }
            
            body {
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                margin: 0;
                padding: 0;
                color: #2d3748;
                font-size: 11pt;
                line-height: 1.6;
                background-color: #ffffff;
            }
            
            /* Cabeçalho */
            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            }
            
            .logo-container {
                width: 20%;
            }
            
            .logo {
                font-size: 20pt;
                font-weight: bold;
                color: #4361ee;
                letter-spacing: -1px;
            }
            
            .title-container {
                width: 80%;
                text-align: right;
            }
            
            h1 {
                color: #4361ee;
                font-size: 22pt;
                margin: 0;
                padding: 0;
                font-weight: 800;
            }
            
            .subtitle {
                color: #4a5568;
                font-size: 11pt;
                margin: 5px 0 0 0;
                font-style: italic;
            }
            
            .date-container {
                text-align: right;
                font-size: 9pt;
                color: #718096;
                margin-bottom: 5px;
            }
            
            .header-line {
                height: 5px;
                background: linear-gradient(90deg, #4361ee, #3a0ca3);
                margin-bottom: 15px;
                border-radius: 2px;
            }
            
            /* Conteúdo */
            main {
                margin-bottom: 2cm;
            }
            
            .info-block {
                background-color: #f8fafc;
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 15px;
                border-left: 4px solid #4361ee;
            }
            
            h2 {
                color: #4361ee;
                font-size: 14pt;
                margin: 0 0 8px 0;
                padding: 0;
            }
            
            .table-container {
                margin-top: 15px;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                box-shadow: 0 2px 6px rgba(67, 97, 238, 0.1);
                font-size: 9pt;
            }
            
            thead {
                background-color: #4361ee;
                color: white;
            }
            
            th {
                text-align: left;
                padding: 10px 8px;
                font-weight: 600;
                font-size: 10pt;
                text-transform: uppercase;
                letter-spacing: 0.3px;
            }
            
            tr:nth-child(even) {
                background-color: #f8fafc;
            }
            
            td {
                padding: 8px;
                border-bottom: 1px solid #e2e8f0;
            }
            
            .endereco-column {
                max-width: 250px;
                word-break: break-word;
            }
            
            .summary-block {
                background-color: #edf2f7;
                border-radius: 6px;
                padding: 12px;
                margin-top: 20px;
                border-left: 4px solid #4361ee;
            }
            
            h3 {
                color: #4361ee;
                font-size: 12pt;
                margin: 0 0 8px 0;
                padding: 0;
            }
            
            /* Rodapé */
            footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                font-size: 8pt;
                color: #718096;
                z-index: 1000;
            }
            
            .footer-line {
                height: 2px;
                background-color: #e2e8f0;
                margin-bottom: 8px;
            }
            
            .footer-content {
                display: flex;
                justify-content: space-between;
            }
            
            .pagenum:before {
                content: counter(page);
            }
            
            /* Garantir que o número de página apareça em todas as páginas */
            @page {
                counter-increment: page;
            }
        </style>
        
        </html>");

        // Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

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
        $totalQuantidade = 0;
        foreach ($produtos as $produto) {
            $categoriaNome = $categoria->findNameById($produto->idCategoria);
            $preco = number_format((float)$produto->preco, 2, ',', '.');
            $totalQuantidade += (int)$produto->quantidade;
            $produtoList .= "
            <tr>
                <td>{$produto->codigo_produto}</td>
                <td class='nome-column'>{$produto->nome}</td>
                <td>{$categoriaNome}</td>
                <td class='descricao-column'>{$produto->descricao}</td>
                <td class='text-right'>R$ {$preco}</td>
                <td class='text-right'>{$produto->quantidade}</td>
                <td>{$produto->unidade_medida}</td>
            </tr>
        ";
        }

        $dompdf = new Dompdf();
        $currentDate = date('d/m/Y H:i:s');

        $dompdf->loadHtml("<html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <title>Relatório de Produtos</title>
        </head>
        <body>
            <header>
                <div class='header-container'>
                    <div class='logo-container'>
                        <div class='logo'>StockDeps</div>
                    </div>
                    <div class='title-container'>
                        <h1>Relatório de Produtos</h1>
                        <p class='subtitle'>Inventário completo de produtos em estoque</p>
                    </div>
                </div>
                <div class='date-container'>
                    <p>Gerado em: {$currentDate}</p>
                </div>
                <div class='header-line'></div>
            </header>
            
            <main>
                <div class='info-block'>
                    <h2>Informações do Relatório</h2>
                    <p>Este relatório contém a lista completa de todos os produtos cadastrados no sistema StockDeps, incluindo suas informações de estoque e preço.</p>
                </div>
                
                <div class='table-container'>
                    <table>
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Qtde</th>
                                <th>Un.</th>
                            </tr>
                        </thead>
                        <tbody>
                            $produtoList
                        </tbody>
                    </table>
                </div>
                
                <div class='summary-block'>
                    <h3>Resumo</h3>
                    <p>Total de produtos cadastrados: <strong>" . count($produtos) . "</strong></p>
                    <p>Quantidade total em estoque: <strong>{$totalQuantidade}</strong> unidades</p>
                </div>
            </main>
            
            <footer>
                <div class='footer-line'></div>
                <div class='footer-content'>
                    <p>© " . date('Y') . " StockDeps - Sistema de Gestão de Estoque</p>
                    <p>Página <span class='pagenum'></span></p>
                </div>
            </footer>
        </body>
        
        <style>
            @page {
                margin: 1.5cm 1.2cm;
                size: A4 portrait;
            }
            
            body {
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                margin: 0;
                padding: 0;
                color: #2d3748;
                font-size: 11pt;
                line-height: 1.6;
                background-color: #ffffff;
            }
            
            /* Cabeçalho */
            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            }
            
            .logo-container {
                width: 20%;
            }
            
            .logo {
                font-size: 20pt;
                font-weight: bold;
                color: #4361ee;
                letter-spacing: -1px;
            }
            
            .title-container {
                width: 80%;
                text-align: right;
            }
            
            h1 {
                color: #4361ee;
                font-size: 22pt;
                margin: 0;
                padding: 0;
                font-weight: 800;
            }
            
            .subtitle {
                color: #4a5568;
                font-size: 11pt;
                margin: 5px 0 0 0;
                font-style: italic;
            }
            
            .date-container {
                text-align: right;
                font-size: 9pt;
                color: #718096;
                margin-bottom: 5px;
            }
            
            .header-line {
                height: 5px;
                background: linear-gradient(90deg, #4361ee, #3a0ca3);
                margin-bottom: 15px;
                border-radius: 2px;
            }
            
            /* Conteúdo */
            main {
                margin-bottom: 2cm;
            }
            
            .info-block {
                background-color: #f8fafc;
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 15px;
                border-left: 4px solid #4361ee;
            }
            
            h2 {
                color: #4361ee;
                font-size: 14pt;
                margin: 0 0 8px 0;
                padding: 0;
            }
            
            .table-container {
                margin-top: 15px;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                box-shadow: 0 2px 6px rgba(67, 97, 238, 0.1);
                font-size: 9pt;
            }
            
            thead {
                background-color: #4361ee;
                color: white;
            }
            
            th {
                text-align: left;
                padding: 10px 8px;
                font-weight: 600;
                font-size: 10pt;
                text-transform: uppercase;
                letter-spacing: 0.3px;
            }
            
            tr:nth-child(even) {
                background-color: #f8fafc;
            }
            
            td {
                padding: 8px;
                border-bottom: 1px solid #e2e8f0;
            }
            
            .text-right {
                text-align: right;
            }
            
            .nome-column {
                min-width: 120px;
                max-width: 140px;
            }
            
            .descricao-column {
                max-width: 200px;
                font-size: 8.5pt;
                font-style: italic;
                color: #4a5568;
            }
            
            .summary-block {
                background-color: #edf2f7;
                border-radius: 6px;
                padding: 12px;
                margin-top: 20px;
                border-left: 4px solid #4361ee;
            }
            
            h3 {
                color: #4361ee;
                font-size: 12pt;
                margin: 0 0 8px 0;
                padding: 0;
            }
            
            /* Rodapé */
            footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                font-size: 8pt;
                color: #718096;
                z-index: 1000;
            }
            
            .footer-line {
                height: 2px;
                background-color: #e2e8f0;
                margin-bottom: 8px;
            }
            
            .footer-content {
                display: flex;
                justify-content: space-between;
            }
            
            .pagenum:before {
                content: counter(page);
            }
            
            /* Garantir que o número de página apareça em todas as páginas */
            @page {
                counter-increment: page;
            }
        </style>
        
        </html>");

        // Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

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