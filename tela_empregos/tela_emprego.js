// Pegando os elementos do DOM
const botoesCandidatar = document.querySelectorAll('.btn-candidatar');
const formCandidatura = document.getElementById('form-candidatura');
const botaoFechar = document.getElementById('fecharFormulario');
const formulario = document.getElementById('curriculoForm');
const vagaTitulo = document.getElementById('vagaTitulo');
const inputCurriculo = document.getElementById('curriculo');
const mensagemErro = document.getElementById('mensagem-erro');
const mensagemSucesso = document.getElementById('mensagem-sucesso'); // NOVO: mensagem de sucesso

// Função para mostrar mensagem de erro
function mostrarMensagemErro(texto) {
    mensagemErro.textContent = texto;
    mensagemErro.style.display = 'block';
    mensagemErro.classList.remove('fade');
    void mensagemErro.offsetWidth;
    mensagemErro.classList.add('fade');

    setTimeout(() => {
        mensagemErro.style.display = 'none';
    }, 4000);
}

// Função para mostrar mensagem de sucesso
function mostrarMensagemSucesso(texto) {
    mensagemSucesso.textContent = texto;
    mensagemSucesso.style.display = 'block';
    mensagemSucesso.classList.remove('fade');
    void mensagemSucesso.offsetWidth;
    mensagemSucesso.classList.add('fade');

    setTimeout(() => {
        mensagemSucesso.style.display = 'none';
    }, 4000);
}

// Função para mostrar o formulário
function abrirFormulario(tituloVaga) {
    vagaTitulo.textContent = `Candidatando-se para: ${tituloVaga}`;
    formCandidatura.style.display = 'flex';
}

// Função para fechar o formulário e limpar o que foi preenchido
function fecharFormulario() {
    formCandidatura.style.display = 'none';
    formulario.reset();
    vagaTitulo.textContent = '';
}

// Evento de clique para cada botão "Candidatar-se"
botoesCandidatar.forEach(botao => {
    botao.addEventListener('click', function() {
        const vaga = this.parentElement.querySelector('h2').innerText;
        abrirFormulario(vaga);
    });
});

// Evento de clique no botão "Cancelar"
botaoFechar.addEventListener('click', fecharFormulario);

// Evento de envio do formulário
formulario.addEventListener('submit', function(event) {
    event.preventDefault();

    const arquivo = inputCurriculo.files[0];

    if (!arquivo) {
        mostrarMensagemErro('Por favor, selecione um arquivo.');
        return;
    }

    if (arquivo.type !== 'application/pdf') {
        mostrarMensagemErro('Arquivo inválido! Envie um PDF.');
        return;
    }

    mostrarMensagemSucesso('Currículo enviado com sucesso!');
    fecharFormulario();
});

document.addEventListener("DOMContentLoaded", function () {
    const temaSelector = document.getElementById("temaSelector");

    // Aplicar tema salvo se houver
    const temaSalvo = localStorage.getItem("tema");
    if (temaSalvo === "escuro") {
        document.body.classList.add("dark-mode");
        temaSelector.value = "escuro";
    }

    // Alterar tema ao selecionar
    temaSelector.addEventListener("change", function () {
        if (this.value === "escuro") {
            document.body.classList.add("dark-mode");
            localStorage.setItem("tema", "escuro");
        } else {
            document.body.classList.remove("dark-mode");
            localStorage.setItem("tema", "claro");
        }
    });
});
