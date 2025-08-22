<?php
include __DIR__ . '/../conect_pgsql/conn.php';
session_start();
$sql = "SELECT * FROM emprego";
$stmt = $conn->prepare($sql);
$stmt->execute();
$empregos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            } else {
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
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="#">Empregos</a></li>
                    <?php
                    if (isset($_SESSION['id_usuario'])) {
                        if ($_SESSION['tipo'] == 1) {
                            echo '<li class="botao-add-emprego">';
                            echo  '<a href="../add_emprego/add_emprego.php">Adicionar vaga de emprego</a>';
                            echo '</li>';
                        } else {
                            echo '';
                        }
                    }
                    ?>
                </ul>

            </div>
        </form>
    </header>
    <?php
    if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'send') {
        echo '<div id="mensagem-sucesso" class="mensagem-sucesso" style="display:block;">Currículo enviado com sucesso!</div>';
    }

    if (isset($_GET['erro']) && $_GET['erro'] == 'notsend') {
        echo '<div id="mensagem-erro" class="mensagem-erro" style="display:block">ERRO: Currículo não foi enviado.</div>';
    }
    ?>

    <main class="job-section">
        <?php if (!empty($empregos)): ?>
            <?php foreach ($empregos as $e): ?>
                <?php
                if (!empty($e['imagem_local'])) {
                    $stream = $e['imagem_local'];
                    $imagemPrimeiraBytes = stream_get_contents($stream);
                    $imagem = "data:image/jpeg;base64," . base64_encode($imagemPrimeiraBytes);
                } else {
                    $imagem = "../imagens/emprego.png";
                }
                ?>
                <div class="job-card">
                    <img src="<?= $imagem ?>" alt="Local">
                    <h2><?= htmlspecialchars($e['nome_lugar']) ?></h2>
                    <p><?= htmlspecialchars($e['cargo']) ?></p>
                    <div class="job-info">
                        <span><i class="fas fa-dollar-sign"></i> <?= number_format($e['salario'], 2, ',', '.') ?></span>
                        <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($e['localizacao']) ?></span>
                        <span><i class="fas fa-phone-alt"></i> <?= htmlspecialchars($e['telefone']) ?></span>
                    </div>
                    <button class="btn-candidatar"
                        data-email="<?= htmlspecialchars($e['email']) ?>">
                        Candidatar-se
                    </button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="sem-empregos">⚠️ Não existem empregos cadastrados no momento.</p>
        <?php endif; ?>

        <div id="form-candidatura" style="display: none;">
            <div class="form-container">
                <h2 id="vagaTitulo"></h2>
                <form id="curriculoForm" action="../actions/send_curriculum.php" method="post" enctype="multipart/form-data">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" value="<?php echo $_SESSION['nome'] ?>" id="nome" name="nome" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $_SESSION['email'] ?>" readonly required>

                    <label for="curriculo">Currículo (PDF):</label>
                    <input type="file" id="curriculo" name="curriculo" accept="application/pdf" required>

                    <input type="hidden" id="email_empresa" name="email_empresa" value="">
                    <button type="submit">Enviar</button>
                    <button type="button" id="fecharFormulario">Cancelar</button>
                </form>
            </div>
        </div>
    </main>
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

    <script src="tela_principal.js"></script>

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

</body>

</html>