<?php 
session_start();

if(isset($_GET['id'])){
    $_SESSION['id_reportagem'] = $_GET['id'];
    header('Location: ../reportagens/reportagens.php');
    exit();
}else{
    echo "Nenhuma reportagem selecionada";
}

?>