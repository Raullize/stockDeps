<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="<?= url('assets/app/css/globals.css') ?>">
  <link rel="stylesheet" href="<?= url('assets/app/css/sidebar.css') ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Ícone do site -->
  <link rel="icon" href="<?= url('assets/web/images/logos/logo-without-background.png') ?>" type="image/png" />
  <title>StockDeps</title>
</head>

<body>
  <div class="layout-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo-container">
        <div class="logo">
          <img src="<?= url('assets/web/images/logos/logo-without-background.png') ?>" alt="StockDeps Logo">
          <span>StockDeps</span>
        </div>
        <div class="toggle-btn">
          <i class="fas fa-chevron-left"></i>
        </div>
      </div>
      
      <ul class="sidebar-menu">
        <li class="menu-item">
          <a href="<?= url('app') ?>" class="menu-link">
            <div class="menu-icon">
              <i class="fas fa-home"></i>
            </div>
            <span class="menu-text">Início</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= url('app/estoque') ?>" class="menu-link">
            <div class="menu-icon">
              <i class="fas fa-box"></i>
            </div>
            <span class="menu-text">Estoque</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= url('app/clientes') ?>" class="menu-link">
            <div class="menu-icon">
              <i class="fas fa-users"></i>
            </div>
            <span class="menu-text">Clientes</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= url('app/fornecedores') ?>" class="menu-link">
            <div class="menu-icon">
              <i class="fas fa-truck"></i>
            </div>
            <span class="menu-text">Fornecedores</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= url('app/relatorio') ?>" class="menu-link">
            <div class="menu-icon">
              <i class="fas fa-chart-bar"></i>
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
      <i class="fas fa-bars"></i>
    </div>
    
    <!-- Main Content -->
    <main class="main-content">
      <?php echo $this->section("content"); ?>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="<?= url('assets/app/js/sidebar.js') ?>"></script>
</body>

</html>