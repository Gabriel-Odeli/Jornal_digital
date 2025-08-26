const btnCancelar = document.querySelector(".btn-cancelar");
if (btnCancelar) {
    btnCancelar.addEventListener("click", limparCampos);
}

function abrirModal() {
    const modal = document.getElementById("perfilModal");
    if (modal) modal.style.display = "block";
}

function fecharModal() {
    const modal = document.getElementById("perfilModal");
    if (modal) modal.style.display = "none";
}

function abrirEditarModal() {
    const modal = document.getElementById("editarPerfilModal");
    if (modal) modal.style.display = "block";
}

function fecharEditarModal() {
    const modal = document.getElementById("editarPerfilModal");
    if (modal) modal.style.display = "none";
}

function limparCampos() {
    const campos = ["novo_nome", "novo_email", "nova_senha"];
    campos.forEach(id => {
        const campo = document.getElementById(id);
        if (campo) campo.value = "";
    });
}

function abrirModalExclusao() {
    document.getElementById("modalExclusao").style.display = "flex";
}

function fecharModalExclusao() {
    document.getElementById("modalExclusao").style.display = "none";
}

const botaoCompartilhar = document.getElementById('botao-compartilhar');
const url = document.getElementById('URL_REPORTAGEM');
const titulo = document.getElementById('TITULO_REPORTAGEM');

botaoCompartilhar.addEventListener('click', async () => {
    if (navigator.share) {
        try {
            await navigator.share({
                title: titulo.value,
                text: "Confira essa reportagem incrível!",
                url: url.value
            });
            console.log('Reportagem compartilhada com sucesso!');
        } catch (error) {
            console.error('Erro ao compartilhar:', error);
        }
    } else {
        alert('Compartilhamento não suportado neste dispositivo. Copie o link manualmente: ' + window.location.href);
    }
});


// Barra de progresso
window.onscroll = function () {
    const barra = document.getElementById('barra-progresso');
    const scrollTotal = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrollAtual = document.documentElement.scrollTop;
    const porcentagem = (scrollAtual / scrollTotal) * 100;
    barra.style.width = porcentagem + "%";
}

// --- Fórum de Mensagens ---
const formMensagem = document.getElementById('form-mensagem');
const listaMensagens = document.getElementById('lista-mensagens');

formMensagem.addEventListener('submit', (e) => {
    e.preventDefault();

    const nome = document.getElementById('nome-usuario').value.trim();
    const mensagem = document.getElementById('mensagem-usuario').value.trim();

    if (nome && mensagem) {
        criarMensagem(nome, mensagem);
        formMensagem.reset();
    }
});


document.addEventListener('click', (e) => {
  // Verifica se o botão clicado tem a classe btn-responder
  if (!e.target.classList.contains('btn-responder')) return;

  e.preventDefault();

  const comentario = e.target.closest('.comentario'); // pega o comentário clicado
  if (!comentario) return;

  const idComentario = comentario.dataset.id;

  // verifica se já existe um formulário aberto neste comentário
  if (comentario.querySelector('.form-resposta')) return;

  // cria o formulário
  const formResposta = document.createElement('form');
  formResposta.classList.add('form-resposta');

  const textarea = document.createElement('textarea');
  textarea.placeholder = 'Escreva sua resposta...';
  textarea.required = true;

  const botoes = document.createElement('div');
  botoes.style.display = 'flex';
  botoes.style.gap = '10px';
  botoes.style.marginTop = '5px';

  const btnEnviar = document.createElement('button');
  btnEnviar.type = 'submit';
  btnEnviar.textContent = 'Responder';

  const btnCancelar = document.createElement('button');
  btnCancelar.type = 'button';
  btnCancelar.textContent = 'Cancelar';
  btnCancelar.style.backgroundColor = '#dc3545';
  btnCancelar.style.color = '#fff';
  btnCancelar.style.border = 'none';
  btnCancelar.style.borderRadius = '4px';
  btnCancelar.style.padding = '5px 10px';
  btnCancelar.style.cursor = 'pointer';

  botoes.appendChild(btnEnviar);
  botoes.appendChild(btnCancelar);
  formResposta.appendChild(textarea);
  formResposta.appendChild(botoes);

  let respostasContainer = comentario.querySelector('.add_respostas');
  if (!respostasContainer) {
    respostasContainer = document.createElement('div');
    respostasContainer.classList.add('add_respostas');
    respostasContainer.style.marginLeft = '20px';
    comentario.appendChild(respostasContainer);
  }

  respostasContainer.appendChild(formResposta);

  // evento cancelar → remove o form
  btnCancelar.addEventListener('click', () => formResposta.remove());

  // evento submit → só pra teste, mostra a resposta abaixo
  formResposta.addEventListener('submit', (ev) => {
    ev.preventDefault();
    const respostaTexto = textarea.value.trim();
    if (!respostaTexto) return;

    const divResposta = document.createElement('div');
    divResposta.classList.add('resposta');
    divResposta.innerHTML = `<p>${respostaTexto}</p>`;

    respostasContainer.appendChild(divResposta);
    formResposta.remove();
  });
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