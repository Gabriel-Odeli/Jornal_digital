<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../imagens/ConectaNews.png">
    <title>Adicionar Administrador</title>
    <link rel="stylesheet" href="administrador.css">
</head>
<body>
    <div class="container">
        <button class="close-btn" onclick="window.location.href='../index.php'">X</button>

        <h1>Adicionar Administrador</h1>
        <form action="../actions/change_type.php" method="POST">
            <label for="email">Email do Usuário:</label>
            <input type="email" id="email" name="email" placeholder="Digite o email" required>

            <label for="nivel">Nível de Acesso:</label>
            <select id="nivel" name="nivel">
                <option value="0">Usuário</option>
                <option value="1">Administrador</option>
            </select>

            <button type="submit">Adicionar</button>
        </form>
    </div>
</body>
</html>
