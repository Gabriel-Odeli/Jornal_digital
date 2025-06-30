const formulario = document.querySelector("form");
const Iemail = document.querySelector(".email");
const Inome = document.querySelector(".nome");
const Idata_nasc = document.querySelector(".data_nascimento");
const Isenha = document.querySelector(".senha")

function cadastrar(){

    fetch("http://localhost:8080/cadastrar",
        {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            method: "POST",
            body: JSON.stringify({
                email: Iemail.value,
                nome: Inome.value,
                data_nasc: Idata_nasc.value,
                senha: Isenha.value
            })
        })
        .then(function (res) { console.log(res) })
        .catch(function (res) { console.log(res) })
};

function limpar () {
    Iemail.value="",
    Inome.value="",
    Idata_nasc.value="",
    Isenha.value=""
}

formulario.addEventListener('submit', function(event) {
    event.preventDefault();
    cadastrar();
    limpar();
});