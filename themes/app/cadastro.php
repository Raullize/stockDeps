
<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!---<title> Responsive Registration Form | CodingLab </title>--->
    <link rel="stylesheet" href="<?= url('assets/app/css/styleCadastro.css') ?>">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <div class="title">Cadastro de clientes</div>
    <div class="content">
      <form action="#">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Nome completo</span>
            <input type="text" placeholder="Escreva o nome completo" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="text" placeholder="Escreva o email" required>
          </div>
          <div class="input-box">
            <span class="details">CPF</span>
            <input type="text" placeholder="Digite o CPF" required>
          </div>
          <div class="input-box">
            <span class="details">Celular</span>
            <input type="text" placeholder="Digite o número do celular" required>
          </div>
          <div class="input-box">
            <span class="details">UF</span>
            <select class="details">
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
          </div>
          <div class="input-box">
            <span class="details">Cidade</span>
            <input type="text" placeholder="Informe a cidade" required>
          </div>
          <div class="input-box">
            <span class="details">Bairro</span>
            <input type="text" placeholder="Informe o bairro" required>
        </div>
        </div>
        
        <div class="button">
          <input type="submit" value="Registre">
        </div>
      </form>
    </div>
  </div>

</body>
</html>
