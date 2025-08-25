<?php
if (isset($_GET['erro']) && $_GET['erro'] == "nouser") {
    echo '<div id="mensagem-erro" class="mensagem-erro" style="display:block;">Crie ou entre em uma conta para acessar!</div>';
}

if (isset($_GET['erro']) && $_GET['erro'] == "notfund") {
    echo '<div id="mensagem-erro" class="mensagem-erro" style="display:block;">Email ou senha incorretos!</div>';
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="login.css">
    <title>Tela de login</title>
</head>

<body>
    <main class="container">
        <?php
        ?>
        <form action="../actions/select_user.php" method="POST">
            <h1 class="login_titulo"> <strong>Login</strong> </h1>
            <div class="input_login">
                <input placeholder="Email" type="email" name="email" required>
                <i class="bx bxs-envelope"></i>
            </div>
            <div class="input_login">
                <input placeholder="Senha" type="password" name="senha" required>
                <i class="bx bxs-lock-alt"></i>
            </div>
            <button type="submit" class="login_button">Login</button>
        </form>
        <div class="cadastro_conta">
            <p>Não tem uma conta? <a href="../cadastro/cadastro.php">Cadastre-se</a></p>
        </div>
    </main>
</body>

</html>