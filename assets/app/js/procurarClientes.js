const botaoProcurar = document.getElementsByClassName('botao-procurar')[0];
const inputProcurar = document.getElementById('procurar-cliente');

const listaDeClientes = document.getElementById('client-list');


inputProcurar.addEventListener('keyup', function(event) {
  const textoPesquisado = event.target.value.toLowerCase();

  listaDeClientes.innerHTML = '';

  clientes.forEach(function(clientes) {
    const nome = clientes.nome.toLowerCase();


    if (nome.includes(textoPesquisado)) {
      const card = document.createElement('div');
      card.classList.add('clientes-card');
      card.innerHTML = `
        <a href="" class="link-clientes">
        <h3>${clientes.nome}</h3>
        </a>
      `;
      listaDeClientes.appendChild(card);
    }
  });
  if(textoPesquisado == ""){
    listaDeClientes.style.display = 'none';
}else {
    listaDeClientes.style.display = "block";
  }
});
