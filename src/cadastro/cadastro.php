<?php
include __DIR__ . '/../conect_pgsql/conn.php';

if (isset($_GET['erro']) && $_GET['erro'] == "emailexistente") {
    echo '<div id="mensagem-erro" class="mensagem-erro" style="display:block;">Este email já está cadastrado!</div>';
}

if (isset($_GET['erro']) && $_GET['erro'] == "camponulo") {
    echo '<div id="mensagem-erro" class="mensagem-erro" style="display:block;">Todos os campos são obrigatórios!</div>';
}

if (isset($_GET['erro']) && $_GET['erro'] == "idadeinapropriada") {
    echo '<div id="mensagem-erro" class="mensagem-erro" style="display:block;">Idade do usuario inapropriada</div>';
}

if (isset($_GET['erro']) && $_GET['erro'] == "senhapequena") {
    echo '<div id="mensagem-erro" class="mensagem-erro" style="display:block;">Senha deve ter mais de 8 caracteres</div>';
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../imagens/ConectaNews.png">
    <title>Tela de cadastro</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="cadastro.css">

</head>

<body>
    <main class="container">
        <h1 class="cadastro_titulo"> <strong>Cadastro</strong> </h1>

        <form action="../actions/create_user.php" method="post">
            <div class="input_cadastro">
                <input class="email" placeholder="Email" type="email" name="email" require>
                <i class="bx bxs-envelope"></i>
            </div>
            <div class="input_cadastro">
                <input class="nome" placeholder="Nome" type="text" name="nome" require>
                <i class="bx bxs-user"></i>
            </div>
            <div class="input_cadastro">
                <input class="data_nascimento" type="date" name="data_nascimento" require>
            </div>
            <div class="input_cadastro">
                <input class="senha" placeholder="Senha" type="password" name="senha" require>
                <i class="bx bxs-lock-alt"></i>
            </div>
            <button type="submit" class="cadastro_button">Cadastrar-se</button>
        </form>
        <div class="login_conta">
            <p>Já tem uma conta? <a href="../login/login.php">Login</a></p>
        </div>
    </main>
</body>

</html>