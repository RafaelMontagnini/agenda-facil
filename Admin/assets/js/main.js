let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => {
  item.addEventListener("mouseover", activeLink);
});

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};


document.getElementById("collapse-link").addEventListener("click", function() {
  var icon = document.getElementById("collapse-icon");
  if (icon.getAttribute("name") === "arrow-down-outline") {
    icon.setAttribute("name", "arrow-up-outline");
  } else {
    icon.setAttribute("name", "arrow-down-outline");
  }
});
document.getElementById("collapse-finance").addEventListener("click", function() {
  var icon = document.getElementById("collapse-icon-finance");
  if (icon.getAttribute("name") === "arrow-down-outline") {
    icon.setAttribute("name", "arrow-up-outline");
  } else {
    icon.setAttribute("name", "arrow-down-outline");
  }
});
document.getElementById("collapse-activity").addEventListener("click", function() {
  var icon = document.getElementById("collapse-icon-activity");
  if (icon.getAttribute("name") === "arrow-down-outline") {
    icon.setAttribute("name", "arrow-up-outline");
  } else {
    icon.setAttribute("name", "arrow-down-outline");
  }
});


function buscarEndereco() {
  var cep = document.getElementById('id_cepCliente').value;

  // Fazer a requisição para a API dos Correios
  fetch('https://viacep.com.br/ws/' + cep + '/json/')
    .then(function(response) {
      return response.json();
    })
    .then(function(data) {
      if (data.logradouro && data.bairro && data.localidade && data.uf) {
        document.getElementById('id_ruaCliente').value = data.logradouro.toUpperCase();
        document.getElementById('id_bairroCliente').value = data.bairro.toUpperCase();
        document.getElementById('id_cidadeCliente').value = data.localidade.toUpperCase();
        document.getElementById('id_estadoCliente').value = data.uf.toUpperCase();
      }else{
        document.getElementById('id_ruaCliente').value = "";
        document.getElementById('id_bairroCliente').value = "";
        document.getElementById('id_cidadeCliente').value = "";
        document.getElementById('id_estadoCliente').value = "";
      }
    })
    .catch(function(error) {
      console.log('Erro ao buscar o endereço:', error);
    });
}

  








