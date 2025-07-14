<?php
include __DIR__ . '/../conect_pgsql/conn.php';
session_start();

if($_SERVER['REQUEST_METHOD'] = 'post'){
    try{
        $id = $_SESSION['id_usuario'];

        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();
        session_destroy();
        header("Location: ../tela_principal/tela_principal.php?error=invalid_request");
    }
    catch(PDOException $e){
        die("Erro no banco de dados: " . $e->getMessage());
    }
    catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
}