
<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!---<title> Responsive Registration Form | CodingLab </title>--->
    <link rel="stylesheet" href="<?= url('assets/app/css/styleCadastro.css') ?>">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
<div class="container">
	<div class="header">
		<div class="title">Cadastrar cliente <a href="<?= url('') ?>"><button class="botao-voltar">Voltar</button></a></div>
	</div>

	<form id="form-cadastro" class="form flex" method="POST" name="cadastro" action="">

    <div class="block mini-container">
      <div class="form-control">
        <label for="nome-completo">Nome completo</label>
        <input type="text" placeholder="Nome completo" id="nome-completo" name="name"/>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>

      <div class="form-control">
        <label for="email">Email</label>
        <input type="email" placeholder="exemplo@email.com" id="email" name="email"/>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>

      <div class="form-control">
        <label for="cpf">CPF</label>
        <input type="text" placeholder="000.000.000-00" id="cpf" name="cpf"/>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>

      <div class="form-control">
        <label for="bairro">Bairro</label>
        <input type="text" placeholder="Informe o bairro" id="bairro" name="bairro"/>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>
      
    </div>
    <div class="block mini-container">
    <div class="form-control">
        <label for="celular">Celular</label>
        <input type="number" placeholder="Digite o número do celular" id="celular" name="celular"/>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>

      <div class="form-control">
      <span class="details">UF</span>
            <select class="details" id="uf" name="uf">
                <option value="">Selecione a UF</option>
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espirito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MT">Mato Grosso</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>
      
      <div class="form-control">
        <label for="cidade">Cidade</label>
        <input type="text" placeholder="Informe a cidade" id="cidade" name="cidade"/>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>

      <div class="button">
          <input type="submit" value="Registre">
      </div>

      <div id="message"></div>

    </div>
	</form>

</div>

</body>
</html>

<script type="text/javascript" async>
        const form = document.querySelector("#form-cadastro");
        const message = document.querySelector("#message");
        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const dataClient = new FormData(form);
            const data = await fetch("<?= url("cadastro"); ?>",{
                method: "POST",
                body: dataClient,
            });
            const client = await data.json();
            console.log(client);
            if(client) {
                message.innerHTML = client.message;

                message.classList.add("message");
                message.classList.remove("success", "warning", "error");
                message.classList.add(`${client.type}`);
            }
        });
    </script>