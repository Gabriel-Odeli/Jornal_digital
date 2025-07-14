<?php
include __DIR__ . '/../conect_pgsql/conn.php';
session_start();

if($_SERVER['REQUEST_METHOD'] = 'POST'){
    try{
        $id_usuario = $_SESSION['id_usuario'];
        $novo_email = $_POST['novo_email'];
        $novo_nome = $_POST['novo_nome'];
        $nova_senha = $_POST['nova_senha'];

        if($nova_senha === ''){
            $sql = "UPDATE usuarios SET email= :email, nome= :nome  WHERE id_usuario = :id";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':nome', $novo_nome);
            $stmt->bindParam(':email', $novo_email);
            $stmt->bindParam(':id', $id_usuario);


            $stmt->execute();
            header("Location: ../tela_principal/tela_principal.php?error=invalid_request");
            $_SESSION['email'] = $novo_email;
            $_SESSION['senha'] = $nova_senha;
            $_SESSION['nome'] = $novo_nome;
        }else{
            $sql = "UPDATE usuarios SET email = '$novo_email', nome = '$novo_nome', senha = $nova_senha where id_usuario = " . $_SESSION['id_usuario'];
            $stmt = $conn->prepare($sql);
            if ($stmt->execute()){
                header("Location: ../tela_principal/tela_principal.php?error=invalid_request");
            }else{
                echo "ERRO";
            }
        }
    }
    catch(PDOException $e){
        die("Erro no banco de dados: " . $e->getMessage());
    }
    catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
}