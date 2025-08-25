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


//Mascara no telefone
document.getElementById('telefone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, "");
    
    if (value.length > 11) value = value.slice(0, 11);
    
    if (value.length <= 10) {
        value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, "($1) $2-$3");
    } else {
        value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, "($1) $2-$3");
    }
    
    e.target.value = value;
});


//Mascara para salario
document.getElementById('salario').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, ""); 
    if (value) {
        value = (value/100).toFixed(2) + "";  
        value = value.replace(".", ",");  
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); 
        e.target.value = "R$ " + value;
    }
});