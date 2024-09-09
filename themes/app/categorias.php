<<<<<<< HEAD
<?php
$this->layout("_theme");
?>

<h2>Inserir Categorias</h2>

<form id="form-inserir" method="POST" name="categorias" action="">
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

<h2>Lista das Categorias</h2>

<ul>
<?php
for($i = 0; $i < count($categorias); $i++){
?>
  <li>
    <?= $categorias[$i]->nome . " | " . $categorias[$i]->descricao; ?>
    <!-- formulário para deletar a categoria -->
    <form class="form-deletar" method="POST" name="categorias-deletar" style="display:inline;" action="">
      <input type="hidden" name="id" value="<?= $categorias[$i]->id; ?>">
      <button type="submit" style="border:none; background:none; cursor:pointer;">
        <i class="fa fa-trash" aria-hidden="true" style="color:red;"></i>
      </button>
    </form>
    <div class="messageDeletar"></div>
  </li>
<?php
}
?>
</ul>

<!-- JS CATEGORIAS INSERIR -->
<script type="text/javascript" async>
  const form = document.querySelector("#form-inserir");
  const message = document.querySelector("#message");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const dataCategorias = new FormData(form);
    const response = await fetch("<?= url('categorias-inserir'); ?>", {
      method: "POST",
      body: dataCategorias,
    });
    const categorias = await response.json();
    console.log(categorias);

    if (categorias) {
      message.innerHTML = categorias.message;
      message.classList.add("message");
      message.classList.remove("success", "warning", "error");
      message.classList.add(`${categorias.type}`);

      if (categorias.type === 'success') {
        location.reload();
        window.alert("categoria cadastrada com sucesso!");
      }
    }
  });
</script>

<!-- JS CATEGORIAS DELETAR -->
<script type="text/javascript" async>
  const formsDeletar = document.querySelectorAll(".form-deletar");

  formsDeletar.forEach((formDeletar) => {
    const messageDeletar = formDeletar.nextElementSibling;

    formDeletar.addEventListener("submit", async (e) => {
      e.preventDefault();

      // Exibe a caixa de diálogo de confirmação
      const confirmDelete = confirm("Você tem certeza que deseja deletar esta categoria?");

      // Se o usuário confirmar, segue com o processo de deleção
      if (confirmDelete) {
        const dataDeletar = new FormData(formDeletar);

        try {
          const response = await fetch("<?= url('categorias-deletar'); ?>", {
            method: "POST",
            body: dataDeletar,
          });

          const deletar = await response.json();
          console.log(deletar);

          if (deletar) {
            /*messageDeletar.innerHTML = deletar.message;
            messageDeletar.classList.add("messageDeletar");
            messageDeletar.classList.remove("success", "warning", "error");
            messageDeletar.classList.add(`${deletar.type}`);*/

            // Remove o elemento da lista após deletar com sucesso
            if (deletar.type === 'success') {
              formDeletar.closest('li').remove();
            }
          }

        } catch (error) {
          console.error("Erro ao deletar a categoria:", error);
        }
      }
    });

  });
=======
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
>>>>>>> 4906133f697bf8a57791c54a769827aa53362dec
</script>