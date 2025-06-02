<?php

namespace Source\Support;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Source\Models\Clientes;
use Source\Models\Fornecedores;
use Source\Models\Produtos;
use Source\Models\Categorias;

/**
 * Classe responsável pela geração de relatórios em Excel
 */
class ExcelReport
{
    /**
     * Gera um relatório de clientes em Excel
     * 
     * @return void
     */
    public function generateClientReport(): void
    {
        $cliente = new Clientes();
        $clientes = $cliente->selectAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Cabeçalho
        $sheet->setCellValue('A1', 'Nome');
        $sheet->setCellValue('B1', 'CPF');
        $sheet->setCellValue('C1', 'Celular');

        // Estilo do cabeçalho
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => 'CCCCCC']],
        ];
        $sheet->getStyle('A1:C1')->applyFromArray($headerStyle);

        // Dados
        $row = 2;
        foreach ($clientes as $cliente) {
            $sheet->setCellValue('A' . $row, $cliente->nome);
            $sheet->setCellValue('B' . $row, $cliente->cpf);
            $sheet->setCellValue('C' . $row, $cliente->celular);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        
        // Cabeçalhos para garantir download e evitar problemas de cache
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="relatorio-clientes.xlsx"');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        
        // Necessário para alguns servidores
        header('X-Download-Options: noopen');
        header('X-Content-Type-Options: nosniff');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Gera um relatório de fornecedores em Excel
     * 
     * @return void
     */
    public function generateSupplierReport(): void
    {
        $fornecedor = new Fornecedores();
        $fornecedores = $fornecedor->selectAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Cabeçalho
        $sheet->setCellValue('A1', 'Nome');
        $sheet->setCellValue('B1', 'CNPJ');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Telefone');
        $sheet->setCellValue('E1', 'Endereço');
        $sheet->setCellValue('F1', 'Município');
        $sheet->setCellValue('G1', 'CEP');
        $sheet->setCellValue('H1', 'UF');

        // Estilo do cabeçalho
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => 'CCCCCC']],
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Dados
        $row = 2;
        foreach ($fornecedores as $fornecedor) {
            $sheet->setCellValue('A' . $row, $fornecedor->nome);
            $sheet->setCellValue('B' . $row, $fornecedor->cnpj);
            $sheet->setCellValue('C' . $row, $fornecedor->email);
            $sheet->setCellValue('D' . $row, $fornecedor->telefone);
            $sheet->setCellValue('E' . $row, $fornecedor->endereco);
            $sheet->setCellValue('F' . $row, $fornecedor->municipio);
            $sheet->setCellValue('G' . $row, $fornecedor->cep);
            $sheet->setCellValue('H' . $row, $fornecedor->uf);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        
        // Cabeçalhos para garantir download e evitar problemas de cache
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="relatorio-fornecedores.xlsx"');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        
        // Necessário para alguns servidores
        header('X-Download-Options: noopen');
        header('X-Content-Type-Options: nosniff');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Gera um relatório de produtos em Excel
     * 
     * @return void
     */
    public function generateProductReport(): void
    {
        $produto = new Produtos();
        $produtos = $produto->selectAll();
        $categoria = new Categorias();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Cabeçalho
        $sheet->setCellValue('A1', 'Código');
        $sheet->setCellValue('B1', 'Nome');
        $sheet->setCellValue('C1', 'Descrição');
        $sheet->setCellValue('D1', 'Categoria');
        $sheet->setCellValue('E1', 'Preço');
        $sheet->setCellValue('F1', 'Quantidade');
        $sheet->setCellValue('G1', 'Unidade');

        // Estilo do cabeçalho
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => 'CCCCCC']],
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

        // Dados
        $row = 2;
        foreach ($produtos as $produto) {
            $categoriaNome = $categoria->findNameById($produto->idCategoria) ?? 'N/A';
            
            $sheet->setCellValue('A' . $row, $produto->codigo_produto);
            $sheet->setCellValue('B' . $row, $produto->nome);
            $sheet->setCellValue('C' . $row, $produto->descricao);
            $sheet->setCellValue('D' . $row, $categoriaNome);
            $sheet->setCellValue('E' . $row, $produto->preco);
            $sheet->setCellValue('F' . $row, $produto->quantidade);
            $sheet->setCellValue('G' . $row, $produto->unidade_medida);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        
        // Cabeçalhos para garantir download e evitar problemas de cache
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="relatorio-produtos.xlsx"');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        
        // Necessário para alguns servidores
        header('X-Download-Options: noopen');
        header('X-Content-Type-Options: nosniff');
        
        $writer->save('php://output');
        exit;
    }
} 