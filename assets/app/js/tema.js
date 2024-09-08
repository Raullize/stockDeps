const switchTema = document.getElementById('darkmode-toggle');

// Abaixo estou criando dois elementos no cadastro
// elemento 1: Cadastro de Clientes 
// elemento 2: Cadastro de Categorias

// Formatar CSS para ficar bonito

  document.getElementById('cadastro-item').addEventListener('mouseover', function() {
    // Verifica se os subitens já foram adicionados
    if (!document.querySelector('#cadastro-item .sub-menu')) {
      // Cria a ul para os subitens
      const submenu = document.createElement('ul');
      submenu.classList.add('sub-menu');
      
       // Obtém a URL do data-attribute
       const urlClientes = this.getAttribute('data-url-clientes');
       const urlCategorias = this.getAttribute('data-url-categorias');

      // Cria os novos itens de navegação
      const item1 = document.createElement('li');
      const link1 = document.createElement('a');
      link1.href = urlClientes;
      link1.textContent = 'Clientes';
      item1.appendChild(link1);

      const item2 = document.createElement('li');
      const link2 = document.createElement('a');
      link2.href = urlCategorias;
      link2.textContent = 'Categorias';
      item2.appendChild(link2);

      // Adiciona os itens ao submenu
      submenu.appendChild(item1);
      submenu.appendChild(item2);

      // Adiciona o submenu ao item de navegação
      this.appendChild(submenu);
    }
  });


switchTema.addEventListener('change', () => {
  if (switchTema.checked) {

    const now = new Date();
    const expireDate = new Date(now.getTime() + (365 * 24 * 60 * 60 * 1000)); // expira em 1 ano
    document.cookie = `darkmode=true; expires=${expireDate.toUTCString()}`;
    document.documentElement.classList.add('dark-mode');
  } else {

    const now = new Date();
    const expireDate = new Date(now.getTime() - (24 * 60 * 60 * 1000)); // expira em 1 dia
    document.cookie = `darkmode=false; expires=${expireDate.toUTCString()}`;
    document.documentElement.classList.remove('dark-mode');
  }
});

const darkModeCookie = document.cookie.split('; ').find(row => row.startsWith('darkmode='));
if (darkModeCookie) {
  const isDarkMode = darkModeCookie.split('=')[1] === 'true';
  if (isDarkMode) {

    switchTema.checked = true;
    document.documentElement.classList.add('dark-mode');
  }
}
