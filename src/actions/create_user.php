<?php
include __DIR__ . '/../conect_pgsql/conn.php';

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

        $sql = "INSERT INTO usuario(nome, email, data_nascimento, senha, tipo) VALUES (:nome, :email, :data_nascimento, :senha, :tipo)";

        $stmt = $conn->prepare($sql);

        //Atribuindo valor para as variaveis
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);

        $stmt->execute();
        header("Location: ../../login/login.php");
    } catch (PDOException $e) {
        die("Erro no banco de dados: " . $e->getMessage());
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
}else {
    // Se não for POST, redireciona
    header("Location: ../../cadastro/cadastro.php?error=invalid_request");
    exit();
}