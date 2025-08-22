<?php
include __DIR__ . '/../conect_pgsql/conn.php';

session_start();
if (!$_SESSION) {
    header("Location: ../login/login.php");
}
if (!$_SESSION['tipo'] == 1) {
    header("Location: ../tela_empregos/tela_empregos.php?erro=notadm");
}


if ($_SERVER['REQUEST_METHOD'] = 'POST') {
    try {
        $arquivo = $_FILES['imagem']['tmp_name'];
        $imagemBinaria = file_get_contents($arquivo);

        $nome_local = $_POST['nome'];
        $cargo = $_POST['vaga'];
        $salario = $_POST['salario'];
        $localizacao = $_POST['localizacao'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];

        $sql = "INSERT INTO emprego(nome_lugar, cargo, salario, localizacao, email, telefone, imagem_local) VALUES (:nome, :cargo, :salario, :localizacao, :email, :telefone, :imagem)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nome", $nome_local);
        $stmt->bindParam(":cargo", $cargo);
        $stmt->bindParam(":salario", $salario);
        $stmt->bindParam(":localizacao", $localizacao);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":imagem", $imagemBinaria, PDO::PARAM_LOB);
        $stmt->execute();
        header("Location: ../add_emprego/add_emprego.php?sucesso=send");
    } catch (PDOException $e) {
        die("Erro no banco de dados: " . $e->getMessage());
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
} else {
    header("Location: ../tela_empregos/tela_empregos.php?erro=wrongmethod");
}
