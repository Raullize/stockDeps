const selectCategoriasEntradas = document.getElementById("dropdown-categorias-entradas");
const selectCategoriasSaidas = document.getElementById("dropdown-categorias-saidas");
const selectCategoriasSaldo = document.getElementById("dropdown-categorias-saldo");

const selectItensEntradas = document.getElementById('dropdown-itens-entradas');
const selectItensSaidas = document.getElementById('dropdown-itens-saidas');

function adicionaCategoriasDropdown(categorias) {
  let options = "";
  for (let i = 0; i < categorias.length; i++) {
    options += `
      <option value="${categorias[i].nome}"> ${categorias[i].nome}</option>
    `;
  }
  return options;
}

function adicionaItensDropdown(categoriaSelecionada) {
  let produtosFiltrados = [];
  let idCategorias;

  if (categoriaSelecionada === "Lava roupas") {
    idCategorias = 1;
  } else if (categoriaSelecionada === "Lava louças") {
    idCategorias = 2;
  } else if (categoriaSelecionada === "Lava carros") {
    idCategorias = 3;
  } else if (categoriaSelecionada === "Limpeza de ambiente") {
    idCategorias = 4;
  }

  produtosFiltrados = produtos.filter(produto => produto.idCategoria === idCategorias);
  console.log(produtosFiltrados)
  let options = "";
  for (let i = 0; i < produtosFiltrados.length; i++) {
    options += `
        <option value="${produtosFiltrados[i].nome}"> ${produtosFiltrados[i].nome}</option>
      `;
  }
  return options;
}

document.addEventListener("DOMContentLoaded", function () {
    selectCategoriasEntradas.insertAdjacentHTML('beforeend', adicionaCategoriasDropdown(categorias));
    selectCategoriasSaidas.insertAdjacentHTML('beforeend', adicionaCategoriasDropdown(categorias));
    selectCategoriasSaldo.insertAdjacentHTML('beforeend', adicionaCategoriasDropdown(categorias));
});

  selectCategoriasEntradas.addEventListener("change", function() {
    const categoriaSelecionada = selectCategoriasEntradas.value;
    
      selectItensEntradas.innerHTML = ""; // Limpa os options anteriores
      selectItensEntradas.insertAdjacentHTML('beforeend', adicionaItensDropdown(categoriaSelecionada)); // Adiciona os novos options
  })
  
  selectCategoriasSaidas.addEventListener("change", function() {
    const categoriaSelecionada = selectCategoriasSaidas.value;
    
      selectItensSaidas.innerHTML = ""; // Limpa os options anteriores
      selectItensSaidas.insertAdjacentHTML('beforeend', adicionaItensDropdown(categoriaSelecionada)); // Adiciona os novos options
  })
