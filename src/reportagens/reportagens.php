<?php
include __DIR__ . '/../conect_pgsql/conn.php';
session_start();


if (!isset($_SESSION['id_reportagem'])) {
    echo "Nenhuma reportagem selecionada.";
    exit;
}

if (isset($_GET['id'])) {
    $id_reportagem = $_GET['id'];
} else {
    $id_reportagem = $_SESSION['id_reportagem'];
}

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

// --- Inserção de comentário ou resposta ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensagem_user'])) {
    if (isset($_SESSION['id_usuario'])) {
        $id_usuario = $_SESSION['id_usuario'];
        $texto = $_POST['mensagem_user'];
        $tipo = $_POST['tipo'] ?? null;
        $id_resposta = $_POST['id_resposta'];
        if ($id_resposta === '') {
            $id_resposta = null;
        } else {
            $id_resposta = $_POST['id_resposta'];
        }

        $sqlAdd = "INSERT INTO comentarios (id_usuario, id_reportagem, texto_comentario, tipo, id_resposta, data_comentario) VALUES (:id_usuario, :id_reportagem, :texto, :tipo, :id_resposta, CURRENT_TIMESTAMP)";
        $stmtAdd = $conn->prepare($sqlAdd);
        $stmtAdd->bindParam(":id_usuario", $id_usuario);
        $stmtAdd->bindParam(":id_reportagem", $id_reportagem);
        $stmtAdd->bindParam(":texto", $texto);
        $stmtAdd->bindParam(":tipo", $tipo);
        $stmtAdd->bindParam(":id_resposta", $id_resposta);
        $stmtAdd->execute();

        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }
}

// --- Buscar comentários e respostas ---
$sqlComentarios = "SELECT c.*, u.nome FROM comentarios c JOIN usuario u ON c.id_usuario = u.id_usuario WHERE c.id_reportagem = :id_reportagem and c.tipo='0' ORDER BY c.data_comentario DESC";
$stmtComentarios = $conn->prepare($sqlComentarios);
$stmtComentarios->bindParam(":id_reportagem", $id_reportagem);
$stmtComentarios->execute();
$comentarios = $stmtComentarios->fetchAll(PDO::FETCH_ASSOC);

