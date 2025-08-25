<?php
session_start();
include __DIR__ . '/../conect_pgsql/conn.php';

if (isset($_SESSION)) {
    if ($_SERVER['REQUEST_METHOD'] = 'POST') {
        try {
            $arquivo = $_FILES['imagem']['tmp_name'];
            $imagemBinaria = file_get_contents($arquivo);

            $titulo = $_POST['titulo'];
            $texto = $_POST['texto'];

            $sql = 'SELECT * from usuario where id_usuario =' . $_SESSION['id_usuario'];
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $id_usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql = "INSERT INTO reportagem(titulo, data_publicacao, texto_reportagem, imagem, id_usuario) VALUES (:titulo, CURRENT_TIMESTAMP AT TIME ZONE 'America/Sao_Paulo', :texto_reportagem, :imagem, :id_usuario)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":titulo", $_POST['titulo']);
            $stmt->bindParam(":texto_reportagem", $_POST['texto']);
            $stmt->bindParam(":id_usuario", $_SESSION['id_usuario']);
            $stmt->bindParam(":imagem", $imagemBinaria, PDO::PARAM_LOB);
            $stmt->execute();
            header("Location: ../index.php");
        } catch (PDOException $e) {
            die("Erro no banco de dados: " . $e->getMessage());
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }
} else {
    header("Location: ../add_reportagem/add_reportagem.php");
    exit;
}
