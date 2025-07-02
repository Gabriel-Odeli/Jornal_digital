<?php
include __DIR__ . '/../conect_pgsql/conn.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de cadastro</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="cadastro.css">

</head>
<body>
    <main class="container">
        <h1 class="cadastro_titulo"> <strong>Cadastro</strong> </h1>
        <form action="../actions/create_user.php" method="post">
            <div class="input_cadastro">
                <input class="email" placeholder="Email" type="email" name = "email" required>
                <i class="bx bxs-envelope"></i>
            </div>
            <div class="input_cadastro">
                <input class="nome" placeholder="Nome" type="text" name = "nome" required>
                <i class="bx bxs-user"></i>
            </div>
            <div class="input_cadastro">
                <input class="data_nascimento" type="date" name = "data_nascimento" required>
            </div>
            <div class="input_cadastro">
                <input class="senha" placeholder="Senha" type="password" name = "senha" required>
                <i class="bx bxs-lock-alt"></i>
            </div>
            <input  type="submit">
        </form>
        <div class="login_conta">
            <p>Já tem uma conta? <a href="../login/login.html">Login</a></p>
        </div>
    </main>
</body>
</html>