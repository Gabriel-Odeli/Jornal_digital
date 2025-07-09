<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="tela_principal.css">
    <title>ConectaNews</title>
</head>

<body>
    <header>
        <nav class="parte_cima">
            <?php
                if (!isset($_SESSION['id_usuario'])) {
                    echo '<a class="login" href="../login/login.php">Login'; 
                    echo '<i class="bx bxs-user"></i></a>';
                }else{
                    echo '<button class="user-btn" onclick="abrirModal()">' . htmlspecialchars($_SESSION['nome']) . '</button>';
                }
            ?>
            <h1 class="titulo">ConectaNews</h1>

        <ul class="nav_list">
            <li> <a href="#"> <img src="../imagens/instagram.png" alt="Instagram"> </a> </li>
            <li> <a href="#"><img src="../imagens/facebook.png" alt="Facebook"> </a> </li>
            <li>
                <button id="toggleTema" class="botao-darkmode" aria-label="Alternar tema">
                <i id="iconeTema" class='bx bx-sun'></i>
                </button>          
            </li>        
        </ul>

        </nav>
        <form action="" class="form_categorias">
            <div class="categorias">
                <ul class="nav_categorias">
                    <li><a href="#">Inicio</a></li>
                    <li><a href="../tela_empregos/tela_empregos.html">Empregos</a></li>
                </ul>
            </div>
        </form>
        <header class="Reportagens">
            <a href="../rep_maior/rep_maior.html" class="rep_maior">
                <div>
                    <img class="rep_maior-img" src="../imagens/pinguins.png" alt="imagem da reportagem">
                    <h2 class="rep_maior-h2">Pinguins loucos deixam 3 pessoas feridas</h2>
                </div>
            </a>
            <div class="rep_menores">
                <a href="../rep_menores/rep_menor1.html" class="rep_menor1">
                    <div>
                        <img class="rep_menor1-img" src="../imagens/jogo_ano.png" alt="imagem da reportagem">
                        <h2 class="rep_menor1-h2">Astro Bot ganha o jogo do ano de 2024 e surpreende gamers de todos os
                            lugares</h2>
                    </div>
                </a>
                <a href="../rep_menores/rep_menor2.html" class="rep_menor2">
                    <div >
                        <img class="rep_menor2-img" src="../imagens/Ucrania_Russia.png" alt="imagem da reportagem">
                        <h2 class="rep_menor2-h2">Guerra da Ucrania e Russia completa 3 anos. Quais foram suas
                            consequencias?</h2>
                    </div>
                </a>
            </div>
        </header>

        <!-- Modal para a reportagem -->
        <div id="modalReportagem" style="display: none;">
            <div class="modal-conteudo">
                <button id="fecharModal" class="fechar-modal">X</button>
                <h2 id="modalTitulo"></h2>
                <img id="modalImagem" alt="Imagem da reportagem">
                <p id="modalTexto"></p>
            </div>
        </div>
    </header>
    <main></main>

    <?php if (isset($_SESSION['id_usuario'])): ?>
    <!-- Modal do Perfil -->
    <div id="perfilModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModal()">&times;</span>
            <h2>Perfil de <?= htmlspecialchars($_SESSION['nome']) ?></h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
            <p><strong>Data de Nascimento:</strong> <?= date('d/m/Y', strtotime($_SESSION['data_nasc'])) ?></p>
            <p><strong>Nome de Usuário:</strong> <?= htmlspecialchars($_SESSION['nome']) ?></p>

            <form method="post" class="form_modal_perfil">
                <input type="password" name="senha_verificacao" placeholder="Digite sua senha" required>
                <button type="submit" name="ver_senha">Ver Senha</button>
            </form>

            <?php
            if (isset($_POST['ver_senha'])) {
                if ($_POST['senha_verificacao'] === $_SESSION['senha']) {
                    echo "<p><strong>Senha:</strong> " . htmlspecialchars($_SESSION['senha']) . "</p>";
                } else {
                    echo "<p class='erro'>Senha incorreta!</p>";
                }
            }
            ?>

            <form action="../actions/logout.php" method="post">
                <button class="logout-btn">Sair da Conta</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
    <script src="tela_principal.js"></script>
</body>

</html>