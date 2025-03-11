<?php

namespace Source\Support;

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class DocumentGenerator
 * 
 * Classe responsável por centralizar as funcionalidades de geração de documentos
 * (PDF e Excel) para os relatórios da aplicação
 * 
 * @package Source\Support
 */
class DocumentGenerator
{
    /** @var Dompdf $dompdf Instância do Dompdf */
    private $dompdf;

    /**
     * DocumentGenerator constructor.
     */
    public function __construct()
    {
        $this->dompdf = new Dompdf([
            'enable_remote' => true,
            'enable_html5_parser' => true,
        ]);
    }

    /**
     * Obtém o template HTML básico para os relatórios
     * 
     * @param string $titulo Título do relatório
     * @return string HTML básico para o relatório
     */
    private function getHtmlTemplate(string $titulo): string
    {
        $logoBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAyCAYAAACqNX6+AAAACXBIWXMAAAsTAAALEwEAmpwYAAAHGmlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDIgNzkuMTYwOTI0LCAyMDE3LzA3LzEzLTAxOjA2OjM5ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAyMy0wNi0xMFQxNjo0MzowNyswMzowMCIgeG1wOk1vZGlmeURhdGU9IjIwMjMtMDYtMTBUMTc6MDg6MTMrMDM6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMjMtMDYtMTBUMTc6MDg6MTMrMDM6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0ic1JHQiBJRUM2MTk2Ni0yLjEiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MDZhMDY2ZGMtNjkxYy0yNTRkLWFkZDktYTU2YjRlZmVkODRmIiB4bXBNTTpEb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6YTZhYWJiNzAtODM2OS01NDRjLWI0MGQtNzA0MDg0N2JhN2Y2IiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6ZDFhZGQwZGEtYWFhYi1hYTRmLTg0MjAtM2IwMDZiZjAzODIwIj4gPHBob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4gPHJkZjpCYWc+IDxyZGY6bGk+eG1wLmRpZDpkMWFkZDBkYS1hYWFiLWFhNGYtODQyMC0zYjAwNmJmMDM4MjA8L3JkZjpsaT4gPC9yZGY6QmFnPiA8L3Bob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDpkMWFkZDBkYS1hYWFiLWFhNGYtODQyMC0zYjAwNmJmMDM4MjAiIHN0RXZ0OndoZW49IjIwMjMtMDYtMTBUMTY6NDM6MDcrMDM6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cykiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjA2YTA2NmRjLTY5MWMtMjU0ZC1hZGQ5LWE1NmI0ZWZlZDg0ZiIgc3RFdnQ6d2hlbj0iMjAyMy0wNi0xMFQxNzowODoxMyswMzowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4iuZs1AAAHtElEQVR4nO1aS2wbxxn+ZnZnl49IkZIoUlRMWbLoRIrsOG4cP5raiBP00EtPvRQ9tUBb9NYCbYFeeuqhQA9tkR56K1CgLdqi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';

        $html = '<!DOCTYPE html>';
        $html .= '<html lang="pt-BR">';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<title>' . $titulo . '</title>';
        $html .= '<style>';
        $html .= 'body { font-family: "Segoe UI", Arial, sans-serif; margin: 15mm; color: #333; }';
        $html .= 'h1 { color: #0d6efd; text-align: center; margin-bottom: 20px; font-size: 24px; font-weight: 600; }';
        $html .= '.header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; }';
        $html .= '.logo-container { display: flex; align-items: center; }';
        $html .= '.logo-image { height: 40px; margin-right: 10px; }';
        $html .= '.logo-text { font-size: 28px; font-weight: bold; color: #0d6efd; }';
        $html .= '.data { font-size: 12px; color: #666; }';
        $html .= 'table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }';
        $html .= 'th { background-color: #f8f9fa; color: #0d6efd; font-weight: 600; text-align: left; border-bottom: 2px solid #dee2e6; }';
        $html .= 'td, th { padding: 12px; border: 1px solid #dee2e6; font-size: 12px; }';
        $html .= 'tr:nth-child(even) { background-color: #f8f9fa; }';
        $html .= 'tr:hover { background-color: #e9ecef; }';
        $html .= '.footer { text-align: center; font-size: 11px; color: #6c757d; margin-top: 30px; border-top: 1px solid #dee2e6; padding-top: 15px; }';
        $html .= '.resumo { margin-top: 20px; background-color: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6; }';
        $html .= '.resumo-title { font-weight: 600; margin-bottom: 15px; color: #0d6efd; font-size: 16px; border-bottom: 1px solid #dee2e6; padding-bottom: 8px; }';
        $html .= '.resumo-data { display: flex; flex-wrap: wrap; justify-content: space-around; gap: 20px; }';
        $html .= '.resumo-item { min-width: 150px; background-color: white; border-radius: 5px; padding: 15px; border: 1px solid #e9ecef; box-shadow: 0 2px 5px rgba(0,0,0,0.05); text-align: center; }';
        $html .= '.resumo-label { display: block; color: #6c757d; font-size: 12px; margin-bottom: 8px; }';
        $html .= '.resumo-valor { display: block; font-size: 20px; font-weight: 600; color: #0d6efd; }';
        $html .= '</style>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '<div class="header">';
        $html .= '<div class="logo-container">';
        $html .= '<img src="' . $logoBase64 . '" class="logo-image" alt="Logo StockDeps">';
        $html .= '<div class="logo-text">StockDeps</div>';
        $html .= '</div>';
        $html .= '<div class="data">Gerado em: ' . date('d/m/Y H:i:s') . '</div>';
        $html .= '</div>';
        $html .= '<h1>' . $titulo . '</h1>';

        return $html;
    }

