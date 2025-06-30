<?php
include('../conect_pgsql/conn.php');

try {
    if ($conn) {
        $name = $_POST['nome'];
        $senha = $_POST['senha'];
        $data_nascimento = $_POST['data_nascimento'];
        $email = $_POST['email'];
        $sql = "INSERT INTO public.usuario(nome, email, data_nascimento, senha, tipo) VALUES (:nome, :email, :data_nascimento, :senha, :tipo)";

        $stmt = $pdo->prepare($sql);

        //Atribuindo valor para as variaveis
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', 0);

        $stmt->execute();
        echo "Usuário cadastrado com sucesso!";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
