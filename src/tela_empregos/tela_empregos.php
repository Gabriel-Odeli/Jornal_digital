<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Vagas</title>
    <link rel="stylesheet" href="tela_empregos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
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
                    <i id="iconeTema" class="bx bx-sun"></i>
                </button>
            </li>                            
        </ul>
        </nav>
        <form action="" class="form_categorias">
            <div class="categorias">
                <ul class="nav_categorias">
                    <li><a href="../tela_principal/tela_principal.php">Inicio</a></li>
                    <li><a href="#">Empregos</a></li>
                </ul>
            </div>
        </form>
    </header>

    <main class="job-section">
        <div class="job-card">
            <img src="../imagens/emprego.png" alt="Local">
            <h2>Supermercado Real</h2>
            <p>Repositor de Mercadorias</p>
            <div class="job-info">
                <span><i class="fas fa-dollar-sign"></i> R$ 1.800</span>
                <span><i class="fas fa-map-marker-alt"></i> Centro</span>
                <span><i class="fas fa-phone-alt"></i> (11) 9999-9999</span>
            </div>
            <button class="btn-candidatar">Candidatar-se</button>
        </div>

        <div class="job-card">
            <img src="../imagens/emprego.png" alt="Local">
            <h2>Farmácia Vida</h2>
            <p>Atendente de Balcão</p>
            <div class="job-info">
                <span><i class="fas fa-dollar-sign"></i> R$ 1.500</span>
                <span><i class="fas fa-map-marker-alt"></i> Bairro Norte</span>
                <span><i class="fas fa-phone-alt"></i> (11) 98888-8888</span>
            </div>
            <button class="btn-candidatar">Candidatar-se</button>
        </div>

        <div class="job-card">
            <img src="../imagens/emprego.png" alt="Local">
            <h2>Loja Tech</h2>
            <p>Caixa</p>
            <div class="job-info">
                <span><i class="fas fa-dollar-sign"></i> R$ 1.700</span>
                <span><i class="fas fa-map-marker-alt"></i> Shopping Azul</span>
                <span><i class="fas fa-phone-alt"></i> (11) 97777-7777</span>
            </div>
            <button class="btn-candidatar">Candidatar-se</button>
        </div>

        <div class="job-card">
            <img src="../imagens/emprego.png" alt="Local">
            <h2>Supermercado Real</h2>
            <p>Repositor de Mercadorias</p>
            <div class="job-info">
                <span><i class="fas fa-dollar-sign"></i> R$ 1.800</span>
                <span><i class="fas fa-map-marker-alt"></i> Centro</span>
                <span><i class="fas fa-phone-alt"></i> (11) 9999-9999</span>
            </div>
            <button class="btn-candidatar">Candidatar-se</button>
        </div>

        <!-- Formulário escondido inicialmente -->
        <div id="form-candidatura" style="display: none;">
            <div class="form-container">
                <h2 id="vagaTitulo"></h2> <!-- NOVO: onde mostra o título da vaga -->
                <form id="curriculoForm">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="curriculo">Currículo (PDF):</label>
                    <input type="file" id="curriculo" name="curriculo" accept=".pdf" required>

                    <button type="submit">Enviar</button>
                    <button type="button" id="fecharFormulario">Cancelar</button>
                </form>
            </div>
        </div>
    </main>
    <div id="mensagem-erro" class="mensagem-erro">Arquivo inválido! Envie um PDF.</div>
    <div id="mensagem-sucesso" class="mensagem-sucesso">Currículo enviado com sucesso!</div>
    <script src="tela_emprego.js" defer></script>


    <?php if (isset($_SESSION['id_usuario'])): ?>
    <div id="perfilModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModal()">&times;</span>
            <h2>Perfil de <?= htmlspecialchars($_SESSION['nome']) ?></h2>

            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
            <p><strong>Data de Nascimento:</strong> <?= date('d/m/Y', strtotime($_SESSION['data_nasc'])) ?></p>
            <p><strong>Nome de Usuário:</strong> <?= htmlspecialchars($_SESSION['nome']) ?></p>

            <div class="senha-wrapper">
                <input type="password" id="senhaUsuario" value = "<?php echo $_SESSION['senha'] ?>" readonly >
                <span id="toggleSenha" class="olho"><i class="fas fa-eye-slash"></i></span>
            </div>

            <div class="botoes-acoes">
                <button type="button" class="editar-btn" onclick="abrirEditarModal()">Editar</button>
                <button class="logout-btn" onclick="abrirModalExclusao()">Excluir</button>
                <button class="sair-btn" onclick="window.location.href='../actions/logout.php'">Sair da conta</button>
            </div>

            </div>
        </div>
    </div>

    <div id="editarPerfilModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharEditarModal()">&times;</span>
            <h2>Editar Perfil</h2>

            <form id="form-editar" class="form-editar" action="../actions/edit_user.php" method="post">
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

                <div class="botoes-acoes">
                    <button type="submit" class="btn-salvar">Salvar</button>
                    <button type="button" class="btn-cancelar" onclick="fecharEditarModal()">Cancelar</button>
                </div>
            </form>


        </div>
    </div>
<?php endif; ?>
    
    <script src="tela_principal.js"></script>

    <div id="modalExclusao">
        <div class="modal-content">
            <span class="close" onclick="fecharModalExclusao()">&times;</span>
            <h3>Confirmação de Exclusão</h3>
            <p>Todos os seus dados de navegação e de usuário serão excluídos. Tem certeza que deseja fazer a exclusão permanente?</p>
            <form action="../actions/delete_user.php" method="post">
                <div class="botoes-confirmacao">
                    <button class="btn-confirmar-exclusao" type="submit">Sim</button>
                    <button class="btn-cancelar-exclusao" onclick="fecharModalExclusao()">Não</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>