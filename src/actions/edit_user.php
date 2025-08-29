<?php
include __DIR__ . '/../conect_pgsql/conn.php';
session_start();

if($_SERVER['REQUEST_METHOD'] = 'POST'){
    try{
        $id_usuario = $_SESSION['id_usuario'];
        $novo_email = $_POST['novo_email'];
        $novo_nome = $_POST['novo_nome'];
        $nova_senha = $_POST['nova_senha'];
        $senha_atual = $_POST['senha_atual'];

        if($nova_senha === ''){
            if($senha_atual === ''){
                header("Location: ../index.php?erro=senhanaodigitada");
                exit;
            }
            if($id_usuario && password_verify($senha_atual, $_SESSION['senha'])){
                $sql = "UPDATE usuario SET email= :email, nome= :nome  WHERE id_usuario = :id";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':nome', $novo_nome);
                $stmt->bindParam(':email', $novo_email);
                $stmt->bindParam(':id', $id_usuario);


                if($stmt->execute()){
                    header("Location: ../index.php?sucesso='editado'");
                    $_SESSION['email'] = $novo_email;
                    $_SESSION['nome'] = $novo_nome;
                }
            }
        }else{
            if(strlen($nova_senha) >= 8){
                if($senha_atual === ''){
                    header("Location: ../index.php?erro=senhanaodigitada");
                    exit;
                }
                if($id_usuario && password_verify($senha_atual, $_SESSION['senha'])){
                    $hash = password_hash($nova_senha, PASSWORD_BCRYPT, ['cost' => 12]);
                    $sql = "UPDATE usuario SET email = :email, nome = :nome, senha = :senha where id_usuario = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':email', $novo_email);
                    $stmt->bindParam(':nome', $novo_nome);
                    $stmt->bindParam(':senha', $hash);
                    $stmt->bindParam(':id', $_SESSION['id_usuario']);

                    if ($stmt->execute()){
                        $_SESSION['email'] = $novo_email;
                        $_SESSION['senha'] = $hash;
                        $_SESSION['nome'] = $novo_nome;
                        header("Location: ../index.php?sucesso='editado'");
                    }
                    else{
                        echo "ERRO";
                    }
                }else{
                    header("Location: ../index.php?erro=incorrectpassword");
                }
            }else{
                header("Location: ../index.php?erro=senhapequena");
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