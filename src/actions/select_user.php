<?php 
include __DIR__ . '/../conect_pgsql/conn.php';

if($_SERVER['REQUEST_METHOD'] = 'POST'){
    try{
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;

        if (empty($senha) || empty($email)) {
            throw new Exception("Todos os campos são obrigatórios!");
        }

        $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha' ";

        $stmt = $conn->prepare($sql);

        if($stmt->execute()){
            header("Location: ../tela_principal/tela_principal.html?error=invalid_request");

        }

    }catch(PDOException $e){
        die("Erro no banco de dados: " . $e->getMessage());
    }catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
}else{
    header("Location: ../../login/login.php?error=invalid_request");
    exit();
}
?>