// Organizar comentários principais e respostas
$listaComentarios = [];
foreach ($comentarios as $c) {
    if ($c['tipo'] == 0) {
        $listaComentarios[$c['id_comentario']] = $c;
        $listaComentarios[$c['id_comentario']]['respostas'] = [];
    } else {
        if (isset($listaComentarios[$c['id_resposta']])) {
            $listaComentarios[$c['id_resposta']]['respostas'][] = $c;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../imagens/ConectaNews.png">
    <title>Jornal Digital - <?php echo $reportagem['titulo'] ?></title>
    <link rel="stylesheet" href="reportagens.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>
    <div id="barra-progresso"></div>
    <?php 
    if(isset($_SESSION['id_usuario'])){
        echo '<input type="hidden" id="nome_usuario" value="' . $_SESSION['nome'] . ' " ';
    }
    ?>
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
            <span class="data_publicacao"><i class="fas fa-calendar-alt"></i> Publicado em: <?php echo date("d/m/Y", strtotime($reportagem['data_publicacao'])); ?></span>
            <span class="autor"><i class="fas fa-user"></i> Por: <?php echo $autor['nome']; ?></span>
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

        <?php
        if (isset($_SESSION['id_usuario'])):
        ?>
            <section class="forum">
                <h2 class="forum-titulo"><i class="fas fa-comments"></i> Fórum de Discussão</h2>
                <form id="form-mensagem" class="form-mensagem" method="post">
                    <input type="text" id="nome-usuario" value='<?php echo $_SESSION['nome'] ?>' readonly>
                    <textarea name='mensagem_user' id="mensagem-usuario" placeholder="Escreva sua mensagem..." required></textarea>
                    <input name='tipo' type="hidden" value='0' readonly>
                    <input name='id_resposta' type="hidden" readonly>
                    <button type="submit" class="btn-enviar">Enviar Mensagem</button>
                </form>

                <?php foreach ($listaComentarios as $comentario): ?>
                <div id="lista-mensagens" class="lista-mensagens">
                        <div class="comentario" data-id="<?php echo $comentario['id_comentario']; ?>">
                            <h4 class="usuario_comentario"><?php echo htmlspecialchars($comentario['nome']); ?></h4>
                            <p class="texto_comentario"><?php echo nl2br(htmlspecialchars($comentario['texto_comentario'])); ?></p>
                            <small class="time"><?php echo date("d/m/Y H:i", strtotime($comentario['data_comentario'])); ?></small>
                            <button type="button" class="btn-responder">Responder</button>
                        </div>
                        
                        <?php 
                        $sqlResposta = "SELECT c.*, u.nome FROM comentarios c JOIN usuario u ON c.id_usuario = u.id_usuario WHERE c.tipo = '1' and c.id_resposta = :id ORDER BY c.data_comentario DESC";
                        $stmtResposta = $conn->prepare($sqlResposta);
                        $stmtResposta->bindParam(':id', $comentario['id_comentario']);
                        $stmtResposta->execute();
                        $respostas = $stmtResposta->fetchAll(PDO::FETCH_ASSOC);
                        if($respostas){
                            echo '<h5>Respostas:</h5>';
                        }else{
                            echo '<h5>Sem respostas.</h5>';
                        }
                        foreach ($respostas as $r):
                        ?>
                        <div class="resposta">
                            <h5 class="usuario_resposta"><?php echo htmlspecialchars($r['nome']); ?></h5>
                            <p class="texto_resposta"><?php echo nl2br(htmlspecialchars($r['texto_comentario'])); ?></p>
                            <small class="time_resposta"><?php echo date("d/m/Y H:i", strtotime($r['data_comentario'])); ?></small>
                        </div>
                        <?php endforeach; ?>
                </div>
                <br>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <p class="login-mensagem">Faça login para Comentar!</p>
        <?php endif ?>

    </main>
    <?php if (isset($_SESSION['id_usuario'])): ?>
        <div id="perfilModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="fecharModal()">&times;</span>
                <h2 class="perfil">Perfil de <?= htmlspecialchars($_SESSION['nome']) ?></h2>

                <p class="perfil"><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
                <p class="perfil"><strong>Data de Nascimento:</strong> <?= date('d/m/Y', strtotime($_SESSION['data_nasc'])) ?></p>
                <p class="perfil"><strong>Nome de Usuário:</strong> <?= htmlspecialchars($_SESSION['nome']) ?></p>

                <div class="botoes-acoes">
                    <button type="button" class="editar-btn" onclick="abrirEditarModal()">Editar</button>
                    <button class="logout-btn" onclick="abrirModalExclusao()">Excluir</button>
                    <button class="sair-btn" onclick="window.location.href='../actions/logout.php'">Sair da conta</button>
                </div>
            </div>
        </div>

        <div id="editarPerfilModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="fecharEditarModal()">&times;</span>
                <h2>Editar Perfil</h2>

                <form id="form-editar" class="form-editar" action="actions/edit_user.php" method="post">
                    <div class="form-group">
                        <label for="novo_nome">Nome de Usuário:</label>
                        <input type="text" name="novo_nome" id="novo_nome" value="<?= htmlspecialchars($_SESSION['nome']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="novo_email">Email:</label>
                        <input type="email" name="novo_email" id="novo_email" value="<?= htmlspecialchars($_SESSION['email']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="senha_atual">Senha atual:</label>
                        <input type="password" name="senha_atual" id="senha_atual" placeholder="Para editar digite sua senha atual">
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

    <?php
    $urlCompartilhar = "reportagens.php?id=" . $reportagem['id_reportagem'];
    $tituloReportagem = $reportagem['titulo'];
    ?>
    <input type="hidden" value="<?php echo $urlCompartilhar ?>" id="URL_REPORTAGEM" readonly>
    <input type="hidden" value="<?php echo $tituloReportagem ?>" id="TITULO_REPORTAGEM" readonly>

    <script src="reportagens.js" defer></script>
</body>

</html>

<?php

?>