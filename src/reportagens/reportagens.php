<?php
include __DIR__ . '/../conect_pgsql/conn.php';
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../login/login.php?erro=usernotfund");
    exit;
}

if (!isset($_SESSION['id_reportagem'])) {
    echo "Nenhuma reportagem selecionada.";
    exit;
}

$id_reportagem = $_SESSION['id_reportagem'];

$sql = "SELECT * FROM reportagem WHERE id_reportagem = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id_reportagem);
$stmt->execute();

//Reportagem clickada
$reportagem = $stmt->fetch(PDO::FETCH_ASSOC);

$sqlAutor = "SELECT * FROM usuario WHERE id_usuario = :idU";
$stmtUsuario = $conn->prepare($sqlAutor);
$stmtUsuario->bindParam(":idU", $reportagem['id_usuario']);
$stmtUsuario->execute();
//Autor
$autor = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

//Imagem
$stream = $reportagem['imagem'];
$imagemBytes = stream_get_contents($stream);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jornal Digital - <?php echo $reportagem['titulo'] ?></title>
    <link rel="stylesheet" href="reportagens.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>
    <div id="barra-progresso"></div>

    <header>
        <nav class="parte_cima">
            <?php
            if (!isset($_SESSION['id_usuario'])) {
                echo '<a class="login" href="../login/login.php">Login';
                echo '<i class="bx bxs-user"></i></a>';
            } else {
                echo '<button class="user-btn" onclick="abrirModal()">' . htmlspecialchars($_SESSION['nome']) . '</button>';
            }
            ?>
            <h1 class="titulo">ConectaNews</h1>
            <ul class="nav_list">
                <li><a href="#"><img src="../imagens/instagram.png" alt="Instagram"></a></li>
                <li><a href="#"><img src="../imagens/facebook.png" alt="Facebook"></a></li>
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
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="../tela_empregos/tela_empregos.php">Empregos</a></li>
                </ul>
            </div>
        </form>
    </header>

    <main class="reportagem">
        <h2 class="titulo-reportagem"><?php echo $reportagem['titulo']; ?></h2>

        <div class="info-reportagem">
            <span><i class="fas fa-calendar-alt"></i> Publicado em: <?php echo date("d/m/Y", strtotime($reportagem['data_publicacao'])); ?></span>
            <span><i class="fas fa-user"></i> Por: <?php echo $autor['nome']; ?></span>
        </div>

        <img class="imagem-reportagem" src="data:image/jpeg;base64,<?php echo base64_encode($imagemBytes); ?>" alt="Pinguins causando confusão">

        <p class="texto-reportagem">
            <?php
            echo nl2br($reportagem['texto_reportagem']);
            ?>
        </p>


        <button id="botao-compartilhar" class="btn-compartilhar">
            <i class="fas fa-share-alt"></i> Compartilhar Reportagem
        </button>

        <a href="../index.php" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar</a>

        <section class="forum">
            <h2 class="forum-titulo"><i class="fas fa-comments"></i> Fórum de Discussão</h2>

            <form id="form-mensagem" class="form-mensagem">
                <input type="text" id="nome-usuario" value='<?php echo $_SESSION['nome'] ?>' readonly>
                <textarea id="mensagem-usuario" placeholder="Escreva sua mensagem..." required></textarea>
                <button type="submit" class="btn-enviar">Enviar Mensagem</button>
            </form>

            <div id="lista-mensagens" class="lista-mensagens">
                <!-- Mensagens aparecerão aqui -->
            </div>
        </section>

    </main>
    <?php if (isset($_SESSION['id_usuario'])): ?>
        <div id="perfilModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="fecharModal()">&times;</span>
                <h2>Perfil de <?= htmlspecialchars($_SESSION['nome']) ?></h2>

                <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
                <p><strong>Data de Nascimento:</strong> <?= date('d/m/Y', strtotime($_SESSION['data_nasc'])) ?></p>
                <p><strong>Nome de Usuário:</strong> <?= htmlspecialchars($_SESSION['nome']) ?></p>

                <div class="senha-wrapper">
                    <input type="password" id="senhaUsuario" value="<?php echo $_SESSION['senha'] ?>" readonly>
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


    <div id="modalExclusao">
        <div class="modal-content">
            <span class="close" onclick="fecharModalExclusao()">&times;</span>
            <h3>Confirmação de Exclusão</h3>
            <p>Todos os seus dados de navegação e de usuário serão excluídos. Tem certeza que deseja fazer a exclusão permanente?</p>
            <form action="../actions/delete_user.php" method="post">
                <div class="botoes-confirmacao">
                    <button class="btn-confirmar-exclusao" type="submit">Sim</button>
                    <button class="btn-cancelar-exclusao" type="button" onclick="fecharModalExclusao()">Não</button>
                </div>
            </form>
        </div>
    </div>
    <script src="reportagens.js" defer></script>
</body>

</html>