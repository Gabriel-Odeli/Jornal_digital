<?php
include __DIR__ . '/conect_pgsql/conn.php';
session_start();

//Reportagem mais recente
$sqlPrimeira = "SELECT id_reportagem, titulo, texto_reportagem, imagem, id_usuario, data_publicacao FROM reportagem ORDER BY data_publicacao DESC LIMIT 1";
$stmtPrimeira = $conn->prepare($sqlPrimeira);
$stmtPrimeira->execute();
$primeira = $stmtPrimeira->fetch(PDO::FETCH_ASSOC);
if ($primeira != null) {
    $stream = $primeira['imagem'];
    $imagemPrimeiraBytes = stream_get_contents($stream);
}


//Reportagens para os campos menores
$sqlMenores = "SELECT id_reportagem, titulo, texto_reportagem, imagem, id_usuario, data_publicacao FROM reportagem ORDER BY data_publicacao DESC LIMIT 2 OFFSET 1";
$stmtMenores = $conn->prepare($sqlMenores);
$stmtMenores->execute();
$Menores = $stmtMenores->fetchAll(PDO::FETCH_ASSOC);
if ($Menores != null) {
    if ($stmtMenores->rowCount() == 1) {
        $stream1 = $Menores[0]['imagem'];
        $imagemMenor1Bytes = stream_get_contents($stream1);
    } elseif ($stmtMenores->rowCount() == 2) {
        $stream2 = $Menores[1]['imagem'];
        $stream1 = $Menores[0]['imagem'];
        $imagemMenor1Bytes = stream_get_contents($stream1);
        $imagemMenor2Bytes = stream_get_contents($stream2);
    } else {
        echo "Erro";
    }
}

//Outras Reportagens
$sqlResto = "SELECT * FROM reportagem ORDER BY data_publicacao DESC LIMIT 10 OFFSET 3";
$stmtResto = $conn->prepare($sqlResto);
$stmtResto->execute();
$Resto = $stmtResto->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['erro']) && $_GET['erro'] == 'incorrectpassword'){
    echo '<div id="mensagem-erro" class="mensagem-erro" style="display:block;">Senha atual incorreta!</div>';
}

if (isset($_GET['erro']) && $_GET['erro'] == "senhapequena") {
    echo '<div id="mensagem-erro" class="mensagem-erro" style="display:block;">Senha deve ter mais de 8 caracteres</div>';
}

if (isset($_GET['erro']) && $_GET['erro'] == "senhanaodigitada") {
    echo '<div id="mensagem-erro" class="mensagem-erro" style="display:block;">Digite a senha atual para editar!</div>';
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="imagens/ConectaNews.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="tela_principal/tela_principal.css">
    <title>ConectaNews</title>
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
                <li> <a href="#"> <img src="imagens/instagram.png" alt="Instagram"> </a> </li>
                <li> <a href="#"><img src="imagens/facebook.png" alt="Facebook"> </a> </li>
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
                    <li><a href="tela_empregos/tela_empregos.php">Empregos</a></li>
                    <?php
                    if (isset($_SESSION['id_usuario'])) {
                        if ($_SESSION['tipo'] == 1) {
                            echo '<li class="botao-add-admin"><a href="administrador/administrador.php">Adicionar administrador</a></li>';

                            echo '<li class="botao-add-reportagem">';
                            echo  '<a href="add_reportagem/add_reportagem.php">Adicionar reportagem</a>';
                            echo '</li>';
                        } else {
                            echo '';
                        }
                    }
                    ?>
                </ul>
                <?php
                ?>
            </div>
        </form>
        <br>
        <?php if ($primeira != null): ?>
        <h2 class='text'>Últimas reportagens:</h2>
        <?php endif; ?>
        <header class="Reportagens">
            <?php if ($primeira != null): ?>
                <a href="actions/pegar_id-rep.php?id=<?php echo $primeira['id_reportagem'] ?>" class="rep_maior">
                    <div>
                        <img class="rep_maior-img" src="data:image/jpeg;base64,<?php echo base64_encode($imagemPrimeiraBytes); ?>" alt="imagem da reportagem">
                        <h2 class="rep_maior-h2"><?php echo $primeira['titulo'] ?></h2>
                    </div>
                </a>

                <?php if (!empty($Menores)): ?>
                    <div class="rep_menores">
                        <?php if (isset($Menores[0])): ?>
                            <a href="actions/pegar_id-rep.php?id=<?php echo $Menores[0]['id_reportagem'] ?>" class="rep_menor1">
                                <div>
                                    <img class="rep_menor1-img" src="data:image/jpeg;base64,<?php echo base64_encode($imagemMenor1Bytes); ?>" alt="imagem da reportagem">
                                    <h2 class="rep_menor1-h2"><?php echo $Menores[0]['titulo'] ?></h2>
                                </div>
                            </a>
                        <?php endif; ?>

                        <?php if (isset($Menores[1])): ?>
                            <a href="actions/pegar_id-rep.php?id=<?php echo $Menores[1]['id_reportagem'] ?>" class="rep_menor2">
                                <div>
                                    <img class="rep_menor2-img" src="data:image/jpeg;base64,<?php echo base64_encode($imagemMenor2Bytes); ?>" alt="imagem da reportagem">
                                    <h2 class="rep_menor2-h2"><?php echo $Menores[1]['titulo'] ?></h2>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p>Mais reportagens em breve</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="sem-reportagens">⚠️ Não existem reportagens no momento</p>
            <?php endif; ?>
        </header>
        <br>
        <br>
        <?php if($Resto){
            echo "<h2 class='text'>Veja também:</h2>";
        }?>
        <div class="veja-tambem">
            <?php foreach($Resto as $r): 
                $streamR = $r['imagem'];
                $imagemRestoBytes = stream_get_contents($streamR);?>
                <a href="actions/pegar_id-rep.php?id=<?php echo $r['id_reportagem'] ?>" class="card">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($imagemRestoBytes); ?>" alt="Imagem da Reportagem">
                    <h3><?php echo $r['titulo'] ?></h3>
                </a>
            <?php endforeach; ?>
        </div>

    </header>
    <main></main>
    <?php if (isset($_SESSION['id_usuario'])): ?>
        <div id="perfilModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="fecharModal()">&times;</span>
                <h2>Perfil de <?= htmlspecialchars($_SESSION['nome']) ?></h2>

                <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
                <p><strong>Data de Nascimento:</strong> <?= date('d/m/Y', strtotime($_SESSION['data_nasc'])) ?></p>
                <p><strong>Nome de Usuário:</strong> <?= htmlspecialchars($_SESSION['nome']) ?></p>

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
            <form action="actions/delete_user.php" method="post">
                <div class="botoes-confirmacao">
                    <button class="btn-confirmar-exclusao" type="submit">Sim</button>
                    <button class="btn-cancelar-exclusao" type="button" onclick="fecharModalExclusao()">Não</button>
                </div>
            </form>
        </div>
    </div>
    <script src="tela_principal/tela_principal.js"></script>
</body>

</html>