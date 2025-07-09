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


// modal perfil

function abrirModal() {
            document.getElementById("perfilModal").style.display = "block";
        }

        function fecharModal() {
            document.getElementById("perfilModal").style.display = "none";
        }

        window.onclick = function(event) {
            let modal = document.getElementById("perfilModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("perfilModal").style.display = "block";
        });