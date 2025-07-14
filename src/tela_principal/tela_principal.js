document.addEventListener("DOMContentLoaded", function () {
    // 🔄 Alternância de Tema
    const botaoTema = document.getElementById("toggleTema");
    const iconeTema = document.getElementById("iconeTema");

    const temaSalvo = localStorage.getItem("tema");
    if (temaSalvo === "escuro") {
        document.body.classList.add("dark-mode");
        iconeTema.className = "bx bx-moon";
    } else {
        iconeTema.className = "bx bx-sun";
    }

    if (botaoTema) {
        botaoTema.addEventListener("click", function () {
            const isDark = document.body.classList.toggle("dark-mode");
            iconeTema.className = isDark ? "bx bx-moon" : "bx bx-sun";
            localStorage.setItem("tema", isDark ? "escuro" : "claro");
        });
    }

    // 👁️ Alternar visibilidade da senha (modal de perfil)
    const senhaInput = document.getElementById("senhaUsuario");
    const toggleSenha = document.getElementById("toggleSenha");

    if (toggleSenha && senhaInput) {
        toggleSenha.addEventListener("click", function () {
            const isSenha = senhaInput.type === "password";
            senhaInput.type = isSenha ? "text" : "password";
            toggleSenha.textContent = isSenha ? "🙈" : "👁️";
        });
    }

    // ✅ Submissão do formulário de edição (simulado)
    const formEditar = document.getElementById("form-editar");
    const mensagem = document.getElementById("mensagemSucesso");

    if (formEditar) {
        formEditar.addEventListener("submit", function (e) {
            e.preventDefault(); // impede envio real

            if (mensagem) {
                mensagem.style.display = "block";
                setTimeout(() => {
                    mensagem.style.display = "none";
                    fecharEditarModal();
                }, 2000);
            }
        });
    }

    // 🧹 Limpar campos ao cancelar
    const btnCancelar = document.querySelector(".btn-cancelar");
    if (btnCancelar) {
        btnCancelar.addEventListener("click", limparCampos);
    }
});

// 🪟 Abrir/Fechar Modais de Perfil
function abrirModal() {
    const modal = document.getElementById("perfilModal");
    if (modal) modal.style.display = "block";
}

function fecharModal() {
    const modal = document.getElementById("perfilModal");
    if (modal) modal.style.display = "none";
}

// 🪟 Abrir/Fechar Modal de Edição
function abrirEditarModal() {
    const modal = document.getElementById("editarPerfilModal");
    if (modal) modal.style.display = "block";
}

function fecharEditarModal() {
    const modal = document.getElementById("editarPerfilModal");
    if (modal) modal.style.display = "none";
}

// Fechar modais clicando fora
window.onclick = function (event) {
    const modalPerfil = document.getElementById("perfilModal");
    const modalEditar = document.getElementById("editarPerfilModal");

    if (event.target === modalPerfil) modalPerfil.style.display = "none";
    if (event.target === modalEditar) modalEditar.style.display = "none";
};

// 🧼 Função para limpar os campos da edição
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

function confirmarExclusao() {
    window.location.href = 'excluir_usuario.php';
}
