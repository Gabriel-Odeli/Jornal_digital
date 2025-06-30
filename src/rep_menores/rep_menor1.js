const botaoCompartilhar = document.getElementById('botao-compartilhar');

botaoCompartilhar.addEventListener('click', async () => {
    if (navigator.share) {
        try {
            await navigator.share({
                title: document.title,
                text: "Confira essa reportagem incrível!",
                url: window.location.href
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
window.onscroll = function() {
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

function criarMensagem(nome, texto) {
    const divMensagem = document.createElement('div');
    divMensagem.classList.add('mensagem');

    const titulo = document.createElement('h4');
    titulo.textContent = nome;

    const corpo = document.createElement('p');
    corpo.textContent = texto;

    const hora = document.createElement('time');
    const agora = new Date();
    hora.textContent = agora.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

    const botaoResponder = document.createElement('button');
    botaoResponder.classList.add('btn-responder');
    botaoResponder.textContent = 'Responder';

    const divRespostas = document.createElement('div');
    divRespostas.classList.add('respostas');

    divMensagem.appendChild(titulo);
    divMensagem.appendChild(corpo);
    divMensagem.appendChild(hora);
    divMensagem.appendChild(botaoResponder);
    divMensagem.appendChild(divRespostas);

    listaMensagens.prepend(divMensagem);

    botaoResponder.addEventListener('click', () => abrirFormularioResposta(divRespostas));
}

function abrirFormularioResposta(respostasContainer) {
    // Cria novo formulário de resposta SEM apagar os antigos
    const formResposta = document.createElement('form');
    formResposta.classList.add('form-resposta');

    const textareaResposta = document.createElement('textarea');
    textareaResposta.placeholder = 'Escreva sua resposta...';
    textareaResposta.required = true;

    const containerBotoes = document.createElement('div');
    containerBotoes.style.display = 'flex';
    containerBotoes.style.gap = '10px';
    containerBotoes.style.marginTop = '5px';

    const botaoEnviarResposta = document.createElement('button');
    botaoEnviarResposta.type = 'submit';
    botaoEnviarResposta.textContent = 'Responder';

    const botaoCancelarResposta = document.createElement('button');
    botaoCancelarResposta.type = 'button';
    botaoCancelarResposta.textContent = 'Cancelar';
    botaoCancelarResposta.style.backgroundColor = '#dc3545';
    botaoCancelarResposta.style.color = '#fff';
    botaoCancelarResposta.style.border = 'none';
    botaoCancelarResposta.style.borderRadius = '4px';
    botaoCancelarResposta.style.padding = '5px 10px';
    botaoCancelarResposta.style.cursor = 'pointer';

    containerBotoes.appendChild(botaoEnviarResposta);
    containerBotoes.appendChild(botaoCancelarResposta);

    formResposta.appendChild(textareaResposta);
    formResposta.appendChild(containerBotoes);

    respostasContainer.appendChild(formResposta);

    // Evento de enviar resposta
    formResposta.addEventListener('submit', (e) => {
        e.preventDefault();
        const respostaTexto = textareaResposta.value.trim();
        if (respostaTexto) {
            criarResposta(respostasContainer, respostaTexto);
            formResposta.reset(); // Limpa o campo para permitir nova resposta
        }
    });

    // Evento de cancelar resposta
    botaoCancelarResposta.addEventListener('click', () => {
        respostasContainer.removeChild(formResposta);
    });
}

function criarResposta(respostasContainer, texto) {
    const divResposta = document.createElement('div');
    divResposta.classList.add('resposta');

    const nomeResposta = document.createElement('h5');
    nomeResposta.textContent = 'Usuário Anônimo'; // ou pode puxar de um login se quiser

    const corpoResposta = document.createElement('p');
    corpoResposta.textContent = texto;

    const horaResposta = document.createElement('time');
    const agora = new Date();
    horaResposta.textContent = agora.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

    divResposta.appendChild(nomeResposta);
    divResposta.appendChild(corpoResposta);
    divResposta.appendChild(horaResposta);

    respostasContainer.appendChild(divResposta);
}


document.addEventListener("DOMContentLoaded", function () {
    const botaoDarkMode = document.getElementById("botao-darkmode");

    // Verificar tema salvo
    const temaSalvo = localStorage.getItem("tema");
    if (temaSalvo === "escuro") {
        document.body.classList.add("dark-mode");
        botaoDarkMode.querySelector("i").classList.replace("bx-sun", "bx-moon");
    }

    // Alternar tema ao clicar no botão
    botaoDarkMode.addEventListener("click", function () {
        if (document.body.classList.contains("dark-mode")) {
            document.body.classList.remove("dark-mode");
            localStorage.setItem("tema", "claro");
            botaoDarkMode.querySelector("i").classList.replace("bx-moon", "bx-sun");
        } else {
            document.body.classList.add("dark-mode");
            localStorage.setItem("tema", "escuro");
            botaoDarkMode.querySelector("i").classList.replace("bx-sun", "bx-moon");
        }
    });
});
