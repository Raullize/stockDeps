# Módulo de Geração de Documentos

Este módulo contém a classe `DocumentGenerator`, responsável por centralizar as funcionalidades de geração de documentos (PDF e Excel) para os relatórios da aplicação.

## Funcionalidades

A classe oferece os seguintes métodos para geração de relatórios:

### Relatórios em PDF

- `gerarRelatorioClientesPdf(array $clientes)`: Gera um relatório de clientes em formato PDF
- `gerarRelatorioFornecedoresPdf(array $fornecedores)`: Gera um relatório de fornecedores em formato PDF
- `gerarRelatorioProdutosPdf(array $produtos)`: Gera um relatório de produtos em formato PDF

### Relatórios em Excel

- `gerarRelatorioClientesExcel(array $clientes)`: Gera um relatório de clientes em formato Excel
- `gerarRelatorioFornecedoresExcel(array $fornecedores)`: Gera um relatório de fornecedores em formato Excel
- `gerarRelatorioProdutosExcel(array $produtos)`: Gera um relatório de produtos em formato Excel

## Dependências

Esta classe utiliza:

- **dompdf/dompdf**: Para geração de arquivos PDF
- **phpoffice/phpspreadsheet**: Para geração de arquivos Excel

As dependências estão configuradas no `composer.json` do projeto.

## Como Usar

Para utilizar a classe, instancie um objeto `DocumentGenerator` e chame o método apropriado:

```php
// Exemplo de uso para gerar relatório de clientes em PDF
$cliente = new Clientes();
$clientes = $cliente->selectAll();

$docGenerator = new DocumentGenerator();
$docGenerator->gerarRelatorioClientesPdf($clientes);
```

## Rotas Disponíveis

As seguintes rotas estão disponíveis para geração de relatórios:

### PDF
- `/app/pdf-r-c`: Relatório de clientes em PDF
- `/app/pdf-r-f`: Relatório de fornecedores em PDF
- `/app/pdf-r-p`: Relatório de produtos em PDF

### Excel
- `/app/excel-r-c`: Relatório de clientes em Excel
- `/app/excel-r-f`: Relatório de fornecedores em Excel
- `/app/excel-r-p`: Relatório de produtos em Excel