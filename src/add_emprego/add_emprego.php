<?php
include __DIR__ . '/../conect_pgsql/conn.php';

session_start();
if (!$_SESSION) {
    header("Location: ../login/login.php");
}
if (!$_SESSION['tipo'] == 1) {
    header("Location: ../tela_empregos/tela_empregos.php?erro=notadm");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Emprego - ConectaNews</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="add_emprego.css">
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

        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
            <div class="msg_sucesso">
                <h3>✅ Emprego salvo com sucesso!</h3>
            </div>
        <?php endif; ?>

        <div class="container">
            <h2>Adicionar Nova Vaga De Emprego</h2>
            <form action="../actions/create_job.php" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label for="nome">Nome do Local:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="form-group">
                    <label for="vaga">Vaga Necessaria:</label>
                    <input type="text" id="vaga" name="vaga" required>
                </div>

                <div class="form-group">
                    <label for="localizacao">Localização da empresa:</label>
                    <input type="text" id="localizacao" name="localizacao" required></input>
                </div>

                <div class="form-group">
                    <label for="email">Email da Empresa:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone para contato:</label>
                    <input type="text" id="telefone" name="telefone" required></input>
                </div>

                <div class="form-group">
                    <label for="salario">Salário Proposto:</label>
                    <input type="number" id="salario" name="salario" required></input>
                </div>

                <div class="form-group">
                    <label for="imagem" class="upload_label">Imagem do Local:</label>
                    <input type="file" id="imagem" name="imagem" required>
                </div>

                <button type="submit" class="btn-submit">Salvar Emprego</button>
            </form>
        </div>


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
                        <button class="btn-cancelar-exclusao" onclick="fecharModalExclusao()">Não</button>
                    </div>
                </form>
            </div>
        </div>
        <script src="add_emprego.js"></script>

</body>

</html>