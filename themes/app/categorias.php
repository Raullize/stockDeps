<?php 
$this->layout("_theme");
?>

<h2>Formulário de Categorias</h2>
  
  <form id="form-categorias" method="POST" name="categorias" action="">
    <div>
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="name">
    </div>

    <div>
      <label for="descricao">Descrição:</label>
      <textarea id="descricao" name="description" rows="4"></textarea>
    </div>

    <button type="submit">Enviar</button>

    <div id="message"></div>
  </form>


<script type="text/javascript" async>
  const form = document.querySelector("#form-categorias");
  const message = document.querySelector("#message");
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const dataCategorias = new FormData(form);
    const data = await fetch("<?= url("categorias-inserir"); ?>", {
      method: "POST",
      body: dataCategorias,
    });
    const categorias = await data.json();
    console.log(categorias);
    if (categorias) {
      message.innerHTML = categorias.message;

      message.classList.add("message");
      message.classList.remove("success", "warning", "error");
      message.classList.add(`${categorias.type}`);
    }
  });
</script>