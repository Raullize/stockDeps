<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= url('assets/app/css/globals.css') ?>">
  <link rel="stylesheet" href="<?= url('assets/app/css/sidebar.css') ?>">
  <link rel="stylesheet" href="<?= url('assets/app/css/loading.css') ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Ícone do site -->
  <link rel="icon" href="<?= url('assets/web/images/logos/logo-simple.png') ?>" type="image/png" />
  <title>StockDeps</title>
  
  <!-- Ajustes de responsividade -->
  <style>
    /* Estilos padrão para cabeçalhos de página */
    .dashboard-header, .page-header, .relatorio-header, .clientes-header, .fornecedores-header, .home-header {
      border-left: 5px solid var(--primary-color);
      padding: 2rem;
      margin-bottom: 2rem;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      background-color: #fff;
      text-align: left;
      animation: fadeInDown 0.7s ease-out;
    }
    
    /* Padronizar cores e estilos dos elementos do cabeçalho */
    .dashboard-header h1, .page-header h1, .relatorio-header h1, .clientes-header h1, .fornecedores-header h1, .home-header h1,
    .dashboard-header .text-gradient, .page-header .text-gradient, .relatorio-header .text-gradient, 
    .clientes-header .text-gradient, .fornecedores-header .text-gradient, .home-header .text-gradient {
      color: var(--primary-color) !important;
      -webkit-text-fill-color: var(--primary-color) !important;
      background: none !important;
      background-clip: unset !important;
      -webkit-background-clip: unset !important;
      font-weight: 700;
    }
    
    .dashboard-header p, .page-header p, .relatorio-header p, .clientes-header p, .fornecedores-header p, .home-header p {
      color: #212529 !important;
      font-size: 1rem;
      margin-bottom: 0.5rem;
    }
    
    .date-display {
      color: #212529 !important;
      font-size: 0.95rem;
    }
    
    .header-divider {
      height: 3px;
      width: 100px !important;
      background: var(--primary-color) !important;
      background-image: none !important;
      border-radius: 3px;
      margin-top: 5px;
      margin-bottom: 10px;
    }
    
    /* Alinhamento centralizado em telas pequenas */
    @media (max-width: 768px) {
      .dashboard-header, .page-header, .relatorio-header, .clientes-header, .fornecedores-header, .home-header {
        text-align: center;
        padding: 1.25rem;
      }
      
      .dashboard-header h1, .page-header h1, .relatorio-header h1, .clientes-header h1, .fornecedores-header h1, .home-header h1,
      .dashboard-header p, .page-header p, .relatorio-header p, .clientes-header p, .fornecedores-header p, .home-header p {
        text-align: center !important;
      }
      
      .header-divider {
        margin: 10px auto !important;
        width: 100px !important;
      }
      
      .date-display {
        text-align: left !important;
        margin-top: 1rem !important;
        display: block !important;
        width: 100% !important;
      }
      
      /* Ajustar margens para celular */
      .container, .container-fluid {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
      }
      
      /* Força alinhamento dos cabeçalhos específicos */
      .home-header .row .col-md-8,
      .dashboard-header .row .col-md-8 {
        text-align: center !important;
        width: 100% !important;
      }
      
      .home-header .row .col-md-4,
      .dashboard-header .row .col-md-4 {
        text-align: left !important;
        width: 100% !important;
      }
    }
    
    @media (max-width: 480px) {
      .container, .container-fluid {
        padding-left: 0.3rem !important;
        padding-right: 0.3rem !important;
      }
      
      .header-divider {
        width: 100px !important;
      }
    }
  </style>
</head>

<body>
  <!-- Loading Overlay -->
  <div class="loading-overlay">
    <div class="loading-spinner"></div>
    <div class="loading-text">Carregando...</div>
  </div>
  
  <!-- Correção para tabelas em dispositivos móveis -->
  <style>
    @media (max-width: 991px) {
      .sidebar.show {
        z-index: 1100 !important;
      }
      
      .table-responsive {
        position: relative !important;
        z-index: 1 !important;
      }
      
      .sidebar.show ~ .main-content .table-responsive {
        z-index: 1 !important;
      }
      
      /* Garantir que os botões de ação fiquem visíveis */
      .table td:last-child {
        white-space: nowrap !important;
        overflow: visible !important;
        text-overflow: initial !important;
      }
      
      .action-btn {
        min-width: 28px !important;
        min-height: 28px !important;
        margin: 0 1px !important;
        padding: 0 !important;
      }
    }
  </style>
  
  <div class="layout-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo-container">
        <div class="logo">
          <img src="<?= url('assets/web/images/logos/logo-simple.png') ?>" alt="StockDeps Logo">
          <span>StockDeps</span>
        </div>
      </div>
      
      <!-- Botão de toggle da sidebar -->
      <div class="toggle-btn">
        <i class="fas fa-chevron-left"></i>
      </div>
      
      <ul class="sidebar-menu">
        <li class="menu-item">
          <a href="<?= url('app') ?>" class="menu-link <?= (basename($_SERVER['REQUEST_URI']) == 'app' || basename($_SERVER['REQUEST_URI']) == '') ? 'active' : '' ?>">
            <div class="menu-icon">
              <i class="fas fa-home"></i>
            </div>
            <span class="menu-text">Início</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= url('app/estoque') ?>" class="menu-link <?= (basename($_SERVER['REQUEST_URI']) == 'estoque') ? 'active' : '' ?>">
            <div class="menu-icon">
              <i class="fas fa-boxes-stacked"></i>
            </div>
            <span class="menu-text">Estoque</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= url('app/clientes') ?>" class="menu-link <?= (basename($_SERVER['REQUEST_URI']) == 'clientes') ? 'active' : '' ?>">
            <div class="menu-icon">
              <i class="fas fa-users"></i>
            </div>
            <span class="menu-text">Clientes</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= url('app/fornecedores') ?>" class="menu-link <?= (basename($_SERVER['REQUEST_URI']) == 'fornecedores') ? 'active' : '' ?>">
            <div class="menu-icon">
              <i class="fas fa-truck-fast"></i>
            </div>
            <span class="menu-text">Fornecedores</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= url('app/relatorio') ?>" class="menu-link <?= (basename($_SERVER['REQUEST_URI']) == 'relatorio') ? 'active' : '' ?>">
            <div class="menu-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <span class="menu-text">Relatórios</span>
          </a>
        </li>
      </ul>
      
      <div class="sidebar-footer">
        <a href="<?= url('app/logout') ?>" class="logout-link">
          <div class="logout-icon">
            <i class="fas fa-sign-out-alt"></i>
          </div>
          <span class="logout-text">Sair</span>
        </a>
      </div>
    </aside>
    
    <!-- Mobile toggle button -->
    <div class="mobile-toggle d-lg-none">
      <i class="fas fa-bars menu-hamburger"></i>
    </div>
    
    <!-- Main Content -->
    <main class="main-content">
      <div class="content-container">
        <?php echo $this->section("content"); ?>
      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="<?= url('assets/app/js/sidebar.js') ?>"></script>
  <script src="<?= url('assets/app/js/logout.js') ?>"></script>
  
  <script>
    // Adiciona o loading nas transições de página
    document.addEventListener('DOMContentLoaded', function() {
      const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"])');
      const loadingOverlay = document.querySelector('.loading-overlay');
      
      links.forEach(link => {
        link.addEventListener('click', function(e) {
          if (!this.href.includes(window.location.origin)) return;
          loadingOverlay.style.display = 'flex';
        });
      });
    });
  </script>
</body>

</html>