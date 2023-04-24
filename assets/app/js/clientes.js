
function criaCartaoCarrossel(cliente) {
    return `
      <div class="card">
        <h3>${cliente.nome}</h3>
        <p class="info-cliente"><strong>CPF:</strong> ${cliente.cpf}</p>
        <p class="info-cliente"><strong>Email:</strong> ${cliente.email}</p>
        <P class="info-cliente"><strong>Celular:</strong> ${cliente.celular}</P>
        <p class="info-cliente"><strong>Cidade:</strong> ${cliente.cidade}</p>
        <p class="info-cliente"><strong>Bairro:</strong> ${cliente.bairro}</p>
        <p class="info-cliente"><strong>UF:</strong> ${cliente.uf}</p>
        <button class="btn btn-danger"> Histórico </button>
      </div>
    `;
}
function criaCardBloco(cliente) {
    return `
      <div class="card-bloco">
  
        <div class="flex">
            <div class="block camada">
                <div class="item-cartao"></div> 
                <p class="info-cliente-bloco "><strong>CPF:</strong> ${cliente.cpf}</p>
                <p class="info-cliente-bloco"><strong>Email:</strong> ${cliente.email}</p>
                
            </div>
            <div class="block camada">
                  <div class="item-cartao"><h3>${cliente.nome}</h3> </div> 
                <P class="info-cliente-bloco"><strong>Celular:</strong> ${cliente.celular}</P>
                <p class="info-cliente-bloco"><strong>Cidade:</strong> ${cliente.cidade}</p>
            </div>    
            <div class="block camada">
                <div class="item-cartao"> 
                    <button class="btn btn-danger center"> 
                    Histórico
                    </button> 
                </div>  
                <p class="info-cliente-bloco"><strong>Bairro:</strong> ${cliente.bairro}</p>
                <p class="info-cliente-bloco"><strong>UF:</strong> ${cliente.uf}</p>
            </div>
        </div>
      </div>
    `;
}

var botaoCarrosel = document.getElementById("checkCarrossel");
var botaoBloco = document.getElementById("checkBloco");

var divCarrossel = document.getElementById("carousel");
var divBloco = document.getElementsByClassName("bloco")[0];

document.addEventListener("DOMContentLoaded", function () {
    function exibirCarrossel() {
        divCarrossel.style.display = "block";
        divBloco.style.display = "none";
        divBloco.innerHTML = "";

        // Verifica se já há cards no carrossel
        if ($('#carousel .card').length > 0) {
            // Se já houver, destrói os cards
            $('#carousel').owlCarousel('destroy');
            $('#carousel .card').remove();
        }

        cliente.forEach(function (cliente) {
            $('#carousel').append(criaCartaoCarrossel(cliente));
        });

        $('#carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 5
                }
            }
        });

    }
    exibirCarrossel(); // chama a função para exibir o carrossel assim que a página for carregada
});

botaoCarrosel.addEventListener("change", function () {
    if (botaoCarrosel.checked) {
        divCarrossel.style.display = "block";
        divBloco.style.display = "none";
        divBloco.innerHTML = "";
    } else {
        divCarrossel.style.display = "none";
        divBloco.style.display = "block";
    }
});

botaoBloco.addEventListener("change", function () {
    if (botaoBloco.checked) {
        divBloco.style.display = "block";
        divCarrossel.style.display = "none";

        if (divBloco.innerHTML === "") { // adiciona cards somente se a div estiver vazia
            cliente.forEach(function (cliente) {
                divBloco.innerHTML += criaCardBloco(cliente);
            });
        }
    } else {
        divBloco.style.display = "none";
        divCarrossel.style.display = "block";
    }
});


