<?php 
include __DIR__ . '/../conect_pgsql/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_comentario = $_POST['id_comentario'];
    $sqlRespostas = 'SELECT * FROM comentarios where id_resposta IS NOT null';
    $stmtRespostas = $conn->prepare($sqlRespostas);
    $stmtRespostas->execute();
    $respostas = $stmtRespostas->fetchAll(PDO::FETCH_ASSOC);
    foreach($respostas as $r){
        if($r['id_resposta'] == $id_comentario){
            $sqlExcluirRespostas = 'DELETE FROM comentarios WHERE id_comentario = :id';
            $stmtExcluirRespostas = $conn->prepare($sqlExcluirRespostas);
            $stmtExcluirRespostas->bindParam(':id', $r['id_comentario']);
            $stmtExcluirRespostas->execute();
        }
    }

    $sql = 'DELETE FROM comentarios WHERE id_comentario = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id_comentario);
    if ($stmt->execute()){
        header("Location: ../reportagens/reportagens.php?sucesso=excluido");
    }else{
        header("Location: ../reportagens/reportagens.php?sucesso=naoexcluido");
    }
}
?>