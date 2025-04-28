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