    /**
     * Gera relatório de clientes em formato PDF
     * 
     * @param array $clientes Array com os dados dos clientes
     * @return void
     */
    public function gerarRelatorioClientesPdf(array $clientes): void
    {
        // Construir o HTML da tabela
        $html = $this->getHtmlTemplate('Relatório de Clientes');
        
        $html .= '<table border="0" cellpadding="10" cellspacing="0" width="100%">';
        $html .= '<thead><tr>';
        $html .= '<th>Nome</th>';
        $html .= '<th>CPF</th>';
        $html .= '<th>Celular</th>';
        $html .= '</tr></thead>';
        $html .= '<tbody>';

        foreach ($clientes as $cliente) {
            $html .= '<tr>';
            $html .= '<td>' . $cliente->nome . '</td>';
            $html .= '<td>' . $cliente->cpf . '</td>';
            $html .= '<td>' . $cliente->celular . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        
        // Resumo
        $html .= '<div class="resumo">';
        $html .= '<div class="resumo-title">Resumo do Relatório</div>';
        $html .= '<div class="resumo-data">';
        $html .= '<div class="resumo-item">';
        $html .= '<span class="resumo-label">Total de Clientes</span>';
        $html .= '<span class="resumo-valor">' . count($clientes) . '</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '<div class="footer">StockDeps - Sistema de Controle de Estoque &copy; ' . date('Y') . '</div>';
        $html .= '</body></html>';

        // Gerar o PDF
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream('relatorio-clientes.pdf', ["Attachment" => true]);
    }

    /**
     * Gera relatório de fornecedores em formato PDF
     * 
     * @param array $fornecedores Array com os dados dos fornecedores
     * @return void
     */
    public function gerarRelatorioFornecedoresPdf(array $fornecedores): void
    {
        // Construir o HTML da tabela
        $html = $this->getHtmlTemplate('Relatório de Fornecedores');
        
        $html .= '<table border="0" cellpadding="10" cellspacing="0" width="100%">';
        $html .= '<thead><tr>';
        $html .= '<th>Nome</th>';
        $html .= '<th>CNPJ</th>';
        $html .= '<th>Email</th>';
        $html .= '<th>Telefone</th>';
        $html .= '<th>Endereço</th>';
        $html .= '</tr></thead>';
        $html .= '<tbody>';

        foreach ($fornecedores as $fornecedor) {
            $html .= '<tr>';
            $html .= '<td>' . $fornecedor->nome . '</td>';
            $html .= '<td>' . $fornecedor->cnpj . '</td>';
            $html .= '<td>' . $fornecedor->email . '</td>';
            $html .= '<td>' . $fornecedor->telefone . '</td>';
            $html .= '<td>' . $fornecedor->endereco . ', ' . $fornecedor->municipio . ' - ' . $fornecedor->uf . ' CEP: ' . $fornecedor->cep . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        
        // Resumo
        $html .= '<div class="resumo">';
        $html .= '<div class="resumo-title">Resumo do Relatório</div>';
        $html .= '<div class="resumo-data">';
        $html .= '<div class="resumo-item">';
        $html .= '<span class="resumo-label">Total de Fornecedores</span>';
        $html .= '<span class="resumo-valor">' . count($fornecedores) . '</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '<div class="footer">StockDeps - Sistema de Controle de Estoque &copy; ' . date('Y') . '</div>';
        $html .= '</body></html>';

        // Gerar o PDF
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream('relatorio-fornecedores.pdf', ["Attachment" => true]);
    }

    /**
     * Gera relatório de produtos em formato PDF
     * 
     * @param array $produtos Array com os dados dos produtos
     * @return void
     */
    public function gerarRelatorioProdutosPdf(array $produtos): void
    {
        // Construir o HTML da tabela
        $html = $this->getHtmlTemplate('Relatório de Produtos');
        
        $html .= '<table border="0" cellpadding="10" cellspacing="0" width="100%">';
        $html .= '<thead><tr>';
        $html .= '<th>Código</th>';
        $html .= '<th>Nome</th>';
        $html .= '<th>Descrição</th>';
        $html .= '<th>Categoria</th>';
        $html .= '<th>Preço</th>';
        $html .= '<th>Qtd</th>';
        $html .= '<th>Un</th>';
        $html .= '</tr></thead>';
        $html .= '<tbody>';

        $valorTotalEstoque = 0;
        $quantidadeTotal = 0;

        foreach ($produtos as $produto) {
            $valorTotalEstoque += $produto->preco * $produto->quantidade;
            $quantidadeTotal += $produto->quantidade;
            
            $html .= '<tr>';
            $html .= '<td>' . $produto->codigo_produto . '</td>';
            $html .= '<td>' . $produto->nome . '</td>';
            $html .= '<td>' . mb_strimwidth($produto->descricao, 0, 40, "...") . '</td>';
            $html .= '<td>' . ($produto->categoria ?? 'N/A') . '</td>';
            $html .= '<td>R$ ' . number_format($produto->preco, 2, ',', '.') . '</td>';
            $html .= '<td>' . $produto->quantidade . '</td>';
            $html .= '<td>' . $produto->unidade_medida . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        
        // Resumo
        $html .= '<div class="resumo">';
        $html .= '<div class="resumo-title">Resumo do Relatório</div>';
        $html .= '<div class="resumo-data">';
        $html .= '<div class="resumo-item">';
        $html .= '<span class="resumo-label">Total de Produtos</span>';
        $html .= '<span class="resumo-valor">' . count($produtos) . '</span>';
        $html .= '</div>';
        $html .= '<div class="resumo-item">';
        $html .= '<span class="resumo-label">Quantidade Total</span>';
        $html .= '<span class="resumo-valor">' . $quantidadeTotal . '</span>';
        $html .= '</div>';
        $html .= '<div class="resumo-item">';
        $html .= '<span class="resumo-label">Valor Total</span>';
        $html .= '<span class="resumo-valor">R$ ' . number_format($valorTotalEstoque, 2, ',', '.') . '</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '<div class="footer">StockDeps - Sistema de Controle de Estoque &copy; ' . date('Y') . '</div>';
        $html .= '</body></html>';

        // Gerar o PDF
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream('relatorio-produtos.pdf', ["Attachment" => true]);
    }

    /**
     * Gera relatório de clientes em formato Excel
     * 
     * @param array $clientes Array com os dados dos clientes
     * @return void
     */
    public function gerarRelatorioClientesExcel(array $clientes): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Cabeçalho
        $sheet->setCellValue('A1', 'Nome');
        $sheet->setCellValue('B1', 'CPF');
        $sheet->setCellValue('C1', 'Celular');

        // Estilo do cabeçalho
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'CCCCCC']],
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
        
        // Headers para download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="relatorio-clientes.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Gera relatório de fornecedores em formato Excel
     * 
     * @param array $fornecedores Array com os dados dos fornecedores
     * @return void
     */
    public function gerarRelatorioFornecedoresExcel(array $fornecedores): void
    {
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
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'CCCCCC']],
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
        
        // Headers para download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="relatorio-fornecedores.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Gera relatório de produtos em formato Excel
     * 
     * @param array $produtos Array com os dados dos produtos
     * @return void
     */
    public function gerarRelatorioProdutosExcel(array $produtos): void
    {
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
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'CCCCCC']],
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

        // Dados
        $row = 2;
        foreach ($produtos as $produto) {
            $sheet->setCellValue('A' . $row, $produto->codigo_produto);
            $sheet->setCellValue('B' . $row, $produto->nome);
            $sheet->setCellValue('C' . $row, $produto->descricao);
            $sheet->setCellValue('D' . $row, $produto->categoria ?? 'N/A');
            $sheet->setCellValue('E' . $row, 'R$ ' . number_format($produto->preco, 2, ',', '.'));
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
        
        // Headers para download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="relatorio-produtos.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
} 