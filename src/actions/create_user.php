<?php
include __DIR__ . '/../conect_pgsql/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] = 'POST') {
    try {
        $nome = $_POST['nome'] ?? null;
        $senha = $_POST['senha'] ?? null;
        $data_nascimento = $_POST['data_nascimento'] ?? null;
        $email = $_POST['email'] ?? null;
        $tipo = 0;

        if (empty($nome) || empty($senha) || empty($data_nascimento) || empty($email)) {
            throw new Exception("Todos os campos são obrigatórios!");
        }

        $sql = "SELECT id_usuario FROM usuario WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: ../cadastro/cadastro.php?erro=emailexistente");
            exit;
        } else {
            $sqlInsert = "INSERT INTO usuario(nome, email, data_nascimento, senha, tipo) VALUES (:nome, :email, :data_nascimento, :senha, :tipo)";

            $stmtInsert = $conn->prepare($sql);

            //Atribuindo valor para as variaveis
            $stmtInsert->bindParam(':nome', $nome);
            $stmtInsert->bindParam(':email', $email);
            $stmtInsert->bindParam(':data_nascimento', $data_nascimento);
            $stmtInsert->bindParam(':senha', $senha);
            $stmtInsert->bindParam(':tipo', $tipo);

            $stmtInsert->execute();
            $sqlLogin = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha' ";

            $stmtLogin = $conn->prepare($sql);

            $stmtLogin->execute();

            $usuario = $stmtLogin->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['senha'] = $usuario['senha'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['data_nasc'] = $usuario['data_nascimento'];
            $_SESSION['tipo'] = $usuario['tipo'];
            header("Location: ../../login/login.php");
        }
    } catch (PDOException $e) {
        die("Erro no banco de dados: " . $e->getMessage());
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
} else {
    // Se não for POST, redireciona
    header("Location: ../../cadastro/cadastro.php?error=invalid_request");
    exit();
}
