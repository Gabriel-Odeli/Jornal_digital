<?php 
include __DIR__ . '/../conect_pgsql/conn.php';

if($_SERVER['REQUEST_METHOD'] = 'POST'){
    try{
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;

        if (empty($senha) || empty($email)) {
            throw new Exception("Todos os campos são obrigatórios!");
        }

        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha' ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['senha'] = $usuario['senha'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['data_nasc'] = $usuario['data_nascimento'];
            header("Location: ../tela_principal/tela_principal.php?error=invalid_request");
            exit;
        } else {
            $erro = "Email não encontrado.";
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