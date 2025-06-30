// formulario.js
 
 // Pegando os elementos do DOM
 const botoesCandidatar = document.querySelectorAll('.btn-candidatar');
 const formCandidatura = document.getElementById('form-candidatura');
 const botaoFechar = document.getElementById('fecharFormulario');
 const formulario = document.getElementById('curriculoForm');
 const vagaTitulo = document.getElementById('vagaTitulo'); // NOVO: Pega o título da vaga
 
 // Função para mostrar o formulário
 function abrirFormulario(tituloVaga) {
     vagaTitulo.textContent = `Candidatando-se para: ${tituloVaga}`;
     formCandidatura.style.display = 'flex';
 }
 
 // Função para fechar o formulário e limpar o que foi preenchido
 function fecharFormulario() {
     formCandidatura.style.display = 'none';
     formulario.reset();
     vagaTitulo.textContent = ''; // Limpa o título da vaga ao fechar
 }
 
 // Evento de clique para cada botão "Candidatar-se"
 botoesCandidatar.forEach(botao => {
     botao.addEventListener('click', function() {
         const vaga = this.parentElement.querySelector('h2').innerText; // Pega o nome da vaga
         abrirFormulario(vaga);
     });
 });
 
 // Evento de clique no botão "Cancelar"
 botaoFechar.addEventListener('click', fecharFormulario);
 
 // Evento de envio do formulário
 formulario.addEventListener('submit', function(event) {
     event.preventDefault();
     alert('Currículo enviado com sucesso!');
     fecharFormulario();
 });

document.addEventListener("DOMContentLoaded", function () {
    const botaoTema = document.getElementById("toggleTema");
    const iconeTema = document.getElementById("iconeTema");

    // Verifica tema salvo
    const temaSalvo = localStorage.getItem("tema");

    if (temaSalvo === "escuro") {
        document.body.classList.add("dark-mode");
        iconeTema.className = "bx bx-moon";
    } else {
        iconeTema.className = "bx bx-sun";
    }

    botaoTema.addEventListener("click", function () {
        const isDark = document.body.classList.toggle("dark-mode");

        if (isDark) {
            iconeTema.className = "bx bx-moon";
            localStorage.setItem("tema", "escuro");
        } else {
            iconeTema.className = "bx bx-sun";
            localStorage.setItem("tema", "claro");
        }
    });
});
