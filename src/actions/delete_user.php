<?php
include __DIR__ . '/../conect_pgsql/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $id = $_SESSION['id_usuario'];

        $sql = "DELETE FROM usuario WHERE id_usuario = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();
        if (isset($_SESSION['ultima_pag'])) {
            $ultima_pag = $_SESSION['ultima_pag'];
        } else {
            $ultima_pag = '../index.php';
        }
        session_destroy();
        header("Location:" . $ultima_pag);
    } catch (PDOException $e) {
        die("Erro no banco de dados: " . $e->getMessage());
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
}
