<?php
include __DIR__ . '/../conect_pgsql/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION)) {
        if ($_SESSION['tipo'] != 1) {
            die("Não é Administrador");
        }
        try {
            $email = $_POST['email'];
            $tipo = $_POST['nivel'];

            $sql = "UPDATE usuario SET tipo = $tipo WHERE email = '$email'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            header("Location: ../index.php");
        } catch (PDOException $e) {
            die("Erro no banco de dados: " . $e->getMessage());
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }
}
