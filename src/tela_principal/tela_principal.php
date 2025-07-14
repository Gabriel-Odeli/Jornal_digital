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
    <!-- Modal de Visualização de Perfil -->
    <div id="perfilModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModal()">&times;</span>
            <h2>Perfil de <?= htmlspecialchars($_SESSION['nome']) ?></h2>

            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
            <p><strong>Data de Nascimento:</strong> <?= date('d/m/Y', strtotime($_SESSION['data_nasc'])) ?></p>
            <p><strong>Nome de Usuário:</strong> <?= htmlspecialchars($_SESSION['nome']) ?></p>

            <div class="senha-wrapper">
                <input type="password" id="senhaUsuario" placeholder="Digite sua senha">
                <span id="toggleSenha" class="olho">&#128065;</span>
            </div>

            <div class="botoes-acoes">
                <button type="button" class="editar-btn" onclick="abrirEditarModal()">Editar</button>
                <button class="logout-btn" onclick="abrirModalExclusao()">Excluir</button>
</div>

            </div>
        </div>
    </div>

    <!-- Modal de Edição de Perfil -->
    <div id="editarPerfilModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharEditarModal()">&times;</span>
            <h2>Editar Perfil</h2>

            <form id="form-editar" class="form-editar">
    <div class="form-group">
        <label for="novo_nome">Nome de Usuário:</label>
        <input type="text" name="novo_nome" id="novo_nome" value="<?= htmlspecialchars($_SESSION['nome']) ?>" required>
    </div>

    <div class="form-group">
        <label for="novo_email">Email:</label>
        <input type="email" name="novo_email" id="novo_email" value="<?= htmlspecialchars($_SESSION['email']) ?>" required>
    </div>

    <div class="form-group">
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" name="nova_senha" id="nova_senha" placeholder="Deixe em branco para manter a atual">
    </div>

    <div class="mensagem-sucesso" id="mensagemSucesso">Salvo com sucesso ✅</div>

    <div class="botoes-acoes">
        <button type="submit" class="btn-salvar">Salvar</button>
        <button type="button" class="btn-cancelar" onclick="limparCampos()">Cancelar</button>
    </div>
</form>


        </div>
    </div>
<?php endif; ?>




            <form action="../actions/logout.php" method="post">
                <button class="logout-btn">Sair da Conta</button>
            </form>
        </div>
    </div>
    
    <script src="tela_principal.js"></script>

    <div id="modalExclusao">
  <div class="modal-content">
    <span class="close" onclick="fecharModalExclusao()">&times;</span>
    <h3>Confirmação de Exclusão</h3>
    <p>Todos os seus dados de navegação e de usuário serão excluídos. Tem certeza que deseja fazer a exclusão permanente?</p>
    <div class="botoes-confirmacao">
      <button class="btn-confirmar-exclusao" onclick="confirmarExclusao()">Sim</button>
      <button class="btn-cancelar-exclusao" onclick="fecharModalExclusao()">Não</button>
    </div>
  </div>
</div>

</body>

</html>