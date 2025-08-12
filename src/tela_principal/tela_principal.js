document.addEventListener("DOMContentLoaded", function () {
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

    const senhaInput = document.getElementById("senhaUsuario");
    const toggleSenha = document.getElementById("toggleSenha");

    if (toggleSenha && senhaInput) {
    toggleSenha.addEventListener("click", function () {
        const isSenha = senhaInput.type === "password";
        senhaInput.type = isSenha ? "text" : "password";

        const icon = toggleSenha.querySelector("i");
        if (isSenha) {
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    });
}

    const btnCancelar = document.querySelector(".btn-cancelar");
    if (btnCancelar) {
        btnCancelar.addEventListener("click", limparCampos);
    }
});

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

